<?php
/**
 * Plugin Name: HRCEF Testimonials
 * Plugin URI: https://hrcef.org
 * Description: A beautiful testimonials plugin for Hood River County Education Foundation with Gutenberg block support
 * Version: 1.0.0
 * Author: HRCEF
 * Author URI: https://hrcef.org
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: hrcef-testimonials
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('HRCEF_TESTIMONIALS_VERSION', '1.0.0');
define('HRCEF_TESTIMONIALS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('HRCEF_TESTIMONIALS_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Main Plugin Class
 */
class HRCEF_Testimonials {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Register custom post type
        add_action('init', array($this, 'register_testimonial_post_type'));
        
        // Register Gutenberg block
        add_action('init', array($this, 'register_gutenberg_block'));
        
        // Enqueue scripts
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        
        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Register REST API endpoint
        add_action('rest_api_init', array($this, 'register_rest_routes'));
        
        // Add meta boxes
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post_hrcef_testimonial', array($this, 'save_testimonial_meta'));
    }
    
    /**
     * Register Custom Post Type for Testimonials
     */
    public function register_testimonial_post_type() {
        $labels = array(
            'name'               => _x('Testimonials', 'post type general name', 'hrcef-testimonials'),
            'singular_name'      => _x('Testimonial', 'post type singular name', 'hrcef-testimonials'),
            'menu_name'          => _x('Testimonials', 'admin menu', 'hrcef-testimonials'),
            'add_new'            => _x('Add New', 'testimonial', 'hrcef-testimonials'),
            'add_new_item'       => __('Add New Testimonial', 'hrcef-testimonials'),
            'new_item'           => __('New Testimonial', 'hrcef-testimonials'),
            'edit_item'          => __('Edit Testimonial', 'hrcef-testimonials'),
            'view_item'          => __('View Testimonial', 'hrcef-testimonials'),
            'all_items'          => __('All Testimonials', 'hrcef-testimonials'),
            'search_items'       => __('Search Testimonials', 'hrcef-testimonials'),
            'not_found'          => __('No testimonials found.', 'hrcef-testimonials'),
            'not_found_in_trash' => __('No testimonials found in Trash.', 'hrcef-testimonials')
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'testimonial'),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 20,
            'menu_icon'          => 'dashicons-format-quote',
            'show_in_rest'       => true,
            'supports'           => array('title', 'editor', 'thumbnail')
        );
        
        register_post_type('hrcef_testimonial', $args);
    }
    
    /**
     * Register Gutenberg Block
     */
    public function register_gutenberg_block() {
        // Register block script
        wp_register_script(
            'hrcef-testimonials-block',
            HRCEF_TESTIMONIALS_PLUGIN_URL . 'blocks/testimonials-block.js',
            array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data'),
            HRCEF_TESTIMONIALS_VERSION
        );
        
        // Register block styles
        wp_register_style(
            'hrcef-testimonials-block-style',
            HRCEF_TESTIMONIALS_PLUGIN_URL . 'assets/css/testimonials.css',
            array(),
            HRCEF_TESTIMONIALS_VERSION
        );
        
        // Register the block
        register_block_type('hrcef/testimonials', array(
            'editor_script'   => 'hrcef-testimonials-block',
            'style'          => 'hrcef-testimonials-block-style',
            'render_callback' => array($this, 'render_testimonials_block')
        ));
    }
    
    /**
     * Render Testimonials Block
     */
    public function render_testimonials_block($attributes) {
        $count = isset($attributes['count']) ? intval($attributes['count']) : 3;
        
        // Get random testimonials
        $args = array(
            'post_type'      => 'hrcef_testimonial',
            'posts_per_page' => $count,
            'orderby'        => 'rand',
            'post_status'    => 'publish'
        );
        
        $testimonials = get_posts($args);
        
        if (empty($testimonials)) {
            return '<p>' . __('No testimonials found.', 'hrcef-testimonials') . '</p>';
        }
        
        ob_start();
        include HRCEF_TESTIMONIALS_PLUGIN_DIR . 'templates/testimonials-display.php';
        return ob_get_clean();
    }
    
    /**
     * Add Meta Boxes
     */
    public function add_meta_boxes() {
        add_meta_box(
            'hrcef_testimonial_details',
            __('Testimonial Details', 'hrcef-testimonials'),
            array($this, 'render_meta_box'),
            'hrcef_testimonial',
            'normal',
            'high'
        );
    }
    
    /**
     * Render Meta Box
     */
    public function render_meta_box($post) {
        wp_nonce_field('hrcef_testimonial_meta_box', 'hrcef_testimonial_meta_box_nonce');
        
        $author = get_post_meta($post->ID, '_hrcef_author', true);
        $institution = get_post_meta($post->ID, '_hrcef_institution', true);
        ?>
        <p>
            <label for="hrcef_author"><strong><?php _e('Author Name:', 'hrcef-testimonials'); ?></strong></label><br>
            <input type="text" id="hrcef_author" name="hrcef_author" value="<?php echo esc_attr($author); ?>" style="width: 100%;" placeholder="e.g., Maria Rodriguez">
        </p>
        <p>
            <label for="hrcef_institution"><strong><?php _e('Institution:', 'hrcef-testimonials'); ?></strong></label><br>
            <input type="text" id="hrcef_institution" name="hrcef_institution" value="<?php echo esc_attr($institution); ?>" style="width: 100%;" placeholder="e.g., Portland Community College">
        </p>
        <p>
            <em><?php _e('Note: Use the "Featured Image" section to add a photo. If no image is provided, a default placeholder will be used.', 'hrcef-testimonials'); ?></em>
        </p>
        <?php
    }
    
    /**
     * Save Meta Box Data
     */
    public function save_testimonial_meta($post_id) {
        // Check nonce
        if (!isset($_POST['hrcef_testimonial_meta_box_nonce']) || 
            !wp_verify_nonce($_POST['hrcef_testimonial_meta_box_nonce'], 'hrcef_testimonial_meta_box')) {
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
        
        // Save author
        if (isset($_POST['hrcef_author'])) {
            update_post_meta($post_id, '_hrcef_author', sanitize_text_field($_POST['hrcef_author']));
        }
        
        // Save institution
        if (isset($_POST['hrcef_institution'])) {
            update_post_meta($post_id, '_hrcef_institution', sanitize_text_field($_POST['hrcef_institution']));
        }
    }
    
    /**
     * Register REST API Routes
     */
    public function register_rest_routes() {
        register_rest_route('hrcef/v1', '/testimonials', array(
            'methods'  => 'GET',
            'callback' => array($this, 'get_testimonials_api'),
            'permission_callback' => '__return_true'
        ));
    }
    
    /**
     * REST API Callback
     */
    public function get_testimonials_api($request) {
        $count = $request->get_param('count') ? intval($request->get_param('count')) : 3;
        
        $args = array(
            'post_type'      => 'hrcef_testimonial',
            'posts_per_page' => $count,
            'orderby'        => 'rand',
            'post_status'    => 'publish'
        );
        
        $testimonials = get_posts($args);
        $data = array();
        
        foreach ($testimonials as $testimonial) {
            $author = get_post_meta($testimonial->ID, '_hrcef_author', true);
            $institution = get_post_meta($testimonial->ID, '_hrcef_institution', true);
            $image_id = get_post_thumbnail_id($testimonial->ID);
            $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
            
            $data[] = array(
                'id'          => $testimonial->ID,
                'quote'       => $testimonial->post_content,
                'author'      => $author,
                'institution' => $institution,
                'image'       => $image_url
            );
        }
        
        return rest_ensure_response($data);
    }
    
    /**
     * Add Admin Menu
     */
    public function add_admin_menu() {
        add_submenu_page(
            'edit.php?post_type=hrcef_testimonial',
            __('Settings', 'hrcef-testimonials'),
            __('Settings', 'hrcef-testimonials'),
            'manage_options',
            'hrcef-testimonials-settings',
            array($this, 'render_settings_page')
        );
    }
    
    /**
     * Render Settings Page
     */
    public function render_settings_page() {
        include HRCEF_TESTIMONIALS_PLUGIN_DIR . 'admin/settings-page.php';
    }
    
    /**
     * Enqueue Frontend Scripts
     */
    public function enqueue_frontend_scripts() {
        wp_enqueue_style(
            'hrcef-testimonials-style',
            HRCEF_TESTIMONIALS_PLUGIN_URL . 'assets/css/testimonials.css',
            array(),
            HRCEF_TESTIMONIALS_VERSION
        );
        
        wp_enqueue_script(
            'hrcef-testimonials-frontend',
            HRCEF_TESTIMONIALS_PLUGIN_URL . 'assets/js/testimonials-frontend.js',
            array(),
            HRCEF_TESTIMONIALS_VERSION,
            true
        );
    }
    
    /**
     * Enqueue Admin Scripts
     */
    public function enqueue_admin_scripts($hook) {
        // Only load on testimonial pages
        if ('post.php' === $hook || 'post-new.php' === $hook) {
            global $post_type;
            if ('hrcef_testimonial' === $post_type) {
                wp_enqueue_media();
            }
        }
    }
}

// Initialize the plugin
new HRCEF_Testimonials();
