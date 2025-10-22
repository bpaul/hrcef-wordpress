# HRCEF Grant Highlights Prototype

A prototype for displaying Impact Teaching Grant highlights in a card-based layout with random selection.

## Features

- **Random Selection** - Displays 3 random grants from the pool
- **Card Layout** - Clean, modern card design with image, description, and attribution
- **Image Display** - Full-width image in upper third of card
- **Grant Details** - Description in middle section
- **Attribution Section** - School/teacher and year in HRCEF blue gradient footer
- **Interactive** - Click any card or refresh button to load new grants
- **Responsive** - 3 cards (desktop) → 2 cards (tablet) → 1 card (mobile)
- **Smooth Animations** - Fade-in effects and hover states

## Card Structure

```
┌─────────────────────────┐
│                         │
│    Grant Image          │  ← Full width, 200px height
│    (Upper 1/3)          │
│                         │
├─────────────────────────┤
│                         │
│  Grant Description      │  ← Text description
│  (Middle section)       │
│                         │
├─────────────────────────┤
│  School Name            │  ← Blue gradient background
│  Teacher • Year         │
└─────────────────────────┘
```

## Design Details

### Card Dimensions
- **Image Height:** 200px (upper 1/3)
- **Content Padding:** 24px
- **Attribution Padding:** 16px 24px
- **Border Radius:** 12px
- **Gap Between Cards:** 32px

### Colors
- **Gradient:** `linear-gradient(135deg, #0066B3, #008B8B)` (HRCEF brand)
- **Card Background:** White
- **Text:** #333
- **Shadow:** `0 4px 12px rgba(0, 0, 0, 0.1)`
- **Hover Shadow:** `0 12px 24px rgba(0, 0, 0, 0.15)`

### Typography
- **Description:** 1rem, line-height 1.6
- **School Name:** 1rem, font-weight 600
- **Teacher:** 0.875rem, italic
- **Year:** 0.875rem, font-weight 600

### Interactions
- **Hover:** Card lifts up 8px with enhanced shadow
- **Image Zoom:** 5% scale on hover
- **Click:** Load new random grants
- **Refresh Button:** Spinning icon animation

## File Structure

```
grant-highlights/
├── index.html           # Main prototype page
├── grants.json          # Sample grant data
├── css/
│   └── grants.css       # Styles
├── js/
│   └── grants.js        # Functionality
├── images/              # Grant images (placeholder)
└── README.md            # This file
```

## Sample Data Format

```json
{
  "id": 1,
  "description": "Grant project description...",
  "school": "School Name",
  "teacher": "Teacher Name",
  "year": "2024",
  "image": "images/grant-1.jpg"
}
```

## Usage

1. Open `index.html` in a web browser
2. View 3 random grant highlights
3. Click "Load More" button or any card to see different grants
4. Test responsive behavior by resizing browser

## Responsive Breakpoints

- **Desktop (>1024px):** 3 cards per row
- **Tablet (768px-1024px):** 2 cards per row
- **Mobile (<768px):** 1 card per row

## Next Steps for WordPress Plugin

1. Create custom post type: `hrcef_grant`
2. Add custom fields:
   - Grant description (textarea)
   - School name (text)
   - Teacher name (text)
   - Grant year (text/select)
   - Featured image (WordPress media)
3. Create Gutenberg block with card count selector
4. Add REST API endpoint
5. Implement random selection logic
6. Add admin settings page

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

---

**Created:** October 21, 2025  
**Status:** Prototype - Ready for review
