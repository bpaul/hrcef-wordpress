<?php
/**
 * Grant Highlights Display Template
 * 
 * @var array $grants Array of grant post objects
 * @var string $align Alignment class (wide, full, or empty)
 * @var array $selected_tags Array of selected tag IDs
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

if (empty($grants)) {
    return;
}

$align_class = !empty($align) ? 'align' . $align : '';
$card_count = isset($card_count) ? $card_count : count($grants);
$tags_string = !empty($selected_tags) ? implode(',', $selected_tags) : '';
?>

<div class="hrcef-grants-container <?php echo esc_attr($align_class); ?>" data-card-count="<?php echo esc_attr($card_count); ?>" data-tags="<?php echo esc_attr($tags_string); ?>">
    <div class="hrcef-grants-grid">
        <?php foreach ($grants as $grant): 
            $school = get_post_meta($grant->ID, 'school_name', true);
            $teacher = get_post_meta($grant->ID, 'teacher_name', true);
            $year = get_post_meta($grant->ID, 'grant_year', true);
            $description = wp_strip_all_tags($grant->post_content);
            
            // Get image - check for themed image first, then featured image, then default
            $themed_image = get_post_meta($grant->ID, '_themed_image', true);
            if ($themed_image) {
                $image_url = HRCEF_GRANTS_PLUGIN_URL . 'assets/images/' . $themed_image;
            } else {
                $image_url = get_the_post_thumbnail_url($grant->ID, 'large');
                if (!$image_url) {
                    $image_url = HRCEF_GRANTS_PLUGIN_URL . 'assets/images/grant-1.svg';
                }
            }
        ?>
        <div class="grant-card">
            <div class="grant-image">
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($school); ?> grant project">
            </div>
            <div class="grant-title">
                <h3><?php echo esc_html(get_the_title($grant->ID)); ?></h3>
            </div>
            <div class="grant-content">
                <p class="grant-description"><?php echo esc_html($description); ?></p>
            </div>
            <div class="grant-attribution">
                <div class="grant-school"><?php echo esc_html($school); ?></div>
                <div class="grant-meta">
                    <?php if (!empty($teacher)): ?>
                        <span class="grant-teacher"><?php echo esc_html($teacher); ?></span>
                    <?php endif; ?>
                    <span class="grant-year"><?php echo esc_html($year); ?></span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
