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
        
        // Create elements and set text content directly to avoid HTML encoding issues
        const contentTop = document.createElement('div');
        contentTop.className = 'hrcef-testimonial-content-top';
        
        const quote = document.createElement('blockquote');
        quote.className = 'hrcef-testimonial-quote';
        quote.textContent = decodeHtmlEntities(testimonial.quote);
        
        const quoteIcon = document.createElement('div');
        quoteIcon.className = 'hrcef-quote-icon';
        quoteIcon.textContent = '"';
        
        const avatar = document.createElement('div');
        avatar.className = 'hrcef-testimonial-avatar';
        avatar.style.backgroundImage = `url('${imageUrl}')`;
        
        contentTop.appendChild(quote);
        contentTop.appendChild(quoteIcon);
        contentTop.appendChild(avatar);
        
        const footer = document.createElement('div');
        footer.className = 'hrcef-testimonial-footer';
        
        const attribution = document.createElement('div');
        attribution.className = 'hrcef-testimonial-attribution';
        
        const authorName = document.createElement('div');
        authorName.className = 'hrcef-author-name';
        authorName.textContent = testimonial.author;
        
        const authorInstitution = document.createElement('div');
        authorInstitution.className = 'hrcef-author-institution';
        authorInstitution.textContent = testimonial.institution;
        
        attribution.appendChild(authorName);
        attribution.appendChild(authorInstitution);
        footer.appendChild(attribution);
        
        card.appendChild(contentTop);
        card.appendChild(footer);
        
        return card;
    }
    
    // Decode HTML entities
    function decodeHtmlEntities(text) {
        const textarea = document.createElement('textarea');
        textarea.innerHTML = text;
        return textarea.value;
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
