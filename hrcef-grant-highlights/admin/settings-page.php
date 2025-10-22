<?php
/**
 * Admin Settings Page
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap">
    <h1><?php _e('Grant Highlights Settings', 'hrcef-grant-highlights'); ?></h1>
    
    <div class="card" style="max-width: 800px;">
        <h2><?php _e('How to Use', 'hrcef-grant-highlights'); ?></h2>
        
        <h3><?php _e('1. Add Grant Highlights', 'hrcef-grant-highlights'); ?></h3>
        <p><?php _e('Go to Grant Highlights > Add New to create grant highlight entries.', 'hrcef-grant-highlights'); ?></p>
        <ul>
            <li><strong><?php _e('Description:', 'hrcef-grant-highlights'); ?></strong> <?php _e('Enter the grant project description in the main content editor', 'hrcef-grant-highlights'); ?></li>
            <li><strong><?php _e('School Name:', 'hrcef-grant-highlights'); ?></strong> <?php _e('Add in the custom field below the editor', 'hrcef-grant-highlights'); ?></li>
            <li><strong><?php _e('Teacher Name:', 'hrcef-grant-highlights'); ?></strong> <?php _e('Add in the custom field', 'hrcef-grant-highlights'); ?></li>
            <li><strong><?php _e('Grant Year:', 'hrcef-grant-highlights'); ?></strong> <?php _e('Add in the custom field', 'hrcef-grant-highlights'); ?></li>
            <li><strong><?php _e('Featured Image:', 'hrcef-grant-highlights'); ?></strong> <?php _e('Upload a photo or select a themed image', 'hrcef-grant-highlights'); ?></li>
        </ul>
        
        <h3><?php _e('2. Themed Images', 'hrcef-grant-highlights'); ?></h3>
        <p><?php _e('The plugin includes 6 themed placeholder images for grants without specific photos:', 'hrcef-grant-highlights'); ?></p>
        <ul>
            <li>🌿 <?php _e('Environmental Science', 'hrcef-grant-highlights'); ?></li>
            <li>🤖 <?php _e('Robotics & Technology', 'hrcef-grant-highlights'); ?></li>
            <li>🎨 <?php _e('Arts & Culture', 'hrcef-grant-highlights'); ?></li>
            <li>🥗 <?php _e('Farm to Table', 'hrcef-grant-highlights'); ?></li>
            <li>🏔️ <?php _e('Outdoor Education', 'hrcef-grant-highlights'); ?></li>
            <li>🎵 <?php _e('Music Technology', 'hrcef-grant-highlights'); ?></li>
        </ul>
        <p><?php _e('These images are located in:', 'hrcef-grant-highlights'); ?> <code><?php echo esc_html(HRCEF_GRANTS_PLUGIN_DIR . 'assets/images/'); ?></code></p>
        
        <h3><?php _e('3. Add to Pages', 'hrcef-grant-highlights'); ?></h3>
        <p><?php _e('Use the Gutenberg block editor to add grant highlights to any page:', 'hrcef-grant-highlights'); ?></p>
        <ol>
            <li><?php _e('Edit a page or post', 'hrcef-grant-highlights'); ?></li>
            <li><?php _e('Click the + button to add a block', 'hrcef-grant-highlights'); ?></li>
            <li><?php _e('Search for "Grant Highlights"', 'hrcef-grant-highlights'); ?></li>
            <li><?php _e('Select the number of cards to display (1-6)', 'hrcef-grant-highlights'); ?></li>
            <li><?php _e('Publish or update the page', 'hrcef-grant-highlights'); ?></li>
        </ol>
        
        <h3><?php _e('4. Features', 'hrcef-grant-highlights'); ?></h3>
        <ul>
            <li>✅ <?php _e('Random selection from all published grants', 'hrcef-grant-highlights'); ?></li>
            <li>✅ <?php _e('Click cards or refresh button to load new grants', 'hrcef-grant-highlights'); ?></li>
            <li>✅ <?php _e('Responsive design (3 → 2 → 1 cards)', 'hrcef-grant-highlights'); ?></li>
            <li>✅ <?php _e('Smooth animations and hover effects', 'hrcef-grant-highlights'); ?></li>
            <li>✅ <?php _e('HRCEF brand gradient styling', 'hrcef-grant-highlights'); ?></li>
        </ul>
        
        <h3><?php _e('REST API', 'hrcef-grant-highlights'); ?></h3>
        <p><?php _e('Grant highlights are available via REST API at:', 'hrcef-grant-highlights'); ?></p>
        <p><code><?php echo esc_url(rest_url('hrcef/v1/grants')); ?></code></p>
    </div>
    
    <div class="card" style="max-width: 800px; margin-top: 20px;">
        <h2><?php _e('Quick Stats', 'hrcef-grant-highlights'); ?></h2>
        <?php
        $grant_count = wp_count_posts('hrcef_grant');
        $published = isset($grant_count->publish) ? $grant_count->publish : 0;
        $draft = isset($grant_count->draft) ? $grant_count->draft : 0;
        ?>
        <p><strong><?php _e('Published Grants:', 'hrcef-grant-highlights'); ?></strong> <?php echo esc_html($published); ?></p>
        <p><strong><?php _e('Draft Grants:', 'hrcef-grant-highlights'); ?></strong> <?php echo esc_html($draft); ?></p>
        <p><a href="<?php echo admin_url('edit.php?post_type=hrcef_grant'); ?>" class="button button-primary"><?php _e('View All Grant Highlights', 'hrcef-grant-highlights'); ?></a></p>
    </div>
</div>
