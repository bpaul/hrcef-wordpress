# HRCEF Announcement Banner Prototype

A dismissible announcement banner for highlighting important blog posts, events, and announcements on the HRCEF website.

## Features

- ✅ **HRCEF Red Color Scheme** - Uses appropriate red gradient (#C41E3A to #E63946)
- ✅ **Dismissible** - X button to close the banner
- ✅ **Persistent** - Remembers user preference using localStorage
- ✅ **Responsive** - Works on all screen sizes
- ✅ **Accessible** - Keyboard navigation and ARIA labels
- ✅ **Animated** - Smooth slide-down entrance
- ✅ **Multiple Variations** - Different colors for different announcement types

## Design Specifications

### Colors

#### Default (Announcement/Alert)
- **Background:** `linear-gradient(135deg, #C41E3A, #E63946)`
- **Text:** White
- **Button:** White background with red text
- **Shadow:** `0 4px 12px rgba(196, 30, 58, 0.3)`

#### Event Variation
- **Background:** `linear-gradient(135deg, #0066B3, #008B8B)` (HRCEF blue-teal)

#### Deadline Variation
- **Background:** `linear-gradient(135deg, #D97706, #F59E0B)` (Orange/amber)

#### Success Variation
- **Background:** `linear-gradient(135deg, #059669, #10B981)` (Green)

### Layout
- **Padding:** 16px vertical
- **Icon:** 40px circle with white background overlay
- **Text:** Two lines - bold title + description
- **Button:** White with colored text, rounded corners
- **Close Button:** 32px circle, rotates on hover

### Typography
- **Title:** 1.125rem (18px), weight 600
- **Description:** 0.9375rem (15px), opacity 0.95
- **Button:** 0.9375rem (15px), weight 600

## File Structure

```
announcement-banner/
├── index.html          # Demo page
├── css/
│   └── banner.css      # All styles
├── js/
│   └── banner.js       # Banner functionality
└── README.md           # This file
```

## How to Use

### View the Prototype

1. Open `index.html` in a web browser
2. The banner appears at the top of the page
3. Click the X to dismiss it
4. Use demo buttons to test different variations

### Integration

To integrate into WordPress:

1. **Add HTML** to your theme's header template:
```html
<div class="announcement-banner" id="announcement-banner">
    <div class="banner-content">
        <div class="banner-icon">
            <!-- SVG icon -->
        </div>
        <div class="banner-text">
            <strong>Your Title</strong>
            <span>Your description text</span>
        </div>
        <a href="your-link" class="banner-link">Learn More →</a>
        <button class="banner-close" id="banner-close" aria-label="Close announcement">
            <!-- X icon -->
        </button>
    </div>
</div>
```

2. **Enqueue CSS** in your theme's functions.php
3. **Enqueue JavaScript** in your theme's functions.php
4. **Customize content** via WordPress admin or theme options

## Features Explained

### Dismissible Behavior
- Click X button to dismiss
- Preference saved to localStorage
- Banner stays hidden on subsequent visits
- Can be reset via demo controls

### Responsive Design
- **Desktop:** Horizontal layout with all elements in a row
- **Tablet:** Slightly compressed with adjusted spacing
- **Mobile:** Stacked layout with close button at top-right

### Accessibility
- ARIA label on close button
- Keyboard navigation support (Enter/Space to close)
- High contrast text
- Focus states on interactive elements

### Animation
- Slides down from top on page load (0.4s)
- Close button rotates 90° on hover
- Link button lifts up on hover
- Smooth transitions throughout

## Customization

### Change Colors
Edit the gradient in `banner.css`:
```css
.announcement-banner {
    background: linear-gradient(135deg, #YourColor1, #YourColor2);
}
```

### Change Content
Use the `changeBannerContent()` function in JavaScript:
```javascript
changeBannerContent('scholarship'); // or 'event', 'deadline', 'success'
```

### Add New Variations
Add to the `bannerContent` object in `banner.js`:
```javascript
yourVariation: {
    icon: '<svg path data>',
    title: 'Your Title',
    text: 'Your description',
    link: '#',
    linkText: 'Button Text →',
    className: 'your-class'
}
```

Then add corresponding CSS:
```css
.announcement-banner.your-class {
    background: linear-gradient(135deg, #Color1, #Color2);
}
```

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## localStorage Key

The banner uses `hrcef_banner_dismissed` as the localStorage key to track dismissal state.

## Demo Controls

The prototype includes demo controls to:
- **Show Banner Again** - Reveals banner if dismissed
- **Clear Storage** - Removes localStorage preference
- **Change Variations** - Preview different banner styles

## WordPress Plugin Considerations

For a WordPress plugin version, consider:
- Admin interface to set banner content
- Post selector to link to specific posts
- Schedule start/end dates
- User role targeting
- A/B testing capabilities
- Analytics tracking

## Notes

- The red color (#C41E3A) is chosen to be attention-grabbing while maintaining HRCEF's professional brand
- The gradient adds visual interest and depth
- White button provides strong contrast and clear call-to-action
- Icon helps quickly communicate the announcement type
- Smooth animations enhance user experience without being distracting

---

**Created:** October 21, 2025  
**For:** Hood River County Education Foundation  
**Purpose:** Highlight important announcements and blog posts
