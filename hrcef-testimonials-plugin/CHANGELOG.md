# Changelog - HRCEF Testimonials Plugin

## Version 1.1.0 - October 26, 2025

### New Features
- **Tag Filtering System**: Added taxonomy-based tag filtering for testimonials
  - New taxonomy: `hrcef_testimonial_tag`
  - Tags appear in admin sidebar under Testimonials menu
  - Tags can be assigned to testimonials in the editor

### Block Editor Enhancements
- **Tag Selection in Block**: New "Filter by Tags" panel in block settings
  - Checkbox controls for each available tag
  - Multiple tags can be selected (OR logic - shows testimonials with ANY selected tag)
  - Leave empty to show all testimonials
  - Live preview updates when tags are selected

### REST API Updates
- **Tag Parameter**: REST API now accepts `tags` parameter
  - Format: `/wp-json/hrcef/v1/testimonials?count=3&tags=1,2,3`
  - Filters testimonials by tag IDs
  - Uses OR logic (testimonials matching any tag)

### Frontend Updates
- **Dynamic Tag Filtering**: Frontend JavaScript passes selected tags to REST API
  - Maintains tag filtering when clicking refresh or cards
  - No visual changes to card display
  - Seamless integration with existing functionality

### Admin Features
- **Tag Management**: Standard WordPress taxonomy interface
  - Add, edit, and delete tags
  - Assign tags to testimonials
  - Tags show in admin column
  - Bulk edit support

### Use Cases
- **Student Scholarships Page**: Filter to show only student testimonials
- **Teacher Grants Page**: Filter to show only teacher testimonials
- **Program-Specific Pages**: Filter by program type (scholarship, grant, field-trip, etc.)
- **Audience Targeting**: Create contextual testimonial displays

### Technical Details
- Taxonomy registered with `show_in_rest` for Gutenberg compatibility
- Block attributes include `selectedTags` array
- Server-side rendering supports tag filtering
- Frontend maintains backward compatibility (no tags = show all)

### Files Modified
- `hrcef-testimonials.php` - Added taxonomy registration and tag filtering
- `blocks/testimonials-block.js` - Added tag selection UI
- `templates/testimonials-display.php` - Added tags data attribute
- `assets/js/testimonials-frontend.js` - Added tag parameter to API calls

### Migration Notes
- Existing testimonials continue to work without tags
- Tags are optional - leaving them empty shows all testimonials
- No database migration required
- Backward compatible with v1.0.x

---

## Version 1.0.4 - October 21, 2025
- Initial release with basic testimonials functionality
- Custom post type with author and institution fields
- Gutenberg block with card count control
- REST API endpoint
- Responsive card layout
- Click-to-refresh functionality
