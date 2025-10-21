(function() {
    'use strict';
    
    // Get number of cards to display based on screen size
    function getCardCount() {
        const width = window.innerWidth;
        if (width <= 768) return 1;  // Mobile: 1 card
        if (width <= 1024) return 2; // Tablet: 2 cards
        return 3;                     // Desktop: 3 cards
    }
    
    // Load random testimonials
    function loadRandomTestimonials(gridElement) {
        const count = getCardCount();
        const defaultImage = gridElement.dataset.defaultImage || '';
        
        fetch('/wp-json/hrcef/v1/testimonials?count=' + count)
            .then(response => response.json())
            .then(testimonials => {
                displayTestimonials(gridElement, testimonials, defaultImage);
            })
            .catch(error => {
                console.error('Error loading testimonials:', error);
            });
    }
    
    // Display testimonials
    function displayTestimonials(gridElement, testimonials, defaultImage) {
        gridElement.innerHTML = '';
        
        testimonials.forEach((testimonial, index) => {
            const card = createTestimonialCard(testimonial, defaultImage);
            gridElement.appendChild(card);
        });
    }
    
    // Create testimonial card element
    function createTestimonialCard(testimonial, defaultImage) {
        const card = document.createElement('div');
        card.className = 'hrcef-testimonial-card';
        
        const imageUrl = testimonial.image || defaultImage;
        
        card.innerHTML = `
            <div class="hrcef-testimonial-content-top">
                <blockquote class="hrcef-testimonial-quote">${escapeHtml(testimonial.quote)}</blockquote>
                <div class="hrcef-quote-icon">"</div>
                <div class="hrcef-testimonial-avatar" style="background-image: url('${escapeHtml(imageUrl)}')"></div>
            </div>
            <div class="hrcef-testimonial-footer">
                <div class="hrcef-testimonial-attribution">
                    <div class="hrcef-author-name">${escapeHtml(testimonial.author)}</div>
                    <div class="hrcef-author-institution">${escapeHtml(testimonial.institution)}</div>
                </div>
            </div>
        `;
        
        return card;
    }
    
    // Escape HTML to prevent XSS
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const grids = document.querySelectorAll('[data-testimonials-grid]');
        
        grids.forEach(function(grid) {
            // Store default image URL
            const defaultImageElement = grid.querySelector('.hrcef-testimonial-avatar');
            if (defaultImageElement) {
                const style = defaultImageElement.style.backgroundImage;
                const match = style.match(/url\(['"]?([^'"]+)['"]?\)/);
                if (match) {
                    grid.dataset.defaultImage = match[1];
                }
            }
            
            // Add click handlers to cards
            grid.addEventListener('click', function(e) {
                if (e.target.closest('.hrcef-testimonial-card')) {
                    loadRandomTestimonials(grid);
                }
            });
        });
        
        // Add click handler to refresh buttons
        const refreshButtons = document.querySelectorAll('[data-testimonials-refresh]');
        refreshButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const section = button.closest('.hrcef-testimonials-section');
                const grid = section.querySelector('[data-testimonials-grid]');
                if (grid) {
                    loadRandomTestimonials(grid);
                }
            });
        });
        
        // Handle window resize (debounced)
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                grids.forEach(function(grid) {
                    loadRandomTestimonials(grid);
                });
            }, 250);
        });
    });
})();
