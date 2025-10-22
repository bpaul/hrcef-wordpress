<?php
/**
 * Plugin Name: HRCEF Grant Highlights
 * Plugin URI: https://hrcef.org
 * Description: Display Impact Teaching Grant highlights with custom post type and Gutenberg block
 * Version: 1.1.4
 * Author: HRCEF
 * Author URI: https://hrcef.org
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: hrcef-grant-highlights
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('HRCEF_GRANTS_VERSION', '1.1.4');
define('HRCEF_GRANTS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('HRCEF_GRANTS_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main Plugin Class
 */
class HRCEF_Grant_Highlights {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Activation hook
        register_activation_hook(__FILE__, array($this, 'activate'));
        
        // Initialize plugin
        add_action('init', array($this, 'register_post_type'));
        add_action('init', array($this, 'register_block'));
        
        // Admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Enqueue scripts
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        
        // REST API
        add_action('rest_api_init', array($this, 'register_rest_route'));
        
        // Meta boxes
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post_hrcef_grant', array($this, 'save_meta_boxes'), 10, 2);
        
        // AJAX handlers
        add_action('wp_ajax_hrcef_save_grant', array($this, 'ajax_save_grant'));
        
        // Add themed images as attachment
        add_action('admin_init', array($this, 'register_themed_images'));
    }
    
    /**
     * Plugin activation
     */
    public function activate() {
        $this->register_post_type();
        flush_rewrite_rules();
    }
    
    /**
     * Register custom post type
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => _x('Grant Highlights', 'Post type general name', 'hrcef-grant-highlights'),
            'singular_name'         => _x('Grant Highlight', 'Post type singular name', 'hrcef-grant-highlights'),
            'menu_name'             => _x('Grant Highlights', 'Admin Menu text', 'hrcef-grant-highlights'),
            'add_new'               => __('Add New', 'hrcef-grant-highlights'),
            'add_new_item'          => __('Add New Grant Highlight', 'hrcef-grant-highlights'),
            'new_item'              => __('New Grant Highlight', 'hrcef-grant-highlights'),
            'edit_item'             => __('Edit Grant Highlight', 'hrcef-grant-highlights'),
            'view_item'             => __('View Grant Highlight', 'hrcef-grant-highlights'),
            'all_items'             => __('All Grant Highlights', 'hrcef-grant-highlights'),
            'search_items'          => __('Search Grant Highlights', 'hrcef-grant-highlights'),
            'not_found'             => __('No grant highlights found.', 'hrcef-grant-highlights'),
            'not_found_in_trash'    => __('No grant highlights found in Trash.', 'hrcef-grant-highlights'),
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'grant-highlight'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 20,
            'menu_icon'          => 'dashicons-awards',
            'supports'           => array('title', 'editor', 'thumbnail'),
            'show_in_rest'       => true,
        );
        
        register_post_type('hrcef_grant', $args);
        
        // Register custom fields
        register_post_meta('hrcef_grant', 'school_name', array(
            'type'         => 'string',
            'single'       => true,
            'show_in_rest' => true,
        ));
        
        register_post_meta('hrcef_grant', 'teacher_name', array(
            'type'         => 'string',
            'single'       => true,
            'show_in_rest' => true,
        ));
        
        register_post_meta('hrcef_grant', 'grant_year', array(
            'type'         => 'string',
            'single'       => true,
            'show_in_rest' => true,
        ));
    }
    
    /**
     * Register Gutenberg block
     */
    public function register_block() {
        if (!function_exists('register_block_type')) {
            return;
        }
        
        wp_register_script(
            'hrcef-grants-block',
            HRCEF_GRANTS_PLUGIN_URL . 'blocks/grants-block.js',
            array('wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-server-side-render'),
            HRCEF_GRANTS_VERSION
        );
        
        // Register editor styles (same as frontend)
        wp_register_style(
            'hrcef-grants-editor-style',
            HRCEF_GRANTS_PLUGIN_URL . 'assets/css/grants.css',
            array(),
            HRCEF_GRANTS_VERSION
        );
        
        register_block_type('hrcef/grant-highlights', array(
            'editor_script' => 'hrcef-grants-block',
            'editor_style' => 'hrcef-grants-editor-style',
            'style' => 'hrcef-grants-editor-style',
            'render_callback' => array($this, 'render_block'),
            'attributes' => array(
                'cardCount' => array(
                    'type' => 'number',
                    'default' => 3,
                ),
                'align' => array(
                    'type' => 'string',
                    'default' => 'full',
                ),
            ),
        ));
    }
    
    /**
     * Render block callback
     */
    public function render_block($attributes) {
        $card_count = isset($attributes['cardCount']) ? intval($attributes['cardCount']) : 3;
        
        // Check if we're in the editor (ServerSideRender context)
        $is_editor = defined('REST_REQUEST') && REST_REQUEST;
        
        if ($is_editor) {
            // In editor: render static preview with sample grants
            return $this->render_editor_preview($card_count);
        }
        
        // On frontend: render dynamic template
        ob_start();
        include HRCEF_GRANTS_PLUGIN_DIR . 'templates/grants-display.php';
        return ob_get_clean();
    }
    
    /**
     * Render editor preview
     */
    private function render_editor_preview($card_count) {
        // Get actual grants from database
        $args = array(
            'post_type' => 'hrcef_grant',
            'posts_per_page' => $card_count,
            'orderby' => 'rand',
            'post_status' => 'publish',
        );
        
        $query = new WP_Query($args);
        
        ob_start();
        ?>
        <div class="hrcef-grants-container alignfull">
            <div class="hrcef-grants-grid">
                <?php
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $post_id = get_the_ID();
                        
                        // Get grant data
                        $school = get_post_meta($post_id, 'school_name', true);
                        $teacher = get_post_meta($post_id, 'teacher_name', true);
                        $year = get_post_meta($post_id, 'grant_year', true);
                        $description = get_the_content();
                        
                        // Get image
                        $themed_image = get_post_meta($post_id, '_themed_image', true);
                        if ($themed_image) {
                            $image_url = HRCEF_GRANTS_PLUGIN_URL . 'assets/images/' . $themed_image;
                        } else {
                            $image_url = get_the_post_thumbnail_url($post_id, 'large');
                            if (!$image_url) {
                                $image_url = HRCEF_GRANTS_PLUGIN_URL . 'assets/images/grant-1.svg';
                            }
                        }
                        ?>
                        <div class="grant-card">
                            <div class="grant-image">
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($school); ?> grant project">
                            </div>
                            <div class="grant-content">
                                <p class="grant-description"><?php echo esc_html($description); ?></p>
                            </div>
                            <div class="grant-attribution">
                                <div class="grant-school"><?php echo esc_html($school); ?></div>
                                <div class="grant-meta">
                                    <span class="grant-teacher"><?php echo esc_html($teacher); ?></span>
                                    <span class="grant-year"><?php echo esc_html($year); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                } else {
                    ?>
                    <div style="text-align: center; padding: 40px; color: #666;">
                        <p><strong>No grant highlights yet.</strong></p>
                        <p>Add your first grant highlight to see it displayed here.</p>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        // Replace "Add New" with custom page
        remove_submenu_page('edit.php?post_type=hrcef_grant', 'post-new.php?post_type=hrcef_grant');
        
        add_submenu_page(
            'edit.php?post_type=hrcef_grant',
            __('Add New', 'hrcef-grant-highlights'),
            __('Add New', 'hrcef-grant-highlights'),
            'edit_posts',
            'hrcef-grants-add-new',
            array($this, 'render_add_new_page')
        );
        
        add_submenu_page(
            'edit.php?post_type=hrcef_grant',
            __('Settings', 'hrcef-grant-highlights'),
            __('Settings', 'hrcef-grant-highlights'),
            'manage_options',
            'hrcef-grants-settings',
            array($this, 'render_settings_page')
        );
    }
    
    /**
     * Render add new page
     */
    public function render_add_new_page() {
        // Check if we're editing an existing grant
        $grant_id = isset($_GET['grant_id']) ? intval($_GET['grant_id']) : 0;
        include HRCEF_GRANTS_PLUGIN_DIR . 'admin/add-new-page.php';
    }
    
    /**
     * Render settings page
     */
    public function render_settings_page() {
        include HRCEF_GRANTS_PLUGIN_DIR . 'admin/settings-page.php';
    }
    
    /**
     * Enqueue frontend assets
     */
    public function enqueue_frontend_assets() {
        wp_enqueue_style(
            'hrcef-grants-style',
            HRCEF_GRANTS_PLUGIN_URL . 'assets/css/grants.css',
            array(),
            HRCEF_GRANTS_VERSION
        );
        
        wp_enqueue_script(
            'hrcef-grants-script',
            HRCEF_GRANTS_PLUGIN_URL . 'assets/js/grants-frontend.js',
            array(),
            HRCEF_GRANTS_VERSION,
            true
        );
        
        wp_localize_script('hrcef-grants-script', 'hrcefGrants', array(
            'restUrl' => rest_url('hrcef/v1/grants'),
            'nonce' => wp_create_nonce('wp_rest'),
        ));
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        global $post_type;
        
        // Check if we're on a grant-related page
        $is_grant_page = (
            'hrcef_grant' === $post_type || 
            strpos($hook, 'hrcef-grants') !== false ||
            (isset($_GET['post_type']) && $_GET['post_type'] === 'hrcef_grant')
        );
        
        if (!$is_grant_page) {
            return;
        }
        
        wp_enqueue_style(
            'hrcef-grants-admin-style',
            HRCEF_GRANTS_PLUGIN_URL . 'assets/css/admin.css',
            array(),
            HRCEF_GRANTS_VERSION
        );
        
        wp_enqueue_script(
            'hrcef-grants-admin-script',
            HRCEF_GRANTS_PLUGIN_URL . 'assets/js/admin.js',
            array('jquery'),
            HRCEF_GRANTS_VERSION,
            true
        );
        
        wp_localize_script('hrcef-grants-admin-script', 'hrcefGrantsAdmin', array(
            'pluginUrl' => HRCEF_GRANTS_PLUGIN_URL,
            'themedImages' => $this->get_themed_images(),
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('hrcef_grants_nonce'),
        ));
    }
    
    /**
     * Register REST API route
     */
    public function register_rest_route() {
        register_rest_route('hrcef/v1', '/grants', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_grants'),
            'permission_callback' => '__return_true',
        ));
    }
    
    /**
     * Get grants for REST API
     */
    public function get_grants($request) {
        $args = array(
            'post_type' => 'hrcef_grant',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        );
        
        $query = new WP_Query($args);
        $grants = array();
        
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                
                // Get image - check for themed image first, then featured image, then default
                $themed_image = get_post_meta($post_id, '_themed_image', true);
                if ($themed_image) {
                    $image_url = HRCEF_GRANTS_PLUGIN_URL . 'assets/images/' . $themed_image;
                } else {
                    $image_url = get_the_post_thumbnail_url($post_id, 'large');
                    // If no featured image, use default themed image
                    if (!$image_url) {
                        $image_url = HRCEF_GRANTS_PLUGIN_URL . 'assets/images/grant-1.svg';
                    }
                }
                
                $grants[] = array(
                    'id' => $post_id,
                    'description' => get_the_content(),
                    'school' => get_post_meta($post_id, 'school_name', true),
                    'teacher' => get_post_meta($post_id, 'teacher_name', true),
                    'year' => get_post_meta($post_id, 'grant_year', true),
                    'image' => $image_url,
                );
            }
            wp_reset_postdata();
        }
        
        return rest_ensure_response($grants);
    }
    
    /**
     * Get themed images
     */
    public function get_themed_images() {
        return array(
            array(
                'name' => 'Environmental Science',
                'file' => 'grant-1.svg',
            ),
            array(
                'name' => 'Robotics & Technology',
                'file' => 'grant-2.svg',
            ),
            array(
                'name' => 'Arts & Culture',
                'file' => 'grant-3.svg',
            ),
            array(
                'name' => 'Farm to Table',
                'file' => 'grant-4.svg',
            ),
            array(
                'name' => 'Outdoor Education',
                'file' => 'grant-5.svg',
            ),
            array(
                'name' => 'Music Technology',
                'file' => 'grant-6.svg',
            ),
        );
    }
    
    /**
     * Add meta boxes
     */
    public function add_meta_boxes() {
        add_meta_box(
            'hrcef_grant_details',
            __('Grant Details', 'hrcef-grant-highlights'),
            array($this, 'render_meta_box'),
            'hrcef_grant',
            'normal',
            'high'
        );
    }
    
    /**
     * Render meta box
     */
    public function render_meta_box($post) {
        // Add nonce for security
        wp_nonce_field('hrcef_grant_meta_box', 'hrcef_grant_meta_box_nonce');
        
        // Get current values
        $school_name = get_post_meta($post->ID, 'school_name', true);
        $teacher_name = get_post_meta($post->ID, 'teacher_name', true);
        $grant_year = get_post_meta($post->ID, 'grant_year', true);
        
        ?>
        <div class="hrcef-grant-meta-box">
            <div class="hrcef-grant-meta-field">
                <label for="school_name">
                    <strong><?php _e('School Name', 'hrcef-grant-highlights'); ?> *</strong>
                </label>
                <input 
                    type="text" 
                    id="school_name" 
                    name="school_name" 
                    value="<?php echo esc_attr($school_name); ?>" 
                    placeholder="<?php esc_attr_e('e.g., Hood River Middle School', 'hrcef-grant-highlights'); ?>"
                    required
                />
                <p class="description"><?php _e('Name of the school that received the grant', 'hrcef-grant-highlights'); ?></p>
            </div>
            
            <div class="hrcef-grant-meta-field">
                <label for="teacher_name">
                    <strong><?php _e('Teacher Name', 'hrcef-grant-highlights'); ?> *</strong>
                </label>
                <input 
                    type="text" 
                    id="teacher_name" 
                    name="teacher_name" 
                    value="<?php echo esc_attr($teacher_name); ?>" 
                    placeholder="<?php esc_attr_e('e.g., Sarah Martinez', 'hrcef-grant-highlights'); ?>"
                    required
                />
                <p class="description"><?php _e('Name of the teacher who received the grant', 'hrcef-grant-highlights'); ?></p>
            </div>
            
            <div class="hrcef-grant-meta-field">
                <label for="grant_year">
                    <strong><?php _e('Grant Year', 'hrcef-grant-highlights'); ?> *</strong>
                </label>
                <select id="grant_year" name="grant_year" required>
                    <option value=""><?php _e('Select Year', 'hrcef-grant-highlights'); ?></option>
                    <?php
                    $current_year = date('Y');
                    for ($year = $current_year; $year >= 2010; $year--) {
                        $selected = ($grant_year == $year) ? 'selected' : '';
                        echo '<option value="' . esc_attr($year) . '" ' . $selected . '>' . esc_html($year) . '</option>';
                    }
                    ?>
                </select>
                <p class="description"><?php _e('Year the grant was awarded', 'hrcef-grant-highlights'); ?></p>
            </div>
            
            <div class="hrcef-grant-meta-field">
                <p><strong><?php _e('Featured Image', 'hrcef-grant-highlights'); ?></strong></p>
                <p class="description">
                    <?php _e('Set the featured image using the "Featured Image" box on the right sidebar.', 'hrcef-grant-highlights'); ?>
                    <br>
                    <?php _e('You can upload a custom photo or use one of the themed images from:', 'hrcef-grant-highlights'); ?>
                    <code><?php echo esc_html(HRCEF_GRANTS_PLUGIN_URL . 'assets/images/'); ?></code>
                </p>
                <ul style="margin-left: 20px; margin-top: 10px;">
                    <li>grant-1.svg - <?php _e('Environmental Science', 'hrcef-grant-highlights'); ?></li>
                    <li>grant-2.svg - <?php _e('Robotics & Technology', 'hrcef-grant-highlights'); ?></li>
                    <li>grant-3.svg - <?php _e('Arts & Culture', 'hrcef-grant-highlights'); ?></li>
                    <li>grant-4.svg - <?php _e('Farm to Table', 'hrcef-grant-highlights'); ?></li>
                    <li>grant-5.svg - <?php _e('Outdoor Education', 'hrcef-grant-highlights'); ?></li>
                    <li>grant-6.svg - <?php _e('Music Technology', 'hrcef-grant-highlights'); ?></li>
                </ul>
            </div>
        </div>
        <?php
    }
    
    /**
     * Save meta box data
     */
    public function save_meta_boxes($post_id, $post) {
        // Check nonce
        if (!isset($_POST['hrcef_grant_meta_box_nonce']) || 
            !wp_verify_nonce($_POST['hrcef_grant_meta_box_nonce'], 'hrcef_grant_meta_box')) {
            return;
        }
        
        // Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        // Check permissions
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Save school name
        if (isset($_POST['school_name'])) {
            update_post_meta($post_id, 'school_name', sanitize_text_field($_POST['school_name']));
        }
        
        // Save teacher name
        if (isset($_POST['teacher_name'])) {
            update_post_meta($post_id, 'teacher_name', sanitize_text_field($_POST['teacher_name']));
        }
        
        // Save grant year
        if (isset($_POST['grant_year'])) {
            update_post_meta($post_id, 'grant_year', sanitize_text_field($_POST['grant_year']));
        }
    }
    
    /**
     * AJAX save grant
     */
    public function ajax_save_grant() {
        // Check nonce
        check_ajax_referer('hrcef_grants_nonce', 'nonce');
        
        // Check permissions
        if (!current_user_can('edit_posts')) {
            wp_send_json_error(array('message' => 'Insufficient permissions'));
        }
        
        // Get data
        $grant_id = isset($_POST['grant_id']) ? intval($_POST['grant_id']) : 0;
        $description = isset($_POST['description']) ? wp_kses_post($_POST['description']) : '';
        $school_name = isset($_POST['school_name']) ? sanitize_text_field($_POST['school_name']) : '';
        $teacher_name = isset($_POST['teacher_name']) ? sanitize_text_field($_POST['teacher_name']) : '';
        $grant_year = isset($_POST['grant_year']) ? sanitize_text_field($_POST['grant_year']) : '';
        $image_url = isset($_POST['image_url']) ? esc_url_raw($_POST['image_url']) : '';
        $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : 'publish';
        
        // Validate required fields
        if (empty($description) || empty($school_name) || empty($teacher_name) || empty($grant_year)) {
            wp_send_json_error(array('message' => 'Please fill in all required fields'));
        }
        
        // Create or update post
        $post_data = array(
            'post_type' => 'hrcef_grant',
            'post_content' => $description,
            'post_status' => $status,
            'post_title' => substr($description, 0, 50) . '...', // Auto-generate title from description
        );
        
        if ($grant_id > 0) {
            $post_data['ID'] = $grant_id;
            $result = wp_update_post($post_data);
        } else {
            $result = wp_insert_post($post_data);
        }
        
        if (is_wp_error($result)) {
            wp_send_json_error(array('message' => $result->get_error_message()));
        }
        
        // Save meta fields
        update_post_meta($result, 'school_name', $school_name);
        update_post_meta($result, 'teacher_name', $teacher_name);
        update_post_meta($result, 'grant_year', $grant_year);
        
        // Handle image
        if (!empty($image_url)) {
            // If it's a themed image, we need to handle it differently
            if (strpos($image_url, 'grant-') !== false && strpos($image_url, '.svg') !== false) {
                // Store the themed image reference
                update_post_meta($result, '_themed_image', basename($image_url));
            } else {
                // Handle uploaded image (would need media upload handling)
                // For now, just store the URL
                update_post_meta($result, '_custom_image_url', $image_url);
            }
        }
        
        wp_send_json_success(array(
            'message' => 'Grant highlight saved successfully!',
            'grant_id' => $result,
            'redirect_url' => admin_url('edit.php?post_type=hrcef_grant')
        ));
    }
    
    /**
     * Register themed images
     */
    public function register_themed_images() {
        // This will be used to make themed images available in media library
    }
}

// Initialize plugin
new HRCEF_Grant_Highlights();
