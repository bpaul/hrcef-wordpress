<?php
/**
 * Add New Grant Highlight Page
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Get grant data if editing
$grant = null;
$school_name = '';
$teacher_name = '';
$grant_year = '';
$description = '';
$image_url = '';

if ($grant_id > 0) {
    $grant = get_post($grant_id);
    if ($grant && $grant->post_type === 'hrcef_grant') {
        $school_name = get_post_meta($grant_id, 'school_name', true);
        $teacher_name = get_post_meta($grant_id, 'teacher_name', true);
        $grant_year = get_post_meta($grant_id, 'grant_year', true);
        $description = $grant->post_content;
        
        // Get image
        $themed_image = get_post_meta($grant_id, '_themed_image', true);
        if ($themed_image) {
            $image_url = HRCEF_GRANTS_PLUGIN_URL . 'assets/images/' . $themed_image;
        } else {
            $image_url = get_the_post_thumbnail_url($grant_id, 'large');
        }
    }
}

$page_title = $grant_id > 0 ? __('Edit Grant Highlight', 'hrcef-grant-highlights') : __('Add New Grant Highlight', 'hrcef-grant-highlights');
?>

<div class="wrap hrcef-grants-admin-page">
    <h1><?php echo esc_html($page_title); ?></h1>
    
    <div id="hrcef-grant-message" class="notice" style="display: none;">
        <p></p>
    </div>
    
    <form id="hrcef-grant-form" class="hrcef-grant-form">
        <input type="hidden" name="grant_id" id="grant_id" value="<?php echo esc_attr($grant_id); ?>">
        
        <!-- Grant Description -->
        <div class="form-section">
            <label for="grant-description"><?php _e('Grant Description', 'hrcef-grant-highlights'); ?> *</label>
            <textarea 
                id="grant-description" 
                name="description" 
                rows="6" 
                placeholder="<?php esc_attr_e('Describe the grant project and its impact on students...', 'hrcef-grant-highlights'); ?>"
                required
            ><?php echo esc_textarea($description); ?></textarea>
            <p class="description"><?php _e('A brief description of the grant project (recommended: 150-200 characters)', 'hrcef-grant-highlights'); ?></p>
        </div>

        <!-- School Information -->
        <div class="form-row">
            <div class="form-field">
                <label for="school-name"><?php _e('School Name', 'hrcef-grant-highlights'); ?> *</label>
                <input type="text" id="school-name" name="school_name" value="<?php echo esc_attr($school_name); ?>" placeholder="<?php esc_attr_e('Enter school name', 'hrcef-grant-highlights'); ?>" required>
            </div>
            <div class="form-field">
                <label for="teacher-name"><?php _e('Teacher Name', 'hrcef-grant-highlights'); ?> *</label>
                <input type="text" id="teacher-name" name="teacher_name" value="<?php echo esc_attr($teacher_name); ?>" placeholder="<?php esc_attr_e('Enter teacher name', 'hrcef-grant-highlights'); ?>" required>
            </div>
        </div>

        <!-- Grant Year -->
        <div class="form-row">
            <div class="form-field">
                <label for="grant-year"><?php _e('Grant Year', 'hrcef-grant-highlights'); ?> *</label>
                <select id="grant-year" name="grant_year" required>
                    <option value=""><?php _e('Select Year', 'hrcef-grant-highlights'); ?></option>
                    <?php
                    $current_year = date('Y');
                    for ($year = $current_year; $year >= 2010; $year--) {
                        $selected = ($grant_year == $year) ? 'selected' : '';
                        echo '<option value="' . esc_attr($year) . '" ' . $selected . '>' . esc_html($year) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-field">
                <label for="grant-status"><?php _e('Status', 'hrcef-grant-highlights'); ?></label>
                <select id="grant-status" name="status">
                    <option value="publish"><?php _e('Published', 'hrcef-grant-highlights'); ?></option>
                    <option value="draft"><?php _e('Draft', 'hrcef-grant-highlights'); ?></option>
                </select>
            </div>
        </div>

        <!-- Featured Image Section -->
        <div class="form-section">
            <h2><?php _e('Featured Image', 'hrcef-grant-highlights'); ?></h2>
            
            <!-- Image Selection Tabs -->
            <div class="image-tabs">
                <button type="button" class="tab-button active" data-tab="themed"><?php _e('Themed Images', 'hrcef-grant-highlights'); ?></button>
                <button type="button" class="tab-button" data-tab="upload"><?php _e('Upload Photo', 'hrcef-grant-highlights'); ?></button>
            </div>

            <!-- Themed Images Tab -->
            <div class="tab-content active" id="themed-tab">
                <p class="description"><?php _e('Select a themed placeholder image that matches your grant type:', 'hrcef-grant-highlights'); ?></p>
                <div class="themed-images-grid">
                    <?php
                    $themed_images = array(
                        array('file' => 'grant-1.svg', 'name' => __('Environmental Science', 'hrcef-grant-highlights')),
                        array('file' => 'grant-2.svg', 'name' => __('Robotics & Technology', 'hrcef-grant-highlights')),
                        array('file' => 'grant-3.svg', 'name' => __('Arts & Culture', 'hrcef-grant-highlights')),
                        array('file' => 'grant-4.svg', 'name' => __('Farm to Table', 'hrcef-grant-highlights')),
                        array('file' => 'grant-5.svg', 'name' => __('Outdoor Education', 'hrcef-grant-highlights')),
                        array('file' => 'grant-6.svg', 'name' => __('Music Technology', 'hrcef-grant-highlights')),
                    );
                    
                    foreach ($themed_images as $index => $img) {
                        $img_url = HRCEF_GRANTS_PLUGIN_URL . 'assets/images/' . $img['file'];
                        $selected = ($image_url === $img_url || ($index === 0 && empty($image_url))) ? 'selected' : '';
                        ?>
                        <div class="themed-image-option <?php echo $selected; ?>" data-image="<?php echo esc_attr($img_url); ?>">
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img['name']); ?>">
                            <div class="image-label"><?php echo esc_html($img['name']); ?></div>
                            <div class="selected-badge">✓ <?php _e('Selected', 'hrcef-grant-highlights'); ?></div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <!-- Upload Tab -->
            <div class="tab-content" id="upload-tab">
                <div class="image-upload-area">
                    <p class="description"><?php _e('Custom photo upload coming soon. For now, please use the themed images.', 'hrcef-grant-highlights'); ?></p>
                </div>
            </div>
            
            <input type="hidden" name="image_url" id="image-url" value="<?php echo esc_url($image_url); ?>">
        </div>

        <!-- Preview Section -->
        <div class="form-section">
            <h2><?php _e('Card Preview', 'hrcef-grant-highlights'); ?></h2>
            <div class="card-preview-wrapper">
                <div class="grant-card-preview">
                    <div class="preview-image">
                        <img src="<?php echo esc_url($image_url ? $image_url : HRCEF_GRANTS_PLUGIN_URL . 'assets/images/grant-1.svg'); ?>" alt="Preview" id="preview-image">
                    </div>
                    <div class="preview-content">
                        <p class="preview-description" id="preview-description">
                            <?php echo $description ? esc_html($description) : __('Grant description will appear here...', 'hrcef-grant-highlights'); ?>
                        </p>
                    </div>
                    <div class="preview-attribution">
                        <div class="preview-school" id="preview-school"><?php echo $school_name ? esc_html($school_name) : __('School Name', 'hrcef-grant-highlights'); ?></div>
                        <div class="preview-meta">
                            <span class="preview-teacher" id="preview-teacher"><?php echo $teacher_name ? esc_html($teacher_name) : __('Teacher Name', 'hrcef-grant-highlights'); ?></span>
                            <span class="preview-year" id="preview-year"><?php echo $grant_year ? esc_html($grant_year) : __('Year', 'hrcef-grant-highlights'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="form-actions">
            <button type="submit" class="button button-primary button-large" id="publish-button">
                <?php echo $grant_id > 0 ? __('Update Grant Highlight', 'hrcef-grant-highlights') : __('Publish Grant Highlight', 'hrcef-grant-highlights'); ?>
            </button>
            <button type="button" class="button button-secondary button-large" id="save-draft-button"><?php _e('Save as Draft', 'hrcef-grant-highlights'); ?></button>
            <a href="<?php echo admin_url('edit.php?post_type=hrcef_grant'); ?>" class="button-link"><?php _e('Cancel', 'hrcef-grant-highlights'); ?></a>
        </div>
    </form>
</div>

<style>
/* Include admin mockup styles inline for now */
<?php include HRCEF_GRANTS_PLUGIN_DIR . 'assets/css/admin-form.css'; ?>
</style>
