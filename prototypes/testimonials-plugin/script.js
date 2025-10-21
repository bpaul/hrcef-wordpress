// Get number of cards to display based on screen size
function getCardCount() {
    const width = window.innerWidth;
    if (width <= 768) return 1;  // Mobile: 1 card
    if (width <= 1024) return 2; // Tablet: 2 cards
    return 3;                     // Desktop: 3 cards
}

// Load testimonials from JSON file and display random ones based on screen size
async function loadRandomTestimonials() {
    try {
        const response = await fetch('testimonials.json');
        const testimonials = await response.json();
        
        // Select random testimonials based on screen size
        const count = getCardCount();
        const randomTestimonials = getRandomTestimonials(testimonials, count);
        
        // Display the testimonials
        displayTestimonials(randomTestimonials);
    } catch (error) {
        console.error('Error loading testimonials:', error);
        displayErrorMessage();
    }
}

// Get random testimonials without duplicates
function getRandomTestimonials(testimonials, count) {
    const shuffled = [...testimonials].sort(() => 0.5 - Math.random());
    return shuffled.slice(0, Math.min(count, testimonials.length));
}

// Get initials from author name for avatar
function getInitials(name) {
    return name
        .split(' ')
        .map(word => word[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);
}

function displayTestimonials(testimonials) {
    const gridElement = document.getElementById('testimonials-grid');
    
    // Clear existing cards
    gridElement.innerHTML = '';
    
    // Create and append cards
    testimonials.forEach((testimonial, index) => {
        const card = createTestimonialCard(testimonial, index);
        gridElement.appendChild(card);
    });
}

function createTestimonialCard(testimonial, index) {
    const card = document.createElement('div');
    card.className = 'testimonial-card';
    
    // Use default image if none provided
    const imageUrl = testimonial.image || 'images/student-placeholder-6.svg';
    
    card.innerHTML = `
        <div class="testimonial-content-top">
            <blockquote class="testimonial-quote">${testimonial.quote}</blockquote>
            <div class="quote-icon">"</div>
            <div class="testimonial-avatar" style="background-image: url('${imageUrl}')"></div>
        </div>
        <div class="testimonial-footer">
            <div class="testimonial-attribution">
                <div class="author-name">${testimonial.author}</div>
                <div class="author-institution">${testimonial.institution}</div>
            </div>
        </div>
    `;
    
    // Add click handler to reload testimonials
    card.style.cursor = 'pointer';
    card.addEventListener('click', loadRandomTestimonials);
    
    return card;
}

function displayErrorMessage() {
    const gridElement = document.getElementById('testimonials-grid');
    gridElement.innerHTML = '<p style="text-align: center; color: #666;">Unable to load testimonials at this time.</p>';
}

// Load testimonials when page loads
document.addEventListener('DOMContentLoaded', () => {
    loadRandomTestimonials();
    
    // Add click handler to refresh button
    const refreshButton = document.getElementById('refresh-button');
    refreshButton.addEventListener('click', loadRandomTestimonials);
    
    // Reload testimonials on window resize (debounced)
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            loadRandomTestimonials();
        }, 250);
    });
});
