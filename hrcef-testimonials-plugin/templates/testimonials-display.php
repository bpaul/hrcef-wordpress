<?php
/**
 * Template for displaying testimonials
 * 
 * @var array $testimonials Array of testimonial post objects
 */

if (empty($testimonials)) {
    return;
}

$default_image = HRCEF_TESTIMONIALS_PLUGIN_URL . 'assets/images/student-placeholder-6.svg';
?>

<div class="hrcef-testimonials-section">
    <div class="hrcef-testimonials-grid" data-testimonials-grid>
        <?php foreach ($testimonials as $testimonial): 
            $author = get_post_meta($testimonial->ID, '_hrcef_author', true);
            $institution = get_post_meta($testimonial->ID, '_hrcef_institution', true);
            $image_id = get_post_thumbnail_id($testimonial->ID);
            $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : $default_image;
            $quote = wp_strip_all_tags($testimonial->post_content);
        ?>
        <div class="hrcef-testimonial-card">
            <div class="hrcef-testimonial-content-top">
                <blockquote class="hrcef-testimonial-quote"><?php echo esc_html($quote); ?></blockquote>
                <div class="hrcef-quote-icon">"</div>
                <div class="hrcef-testimonial-avatar" style="background-image: url('<?php echo esc_url($image_url); ?>')"></div>
            </div>
            <div class="hrcef-testimonial-footer">
                <div class="hrcef-testimonial-attribution">
                    <div class="hrcef-author-name"><?php echo esc_html($author); ?></div>
                    <div class="hrcef-author-institution"><?php echo esc_html($institution); ?></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <button class="hrcef-refresh-button" data-testimonials-refresh aria-label="<?php esc_attr_e('Load new testimonials', 'hrcef-testimonials'); ?>">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/>
        </svg>
        <?php _e('Load New Testimonials', 'hrcef-testimonials'); ?>
    </button>
</div>
