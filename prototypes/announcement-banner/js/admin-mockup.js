(function() {
    'use strict';
    
    // Get form elements
    const form = document.getElementById('banner-settings-form');
    const titleInput = document.getElementById('banner_title');
    const descriptionInput = document.getElementById('banner_description');
    const linkTextInput = document.getElementById('banner_link_text');
    const linkTypeSelect = document.getElementById('banner_link_type');
    const colorRadios = document.querySelectorAll('input[name="banner_color"]');
    
    // Get preview elements
    const previewBanner = document.getElementById('banner-preview');
    const previewTitle = document.getElementById('preview-title');
    const previewDescription = document.getElementById('preview-description');
    const previewLinkText = document.getElementById('preview-link-text');
    
    // Update preview in real-time
    function updatePreview() {
        if (titleInput && previewTitle) {
            previewTitle.textContent = titleInput.value || 'Banner Title';
        }
        
        if (descriptionInput && previewDescription) {
            previewDescription.textContent = descriptionInput.value || 'Banner description text';
        }
        
        if (linkTextInput && previewLinkText) {
            previewLinkText.textContent = linkTextInput.value || 'Learn More →';
        }
    }
    
    // Update banner color
    function updateBannerColor() {
        const selectedColor = document.querySelector('input[name="banner_color"]:checked');
        if (!selectedColor || !previewBanner) return;
        
        // Remove all color classes
        previewBanner.className = 'announcement-banner-preview';
        
        // Add selected color class
        const colorValue = selectedColor.value;
        if (colorValue !== 'default') {
            previewBanner.classList.add(colorValue);
        }
        
        // Update button color based on gradient
        const linkButton = previewBanner.querySelector('.banner-link');
        if (linkButton) {
            switch(colorValue) {
                case 'event':
                    linkButton.style.color = '#0066B3';
                    previewBanner.style.background = 'linear-gradient(135deg, #0066B3, #008B8B)';
                    break;
                case 'deadline':
                    linkButton.style.color = '#D97706';
                    previewBanner.style.background = 'linear-gradient(135deg, #D97706, #F59E0B)';
                    break;
                case 'success':
                    linkButton.style.color = '#059669';
                    previewBanner.style.background = 'linear-gradient(135deg, #059669, #10B981)';
                    break;
                default:
                    linkButton.style.color = '#C41E3A';
                    previewBanner.style.background = 'linear-gradient(135deg, #C41E3A, #E63946)';
            }
        }
    }
    
    // Handle link type change
    function handleLinkTypeChange() {
        const linkType = linkTypeSelect.value;
        const postSelector = document.getElementById('post-selector');
        const customUrl = document.getElementById('custom-url');
        
        if (linkType === 'custom') {
            if (postSelector) postSelector.style.display = 'none';
            if (customUrl) customUrl.style.display = 'table-row';
        } else {
            if (postSelector) postSelector.style.display = 'table-row';
            if (customUrl) customUrl.style.display = 'none';
        }
    }
    
    // Form submission
    function handleFormSubmit(e) {
        e.preventDefault();
        
        // Show success notice
        const notice = document.getElementById('success-notice');
        if (notice) {
            notice.style.display = 'block';
            
            // Auto-hide after 3 seconds
            setTimeout(() => {
                notice.style.display = 'none';
            }, 3000);
        }
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        console.log('Form submitted (mockup - no actual save)');
    }
    
    // Reset form
    function handleReset() {
        if (confirm('Are you sure you want to reset all settings to defaults?')) {
            form.reset();
            updatePreview();
            updateBannerColor();
            handleLinkTypeChange();
        }
    }
    
    // Dismiss notice
    function setupNoticeDismiss() {
        const dismissButtons = document.querySelectorAll('.notice-dismiss');
        dismissButtons.forEach(button => {
            button.addEventListener('click', function() {
                const notice = this.closest('.notice');
                if (notice) {
                    notice.style.display = 'none';
                }
            });
        });
    }
    
    // Event listeners
    if (titleInput) {
        titleInput.addEventListener('input', updatePreview);
    }
    
    if (descriptionInput) {
        descriptionInput.addEventListener('input', updatePreview);
    }
    
    if (linkTextInput) {
        linkTextInput.addEventListener('input', updatePreview);
    }
    
    if (linkTypeSelect) {
        linkTypeSelect.addEventListener('change', handleLinkTypeChange);
    }
    
    colorRadios.forEach(radio => {
        radio.addEventListener('change', updateBannerColor);
    });
    
    if (form) {
        form.addEventListener('submit', handleFormSubmit);
    }
    
    const resetButton = document.getElementById('reset-banner');
    if (resetButton) {
        resetButton.addEventListener('click', handleReset);
    }
    
    // Initialize
    setupNoticeDismiss();
    handleLinkTypeChange();
    updatePreview();
    updateBannerColor();
    
})();
