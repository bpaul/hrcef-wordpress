# HRCEF Testimonials Plugin - Display Template Prototype

## Overview
This prototype demonstrates the testimonial display template for the Hood River County Education Foundation WordPress site. It loads a random testimonial from a JSON data file on page load.

## Files
- **index.html** - Main HTML structure
- **styles.css** - Styling matching the HRCEF design aesthetic
- **script.js** - JavaScript for loading and displaying random testimonials
- **testimonials.json** - Sample testimonial data

## Features
- ✅ Loads random testimonial on page load
- ✅ Reads data from JSON file
- ✅ Responsive design (mobile, tablet, desktop)
- ✅ Smooth fade-in animation
- ✅ Blue quotation mark accent (HRCEF brand color)
- ✅ Overlay background with hero image
- ✅ Attribution with author name and institution

## Design Elements
- **Quote Icon**: Large blue quotation mark (#0033A0)
- **Typography**: Large, bold quote text with dark color for readability
- **Attribution**: Right-aligned author name and institution
- **Background**: Semi-transparent overlay on hero image
- **Animation**: Fade-in effect on load

## Usage

### Local Testing
1. Open `index.html` in a web browser
2. A random testimonial will load automatically
3. Refresh the page to see a different random testimonial

### Live Server (Recommended)
Due to CORS restrictions with loading JSON files, it's best to use a local server:

```bash
# Using Python 3
python3 -m http.server 8000

# Using Node.js (if you have http-server installed)
npx http-server

# Using PHP
php -S localhost:8000
```

Then navigate to `http://localhost:8000` in your browser.

## Customization

### Adding More Testimonials
Edit `testimonials.json` and add new entries:

```json
{
  "id": 7,
  "quote": "Your testimonial text here",
  "author": "Author Name",
  "institution": "Institution Name",
  "image": "image-filename.jpg"
}
```

### Styling Adjustments
- **Colors**: Edit the color values in `styles.css`
- **Font Sizes**: Adjust `.testimonial-quote` font-size
- **Background**: Replace the background image URL in `.testimonial-container`
- **Spacing**: Modify padding and margin values

### Auto-Rotation (Optional)
Uncomment the last line in `script.js` to enable automatic testimonial rotation every 10 seconds:

```javascript
setInterval(loadRandomTestimonial, 10000);
```

## WordPress Integration Notes

When converting this to a WordPress plugin:

1. **Data Source**: Replace JSON file with WordPress custom post type or database queries
2. **Shortcode**: Create shortcode `[hrcef_testimonial]` for easy placement
3. **Widget**: Develop widget for sidebar/footer placement
4. **Admin Panel**: Build interface for managing testimonials
5. **Image Handling**: Integrate with WordPress Media Library
6. **Caching**: Implement transients for performance
7. **Settings**: Add options for rotation speed, display style, etc.

## Browser Support
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Next Steps
1. Test prototype with various testimonial lengths
2. Add navigation controls (previous/next buttons)
3. Create multiple layout variations (grid, slider, card)
4. Design admin interface for testimonial management
5. Plan WordPress plugin architecture
