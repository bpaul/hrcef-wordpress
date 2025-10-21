<?php
/**
 * Plugin Name: HRCEF Announcement Banner
 * Plugin URI: https://hrcef.org
 * Description: A dismissible announcement banner for highlighting important posts, events, and announcements on the HRCEF website
 * Version: 1.0.0
 * Author: HRCEF
 * Author URI: https://hrcef.org
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: hrcef-announcement-banner
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('HRCEF_BANNER_VERSION', '1.0.0');
define('HRCEF_BANNER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('HRCEF_BANNER_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main Plugin Class
 */
class HRCEF_Announcement_Banner {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Activation hook
        register_activation_hook(__FILE__, array($this, 'activate'));
        
        // Initialize plugin
        add_action('init', array($this, 'init'));
        
        // Admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        
        // Insert banner into page
        add_action('wp_body_open', array($this, 'display_banner'));
        
        // AJAX handlers
        add_action('wp_ajax_hrcef_save_banner_settings', array($this, 'save_settings'));
    }
    
    /**
     * Plugin activation
     */
    public function activate() {
        // Set default options
        $defaults = array(
            'enabled' => true,
            'title' => 'New Scholarship Opportunity!',
            'description' => 'Applications now open for the 2025-26 academic year.',
            'link_type' => 'post',
            'link_url' => '',
            'link_text' => 'Learn More →',
            'color_scheme' => 'default',
            'icon' => 'graduation',
            'dismissible' => true,
            'show_on' => 'all',
            'start_date' => '',
            'end_date' => ''
        );
        
        add_option('hrcef_banner_settings', $defaults);
    }
    
    /**
     * Initialize plugin
     */
    public function init() {
        // Load text domain for translations
        load_plugin_textdomain('hrcef-announcement-banner', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            __('Announcement Banner', 'hrcef-announcement-banner'),
            __('Announcement Banner', 'hrcef-announcement-banner'),
            'manage_options',
            'hrcef-announcement-banner',
            array($this, 'render_admin_page'),
            'dashicons-megaphone',
            30
        );
    }
    
    /**
     * Render admin page
     */
    public function render_admin_page() {
        include HRCEF_BANNER_PLUGIN_DIR . 'admin/settings-page.php';
    }
    
    /**
     * Enqueue frontend assets
     */
    public function enqueue_frontend_assets() {
        $settings = get_option('hrcef_banner_settings');
        
        // Only load if banner is enabled
        if (!isset($settings['enabled']) || !$settings['enabled']) {
            return;
        }
        
        // Check schedule
        if (!$this->is_banner_scheduled()) {
            return;
        }
        
        wp_enqueue_style(
            'hrcef-banner-style',
            HRCEF_BANNER_PLUGIN_URL . 'assets/css/banner.css',
            array(),
            HRCEF_BANNER_VERSION
        );
        
        wp_enqueue_script(
            'hrcef-banner-script',
            HRCEF_BANNER_PLUGIN_URL . 'assets/js/banner.js',
            array(),
            HRCEF_BANNER_VERSION,
            true
        );
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        // Only load on our admin page
        if ($hook !== 'toplevel_page_hrcef-announcement-banner') {
            return;
        }
        
        wp_enqueue_style(
            'hrcef-banner-admin-style',
            HRCEF_BANNER_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            HRCEF_BANNER_VERSION
        );
        
        wp_enqueue_script(
            'hrcef-banner-admin-script',
            HRCEF_BANNER_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery'),
            HRCEF_BANNER_VERSION,
            true
        );
        
        // Localize script for AJAX
        wp_localize_script('hrcef-banner-admin-script', 'hrcefBanner', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('hrcef_banner_nonce')
        ));
    }
    
    /**
     * Display banner on frontend
     */
    public function display_banner() {
        $settings = get_option('hrcef_banner_settings');
        
        // Check if enabled
        if (!isset($settings['enabled']) || !$settings['enabled']) {
            return;
        }
        
        // Check schedule
        if (!$this->is_banner_scheduled()) {
            return;
        }
        
        // Check page targeting
        if (!$this->should_show_on_current_page()) {
            return;
        }
        
        // Include banner template
        include HRCEF_BANNER_PLUGIN_DIR . 'templates/banner-display.php';
    }
    
    /**
     * Check if banner is scheduled to show
     */
    private function is_banner_scheduled() {
        $settings = get_option('hrcef_banner_settings');
        $now = current_time('timestamp');
        
        // Check start date
        if (!empty($settings['start_date'])) {
            $start = strtotime($settings['start_date']);
            if ($now < $start) {
                return false;
            }
        }
        
        // Check end date
        if (!empty($settings['end_date'])) {
            $end = strtotime($settings['end_date']);
            if ($now > $end) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Check if banner should show on current page
     */
    private function should_show_on_current_page() {
        $settings = get_option('hrcef_banner_settings');
        $show_on = isset($settings['show_on']) ? $settings['show_on'] : 'all';
        
        switch ($show_on) {
            case 'home':
                return is_front_page();
            case 'all':
            default:
                return true;
        }
    }
    
    /**
     * Save settings via AJAX
     */
    public function save_settings() {
        // Check nonce
        check_ajax_referer('hrcef_banner_nonce', 'nonce');
        
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Insufficient permissions'));
        }
        
        // Sanitize and save settings
        $settings = array(
            'enabled' => isset($_POST['enabled']) ? (bool)$_POST['enabled'] : false,
            'title' => sanitize_text_field($_POST['title']),
            'description' => sanitize_textarea_field($_POST['description']),
            'link_type' => sanitize_text_field($_POST['link_type']),
            'link_url' => esc_url_raw($_POST['link_url']),
            'link_text' => sanitize_text_field($_POST['link_text']),
            'color_scheme' => sanitize_text_field($_POST['color_scheme']),
            'icon' => sanitize_text_field($_POST['icon']),
            'dismissible' => isset($_POST['dismissible']) ? (bool)$_POST['dismissible'] : false,
            'show_on' => sanitize_text_field($_POST['show_on']),
            'start_date' => sanitize_text_field($_POST['start_date']),
            'end_date' => sanitize_text_field($_POST['end_date'])
        );
        
        update_option('hrcef_banner_settings', $settings);
        
        wp_send_json_success(array('message' => 'Settings saved successfully'));
    }
    
    /**
     * Get banner icon SVG
     */
    public static function get_icon_svg($icon_type) {
        $icons = array(
            'graduation' => '<path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5M2 12l10 5 10-5"/>',
            'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
            'megaphone' => '<path d="M3 11l18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>',
            'star' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
            'bell' => '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
            'trophy' => '<path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2z"/>'
        );
        
        return isset($icons[$icon_type]) ? $icons[$icon_type] : $icons['graduation'];
    }
}

// Initialize plugin
new HRCEF_Announcement_Banner();
