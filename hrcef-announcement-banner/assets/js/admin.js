(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // Get form elements
        const $form = $('#hrcef-banner-settings-form');
        const $titleInput = $('#banner_title');
        const $descriptionInput = $('#banner_description');
        const $linkTextInput = $('#banner_link_text');
        const $linkTypeSelect = $('#banner_link_type');
        const $iconSelect = $('#banner_icon');
        const $colorRadios = $('input[name="color_scheme"]');
        
        // Get preview elements
        const $previewBanner = $('#banner-preview');
        const $previewTitle = $('#preview-title');
        const $previewDescription = $('#preview-description');
        const $previewLinkText = $('#preview-link-text');
        const $previewIcon = $previewBanner.find('.hrcef-banner-icon svg');
        
        // Icon SVG paths
        const iconPaths = {
            graduation: '<path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5M2 12l10 5 10-5"/>',
            calendar: '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
            megaphone: '<path d="M3 11l18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>',
            star: '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
            bell: '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
            trophy: '<path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2z"/>'
        };
        
        // Update preview in real-time
        function updatePreview() {
            if ($titleInput.val()) {
                $previewTitle.text($titleInput.val());
            }
            
            if ($descriptionInput.val()) {
                $previewDescription.text($descriptionInput.val());
            }
            
            if ($linkTextInput.val()) {
                $previewLinkText.text($linkTextInput.val());
            }
        }
        
        // Update banner color
        function updateBannerColor() {
            const selectedColor = $('input[name="color_scheme"]:checked').val();
            
            // Remove all color classes
            $previewBanner.removeClass('default event deadline success');
            
            // Add selected color class
            if (selectedColor !== 'default') {
                $previewBanner.addClass(selectedColor);
            }
        }
        
        // Update icon
        function updateIcon() {
            const selectedIcon = $iconSelect.val();
            if (iconPaths[selectedIcon]) {
                $previewIcon.html(iconPaths[selectedIcon]);
            }
        }
        
        // Handle link type change
        function handleLinkTypeChange() {
            const linkType = $linkTypeSelect.val();
            
            if (linkType === 'custom') {
                $('#post-selector').hide();
                $('#custom-url').show();
            } else {
                $('#post-selector').show();
                $('#custom-url').hide();
            }
        }
        
        // Form submission
        $form.on('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                action: 'hrcef_save_banner_settings',
                nonce: hrcefBanner.nonce,
                enabled: $('#banner_enabled').is(':checked'),
                title: $titleInput.val(),
                description: $descriptionInput.val(),
                link_type: $linkTypeSelect.val(),
                link_url: $('#banner_link_type').val() === 'custom' ? $('#banner_custom_url').val() : $('#banner_post option:selected').data('url'),
                link_text: $linkTextInput.val(),
                color_scheme: $('input[name="color_scheme"]:checked').val(),
                icon: $iconSelect.val(),
                dismissible: $('#banner_dismissible').is(':checked'),
                show_on: $('input[name="show_on"]:checked').val(),
                start_date: $('#banner_start_date').val(),
                end_date: $('#banner_end_date').val()
            };
            
            $.ajax({
                url: hrcefBanner.ajaxurl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    showMessage('Settings saved successfully!', 'success');
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
                },
                error: function() {
                    showMessage('Error saving settings. Please try again.', 'error');
                }
            });
        });
        
        // Show message
        function showMessage(message, type) {
            const $notice = $('#hrcef-banner-message');
            $notice.removeClass('notice-success notice-error')
                   .addClass('notice-' + type)
                   .find('p').text(message);
            $notice.show();
            
            setTimeout(function() {
                $notice.fadeOut();
            }, 3000);
        }
        
        // Event listeners
        $titleInput.on('input', updatePreview);
        $descriptionInput.on('input', updatePreview);
        $linkTextInput.on('input', updatePreview);
        $linkTypeSelect.on('change', handleLinkTypeChange);
        $iconSelect.on('change', updateIcon);
        $colorRadios.on('change', updateBannerColor);
        
        // Initialize
        handleLinkTypeChange();
        updatePreview();
        updateBannerColor();
        updateIcon();
    });
    
})(jQuery);
