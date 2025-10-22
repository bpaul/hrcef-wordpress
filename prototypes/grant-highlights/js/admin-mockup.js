(function() {
    'use strict';
    
    // Tab switching
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            
            // Remove active class from all tabs
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            document.getElementById(tabName + '-tab').classList.add('active');
        });
    });
    
    // Themed image selection
    const themedImages = document.querySelectorAll('.themed-image-option');
    const currentImagePreview = document.getElementById('current-image-preview');
    const previewImage = document.getElementById('preview-image');
    
    themedImages.forEach(option => {
        option.addEventListener('click', function() {
            const imagePath = 'images/' + this.getAttribute('data-image');
            
            // Remove selected class from all
            themedImages.forEach(img => img.classList.remove('selected'));
            
            // Add selected class to clicked
            this.classList.add('selected');
            
            // Update preview images
            currentImagePreview.src = imagePath;
            previewImage.src = imagePath;
        });
    });
    
    // Live preview updates
    const descriptionInput = document.getElementById('grant-description');
    const schoolInput = document.getElementById('school-name');
    const teacherInput = document.getElementById('teacher-name');
    const yearSelect = document.getElementById('grant-year');
    
    const previewDescription = document.getElementById('preview-description');
    const previewSchool = document.getElementById('preview-school');
    const previewTeacher = document.getElementById('preview-teacher');
    const previewYear = document.getElementById('preview-year');
    
    // Update preview on input
    descriptionInput.addEventListener('input', function() {
        previewDescription.textContent = this.value || 'Grant description will appear here...';
    });
    
    schoolInput.addEventListener('input', function() {
        previewSchool.textContent = this.value || 'School Name';
    });
    
    teacherInput.addEventListener('input', function() {
        previewTeacher.textContent = this.value || 'Teacher Name';
    });
    
    yearSelect.addEventListener('change', function() {
        previewYear.textContent = this.value || 'Year';
    });
    
    // Form submission (mockup)
    const form = document.querySelector('.grant-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Grant Highlight Published!\n\nIn the actual plugin, this would save to WordPress and display in the frontend.');
    });
})();
