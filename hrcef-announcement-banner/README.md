# HRCEF Announcement Banner Plugin

A WordPress plugin for displaying dismissible announcement banners on the HRCEF website.

## Features

- ✅ **Fixed to Top** - Banner stays at top of browser window
- ✅ **Dismissible** - Users can close the banner (remembers preference)
- ✅ **4 Color Schemes** - Red (default), Blue, Orange, Green
- ✅ **6 Icon Options** - Graduation, Calendar, Megaphone, Star, Bell, Trophy
- ✅ **Link to Posts/Pages** - Direct link to blog posts, pages, or custom URLs
- ✅ **Schedule Support** - Set start and end dates
- ✅ **Page Targeting** - Show on all pages or homepage only
- ✅ **Live Preview** - See changes in real-time in admin
- ✅ **Responsive** - Works on all screen sizes
- ✅ **Accessible** - Keyboard navigation and ARIA labels

## Installation

### Via WordPress Admin

1. Zip the `hrcef-announcement-banner` folder
2. Go to WordPress Admin > Plugins > Add New > Upload Plugin
3. Choose the zip file and click "Install Now"
4. Click "Activate Plugin"

### Via FTP/SFTP

1. Upload the `hrcef-announcement-banner` folder to `/wp-content/plugins/`
2. Go to WordPress Admin > Plugins
3. Find "HRCEF Announcement Banner" and click "Activate"

## Usage

### Basic Setup

1. Go to **Announcement Banner** in WordPress admin sidebar
2. Toggle "Enable Banner" to ON
3. Enter your banner title and description
4. Select a post/page to link to or enter a custom URL
5. Choose a color scheme and icon
6. Click "Save Settings"

### Settings

#### Banner Status
- **Enable Banner** - Turn the banner on or off site-wide

#### Banner Content
- **Title** - Main heading text (max 60 characters recommended)
- **Description** - Supporting text (max 120 characters recommended)
- **Link To** - Choose Post, Page, or Custom URL
- **Button Text** - Text for the call-to-action button

#### Banner Style
- **Color Scheme**:
  - Alert Red (default) - For urgent announcements
  - HRCEF Blue - For general information
  - Urgent Orange - For deadlines
  - Success Green - For celebrations
- **Icon** - Choose from 6 icon options

#### Schedule (Optional)
- **Start Date** - When to start showing the banner
- **End Date** - When to stop showing the banner
- Leave blank for immediate/indefinite display

#### Advanced Options
- **Dismissible** - Allow users to close the banner
- **Show On** - All pages or homepage only

## How It Works

### Frontend Display

The banner is automatically inserted at the top of every page using the `wp_body_open` hook. No template editing required!

The banner:
- Appears fixed at the top of the browser window
- Adds padding to the body so content isn't hidden
- Removes padding when dismissed
- Remembers user's dismissal preference via localStorage

### Admin Interface

The admin page provides:
- Live preview that updates as you type
- Visual color scheme selector
- Post/page selector
- Date/time pickers for scheduling
- AJAX saving (no page reload)

## File Structure

```
hrcef-announcement-banner/
├── hrcef-announcement-banner.php    # Main plugin file
├── admin/
│   └── settings-page.php            # Admin settings page
├── assets/
│   ├── css/
│   │   ├── banner.css               # Frontend styles
│   │   └── admin.css                # Admin styles
│   └── js/
│       ├── banner.js                # Frontend functionality
│       └── admin.js                 # Admin functionality
├── templates/
│   └── banner-display.php           # Frontend banner template
└── README.md                        # This file
```

## Customization

### Change Colors

Edit the gradient in `assets/css/banner.css`:

```css
.hrcef-announcement-banner {
    background: linear-gradient(135deg, #YourColor1, #YourColor2);
}
```

### Add New Icon

1. Add SVG path to `get_icon_svg()` method in main plugin file
2. Add option to icon selector in `admin/settings-page.php`
3. Add to `iconPaths` object in `assets/js/admin.js`

### Modify Layout

Edit `templates/banner-display.php` for HTML structure
Edit `assets/css/banner.css` for styling

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## WordPress Requirements

- WordPress 5.2 or higher (for `wp_body_open` hook)
- PHP 7.0 or higher

## Content Versioning

The plugin automatically tracks content versions to ensure users see updated banners even if they dismissed a previous version.

### How It Works

1. **Content Version Tracking** - Each banner has a `content_version` number
2. **Auto-Increment** - Version increments automatically when you change:
   - Title
   - Description
   - Link URL
3. **Version-Based Dismissal** - localStorage key includes version: `hrcef_banner_dismissed_v1`, `hrcef_banner_dismissed_v2`, etc.
4. **Reappearance** - When content changes, dismissed users will see the new banner

### Example

- User dismisses banner with "Scholarship Deadline" (version 1)
- Admin updates banner to "New Event Announcement" (version auto-increments to 2)
- User sees the new banner even though they dismissed version 1

### What Triggers Version Increment

✅ **Increments version:**
- Changing title text
- Changing description text
- Changing link URL

❌ **Does NOT increment version:**
- Changing button text
- Changing color scheme
- Changing icon
- Changing schedule dates
- Enabling/disabling banner

## localStorage Keys

The plugin uses version-specific localStorage keys to track dismissal state:
- Format: `hrcef_banner_dismissed_v[version]`
- Example: `hrcef_banner_dismissed_v1`, `hrcef_banner_dismissed_v2`

## Hooks & Filters

### Actions

- `wp_body_open` - Inserts banner into page
- `admin_menu` - Adds admin menu item
- `wp_enqueue_scripts` - Loads frontend assets
- `admin_enqueue_scripts` - Loads admin assets

### Filters

None currently, but can be added for customization.

## Troubleshooting

### Banner doesn't appear

1. Check that "Enable Banner" is toggled ON
2. Verify schedule dates (if set)
3. Check page targeting settings
4. Clear browser cache
5. Check if theme supports `wp_body_open` hook

### Banner appears behind other elements

Increase z-index in `assets/css/banner.css`:

```css
.hrcef-announcement-banner {
    z-index: 99999; /* Increase this value */
}
```

### Dismissal not working

1. Check that "Dismissible" option is enabled
2. Verify browser supports localStorage
3. Clear browser localStorage
4. Check browser console for JavaScript errors

## Support

For issues or questions, contact the HRCEF web team.

## Changelog

### Version 1.0.3
- Fixed gap between banner and page content
- Removed theme margins that caused spacing issues
- Ensured seamless connection to page header

### Version 1.0.2
- Fixed positioning to display below WordPress admin bar
- Added responsive handling for mobile admin bar (46px height)
- Adjusted z-index to work properly with WordPress.com toolbar
- Improved body padding calculations for admin bar presence

### Version 1.0.1
- Added content versioning system
- Banner reappears when content is updated (title, description, or link)
- Auto-increments version number on content changes
- Shows helpful message when content is updated
- Displays current content version in admin

### Version 1.0.0
- Initial release
- Fixed banner at top of browser
- 4 color schemes
- 6 icon options
- Link to posts/pages/custom URLs
- Schedule support
- Page targeting
- Dismissible with localStorage
- Live preview in admin
- Responsive design
- Accessibility features

## Credits

**Developed for:** Hood River County Education Foundation  
**Version:** 1.0.0  
**License:** GPL v2 or later

---

**Last Updated:** October 21, 2025
