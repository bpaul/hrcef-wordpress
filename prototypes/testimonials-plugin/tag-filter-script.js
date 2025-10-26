(function() {
    'use strict';
    
    let allTestimonials = [];
    let filteredTestimonials = [];
    let activeFilters = new Set();
    const cardCount = 3;
    
    const grid = document.getElementById('testimonialsGrid');
    const refreshButton = document.getElementById('refreshButton');
    const tagFiltersContainer = document.getElementById('tagFilters');
    const activeFiltersDiv = document.getElementById('activeFilters');
    const activeFiltersList = document.getElementById('activeFiltersList');
    const clearFiltersButton = document.getElementById('clearFilters');
    const resultsCount = document.getElementById('resultsCount');
    const noResults = document.getElementById('noResults');
    
    // Fetch testimonials data
    async function fetchTestimonials() {
        try {
            const response = await fetch('testimonials-with-tags.json');
            allTestimonials = await response.json();
            filteredTestimonials = [...allTestimonials];
            
            renderTagFilters();
            updateResultsCount();
            displayRandomTestimonials();
        } catch (error) {
            console.error('Error loading testimonials:', error);
            grid.innerHTML = '<p style="text-align: center; color: #666;">Unable to load testimonials. Please try again.</p>';
        }
    }
    
    // Get all unique tags from testimonials
    function getAllTags() {
        const tagCounts = {};
        
        allTestimonials.forEach(testimonial => {
            if (testimonial.tags) {
                testimonial.tags.forEach(tag => {
                    tagCounts[tag] = (tagCounts[tag] || 0) + 1;
                });
            }
        });
        
        return Object.entries(tagCounts)
            .sort((a, b) => b[1] - a[1]) // Sort by count descending
            .map(([tag, count]) => ({ tag, count }));
    }
    
    // Render tag filter buttons
    function renderTagFilters() {
        const tags = getAllTags();
        
        tagFiltersContainer.innerHTML = tags.map(({ tag, count }) => `
            <button class="tag-filter" data-tag="${tag}">
                ${formatTagName(tag)}
                <span class="count">${count}</span>
            </button>
        `).join('');
        
        // Add click handlers
        document.querySelectorAll('.tag-filter').forEach(button => {
            button.addEventListener('click', () => toggleFilter(button.dataset.tag, button));
        });
    }
    
    // Format tag name for display
    function formatTagName(tag) {
        return tag
            .split('-')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
    }
    
    // Toggle filter on/off
    function toggleFilter(tag, button) {
        if (activeFilters.has(tag)) {
            activeFilters.delete(tag);
            button.classList.remove('active');
        } else {
            activeFilters.add(tag);
            button.classList.add('active');
        }
        
        applyFilters();
    }
    
    // Apply active filters
    function applyFilters() {
        if (activeFilters.size === 0) {
            // No filters - show all
            filteredTestimonials = [...allTestimonials];
        } else {
            // Filter testimonials that have ALL active tags (AND logic)
            // Change to ANY tag (OR logic) by using .some() instead of .every()
            filteredTestimonials = allTestimonials.filter(testimonial => {
                if (!testimonial.tags) return false;
                
                // OR logic: testimonial has at least one of the active tags
                return Array.from(activeFilters).some(tag => testimonial.tags.includes(tag));
            });
        }
        
        updateActiveFiltersDisplay();
        updateResultsCount();
        displayRandomTestimonials();
    }
    
    // Update active filters display
    function updateActiveFiltersDisplay() {
        if (activeFilters.size === 0) {
            activeFiltersDiv.style.display = 'none';
        } else {
            activeFiltersDiv.style.display = 'flex';
            activeFiltersList.textContent = Array.from(activeFilters)
                .map(formatTagName)
                .join(', ');
        }
    }
    
    // Update results count
    function updateResultsCount() {
        const total = filteredTestimonials.length;
        const showing = Math.min(total, cardCount);
        
        if (total === 0) {
            resultsCount.style.display = 'none';
        } else {
            resultsCount.style.display = 'block';
            resultsCount.innerHTML = `Showing <strong>${showing}</strong> of <strong>${total}</strong> testimonials`;
        }
    }
    
    // Clear all filters
    clearFiltersButton.addEventListener('click', () => {
        activeFilters.clear();
        document.querySelectorAll('.tag-filter').forEach(button => {
            button.classList.remove('active');
        });
        applyFilters();
    });
    
    // Get random testimonials from filtered set
    function getRandomTestimonials(count) {
        const shuffled = [...filteredTestimonials].sort(() => Math.random() - 0.5);
        return shuffled.slice(0, Math.min(count, shuffled.length));
    }
    
    // Create testimonial card HTML
    function createTestimonialCard(testimonial) {
        return `
            <div class="hrcef-testimonial-card">
                <div class="hrcef-testimonial-content">
                    <div class="hrcef-testimonial-quote-icon">"</div>
                    <p class="hrcef-testimonial-quote">${testimonial.quote}</p>
                </div>
                <div class="hrcef-testimonial-avatar">
                    <img src="${testimonial.image}" alt="${testimonial.author}">
                </div>
                <div class="hrcef-testimonial-footer">
                    <div class="hrcef-testimonial-author">${testimonial.author}</div>
                    <div class="hrcef-testimonial-institution">${testimonial.institution}</div>
                </div>
            </div>
        `;
    }
    
    // Display random testimonials
    function displayRandomTestimonials() {
        if (filteredTestimonials.length === 0) {
            grid.style.display = 'none';
            noResults.style.display = 'block';
            return;
        }
        
        grid.style.display = 'grid';
        noResults.style.display = 'none';
        
        const randomTestimonials = getRandomTestimonials(cardCount);
        
        // Add loading state
        grid.classList.add('loading');
        
        // Small delay for smooth transition
        setTimeout(() => {
            grid.innerHTML = randomTestimonials.map(testimonial => 
                createTestimonialCard(testimonial)
            ).join('');
            grid.classList.remove('loading');
        }, 300);
    }
    
    // Refresh button handler
    refreshButton.addEventListener('click', function() {
        // Add spinning animation
        this.classList.add('spinning');
        
        // Remove spinning class after animation
        setTimeout(() => {
            this.classList.remove('spinning');
        }, 600);
        
        displayRandomTestimonials();
    });
    
    // Click on card to refresh
    grid.addEventListener('click', function(e) {
        const card = e.target.closest('.hrcef-testimonial-card');
        if (card) {
            displayRandomTestimonials();
        }
    });
    
    // Initialize
    fetchTestimonials();
})();
