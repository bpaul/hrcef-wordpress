<?php
/**
 * Admin Settings Page
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

$settings = get_option('hrcef_banner_settings');
$posts = get_posts(array('numberposts' => 50, 'post_status' => 'publish', 'post_type' => array('post', 'page'), 'orderby' => 'date', 'order' => 'DESC'));
?>

<div class="wrap hrcef-banner-admin">
    <h1><?php _e('Announcement Banner Settings', 'hrcef-announcement-banner'); ?></h1>
    
    <div id="hrcef-banner-message" class="notice" style="display: none;">
        <p></p>
    </div>
    
    <!-- Banner Preview -->
    <div class="hrcef-banner-preview-section">
        <h2><?php _e('Live Preview', 'hrcef-announcement-banner'); ?></h2>
        <p class="description" style="margin-bottom: 12px;">
            <?php 
            $version = isset($settings['content_version']) ? $settings['content_version'] : 1;
            printf(__('Content Version: %d (increments automatically when title, description, or link changes)', 'hrcef-announcement-banner'), $version); 
            ?>
        </p>
        <div class="hrcef-banner-preview-wrapper">
            <div class="hrcef-announcement-banner-preview <?php echo esc_attr($settings['color_scheme']); ?>" id="banner-preview">
                <div class="hrcef-banner-content">
                    <div class="hrcef-banner-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <?php echo HRCEF_Announcement_Banner::get_icon_svg($settings['icon']); ?>
                        </svg>
                    </div>
                    <div class="hrcef-banner-text">
                        <strong id="preview-title"><?php echo esc_html($settings['title']); ?></strong>
                        <span id="preview-description"><?php echo esc_html($settings['description']); ?></span>
                    </div>
                    <a href="#" class="hrcef-banner-link" id="preview-link-text"><?php echo esc_html($settings['link_text']); ?></a>
                    <?php if ($settings['dismissible']): ?>
                    <button class="hrcef-banner-close" aria-label="<?php esc_attr_e('Close', 'hrcef-announcement-banner'); ?>">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Settings Form -->
    <form id="hrcef-banner-settings-form" method="post">
        <?php wp_nonce_field('hrcef_banner_settings', 'hrcef_banner_nonce'); ?>
        
        <!-- Banner Status -->
        <div class="hrcef-postbox">
            <h2><?php _e('Banner Status', 'hrcef-announcement-banner'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="banner_enabled"><?php _e('Enable Banner', 'hrcef-announcement-banner'); ?></label>
                    </th>
                    <td>
                        <label class="hrcef-toggle-switch">
                            <input type="checkbox" id="banner_enabled" name="enabled" value="1" <?php checked($settings['enabled'], true); ?>>
                            <span class="hrcef-toggle-slider"></span>
                        </label>
                        <p class="description"><?php _e('Show the announcement banner on your site', 'hrcef-announcement-banner'); ?></p>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- Banner Content -->
        <div class="hrcef-postbox">
            <h2><?php _e('Banner Content', 'hrcef-announcement-banner'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="banner_title"><?php _e('Title', 'hrcef-announcement-banner'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="banner_title" name="title" class="regular-text" value="<?php echo esc_attr($settings['title']); ?>" placeholder="<?php esc_attr_e('Enter banner title', 'hrcef-announcement-banner'); ?>">
                        <p class="description"><?php _e('The main heading text (max 60 characters recommended)', 'hrcef-announcement-banner'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="banner_description"><?php _e('Description', 'hrcef-announcement-banner'); ?></label>
                    </th>
                    <td>
                        <textarea id="banner_description" name="description" rows="3" class="large-text" placeholder="<?php esc_attr_e('Enter banner description', 'hrcef-announcement-banner'); ?>"><?php echo esc_textarea($settings['description']); ?></textarea>
                        <p class="description"><?php _e('Supporting text (max 120 characters recommended)', 'hrcef-announcement-banner'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="banner_link_type"><?php _e('Link To', 'hrcef-announcement-banner'); ?></label>
                    </th>
                    <td>
                        <select id="banner_link_type" name="link_type" class="regular-text">
                            <option value="post" <?php selected($settings['link_type'], 'post'); ?>><?php _e('Blog Post', 'hrcef-announcement-banner'); ?></option>
                            <option value="page" <?php selected($settings['link_type'], 'page'); ?>><?php _e('Page', 'hrcef-announcement-banner'); ?></option>
                            <option value="custom" <?php selected($settings['link_type'], 'custom'); ?>><?php _e('Custom URL', 'hrcef-announcement-banner'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr id="post-selector" style="<?php echo $settings['link_type'] === 'custom' ? 'display:none;' : ''; ?>">
                    <th scope="row">
                        <label for="banner_post"><?php _e('Select Post/Page', 'hrcef-announcement-banner'); ?></label>
                    </th>
                    <td>
                        <select id="banner_post" name="link_post" class="regular-text">
                            <option value=""><?php _e('-- Select --', 'hrcef-announcement-banner'); ?></option>
                            <?php foreach ($posts as $post): ?>
                                <option value="<?php echo esc_attr($post->ID); ?>" data-url="<?php echo esc_url(get_permalink($post->ID)); ?>" <?php selected($settings['link_url'], get_permalink($post->ID)); ?>>
                                    <?php echo esc_html($post->post_title); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr id="custom-url" style="<?php echo $settings['link_type'] !== 'custom' ? 'display:none;' : ''; ?>">
                    <th scope="row">
                        <label for="banner_custom_url"><?php _e('Custom URL', 'hrcef-announcement-banner'); ?></label>
                    </th>
                    <td>
                        <input type="url" id="banner_custom_url" name="link_url" class="regular-text" value="<?php echo esc_url($settings['link_url']); ?>" placeholder="https://example.com">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="banner_link_text"><?php _e('Button Text', 'hrcef-announcement-banner'); ?></label>
                    </th>
                    <td>
                        <input type="text" id="banner_link_text" name="link_text" class="regular-text" value="<?php echo esc_attr($settings['link_text']); ?>" placeholder="<?php esc_attr_e('e.g., Learn More, Read More, Apply Now', 'hrcef-announcement-banner'); ?>">
                        <p class="description"><?php _e('Text for the call-to-action button', 'hrcef-announcement-banner'); ?></p>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- Banner Style -->
        <div class="hrcef-postbox">
            <h2><?php _e('Banner Style', 'hrcef-announcement-banner'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label><?php _e('Color Scheme', 'hrcef-announcement-banner'); ?></label>
                    </th>
                    <td>
                        <div class="hrcef-color-scheme-options">
                            <label class="hrcef-color-scheme-option">
                                <input type="radio" name="color_scheme" value="default" <?php checked($settings['color_scheme'], 'default'); ?>>
                                <span class="hrcef-color-preview" style="background: linear-gradient(135deg, #C41E3A, #E63946);"></span>
                                <span class="hrcef-color-label"><?php _e('Alert Red (Default)', 'hrcef-announcement-banner'); ?></span>
                            </label>
                            <label class="hrcef-color-scheme-option">
                                <input type="radio" name="color_scheme" value="event" <?php checked($settings['color_scheme'], 'event'); ?>>
                                <span class="hrcef-color-preview" style="background: linear-gradient(135deg, #0066B3, #008B8B);"></span>
                                <span class="hrcef-color-label"><?php _e('HRCEF Blue', 'hrcef-announcement-banner'); ?></span>
                            </label>
                            <label class="hrcef-color-scheme-option">
                                <input type="radio" name="color_scheme" value="deadline" <?php checked($settings['color_scheme'], 'deadline'); ?>>
                                <span class="hrcef-color-preview" style="background: linear-gradient(135deg, #9A3412, #C2410C);"></span>
                                <span class="hrcef-color-label"><?php _e('Urgent Orange', 'hrcef-announcement-banner'); ?></span>
                            </label>
                            <label class="hrcef-color-scheme-option">
                                <input type="radio" name="color_scheme" value="success" <?php checked($settings['color_scheme'], 'success'); ?>>
                                <span class="hrcef-color-preview" style="background: linear-gradient(135deg, #059669, #10B981);"></span>
                                <span class="hrcef-color-label"><?php _e('Success Green', 'hrcef-announcement-banner'); ?></span>
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="banner_icon"><?php _e('Icon', 'hrcef-announcement-banner'); ?></label>
                    </th>
                    <td>
                        <select id="banner_icon" name="icon" class="regular-text">
                            <option value="graduation" <?php selected($settings['icon'], 'graduation'); ?>><?php _e('🎓 Graduation Cap', 'hrcef-announcement-banner'); ?></option>
                            <option value="calendar" <?php selected($settings['icon'], 'calendar'); ?>><?php _e('📅 Calendar', 'hrcef-announcement-banner'); ?></option>
                            <option value="megaphone" <?php selected($settings['icon'], 'megaphone'); ?>><?php _e('📢 Megaphone', 'hrcef-announcement-banner'); ?></option>
                            <option value="star" <?php selected($settings['icon'], 'star'); ?>><?php _e('⭐ Star', 'hrcef-announcement-banner'); ?></option>
                            <option value="bell" <?php selected($settings['icon'], 'bell'); ?>><?php _e('🔔 Bell', 'hrcef-announcement-banner'); ?></option>
                            <option value="trophy" <?php selected($settings['icon'], 'trophy'); ?>><?php _e('🏆 Trophy', 'hrcef-announcement-banner'); ?></option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- Schedule -->
        <div class="hrcef-postbox">
            <h2><?php _e('Schedule (Optional)', 'hrcef-announcement-banner'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="banner_start_date"><?php _e('Start Date', 'hrcef-announcement-banner'); ?></label>
                    </th>
                    <td>
                        <input type="datetime-local" id="banner_start_date" name="start_date" class="regular-text" value="<?php echo esc_attr($settings['start_date']); ?>">
                        <p class="description"><?php _e('Leave blank to show immediately', 'hrcef-announcement-banner'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="banner_end_date"><?php _e('End Date', 'hrcef-announcement-banner'); ?></label>
                    </th>
                    <td>
                        <input type="datetime-local" id="banner_end_date" name="end_date" class="regular-text" value="<?php echo esc_attr($settings['end_date']); ?>">
                        <p class="description"><?php _e('Leave blank to show indefinitely', 'hrcef-announcement-banner'); ?></p>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- Advanced Options -->
        <div class="hrcef-postbox">
            <h2><?php _e('Advanced Options', 'hrcef-announcement-banner'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="banner_dismissible"><?php _e('Dismissible', 'hrcef-announcement-banner'); ?></label>
                    </th>
                    <td>
                        <label>
                            <input type="checkbox" id="banner_dismissible" name="dismissible" value="1" <?php checked($settings['dismissible'], true); ?>>
                            <?php _e('Allow users to close the banner', 'hrcef-announcement-banner'); ?>
                        </label>
                        <p class="description"><?php _e('If enabled, users can dismiss the banner and it won\'t show again', 'hrcef-announcement-banner'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php _e('Show On', 'hrcef-announcement-banner'); ?></label>
                    </th>
                    <td>
                        <label>
                            <input type="radio" name="show_on" value="all" <?php checked($settings['show_on'], 'all'); ?>>
                            <?php _e('All pages', 'hrcef-announcement-banner'); ?>
                        </label><br>
                        <label>
                            <input type="radio" name="show_on" value="home" <?php checked($settings['show_on'], 'home'); ?>>
                            <?php _e('Homepage only', 'hrcef-announcement-banner'); ?>
                        </label>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- Save Button -->
        <p class="submit">
            <button type="submit" class="button button-primary button-large"><?php _e('Save Settings', 'hrcef-announcement-banner'); ?></button>
        </p>
    </form>
</div>
