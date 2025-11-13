(function() {
    'use strict';
    
    let allGrants = [];
    const containers = document.querySelectorAll('.hrcef-grants-container');
    
    containers.forEach(container => {
        const grantsGrid = container.querySelector('.hrcef-grants-grid');
        const cardCount = parseInt(container.getAttribute('data-card-count')) || 3;
        const tags = container.getAttribute('data-tags') || '';
        
        // Fetch grants data
        async function fetchGrants() {
            try {
                let url = hrcefGrants.restUrl;
                if (tags) {
                    url += '?tags=' + tags;
                }
                const response = await fetch(url);
                allGrants = await response.json();
                displayRandomGrants();
            } catch (error) {
                console.error('Error loading grants:', error);
                grantsGrid.innerHTML = '<p style="text-align: center; color: #666;">Unable to load grant highlights. Please try again.</p>';
            }
        }
        
        // Get random grants
        function getRandomGrants(count) {
            const shuffled = [...allGrants].sort(() => Math.random() - 0.5);
            return shuffled.slice(0, Math.min(count, shuffled.length));
        }
        
        // Create grant card HTML
        function createGrantCard(grant) {
            const imageUrl = grant.image || hrcefGrants.pluginUrl + 'assets/images/grant-placeholder.svg';
            const title = grant.title || 'Grant Project';
            
            return `
                <div class="grant-card">
                    <div class="grant-image">
                        <img src="${imageUrl}" alt="${grant.school} grant project">
                    </div>
                    <div class="grant-title">
                        <h3>${title}</h3>
                    </div>
                    <div class="grant-content">
                        <p class="grant-description">${grant.description}</p>
                    </div>
                    <div class="grant-attribution">
                        <div class="grant-school">${grant.school}</div>
                        <div class="grant-meta">
                            ${grant.teacher ? `<span class="grant-teacher">${grant.teacher}</span>` : ''}
                            <span class="grant-year">${grant.year}</span>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Display random grants
        function displayRandomGrants() {
            const randomGrants = getRandomGrants(cardCount);
            
            // Add loading state
            grantsGrid.classList.add('loading');
            
            // Small delay for smooth transition
            setTimeout(() => {
                grantsGrid.innerHTML = randomGrants.map(grant => createGrantCard(grant)).join('');
                grantsGrid.classList.remove('loading');
            }, 300);
        }
        
        // Click on card to refresh
        grantsGrid.addEventListener('click', function(e) {
            const card = e.target.closest('.grant-card');
            if (card) {
                displayRandomGrants();
            }
        });
        
        // Initialize
        fetchGrants();
    });
})();
