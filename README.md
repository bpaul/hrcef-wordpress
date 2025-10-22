# HRCEF WordPress Project

Custom WordPress plugins and components for the Hood River County Education Foundation website.

## Overview

This repository contains custom WordPress plugins developed for hrcef.org, a nonprofit organization supporting students and teachers in Hood River County through scholarships and grants.

**Live Site:** https://hrcef.wordpress.com
**Hosting:** WordPress.com Business Plan
**Project Documentation:** See `context-docs/` directory

## Custom Plugins

### 1. HRCEF Testimonials Plugin
**Status:** Deployed (v1.0.4)
**Location:** `/hrcef-testimonials-plugin/`

Gutenberg block for displaying testimonial cards with beautiful responsive layout featuring the HRCEF brand gradient.

**Features:**
- Custom post type for testimonials
- Gutenberg block with configurable card count (1-6)
- Click cards to refresh with random testimonials
- Circular avatar photos with gradient footer
- Responsive: 3 columns → 2 columns → 1 column
- REST API endpoint for dynamic loading

### 2. HRCEF Announcement Banner Plugin
**Status:** Ready for installation (v1.0.3)
**Location:** `/hrcef-announcement-banner/`

Fixed banner at top of browser for important announcements and events.

**Features:**
- Dismissible with localStorage (version-based)
- 4 color schemes (Red, Blue, Orange, Green)
- 6 icon options
- Schedule support (start/end dates)
- Page targeting (all pages or homepage only)
- Live preview in admin
- Responsive design

### 3. HRCEF Grant Highlights Plugin
**Status:** Ready for installation (v1.1.4)
**Location:** `/hrcef-grant-highlights/`

Showcase Impact Teaching Grant awards with image-focused card layout.

**Features:**
- Custom post type with school, teacher, year fields
- Gutenberg block with configurable card count (1-6)
- 6 themed placeholder images
- Click-to-refresh random selection
- Image-focused layout (250px images)
- HRCEF brand gradient styling
- Responsive: 3 → 2 → 1 cards

## Project Structure

```
hrcef-wordpress/
├── hrcef-testimonials-plugin/      # Testimonials plugin (deployed)
├── hrcef-announcement-banner/      # Banner plugin (ready)
├── hrcef-grant-highlights/         # Grant highlights plugin (ready)
├── prototypes/                     # HTML/CSS/JS prototypes for testing
│   ├── testimonials-plugin/
│   ├── announcement-banner/
│   └── grant-highlights/
├── context-docs/                   # Project documentation
│   ├── foundation-background.md    # HRCEF overview and requirements
│   ├── hrcef-style-guide.md       # Brand colors, typography, components
│   ├── testimonials-plugin-summary.md
│   └── hosting-and-deployment.md   # Deployment instructions
└── README.md                       # This file
```

## Installation

All plugins can be installed via WordPress.com admin:

1. **Create plugin zip:**
   ```bash
   cd hrcef-wordpress
   zip -r hrcef-[plugin-name]-v[version].zip hrcef-[plugin-name]/
   ```

2. **Upload to WordPress:**
   - Log in to WordPress.com admin
   - Go to Plugins > Add New > Upload Plugin
   - Choose the zip file
   - Click Install Now
   - Activate the plugin

## Development Workflow

### 1. Prototype First
Develop and test features using HTML/CSS/JS prototypes:

```bash
cd prototypes/[plugin-name]
python3 -m http.server 8000
```

Open http://localhost:8000 to test.

### 2. Build WordPress Plugin
Convert prototype to WordPress plugin following HRCEF naming conventions:
- Plugin folder: `hrcef-[plugin-name]/`
- Main file: `hrcef-[plugin-name].php`
- CSS classes: `.hrcef-[component]-[element]`
- Database options: `hrcef_[plugin]_[setting]`

### 3. Version and Deploy
1. Update version number in plugin PHP file
2. Create zip: `hrcef-[plugin-name]-v[version].zip`
3. Delete previous version zip
4. Update version history in `context-docs/hosting-and-deployment.md`
5. Upload to WordPress.com

## Version Management

**Format:** `v[major].[minor].[patch]`

- **Major (1.x.x)** - Breaking changes, major features
- **Minor (x.1.x)** - New features, non-breaking changes
- **Patch (x.x.1)** - Bug fixes, minor improvements

**Current Versions:**
- Testimonials: v1.0.4
- Announcement Banner: v1.0.3
- Grant Highlights: v1.1.4

Keep only the latest zip file in the project root.

## Brand Guidelines

See `context-docs/hrcef-style-guide.md` for complete brand specifications.

### Key Colors
- Primary Blue: `#0066B3`
- Teal: `#008B8B`
- Gradient: `linear-gradient(135deg, #0066B3, #008B8B)`

### Design Principles
- Clean, modern interface
- Generous white space
- Responsive mobile-first approach
- HRCEF brand consistency across all plugins
- Professional yet approachable tone

## Documentation

- **Foundation Background:** `context-docs/foundation-background.md`
- **Style Guide:** `context-docs/hrcef-style-guide.md`
- **Hosting & Deployment:** `context-docs/hosting-and-deployment.md`
- **Testimonials Plugin:** `context-docs/testimonials-plugin-summary.md`

## Support

**WordPress.com Support:** https://wordpress.com/support/
**SFTP Access:** https://wordpress.com/support/sftp/
**Plugin Management:** https://wordpress.com/support/plugins/

## License

Custom plugins developed for Hood River County Education Foundation.

---

**Last Updated:** October 22, 2025
**Maintained by:** HRCEF Web Team
