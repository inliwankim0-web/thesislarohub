<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Venue;
use App\Models\Facility;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Admin ---
        User::create([
            'first_name' => 'Admin',
            'last_name'  => 'LaroHub',
            'email'      => 'admin@larohub.com',
            'contact'    => '09000000000',
            'password'   => Hash::make('password'),
            'role'       => 'admin',
        ]);

        // --- Staff user for each venue ---
        $staffUsers = [];
        $venueNames = ['Homecourt','Playsite','Recreation Center','Aqua Verde','Southside','Wheels N More'];
        foreach ($venueNames as $i => $name) {
            $slug = strtolower(str_replace([' ', "'"], ['-', ''], $name));
            $staffUsers[$name] = User::create([
                'first_name' => 'Staff',
                'last_name'  => $name,
                'email'      => $slug . '@larohub.com',
                'contact'    => '0900000000' . ($i + 1),
                'password'   => Hash::make('password'),
                'role'       => 'staff',
            ]);
        }

        // --- Demo renter ---
        User::create([
            'first_name' => 'Juan',
            'last_name'  => 'Dela Cruz',
            'email'      => 'renter@larohub.com',
            'contact'    => '09171234567',
            'password'   => Hash::make('password'),
            'role'       => 'renter',
        ]);

        // --- Venues ---
        $venueData = [
            [
                'name' => 'Homecourt',
                'slug' => 'homecourt',
                'address' => 'Davao City, Davao del Sur',
                'latitude' => 7.0731,
                'longitude' => 125.6128,
                'description' => 'Premier multi-sport facility offering basketball, badminton, and gym services.',
                'rating' => 4.5,
                'color' => 'from-orange-400 to-red-500',
                'emoji' => '🏀',
                'facilities' => [
                    ['sport'=>'Basketball','label'=>'Basketball Court','time_slot'=>'daytime','price_per_hour'=>1200,'has_lights'=>false,'rate_type'=>'hourly'],
                    ['sport'=>'Basketball','label'=>'Basketball Court (Night)','time_slot'=>'night','price_per_hour'=>1900,'has_lights'=>true,'rate_type'=>'hourly'],
                    ['sport'=>'Badminton','label'=>'Badminton Court','time_slot'=>'daytime','price_per_hour'=>200,'has_lights'=>false,'rate_type'=>'hourly'],
                    ['sport'=>'Badminton','label'=>'Badminton Court (Night)','time_slot'=>'night','price_per_hour'=>250,'has_lights'=>true,'rate_type'=>'hourly'],
                    ['sport'=>'Gym','label'=>'Gym — Regular','time_slot'=>'any','price_per_hour'=>1500,'has_lights'=>true,'rate_type'=>'monthly','is_monthly'=>true],
                    ['sport'=>'Gym','label'=>'Gym — Student','time_slot'=>'any','price_per_hour'=>1200,'has_lights'=>true,'rate_type'=>'monthly','is_monthly'=>true],
                    ['sport'=>'Gym','label'=>'Gym — Group (5 pax)','time_slot'=>'any','price_per_hour'=>1200,'has_lights'=>true,'rate_type'=>'monthly','is_monthly'=>true],
                    ['sport'=>'Gym','label'=>'Gym — w/ Group Class','time_slot'=>'any','price_per_hour'=>2200,'has_lights'=>true,'rate_type'=>'monthly','is_monthly'=>true],
                ],
            ],
            [
                'name' => 'Playsite',
                'slug' => 'playsite',
                'address' => 'Davao City, Davao del Sur',
                'latitude' => 7.0682,
                'longitude' => 125.6095,
                'description' => 'Multi-sport complex for basketball, volleyball and badminton with flexible lighting options.',
                'rating' => 4.3,
                'color' => 'from-blue-400 to-cyan-500',
                'emoji' => '🏐',
                'facilities' => [
                    ['sport'=>'Basketball','label'=>'Basketball Court (With Lights)','time_slot'=>'any','price_per_hour'=>1200,'has_lights'=>true,'rate_type'=>'hourly'],
                    ['sport'=>'Basketball','label'=>'Basketball Court (No Lights)','time_slot'=>'any','price_per_hour'=>800,'has_lights'=>false,'rate_type'=>'hourly'],
                    ['sport'=>'Volleyball','label'=>'Volleyball Court (With Lights)','time_slot'=>'any','price_per_hour'=>500,'has_lights'=>true,'rate_type'=>'hourly'],
                    ['sport'=>'Volleyball','label'=>'Volleyball Court (No Lights)','time_slot'=>'any','price_per_hour'=>450,'has_lights'=>false,'rate_type'=>'hourly'],
                    ['sport'=>'Badminton','label'=>'Badminton Court (With Lights)','time_slot'=>'any','price_per_hour'=>200,'has_lights'=>true,'rate_type'=>'hourly'],
                    ['sport'=>'Badminton','label'=>'Badminton Court (No Lights)','time_slot'=>'any','price_per_hour'=>150,'has_lights'=>false,'rate_type'=>'hourly'],
                ],
            ],
            [
                'name' => 'Recreation Center',
                'slug' => 'recreation-center',
                'address' => 'Davao City, Davao del Sur',
                'latitude' => 7.0810,
                'longitude' => 125.6050,
                'description' => 'Affordable community basketball center open for everyone.',
                'rating' => 4.0,
                'color' => 'from-green-500 to-emerald-600',
                'emoji' => '🏀',
                'facilities' => [
                    ['sport'=>'Basketball','label'=>'Basketball Court','time_slot'=>'any','price_per_hour'=>600,'has_lights'=>true,'rate_type'=>'hourly'],
                ],
            ],
            [
                'name' => 'Aqua Verde',
                'slug' => 'aqua-verde',
                'address' => 'Davao City, Davao del Sur',
                'latitude' => 7.0598,
                'longitude' => 125.6200,
                'description' => 'Premium multi-sport venue featuring basketball, tennis, and volleyball courts.',
                'rating' => 4.7,
                'color' => 'from-teal-400 to-cyan-600',
                'emoji' => '🎾',
                'facilities' => [
                    ['sport'=>'Basketball','label'=>'Basketball Court','time_slot'=>'any','price_per_hour'=>750,'has_lights'=>true,'rate_type'=>'hourly'],
                    ['sport'=>'Tennis','label'=>'Tennis Court','time_slot'=>'any','price_per_hour'=>450,'has_lights'=>true,'rate_type'=>'hourly'],
                    ['sport'=>'Volleyball','label'=>'Volleyball Court','time_slot'=>'any','price_per_hour'=>500,'has_lights'=>true,'rate_type'=>'hourly'],
                ],
            ],
            [
                'name' => 'Southside',
                'slug' => 'southside',
                'address' => 'Davao City, Davao del Sur',
                'latitude' => 7.0500,
                'longitude' => 125.6150,
                'description' => 'Davao\'s dedicated pickleball hub with 8 professional courts.',
                'rating' => 4.6,
                'color' => 'from-purple-500 to-violet-600',
                'emoji' => '🏓',
                'facilities' => [
                    ['sport'=>'Pickleball','label'=>'Pickleball Court','time_slot'=>'any','price_per_hour'=>350,'has_lights'=>true,'court_count'=>8,'rate_type'=>'hourly'],
                ],
            ],
            [
                'name' => 'Wheels N More',
                'slug' => 'wheels-n-more',
                'address' => 'Davao City, Davao del Sur',
                'latitude' => 7.0780,
                'longitude' => 125.6300,
                'description' => 'Badminton-focused center with 6 professional courts and flexible time pricing.',
                'rating' => 4.4,
                'color' => 'from-pink-400 to-rose-500',
                'emoji' => '🏸',
                'facilities' => [
                    ['sport'=>'Badminton','label'=>'Badminton Court (7AM–4PM)','time_slot'=>'7am-4pm','price_per_hour'=>180,'has_lights'=>true,'court_count'=>6,'rate_type'=>'hourly'],
                    ['sport'=>'Badminton','label'=>'Badminton Court (4PM–10PM)','time_slot'=>'4pm-10pm','price_per_hour'=>250,'has_lights'=>true,'court_count'=>6,'rate_type'=>'hourly'],
                ],
            ],
        ];

        foreach ($venueData as $vd) {
            $facilities = $vd['facilities'];
            unset($vd['facilities']);
            $vd['owner_id'] = $staffUsers[$vd['name']]->id;
            $venue = Venue::create($vd);
            foreach ($facilities as $f) {
                $venue->facilities()->create(array_merge(['is_active' => true], $f));
            }
        }
    }
}
