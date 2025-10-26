<?php
/**
 * Template for displaying testimonials
 * 
 * @var array $testimonials Array of testimonial post objects
 * @var string $align Alignment class (wide, full, or empty)
 * @var array $selected_tags Array of selected tag IDs
 */

if (empty($testimonials)) {
    return;
}

$default_image = HRCEF_TESTIMONIALS_PLUGIN_URL . 'assets/images/student-placeholder-6.svg';
$align_class = !empty($align) ? 'align' . $align : '';
$tags_string = !empty($selected_tags) ? implode(',', $selected_tags) : '';
?>

<div class="hrcef-testimonials-section <?php echo esc_attr($align_class); ?>">
    <div class="hrcef-testimonials-grid" data-testimonials-grid data-tags="<?php echo esc_attr($tags_string); ?>" data-default-image="<?php echo esc_url($default_image); ?>">
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
</div>
