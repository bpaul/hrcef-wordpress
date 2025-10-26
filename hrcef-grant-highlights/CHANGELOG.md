# Changelog - HRCEF Grant Highlights Plugin

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
