// Mobile nav toggle
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (btn && menu) {
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    }

    // Booking modal
    const bookBtns = document.querySelectorAll('[data-book]');
    const modal = document.getElementById('booking-modal');
    const closeModal = document.getElementById('close-modal');
    const facilityInput = document.getElementById('modal-facility');
    const venueInput = document.getElementById('modal-venue');

    if (bookBtns && modal) {
        bookBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const facility = btn.getAttribute('data-facility');
                const venue = btn.getAttribute('data-venue');
                if (facilityInput) facilityInput.value = facility;
                if (venueInput) venueInput.value = venue;
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });
        });
    }

    if (closeModal && modal) {
        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    }

    // Tab switching on venues page
    const tabs = document.querySelectorAll('[data-tab]');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.getAttribute('data-tab');
            tabs.forEach(t => {
                t.classList.remove('border-blue-600', 'text-blue-600', 'bg-blue-50');
                t.classList.add('border-transparent', 'text-gray-500');
            });
            tab.classList.add('border-blue-600', 'text-blue-600', 'bg-blue-50');
            tab.classList.remove('border-transparent', 'text-gray-500');
            document.querySelectorAll('[data-tab-content]').forEach(c => c.classList.add('hidden'));
            const content = document.querySelector(`[data-tab-content="${target}"]`);
            if (content) content.classList.remove('hidden');
        });
    });

    // Activate first tab by default
    if (tabs.length > 0) tabs[0].click();
});
