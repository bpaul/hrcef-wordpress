# Changelog - HRCEF Grant Highlights Plugin

## Version 1.9.0 - November 12, 2025

### Improvements
- **3:2 Aspect Ratio Images**: Fixed image aspect ratio to 3:2 for consistent display
  - Changed from fixed 250px height to responsive aspect ratio
  - Images now scale proportionally at all screen sizes
  - Maintains professional appearance across devices
  - Uses modern CSS `aspect-ratio` property

### Display Enhancements
- **Responsive Image Sizing**: Images adapt to card width while maintaining ratio
  - Desktop (3 columns): Proportional to card width
  - Tablet (2 columns): Larger but maintains 3:2 ratio
  - Mobile (1 column): Full width with 3:2 ratio
  - No distortion or stretching

### Technical Implementation
- **CSS Update**: Replaced `height: 250px` with `aspect-ratio: 3 / 2`
  - More responsive and modern approach
  - Better browser support for modern devices
  - Maintains `object-fit: cover` for proper image cropping

### Files Modified
- `assets/css/grants.css` - Updated grant image styling

### Benefits
- ✅ Consistent image proportions across all screen sizes
- ✅ More professional and polished appearance
- ✅ Better responsive behavior
- ✅ Modern CSS implementation
- ✅ No breaking changes to existing functionality

---

## Version 1.8.0 - November 12, 2025

### Improvements
- **"Current" Year Option**: Added "Current" as a grant year option
  - Appears as first option in year dropdown (after "Select Year")
  - Useful for ongoing grants or current year projects
  - Displays as "Current" on grant cards

### Admin Interface Updates
- **Year Dropdown Enhancement**: 
  - Options now: Select Year, Current, 2025, 2024, 2023...
  - "Current" option properly saves and loads when editing
  
### Files Modified
- `admin/add-new-page.php` - Added "Current" option to year dropdown

### Use Cases
- Ongoing multi-year grants
- Current year grants before year-end
- Flexibility in grant year attribution

### Benefits
- ✅ Better support for current/ongoing grants
- ✅ More flexible year selection
- ✅ No breaking changes to existing grants
- ✅ Backward compatible

---

## Version 1.7.0 - November 12, 2025

### Improvements
- **Optional Teacher Name**: Teacher name field is now optional
  - Removed required validation from admin form
  - Updated placeholder text to indicate "(optional)"
  - Display gracefully handles grants without teacher names
  - Only shows teacher name in card footer if provided

### Admin Interface Updates
- **Form Field Changes**: Teacher name input no longer required
  - No asterisk (*) on label
  - Placeholder updated to "Enter teacher name (optional)"
  - Can save grants without teacher information

### Display Updates
- **Conditional Rendering**: Teacher name only displays when present
  - Server-side template checks for empty teacher name
  - JavaScript template uses conditional rendering
  - Year still displays even without teacher name
  
### Files Modified
- `admin/add-new-page.php` - Removed required attribute from teacher field
- `hrcef-grant-highlights.php` - Updated validation to allow empty teacher name
- `templates/grants-display.php` - Added conditional check for teacher display
- `assets/js/grants-frontend.js` - Added conditional rendering in JavaScript

### Use Cases
- Grants awarded to entire departments or schools
- Collaborative grants without single teacher attribution
- Flexibility in grant attribution

### Benefits
- ✅ More flexible grant attribution
- ✅ Cleaner display when teacher name not applicable
- ✅ No breaking changes to existing grants
- ✅ Backward compatible (existing grants with teachers still display)

---

## Version 1.6.0 - November 11, 2025

### New Features
- **Click-to-Reload Functionality**: Interactive card refresh like testimonials plugin
  - Click any grant card to load new random grants
  - Smooth 300ms fade transition with loading state
  - Fetches grants from REST API dynamically
  - Maintains card count and tag filter settings

### User Experience Improvements
- **Hybrid Rendering**: Best of both worlds
  - Initial page load: Server-side rendering (instant display, SEO-friendly)
  - After click: JavaScript fetches new grants (interactive experience)
  - No page refresh needed
  
### Technical Implementation
- **Frontend JavaScript Enabled**: Re-enabled `grants-frontend.js`
  - Updated card template to include title section
  - Added `pluginUrl` to localized script data
  - Reads `data-card-count` and `data-tags` from container
  
### Files Modified
- `hrcef-grant-highlights.php` - Re-enabled frontend script enqueuing
- `assets/js/grants-frontend.js` - Added title to card template
- `templates/grants-display.php` - Added data attributes for JavaScript

### Benefits
- ✅ Interactive user experience (click to see more grants)
- ✅ Fast initial load (server-side rendering)
- ✅ Smooth animations and transitions
- ✅ Matches testimonials plugin behavior
- ✅ No breaking changes

---

## Version 1.5.0 - November 11, 2025

### New Features
- **Grant Title Display**: Added title section to grant highlight cards
  - Title appears between image and description
  - Uses WordPress post title (proper implementation)
  - Blue color (#0066B3) with subtle border separator
  - Clean, professional card hierarchy

### Admin Interface Enhancements
- **Title Input Field**: New required field in admin form
  - Appears at top of form before description
  - Placeholder example: "Columbia River Ecosystem Study"
  - Live preview updates as you type
  - Validates as required field

### Display Improvements
- **Card Structure Updated**: New visual hierarchy
  1. Image (250px height)
  2. Title (blue, bold) ← NEW
  3. Description
  4. Footer (school, teacher, year)
  
### Technical Implementation
- **WordPress Post Title**: Uses native `post_title` field
  - No custom meta fields needed
  - Proper WordPress data structure
  - SEO-friendly implementation
- **REST API Updated**: Added `title` field to API response
- **Minimal CSS Changes**: Only added title section styles
  - No changes to existing card, image, or footer styles
  - Maintains all existing animations and hover effects

### Files Modified
- `templates/grants-display.php` - Added title display
- `assets/css/grants.css` - Added title section styles
- `admin/add-new-page.php` - Added title input field
- `assets/css/admin-form.css` - Added preview title styles
- `assets/js/admin.js` - Added title to form and preview
- `hrcef-grant-highlights.php` - Updated AJAX handler and REST API

### Benefits
- ✅ Clear visual hierarchy with descriptive titles
- ✅ Better content organization
- ✅ Uses WordPress post title (standard practice)
- ✅ No breaking changes to existing grants
- ✅ Backward compatible

---

## Version 1.4.0 - November 11, 2025

### New Features
- **Custom Image Upload**: Added WordPress media library integration for custom grant images
  - Upload custom photos via WordPress media uploader
  - "Upload Photo" tab with upload button and image preview
  - Change or remove uploaded images
  - Custom images saved as WordPress featured images (proper WordPress way)
  - Maintains backward compatibility with themed images

### Admin Interface Enhancements
- **Media Uploader Integration**: Full WordPress media library access
  - Click "Upload Custom Image" to open media library
  - Select from existing images or upload new ones
  - Live preview updates when image is selected
  - "Change Image" and "Remove Image" buttons for uploaded photos
  
### Technical Improvements
- **Proper Featured Image Support**: Uses WordPress `set_post_thumbnail()` function
  - Custom images stored as featured images (WordPress standard)
  - Themed images stored in `_themed_image` post meta
  - Display code checks featured image first, then themed image
  - Proper cleanup when switching between image types

### Files Modified
- `hrcef-grant-highlights.php` - Added media script enqueuing and featured image handling
- `assets/js/admin.js` - Added WordPress media uploader JavaScript
- `admin/add-new-page.php` - Replaced placeholder with functional upload UI

### Benefits
- ✅ Full WordPress media library integration
- ✅ Upload custom grant photos
- ✅ Backward compatible with themed images
- ✅ No changes to display code or styling
- ✅ Proper WordPress featured image implementation

---

## Version 1.3.1 - October 30, 2025

### Responsive Card Display
- **CSS-Based Card Limiting**: Added responsive card display using pure CSS
  - Desktop (>1024px): Shows all cards (3 by default)
  - Tablet (769-1024px): Shows only 2 cards
  - Mobile (≤768px): Shows only 1 card
  - Uses `nth-child` selectors to hide extra cards
  
### Benefits
- ✅ No JavaScript required
- ✅ Instant (no fetch delay)
- ✅ Works even if JavaScript is disabled
- ✅ Better mobile performance
- ✅ Simpler implementation than testimonials' JavaScript approach

### Technical Details
- Added `.grant-card:nth-child(n+3) { display: none; }` for tablet
- Added `.grant-card:nth-child(n+2) { display: none; }` for mobile
- Maintains server-side rendering benefits from v1.3.0

---

## Version 1.3.0 - October 30, 2025

### Major Refactor - Server-Side Rendering
- **Matching Testimonials Structure**: Refactored to match testimonials plugin architecture
  - Removed separate `render_editor_preview()` method
  - Now uses same rendering logic for both editor and frontend
  - Server-side rendering for immediate display (no JavaScript dependency)
  
### Display Improvements
- **Fixed Editor Width Issue**: Container now properly constrained in editor
  - Added `max-width: 1400px` to base container (like testimonials)
  - Only expands to full width with `alignfull` class
  - Added `alignwide` support for 1600px max-width
  
### Template Updates
- **Server-Side Data Rendering**: Template now renders actual grant data
  - Removed empty template that relied on JavaScript
  - PHP loops through grants and outputs HTML directly
  - Matches testimonials template structure exactly
  
### CSS Updates
- **Consistent Styling**: Updated CSS to match testimonials
  - Proper container width constraints
  - Responsive padding adjustments
  - Better mobile display (40px 16px padding)
  
### JavaScript Changes
- **Removed Initial Load Dependency**: JavaScript no longer required for display
  - Commented out frontend JS enqueue
  - Cards display immediately via PHP
  - REST API still available for future interactivity
  
### Benefits
- ✅ Consistent structure across both plugins
- ✅ Faster initial page load (no JS dependency)
- ✅ Better SEO (content rendered server-side)
- ✅ Proper editor preview sizing
- ✅ Easier to maintain (single code path)

---

## Version 1.2.5 - October 26, 2025

### Bug Fixes
- **Edit Links Redirect**: Added redirect for "Edit" links to use custom editor
  - Intercepts `post.php` requests for grant posts
  - Redirects to custom editor with `grant_id` parameter
  - Now both "Add New" and "Edit" use the custom editor interface

---

## Version 1.2.4 - October 26, 2025

### Bug Fixes
- **Custom Editor Working**: Implemented CSS + redirect approach for menu
  - Hides default "Add New" with CSS
  - Redirects any access to default editor to custom page
  - Works reliably with taxonomy integration

---

## Version 1.2.3 - October 26, 2025

### Bug Fixes
- **Proper Admin Menu Solution**: Implemented robust fix using `register_post_type_args` filter
  - Uses custom capabilities to prevent default "Add New" menu from appearing
  - Sets `'create_posts' => 'edit_posts'` to disable automatic menu creation
  - Much cleaner approach than trying to remove menu items after creation
  - Works reliably with taxonomy integration
  - No more brittle menu manipulation code

### Technical Improvements
- Added `modify_post_type_args()` method with filter hook
- Simplified `add_admin_menu()` method - no longer needs complex submenu removal
- Removed dependency on high priority hooks and global $submenu manipulation
- More maintainable and WordPress-standard approach

---

## Version 1.2.2 - October 26, 2025

### Bug Fixes
- **Admin Menu Fix**: Improved custom "Add New" grant editor menu handling
  - Changed approach to use global $submenu for direct menu manipulation
  - Custom "Add New" page now positioned correctly after "All Grant Highlights"
  - Properly removes default WordPress "Add New" menu item
  - More reliable than remove_submenu_page() approach

---

## Version 1.2.1 - October 26, 2025

### Bug Fixes
- **Admin Menu Priority**: Fixed custom "Add New" grant editor not appearing in admin menu
  - Increased admin_menu hook priority to 100 to ensure it runs after taxonomy menu is registered
  - Custom grant editor now properly replaces default WordPress editor

---

## Version 1.2.0 - October 26, 2025

### New Features
- **Tag Filtering System**: Added taxonomy-based tag filtering for grant highlights
  - New taxonomy: `hrcef_grant_tag`
  - Tags appear in admin sidebar under Grant Highlights menu
  - Tags can be assigned to grants in the editor

### Block Editor Enhancements
- **Tag Selection in Block**: New "Filter by Tags" panel in block settings
  - Checkbox controls for each available tag
  - Multiple tags can be selected (OR logic - shows grants with ANY selected tag)
  - Leave empty to show all grants
  - Live preview updates when tags are selected

### REST API Updates
- **Tag Parameter**: REST API now accepts `tags` parameter
  - Format: `/wp-json/hrcef/v1/grants?tags=1,2,3`
  - Filters grants by tag IDs
  - Uses OR logic (grants matching any tag)

### Frontend Updates
- **Dynamic Tag Filtering**: Frontend JavaScript passes selected tags to REST API
  - Maintains tag filtering when clicking cards
  - No visual changes to card display
  - Seamless integration with existing functionality

### Admin Features
- **Tag Management**: Standard WordPress taxonomy interface
  - Add, edit, and delete tags
  - Assign tags to grants
  - Tags show in admin column
  - Bulk edit support

### Use Cases
- **Subject-Specific Pages**: Filter by subject (science, arts, music, etc.)
- **Grade Level Pages**: Filter by elementary, middle, high school
- **Program Type Pages**: Filter by field trip, classroom equipment, professional development
- **School-Specific Pages**: Filter by specific schools

### Technical Details
- Taxonomy registered with `show_in_rest` for Gutenberg compatibility
- Block attributes include `selectedTags` array
- Server-side rendering supports tag filtering
- Frontend maintains backward compatibility (no tags = show all)

### Files Modified
- `hrcef-grant-highlights.php` - Added taxonomy registration and tag filtering
- `blocks/grants-block.js` - Added tag selection UI
- `templates/grants-display.php` - Added tags data attribute
- `assets/js/grants-frontend.js` - Added tag parameter to API calls

### Migration Notes
- Existing grants continue to work without tags
- Tags are optional - leaving them empty shows all grants
- No database migration required
- Backward compatible with v1.1.x

---

## Version 1.1.4 - October 26, 2025
- Fixed block not appearing in editor (wp-block-editor dependency)
- Added editor styles for proper preview display
- Improved editor preview rendering

## Version 1.1.0 - October 21, 2025
- Initial release with grant highlights functionality
- Custom post type with school, teacher, and year fields
- Gutenberg block with card count control
- REST API endpoint
- 6 themed placeholder images
- Responsive card layout
- Click-to-refresh functionality
