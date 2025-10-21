<?php
/**
 * Admin Settings Page
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php _e('HRCEF Testimonials Settings', 'hrcef-testimonials'); ?></h1>
    
    <div class="card">
        <h2><?php _e('How to Use', 'hrcef-testimonials'); ?></h2>
        <ol>
            <li><strong><?php _e('Add Testimonials:', 'hrcef-testimonials'); ?></strong> <?php _e('Go to Testimonials > Add New to create testimonials.', 'hrcef-testimonials'); ?></li>
            <li><strong><?php _e('Enter Details:', 'hrcef-testimonials'); ?></strong> <?php _e('Add the quote in the content editor, then fill in the author name and institution.', 'hrcef-testimonials'); ?></li>
            <li><strong><?php _e('Add Photo (Optional):', 'hrcef-testimonials'); ?></strong> <?php _e('Set a featured image. If no image is provided, a default placeholder will be used.', 'hrcef-testimonials'); ?></li>
            <li><strong><?php _e('Display Testimonials:', 'hrcef-testimonials'); ?></strong> <?php _e('Use the Gutenberg block "HRCEF Testimonials" in any page or post.', 'hrcef-testimonials'); ?></li>
        </ol>
    </div>
    
    <div class="card">
        <h2><?php _e('Gutenberg Block', 'hrcef-testimonials'); ?></h2>
        <p><?php _e('The HRCEF Testimonials block displays random testimonials in a beautiful card layout.', 'hrcef-testimonials'); ?></p>
        <ul>
            <li><?php _e('Desktop: Shows 3 testimonials', 'hrcef-testimonials'); ?></li>
            <li><?php _e('Tablet: Shows 2 testimonials', 'hrcef-testimonials'); ?></li>
            <li><?php _e('Mobile: Shows 1 testimonial', 'hrcef-testimonials'); ?></li>
        </ul>
        <p><?php _e('Visitors can click on any card or the refresh button to load new random testimonials.', 'hrcef-testimonials'); ?></p>
    </div>
    
    <div class="card">
        <h2><?php _e('Block Settings', 'hrcef-testimonials'); ?></h2>
        <p><?php _e('When you add the block to a page, you can configure:', 'hrcef-testimonials'); ?></p>
        <ul>
            <li><strong><?php _e('Number of Testimonials:', 'hrcef-testimonials'); ?></strong> <?php _e('Choose how many testimonials to display (1-6)', 'hrcef-testimonials'); ?></li>
        </ul>
    </div>
    
    <div class="card">
        <h2><?php _e('Design Features', 'hrcef-testimonials'); ?></h2>
        <ul>
            <li><?php _e('Split card design with circular photo in the middle', 'hrcef-testimonials'); ?></li>
            <li><?php _e('HRCEF brand gradient (blue to teal) on footer', 'hrcef-testimonials'); ?></li>
            <li><?php _e('Hover effects and smooth animations', 'hrcef-testimonials'); ?></li>
            <li><?php _e('Fully responsive design', 'hrcef-testimonials'); ?></li>
            <li><?php _e('Click to refresh functionality', 'hrcef-testimonials'); ?></li>
        </ul>
    </div>
    
    <div class="card">
        <h2><?php _e('Quick Links', 'hrcef-testimonials'); ?></h2>
        <p>
            <a href="<?php echo admin_url('post-new.php?post_type=hrcef_testimonial'); ?>" class="button button-primary">
                <?php _e('Add New Testimonial', 'hrcef-testimonials'); ?>
            </a>
            <a href="<?php echo admin_url('edit.php?post_type=hrcef_testimonial'); ?>" class="button">
                <?php _e('View All Testimonials', 'hrcef-testimonials'); ?>
            </a>
        </p>
    </div>
    
    <div class="card">
        <h2><?php _e('Plugin Information', 'hrcef-testimonials'); ?></h2>
        <p><strong><?php _e('Version:', 'hrcef-testimonials'); ?></strong> <?php echo HRCEF_TESTIMONIALS_VERSION; ?></p>
        <p><strong><?php _e('Developed for:', 'hrcef-testimonials'); ?></strong> Hood River County Education Foundation</p>
    </div>
</div>

<style>
.wrap .card {
    max-width: 800px;
    margin-bottom: 20px;
}
.wrap .card h2 {
    margin-top: 0;
}
.wrap .card ul,
.wrap .card ol {
    margin-left: 20px;
}
.wrap .card li {
    margin-bottom: 8px;
}
</style>
