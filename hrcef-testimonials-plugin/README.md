# HRCEF Testimonials WordPress Plugin

A beautiful, responsive testimonials plugin built specifically for the Hood River County Education Foundation WordPress site.

## Features

- ✅ **Custom Post Type** - Dedicated testimonials management
- ✅ **Gutenberg Block** - Easy drag-and-drop testimonials display
- ✅ **Responsive Design** - 3 cards on desktop, 2 on tablet, 1 on mobile
- ✅ **Random Display** - Shows random testimonials on each load
- ✅ **Click to Refresh** - Users can click cards or button to load new testimonials
- ✅ **Default Placeholder** - Automatic fallback image if none provided
- ✅ **HRCEF Branding** - Blue-to-teal gradient matching the foundation's logo
- ✅ **REST API** - Endpoint for dynamic testimonial loading
- ✅ **Beautiful Animations** - Smooth hover effects and transitions

## Installation

1. Upload the `hrcef-testimonials-plugin` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to **Testimonials > Settings** to see usage instructions

## Usage

### Adding Testimonials

1. Go to **Testimonials > Add New**
2. Enter the testimonial quote in the content editor
3. Fill in the **Author Name** and **Institution** fields
4. (Optional) Set a **Featured Image** for the person's photo
5. Click **Publish**

### Displaying Testimonials

1. Edit any page or post with the Gutenberg editor
2. Add the **HRCEF Testimonials** block
3. Configure the number of testimonials to display (1-6)
4. Publish your page

### Block Settings

- **Number of Testimonials**: Choose how many testimonials to display (default: 3)

## Design

The testimonials are displayed in a beautiful card layout:

- **Top Section**: White background with the testimonial quote
- **Circular Photo**: Overlapping the split between sections
- **Bottom Section**: HRCEF gradient (blue to teal) with author info
- **Hover Effects**: Cards lift up on hover
- **Click Interaction**: Click any card to load new testimonials

## Responsive Behavior

- **Desktop (>1024px)**: 3 testimonials in a row
- **Tablet (769-1024px)**: 2 testimonials in a row
- **Mobile (≤768px)**: 1 testimonial

The layout automatically adjusts when the browser is resized.

## REST API

The plugin provides a REST API endpoint for retrieving testimonials:

```
GET /wp-json/hrcef/v1/testimonials?count=3
```

**Parameters:**
- `count` (optional): Number of testimonials to return (default: 3)

**Response:**
```json
[
  {
    "id": 123,
    "quote": "The testimonial text...",
    "author": "Student Name",
    "institution": "University Name",
    "image": "https://example.com/image.jpg"
  }
]
```

## File Structure

```
hrcef-testimonials-plugin/
├── hrcef-testimonials.php          # Main plugin file
├── admin/
│   └── settings-page.php           # Admin settings page
├── blocks/
│   └── testimonials-block.js       # Gutenberg block
├── templates/
│   └── testimonials-display.php    # Display template
├── assets/
│   ├── css/
│   │   └── testimonials.css        # Styles
│   ├── js/
│   │   └── testimonials-frontend.js # Frontend JavaScript
│   └── images/
│       └── student-placeholder-6.svg # Default image
└── README.md
```

## Customization

### Default Image

The default placeholder image is located at:
```
assets/images/student-placeholder-6.svg
```

You can replace this file to change the default image for testimonials without photos.

### Colors

The HRCEF brand gradient can be customized in `assets/css/testimonials.css`:

```css
.hrcef-testimonial-footer {
    background: linear-gradient(135deg, #0066B3, #008B8B);
}
```

### Card Count

To change the default number of cards displayed, modify the `count` attribute default in `blocks/testimonials-block.js`:

```javascript
count: {
    type: 'number',
    default: 3  // Change this value
}
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher
- Gutenberg editor enabled

## Development

Built with:
- WordPress Custom Post Types
- Gutenberg Block API
- WordPress REST API
- Vanilla JavaScript (no jQuery dependency)
- CSS Grid for responsive layout

## Version History

### 1.0.0
- Initial release
- Custom post type for testimonials
- Gutenberg block support
- Responsive card layout
- Click-to-refresh functionality
- REST API endpoint
- Default placeholder image

## Credits

Developed for Hood River County Education Foundation (HRCEF)

## License

GPL v2 or later
