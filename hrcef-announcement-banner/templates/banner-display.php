<?php
/**
 * Frontend Banner Display Template
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('hrcef_banner_settings');

// Get link URL
$link_url = '#';
if ($settings['link_type'] === 'custom') {
    $link_url = esc_url($settings['link_url']);
} elseif (!empty($settings['link_url'])) {
    $link_url = esc_url($settings['link_url']);
}

// Color scheme class
$color_class = 'hrcef-banner-' . esc_attr($settings['color_scheme']);

// Content version for dismissal tracking
$content_version = isset($settings['content_version']) ? $settings['content_version'] : 1;
?>

<div class="hrcef-announcement-banner <?php echo $color_class; ?>" id="hrcef-announcement-banner" data-dismissible="<?php echo $settings['dismissible'] ? '1' : '0'; ?>" data-version="<?php echo esc_attr($content_version); ?>">
    <div class="hrcef-banner-content">
        <div class="hrcef-banner-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <?php echo HRCEF_Announcement_Banner::get_icon_svg($settings['icon']); ?>
            </svg>
        </div>
        <div class="hrcef-banner-text">
            <strong><?php echo esc_html($settings['title']); ?></strong>
            <span><?php echo esc_html($settings['description']); ?></span>
        </div>
        <a href="<?php echo $link_url; ?>" class="hrcef-banner-link"><?php echo esc_html($settings['link_text']); ?></a>
        <?php if ($settings['dismissible']): ?>
        <button class="hrcef-banner-close" id="hrcef-banner-close" aria-label="<?php esc_attr_e('Close announcement', 'hrcef-announcement-banner'); ?>">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/>
                <line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
        <?php endif; ?>
    </div>
</div>
