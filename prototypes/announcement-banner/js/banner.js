(function() {
    'use strict';
    
    const STORAGE_KEY = 'hrcef_banner_dismissed';
    const banner = document.getElementById('announcement-banner');
    const closeButton = document.getElementById('banner-close');
    const showButton = document.getElementById('show-banner');
    const clearStorageButton = document.getElementById('clear-storage');
    
    // Banner content variations
    const bannerContent = {
        scholarship: {
            icon: '<path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5M2 12l10 5 10-5"/>',
            title: 'New Scholarship Opportunity!',
            text: 'Applications now open for the 2025-26 academic year. Apply by March 15th.',
            link: '#',
            linkText: 'Learn More →',
            className: ''
        },
        event: {
            icon: '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
            title: 'Columbia Gorge Wine Festival 2025',
            text: 'Join us for our annual fundraising event on May 10th. Tickets available now!',
            link: '#',
            linkText: 'Get Tickets →',
            className: 'event'
        },
        deadline: {
            icon: '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
            title: 'Application Deadline Approaching',
            text: 'Submit your scholarship application by March 15th. Don\'t miss out!',
            link: '#',
            linkText: 'Apply Now →',
            className: 'deadline'
        },
        success: {
            icon: '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
            title: 'Congratulations to Our 2025 Recipients!',
            text: 'We awarded $500,000 in scholarships this year. Read their inspiring stories.',
            link: '#',
            linkText: 'Read Stories →',
            className: 'success'
        }
    };
    
    // Check if banner was previously dismissed
    function isBannerDismissed() {
        return localStorage.getItem(STORAGE_KEY) === 'true';
    }
    
    // Show banner
    function showBanner() {
        banner.classList.remove('hidden');
        document.body.classList.remove('banner-hidden');
        localStorage.removeItem(STORAGE_KEY);
    }
    
    // Hide banner
    function hideBanner() {
        banner.classList.add('hidden');
        document.body.classList.add('banner-hidden');
        localStorage.setItem(STORAGE_KEY, 'true');
    }
    
    // Initialize banner visibility
    function initBanner() {
        if (isBannerDismissed()) {
            banner.classList.add('hidden');
            document.body.classList.add('banner-hidden');
        }
    }
    
    // Change banner content
    window.changeBannerContent = function(type) {
        const content = bannerContent[type];
        if (!content) return;
        
        // Remove all variation classes
        banner.className = 'announcement-banner';
        
        // Add new class if specified
        if (content.className) {
            banner.classList.add(content.className);
        }
        
        // Update content
        const iconElement = banner.querySelector('.banner-icon svg');
        const titleElement = banner.querySelector('.banner-text strong');
        const textElement = banner.querySelector('.banner-text span');
        const linkElement = banner.querySelector('.banner-link');
        
        iconElement.innerHTML = content.icon;
        titleElement.textContent = content.title;
        textElement.textContent = content.text;
        linkElement.href = content.link;
        linkElement.textContent = content.linkText;
        
        // Show banner if hidden
        if (banner.classList.contains('hidden')) {
            showBanner();
        }
    };
    
    // Event Listeners
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            hideBanner();
        });
    }
    
    if (showButton) {
        showButton.addEventListener('click', function() {
            showBanner();
        });
    }
    
    if (clearStorageButton) {
        clearStorageButton.addEventListener('click', function() {
            localStorage.removeItem(STORAGE_KEY);
            alert('Storage cleared! Refresh the page to see the banner again.');
        });
    }
    
    // Keyboard accessibility
    if (closeButton) {
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
