(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Tab switching
        $('.tab-button').on('click', function() {
            const tabName = $(this).data('tab');
            
            // Remove active class from all tabs
            $('.tab-button').removeClass('active');
            $('.tab-content').removeClass('active');
            
            // Add active class to clicked tab
            $(this).addClass('active');
            $('#' + tabName + '-tab').addClass('active');
        });
        
        // Themed image selection
        $('.hrcef-themed-image-option, .themed-image-option').on('click', function() {
            const imagePath = $(this).data('image');
            
            // Remove selected class from all
            $('.hrcef-themed-image-option, .themed-image-option').removeClass('selected');
            
            // Add selected class to clicked
            $(this).addClass('selected');
            
            // Update hidden field
            $('#image-url').val(imagePath);
            
            // Update preview
            $('#preview-image').attr('src', imagePath);
        });
        
        // Live preview updates
        $('#grant-description').on('input', function() {
            const val = $(this).val();
            $('#preview-description').text(val || 'Grant description will appear here...');
        });
        
        $('#school-name').on('input', function() {
            const val = $(this).val();
            $('#preview-school').text(val || 'School Name');
        });
        
        $('#teacher-name').on('input', function() {
            const val = $(this).val();
            $('#preview-teacher').text(val || 'Teacher Name');
        });
        
        $('#grant-year').on('change', function() {
            const val = $(this).val();
            $('#preview-year').text(val || 'Year');
        });
        
        // Form submission
        $('#hrcef-grant-form').on('submit', function(e) {
            e.preventDefault();
            saveGrant('publish');
        });
        
        // Save as draft
        $('#save-draft-button').on('click', function(e) {
            e.preventDefault();
            saveGrant('draft');
        });
        
        // Save grant function
        function saveGrant(status) {
            // Check if hrcefGrantsAdmin exists
            if (typeof hrcefGrantsAdmin === 'undefined') {
                alert('Error: Admin scripts not loaded properly. Please refresh the page.');
                return;
            }
            
            const formData = {
                action: 'hrcef_save_grant',
                nonce: hrcefGrantsAdmin.nonce,
                grant_id: $('#grant_id').val(),
                description: $('#grant-description').val(),
                school_name: $('#school-name').val(),
                teacher_name: $('#teacher-name').val(),
                grant_year: $('#grant-year').val(),
                image_url: $('#image-url').val(),
                status: status
            };
            
            console.log('Saving grant with data:', formData);
            
            // Disable buttons
            $('#publish-button, #save-draft-button').prop('disabled', true).text('Saving...');
            
            $.ajax({
                url: hrcefGrantsAdmin.ajaxurl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log('AJAX response:', response);
                    if (response.success) {
                        showMessage(response.data.message, 'success');
                        
                        // Redirect after short delay
                        setTimeout(function() {
                            window.location.href = response.data.redirect_url;
                        }, 1500);
                    } else {
                        showMessage(response.data.message, 'error');
                        $('#publish-button, #save-draft-button').prop('disabled', false);
                        $('#publish-button').text($('#grant_id').val() ? 'Update Grant Highlight' : 'Publish Grant Highlight');
                        $('#save-draft-button').text('Save as Draft');
                    }
                },
                error: function() {
                    showMessage('Error saving grant. Please try again.', 'error');
                    $('#publish-button, #save-draft-button').prop('disabled', false);
                    $('#publish-button').text($('#grant_id').val() ? 'Update Grant Highlight' : 'Publish Grant Highlight');
                    $('#save-draft-button').text('Save as Draft');
                }
            });
        }
        
        // Show message
        function showMessage(message, type) {
            const $notice = $('#hrcef-grant-message');
            $notice.removeClass('notice-success notice-error')
                   .addClass('notice-' + type)
                   .find('p').text(message);
            $notice.show();
            
            $('html, body').animate({ scrollTop: 0 }, 'fast');
            
            if (type === 'success') {
                setTimeout(function() {
                    $notice.fadeOut();
                }, 3000);
            }
        }
    });
    
})(jQuery);
