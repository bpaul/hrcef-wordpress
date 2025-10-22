<?php
/**
 * Grant Highlights Display Template
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

$card_count = isset($card_count) ? $card_count : 3;
?>

<div class="hrcef-grants-container alignfull" data-card-count="<?php echo esc_attr($card_count); ?>">
    <div class="hrcef-grants-grid">
        <!-- Grant cards will be inserted here by JavaScript -->
    </div>
</div>
