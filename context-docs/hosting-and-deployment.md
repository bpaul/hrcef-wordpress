# HRCEF WordPress Hosting & Deployment Information

## Hosting Details

**Platform:** WordPress.com  
**Plan:** Business Plan  
**Site URL:** https://hrcef.wordpress.com

## WordPress.com Business Plan Features

The Business Plan includes:
- Custom plugin installation ✅
- Custom theme installation ✅
- SFTP and database access ✅
- Remove WordPress.com branding ✅
- Advanced SEO tools ✅
- Google Analytics integration ✅

## Plugin Installation Process

Since you have a Business Plan, you can install custom plugins:

### Method 1: Via WordPress Admin (Recommended)

1. **Prepare the plugin:**
   - Zip the `hrcef-testimonials-plugin` folder
   - Name it: `hrcef-testimonials-plugin.zip`

2. **Upload to WordPress.com:**
   - Log in to WordPress.com admin
   - Go to **Plugins > Add New**
   - Click **Upload Plugin** button
   - Choose the zip file
   - Click **Install Now**
   - Click **Activate Plugin**

### Method 2: Via SFTP (Alternative)

1. **Get SFTP credentials:**
   - Go to WordPress.com > Hosting Configuration
   - Note your SFTP credentials

2. **Connect via SFTP:**
   - Use an FTP client (FileZilla, Cyberduck, etc.)
   - Connect to your site

3. **Upload plugin:**
   - Navigate to `/wp-content/plugins/`
   - Upload the `hrcef-testimonials-plugin` folder
   - Go to WordPress admin > Plugins
   - Activate the plugin

## Post-Installation Steps

1. **Activate Plugin:**
   - Go to Plugins in WordPress admin
   - Find "HRCEF Testimonials"
   - Click "Activate"

2. **Add Testimonials:**
   - Go to **Testimonials > Add New**
   - Create your first testimonial

3. **Add Block to Page:**
   - Edit any page with Gutenberg
   - Add the "HRCEF Testimonials" block
   - Configure settings
   - Publish

## Important Notes

- WordPress.com Business Plan allows custom plugins ✅
- The plugin is compatible with WordPress.com
- No additional configuration needed
- All features will work as designed

## Support Resources

- **WordPress.com Support:** https://wordpress.com/support/
- **SFTP Access:** https://wordpress.com/support/sftp/
- **Plugin Management:** https://wordpress.com/support/plugins/

## Plugin Version History

### v1.0.4 (Current)
- Fixed HTML entity decoding (apostrophes, quotes, etc. now display correctly)
- Improved JavaScript to properly handle special characters
- File: `hrcef-testimonials-plugin-v1.0.4.zip`

### v1.0.3
- Fixed REST API to return clean text without Gutenberg block markup
- Testimonials now display properly when clicking to refresh
- File: `hrcef-testimonials-plugin-v1.0.3.zip`

### v1.0.2
- Added full-width alignment support (default)
- Removed "Load New Testimonials" button
- Click on cards to refresh testimonials
- File: `hrcef-testimonials-plugin-v1.0.2.zip`

### v1.0.1
- Fixed block attributes error
- Improved empty state with helpful message
- Added link to create first testimonial

### v1.0.0
- Initial release
- Custom post type for testimonials
- Gutenberg block support
- Responsive card layout
- REST API endpoint
- Default placeholder image

## Deployment Checklist

- [ ] Update version number in plugin file
- [ ] Zip the plugin folder (version number in filename)
- [ ] Remove old zip files (keep only latest version)
- [ ] Update version history in this document
- [ ] Log in to WordPress.com admin
- [ ] Upload plugin via Plugins > Add New > Upload Plugin
- [ ] Activate the plugin
- [ ] Go to Testimonials > Settings to review instructions
- [ ] Create test testimonials
- [ ] Add block to a test page
- [ ] Verify display and functionality
- [ ] Deploy to production pages

## Version Management

**Current Practice:** Keep only the latest zip file in the project root.

When creating a new version:
1. Update version number in `hrcef-testimonials.php` (header and constant)
2. Create new zip: `hrcef-testimonials-plugin-v1.0.X.zip`
3. Delete previous version zip file
4. Update version history in this document

**Latest Version:** v1.0.4
**Zip File:** `hrcef-testimonials-plugin-v1.0.4.zip`

## Site Migration Notes (Future Reference)

If you ever need to migrate from WordPress.com:
- Export all content via Tools > Export
- Download plugin files via SFTP
- The plugin is portable and will work on any WordPress installation
- Database tables are standard WordPress custom post types

---

**Last Updated:** October 21, 2025  
**Status:** Ready for deployment
