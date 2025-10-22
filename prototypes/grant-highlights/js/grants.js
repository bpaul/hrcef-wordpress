(function() {
    'use strict';
    
    let allGrants = [];
    const grantsGrid = document.getElementById('grants-grid');
    const refreshButton = document.getElementById('refresh-grants');
    const CARDS_TO_SHOW = 3;
    
    // Fetch grants data
    async function fetchGrants() {
        try {
            const response = await fetch('grants.json');
            allGrants = await response.json();
            displayRandomGrants();
        } catch (error) {
            console.error('Error loading grants:', error);
            grantsGrid.innerHTML = '<p style="text-align: center; color: #666;">Unable to load grants. Please try again.</p>';
        }
    }
    
    // Get random grants
    function getRandomGrants(count) {
        const shuffled = [...allGrants].sort(() => Math.random() - 0.5);
        return shuffled.slice(0, Math.min(count, shuffled.length));
    }
    
    // Create grant card HTML
    function createGrantCard(grant) {
        return `
            <div class="grant-card">
                <div class="grant-image">
                    <img src="${grant.image}" alt="${grant.school} grant project" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22200%22%3E%3Crect fill=%22%23e0e0e0%22 width=%22400%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 font-family=%22sans-serif%22 font-size=%2218%22 fill=%22%23999%22%3EGrant Image%3C/text%3E%3C/svg%3E'">
                </div>
                <div class="grant-content">
                    <p class="grant-description">${grant.description}</p>
                </div>
                <div class="grant-attribution">
                    <div class="grant-school">${grant.school}</div>
                    <div class="grant-meta">
                        <span class="grant-teacher">${grant.teacher}</span>
                        <span class="grant-year">${grant.year}</span>
                    </div>
                </div>
            </div>
        `;
    }
    
    // Display random grants
    function displayRandomGrants() {
        const randomGrants = getRandomGrants(CARDS_TO_SHOW);
        
        // Add loading state
        grantsGrid.classList.add('loading');
        
        // Small delay for smooth transition
        setTimeout(() => {
            grantsGrid.innerHTML = randomGrants.map(grant => createGrantCard(grant)).join('');
            grantsGrid.classList.remove('loading');
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
        
        displayRandomGrants();
    });
    
    // Click on card to refresh
    grantsGrid.addEventListener('click', function(e) {
        const card = e.target.closest('.grant-card');
        if (card) {
            displayRandomGrants();
        }
    });
    
    // Initialize
    fetchGrants();
})();
