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

## Naming Conventions

### Plugin Naming
All HRCEF custom plugins must follow this naming convention:

**Format:** `hrcef-[plugin-name]`

**Examples:**
- `hrcef-testimonials-plugin`
- `hrcef-announcement-banner`
- `hrcef-scholarship-portal`

**Rules:**
- Always prefix with `hrcef-`
- Use lowercase letters
- Separate words with hyphens
- Use descriptive, clear names
- Avoid abbreviations unless widely understood

### File Naming
- **Main plugin file:** `hrcef-[plugin-name].php`
- **Folder name:** `hrcef-[plugin-name]/`
- **Zip file:** `hrcef-[plugin-name]-v[version].zip`

### Version Numbering

**Format:** `v[major].[minor].[patch]`

**Example:** `v1.0.4`

**Rules:**
- **Major (1.x.x)** - Breaking changes, major new features
- **Minor (x.1.x)** - New features, non-breaking changes
- **Patch (x.x.1)** - Bug fixes, minor improvements

**IMPORTANT:** Version numbers must be incremented with each build:
1. Update version in plugin header comment
2. Update version constant (e.g., `HRCEF_BANNER_VERSION`)
3. Include version in zip filename
4. Update version history in this document

### CSS/JS Class Naming
- **Prefix:** `hrcef-`
- **Format:** `hrcef-[component]-[element]`
- **Examples:**
  - `.hrcef-banner-content`
  - `.hrcef-testimonial-card`
  - `.hrcef-toggle-switch`

### Database Options
- **Prefix:** `hrcef_`
- **Format:** `hrcef_[plugin]_[setting]`
- **Examples:**
  - `hrcef_banner_settings`
  - `hrcef_testimonial_count`

### JavaScript Variables
- **Global objects:** `hrcefBanner`, `hrcefTestimonials`
- **localStorage keys:** `hrcef_banner_dismissed`, `hrcef_[feature]_[state]`

## Version Management

**Current Practice:** Keep only the latest zip file in the project root.

When creating a new version:
1. **Increment version number** in plugin PHP file (header and constant)
2. Create new zip: `hrcef-[plugin-name]-v[version].zip`
3. Delete previous version zip file
4. Update version history in this document
5. Test thoroughly before deployment

**Latest Versions:**
- Testimonials: v1.1.0 (`hrcef-testimonials-plugin-v1.1.0.zip`)
- Announcement Banner: v1.0.3 (`hrcef-announcement-banner-v1.0.3.zip`)
- Grant Highlights: v1.1.4 (`hrcef-grant-highlights-v1.1.4.zip`)

## Site Migration Notes (Future Reference)

If you ever need to migrate from WordPress.com:
- Export all content via Tools > Export
- Download plugin files via SFTP
- The plugin is portable and will work on any WordPress installation
- Database tables are standard WordPress custom post types

---

## HRCEF Plugins

### 1. HRCEF Testimonials Plugin
**Location:** `/hrcef-testimonials-plugin/`
**Current Version:** v1.0.4
**Zip File:** `hrcef-testimonials-plugin-v1.0.4.zip`
**Status:** Installed and active

### 2. HRCEF Announcement Banner Plugin
**Location:** `/hrcef-announcement-banner/`
**Current Version:** v1.0.3
**Zip File:** `hrcef-announcement-banner-v1.0.3.zip`
**Status:** Ready for installation

**Features:**
- Fixed banner at top of browser
- Dismissible with localStorage
- Content versioning (banner reappears when updated)
- 4 color schemes (Red, Blue, Orange, Green)
- 6 icon options
- Link to posts/pages/custom URLs
- Schedule support (start/end dates)
- Page targeting (all pages or homepage)
- Live preview in admin
- Responsive design

### 3. HRCEF Grant Highlights Plugin
**Location:** `/hrcef-grant-highlights/`
**Current Version:** v1.1.4
**Zip File:** `hrcef-grant-highlights-v1.1.4.zip`
**Status:** Ready for installation

**Features:**
- Custom post type (hrcef_grant) with school, teacher, year fields
- Gutenberg block with configurable card count (1-6)
- REST API endpoint: /wp-json/hrcef/v1/grants
- 6 themed placeholder images (Environmental Science, Robotics, Arts, Farm to Table, Outdoor Ed, Music)
- Random selection with click-to-refresh
- Image-focused card layout (250px image + description + gradient footer)
- HRCEF brand gradient styling
- Responsive: 3 → 2 → 1 cards
- Admin settings page with usage instructions

---

## Prototypes & Development Servers

### Running Prototype Servers

Prototypes use Python's built-in HTTP server for local testing:

**Testimonials Plugin:**
```bash
cd /Users/barry/Projects/hrcef-wordpress/prototypes/testimonials-plugin
python3 -m http.server 8000
```
Open: http://localhost:8000

**Announcement Banner:**
```bash
cd /Users/barry/Projects/hrcef-wordpress/prototypes/announcement-banner
python3 -m http.server 8001
```
Open: http://localhost:8001

**Grant Highlights:**
```bash
cd /Users/barry/Projects/hrcef-wordpress/prototypes/grant-highlights
python3 -m http.server 8002
```
Open: http://localhost:8002

### Port Assignments
- **8000** - Testimonials Plugin
- **8001** - Announcement Banner
- **8002** - Grant Highlights
- **8003+** - Future prototypes

### Stopping Servers
Press `Ctrl+C` in the terminal running the server.

---

**Last Updated:** October 21, 2025  
**Status:** Ready for deployment
