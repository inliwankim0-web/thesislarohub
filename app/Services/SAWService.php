<?php

namespace App\Services;

use App\Models\Venue;
use App\Models\Facility;

/**
 * Simple Additive Weighting (SAW) — updated weights per research revision.
 *
 * Weights (sum = 1.0):
 *   W_price    = 0.50  (cost     → min_price / facility_price)
 *   W_distance = 0.25  (cost     → min_distance / facility_distance)
 *   W_rating   = 0.25  (benefit  → facility_rating / max_rating)
 *
 * Formula per facility i:
 *   Score_i = (W_price × R_price) + (W_distance × R_distance) + (W_rating × R_rating)
 */
class SAWService
{
    // Updated weights per research revision:
    //   W_price    = 0.50  (cost     → min_price / facility_price)
    //   W_distance = 0.25  (cost     → min_distance / facility_distance)
    //   W_rating   = 0.25  (benefit  → facility_rating / max_rating)
    const W_PRICE    = 0.50;
    const W_DISTANCE = 0.25;
    const W_RATING   = 0.25;

    /**
     * @param  string      $sport       e.g. "Basketball"
     * @param  string      $date        "YYYY-MM-DD"
     * @param  string      $startTime   "HH:MM"
     * @param  string      $endTime     "HH:MM"
     * @param  int         $hours       duration
     * @param  float       $minRating   minimum rating filter (e.g. 4.0)
     * @param  float|null  $userLat     renter latitude
     * @param  float|null  $userLng     renter longitude
     *
     * @return array [
     *   'available'    => [...ranked facilities that passed availability check],
     *   'alternatives' => [...facilities that are unavailable but match sport],
     *   'weights'      => ['rating'=>0.50, 'price'=>0.30, 'distance'=>0.20],
     * ]
     */
    public function recommend(
        string  $sport,
        string  $date,
        string  $startTime,
        string  $endTime,
        int     $hours,
        float   $minRating  = 0.0,
        float   $maxPrice   = 0.0,   // 0 = no limit
        ?float  $userLat    = null,
        ?float  $userLng    = null
    ): array {
        // ── Step 1: Load all active venues that offer this sport ──────────────
        $venues = Venue::with(['facilities' => function ($q) use ($sport) {
            $q->where('sport', $sport)
              ->where('is_active', true)
              ->where('rate_type', 'hourly');
        }])->where('is_active', true)->get();

        $candidates   = [];
        $alternatives = [];

        // Determine if the time slot is "night" (17:00 onwards)
        $startHour  = (int) explode(':', $startTime)[0];
        $isNight    = $startHour >= 17;

        foreach ($venues as $venue) {
            $matchFacilities = $venue->facilities->filter(fn($f) => $f->sport === $sport);
            if ($matchFacilities->isEmpty()) continue;

            // ── Time-aware facility selection ─────────────────────────────────
            // Prefer a facility whose time_slot matches (daytime/night/7am-4pm/4pm-10pm)
            // Fall back to 'any' or cheapest if no match
            $facility = $this->selectBestFacility($matchFacilities, $isNight, $startHour);

            // ── Availability check ────────────────────────────────────────────
            $isAvailable = $facility->isAvailable($date, $startTime, $hours);

            // ── Rating filter ─────────────────────────────────────────────────
            $meetsRating = $venue->rating >= $minRating;

            // ── Price filter ──────────────────────────────────────────────────
            $meetsPrice = ($maxPrice <= 0) || ($facility->price_per_hour <= $maxPrice);

            // ── Distance ─────────────────────────────────────────────────────
            $distance = $this->haversine($userLat, $userLng, $venue->latitude, $venue->longitude);

            $entry = [
                'venue'      => $venue,
                'facility'   => $facility,
                'rating'     => (float) $venue->rating,
                'price'      => (float) $facility->price_per_hour,
                'distance'   => $distance,
                'available'  => $isAvailable,
                'saw_score'  => 0.0,
                'R_rating'   => 0.0,
                'R_price'    => 0.0,
                'R_distance' => 0.0,
                'rank'       => null,
                'time_slot'  => $facility->time_slot,
            ];

            if ($isAvailable && $meetsRating && $meetsPrice) {
                $candidates[] = $entry;
            } else {
                $reasons = [];
                if (!$isAvailable) $reasons[] = 'Time slot unavailable';
                if (!$meetsRating) $reasons[] = 'Below min. rating';
                if (!$meetsPrice)  $reasons[] = 'Above budget (₱'.number_format($maxPrice,0).')';
                $entry['unavailable_reason'] = implode(' · ', $reasons);
                $alternatives[] = $entry;
            }
        }

        $candidates   = $this->applySAW($candidates);
        $alternatives = $this->applySAW($alternatives);

        return [
            'available'    => $candidates,
            'alternatives' => $alternatives,
            'weights' => [
                'rating'   => self::W_RATING,
                'price'    => self::W_PRICE,
                'distance' => self::W_DISTANCE,
            ],
        ];
    }

    /**
     * Pick the most appropriate facility from a collection based on time of day.
     * Priority: exact slot match → 'any' → cheapest overall
     */
    private function selectBestFacility($facilities, bool $isNight, int $startHour)
    {
        // Try exact slot match
        $slotKey = $isNight ? 'night' : 'daytime';
        // For Wheels N More style (7am-4pm / 4pm-10pm)
        if ($startHour >= 4 && $startHour < 16) {
            $altSlot = '7am-4pm';
        } else {
            $altSlot = '4pm-10pm';
        }

        foreach ([$slotKey, $altSlot, 'any'] as $slot) {
            $match = $facilities->firstWhere('time_slot', $slot);
            if ($match) return $match;
        }

        // Fall back: cheapest
        return $facilities->sortBy('price_per_hour')->first();
    }

    /**
     * Apply SAW normalization and scoring to a list of facility entries.
     *
     * Normalization rules (matching your dataset):
     *   R_rating   = facility_rating   / max_rating      (benefit)
     *   R_price    = min_price         / facility_price   (cost)
     *   R_distance = min_distance      / facility_distance (cost)
     *
     * Special case: if all distances are 0 (no user location), R_distance = 1.0 for all.
     */
    private function applySAW(array $items): array
    {
        if (empty($items)) return [];

        $ratings   = array_column($items, 'rating');
        $prices    = array_column($items, 'price');
        $distances = array_column($items, 'distance');

        $maxRating = max($ratings);
        $minPrice  = min($prices);
        $minDist   = min($distances);
        $allZeroDist = ($minDist == 0.0);

        foreach ($items as &$item) {
            // R_rating: benefit → ratio to best
            $item['R_rating'] = $maxRating > 0
                ? round($item['rating'] / $maxRating, 4)
                : 1.0;

            // R_price: cost → min/current (best price = 1.0)
            $item['R_price'] = $item['price'] > 0
                ? round($minPrice / $item['price'], 4)
                : 1.0;

            // R_distance: cost → min/current (nearest = 1.0)
            // If no user location provided, treat all as equal (1.0)
            if ($allZeroDist || $item['distance'] == 0) {
                $item['R_distance'] = 1.0;
            } else {
                $item['R_distance'] = round($minDist / $item['distance'], 4);
            }

            // SAW Score = (W_price × R_price) + (W_distance × R_distance) + (W_rating × R_rating)
            $item['saw_score'] = round(
                (self::W_PRICE    * $item['R_price'])    +
                (self::W_DISTANCE * $item['R_distance']) +
                (self::W_RATING   * $item['R_rating']),
                4
            );
        }
        unset($item);

        // Sort descending by SAW score
        usort($items, fn($a, $b) => $b['saw_score'] <=> $a['saw_score']);

        foreach ($items as $i => &$item) {
            $item['rank'] = $i + 1;
        }
        unset($item);

        return $items;
    }

    /**
     * Haversine distance in km.
     * Returns 0.0 if either coordinate is null (no user location provided).
     */
    public function haversine(?float $lat1, ?float $lng1, ?float $lat2, ?float $lng2): float
    {
        if ($lat1 === null || $lng1 === null || $lat2 === null || $lng2 === null) {
            return 0.0;
        }
        $R    = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);
        $a    = sin($dLat / 2) ** 2
              + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;
        return round($R * 2 * atan2(sqrt($a), sqrt(1 - $a)), 2);
    }
}
