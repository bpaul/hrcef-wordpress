<?php
/**
 * Grant Highlights Display Template
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

$card_count = isset($card_count) ? $card_count : 3;
$selected_tags = isset($selected_tags) ? $selected_tags : array();
$tags_string = !empty($selected_tags) ? implode(',', $selected_tags) : '';
?>

<div class="hrcef-grants-container alignfull" data-card-count="<?php echo esc_attr($card_count); ?>" data-tags="<?php echo esc_attr($tags_string); ?>">
    <div class="hrcef-grants-grid">
        <!-- Grant cards will be inserted here by JavaScript -->
    </div>
</div>
