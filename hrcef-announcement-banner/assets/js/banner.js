(function() {
    'use strict';
    
    const banner = document.getElementById('hrcef-announcement-banner');
    
    if (!banner) return;
    
    const closeButton = document.getElementById('hrcef-banner-close');
    const isDismissible = banner.getAttribute('data-dismissible') === '1';
    const bannerVersion = banner.getAttribute('data-version') || '1';
    const STORAGE_KEY = 'hrcef_banner_dismissed_v' + bannerVersion;
    
    // Check if banner was previously dismissed
    function isBannerDismissed() {
        return localStorage.getItem(STORAGE_KEY) === 'true';
    }
    
    // Hide banner
    function hideBanner() {
        banner.classList.add('hrcef-banner-hidden');
        document.body.classList.remove('hrcef-banner-visible');
        
        if (isDismissible) {
            localStorage.setItem(STORAGE_KEY, 'true');
        }
    }
    
    // Show banner
    function showBanner() {
        banner.classList.remove('hrcef-banner-hidden');
        document.body.classList.add('hrcef-banner-visible');
    }
    
    // Initialize banner visibility
    function initBanner() {
        if (isDismissible && isBannerDismissed()) {
            banner.classList.add('hrcef-banner-hidden');
        } else {
            document.body.classList.add('hrcef-banner-visible');
        }
    }
    
    // Event Listeners
    if (closeButton && isDismissible) {
        closeButton.addEventListener('click', function() {
            hideBanner();
        });
        
        // Keyboard accessibility
        closeButton.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                hideBanner();
            }
        });
    }
    
    // Initialize on page load
    initBanner();
})();
