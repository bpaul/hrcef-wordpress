# HRCEF Grant Highlights Plugin

A WordPress plugin for displaying Impact Teaching Grant highlights with custom post type, Gutenberg block, and themed placeholder images.

## Features

- ✅ **Custom Post Type** - `hrcef_grant` with custom fields
- ✅ **Gutenberg Block** - Configurable card count (1-6)
- ✅ **REST API** - `/wp-json/hrcef/v1/grants`
- ✅ **Themed Images** - 6 pre-designed placeholder images
- ✅ **Random Selection** - Shows random grants on each load
- ✅ **Interactive** - Click cards or refresh button for new grants
- ✅ **Responsive Design** - 3 → 2 → 1 cards (desktop → tablet → mobile)
- ✅ **HRCEF Branding** - Blue gradient styling matching testimonials

## Installation

### Via WordPress Admin

1. Zip the `hrcef-grant-highlights` folder
2. Go to WordPress Admin > Plugins > Add New > Upload Plugin
3. Choose the zip file and click "Install Now"
4. Click "Activate Plugin"

### Via FTP/SFTP

1. Upload the `hrcef-grant-highlights` folder to `/wp-content/plugins/`
2. Go to WordPress Admin > Plugins
3. Find "HRCEF Grant Highlights" and click "Activate"

## Usage

### Adding Grant Highlights

1. Go to **Grant Highlights > Add New**
2. Enter grant description in the main editor
3. Add custom fields:
   - **School Name** - Name of the school
   - **Teacher Name** - Name of the teacher
   - **Grant Year** - Year the grant was awarded
4. Set **Featured Image**:
   - Upload a custom photo, OR
   - Use one of the 6 themed images
5. Click **Publish**

### Themed Images

The plugin includes 6 themed placeholder images:

1. **Environmental Science** - Blue-green gradient with nature elements
2. **Robotics & Technology** - Purple gradient with robot and circuits
3. **Arts & Culture** - Pink-red gradient with art supplies
4. **Farm to Table** - Green gradient with vegetables and chef hat
5. **Outdoor Education** - Teal gradient with mountains and compass
6. **Music Technology** - Purple gradient with headphones and notes

Located in: `assets/images/grant-[1-6].svg`

### Adding to Pages

1. Edit a page or post
2. Click the **+** button to add a block
3. Search for **"Grant Highlights"**
4. Select the block
5. In the sidebar, choose number of cards (1-6)
6. Publish or update the page

## Card Structure

```
┌─────────────────────────┐
│                         │
│    Grant Image          │  ← 250px height
│                         │
├─────────────────────────┤
│                         │
│  Grant Description      │  ← Main content
│                         │
├─────────────────────────┤
│  School Name            │  ← Blue gradient
│  Teacher • Year         │
└─────────────────────────┘
```

## Custom Fields

- **school_name** (string) - School name
- **teacher_name** (string) - Teacher name
- **grant_year** (string) - Grant year

## REST API

**Endpoint:** `GET /wp-json/hrcef/v1/grants`

**Response:**
```json
[
  {
    "id": 1,
    "description": "Grant description...",
    "school": "School Name",
    "teacher": "Teacher Name",
    "year": "2024",
    "image": "https://example.com/image.jpg"
  }
]
```

## File Structure

```
hrcef-grant-highlights/
├── hrcef-grant-highlights.php  # Main plugin file
├── admin/
│   └── settings-page.php       # Admin settings
├── assets/
│   ├── css/
│   │   ├── grants.css          # Frontend styles
│   │   └── admin.css           # Admin styles
│   ├── js/
│   │   ├── grants-frontend.js  # Frontend functionality
│   │   └── admin.js            # Admin functionality
│   └── images/
│       ├── grant-1.svg         # Environmental Science
│       ├── grant-2.svg         # Robotics & Technology
│       ├── grant-3.svg         # Arts & Culture
│       ├── grant-4.svg         # Farm to Table
│       ├── grant-5.svg         # Outdoor Education
│       └── grant-6.svg         # Music Technology
├── blocks/
│   └── grants-block.js         # Gutenberg block
├── templates/
│   └── grants-display.php      # Frontend template
└── README.md                   # This file
```

## Design Details

### Colors
- **Gradient:** `linear-gradient(135deg, #0066B3, #008B8B)`
- **Card Background:** White
- **Text:** #333
- **Shadow:** `0 4px 12px rgba(0, 0, 0, 0.1)`

### Typography
- **Description:** 1rem, line-height 1.6
- **School:** 1rem, font-weight 600
- **Teacher:** 0.875rem, italic
- **Year:** 0.875rem, font-weight 600

### Interactions
- **Hover:** Card lifts 8px with enhanced shadow
- **Image Zoom:** 5% scale on hover
- **Click:** Load new random grants
- **Refresh Button:** Spinning icon animation

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## WordPress Requirements

- WordPress 5.0 or higher
- PHP 7.0 or higher

## Changelog

### Version 1.0.0
- Initial release
- Custom post type with meta fields
- Gutenberg block with card count selector
- 6 themed placeholder images
- REST API endpoint
- Random selection functionality
- Responsive design
- Click to refresh
- Admin settings page

## Credits

**Developed for:** Hood River County Education Foundation  
**Version:** 1.0.0  
**License:** GPL v2 or later

---

**Last Updated:** October 21, 2025
