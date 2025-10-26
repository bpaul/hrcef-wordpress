# Prototyping Best Practices

Guidelines and best practices for creating and testing prototypes for the HRCEF WordPress project.

---

## Running Prototypes

### ⚠️ CRITICAL: Always Use a Local Server

**Prototypes MUST be run through a local web server, not opened directly as files.**

#### Why?
- JavaScript `fetch()` requests for JSON files fail with CORS errors when opening HTML files directly (`file://` protocol)
- Modern browsers block local file access for security reasons
- Server simulation provides realistic testing environment

#### How to Run a Server

**Python (Recommended):**
```bash
# Navigate to prototype directory
cd /Users/barry/Projects/hrcef-wordpress/prototypes/[prototype-name]

# Start server on port 8000 (or any available port)
python3 -m http.server 8000
```

**Alternative Ports:**
- Use different ports for multiple simultaneous prototypes
- Example ports: 8000, 8001, 8002, 8003, 8004, etc.

**Access in Browser:**
```
http://localhost:8000
http://localhost:8000/index.html
http://localhost:8000/demo-page.html
```

---

## Prototype Directory Structure

### Standard Layout
```
prototypes/
├── [feature-name]/
│   ├── index.html              # Main demo page
│   ├── [feature]-demo.html     # Alternative demo pages
│   ├── styles.css              # Styles
│   ├── script.js               # JavaScript functionality
│   ├── data.json               # Sample data
│   ├── images/                 # Image assets
│   └── README.md               # Prototype documentation
```

### Example: Testimonials Plugin
```
prototypes/testimonials-plugin/
├── index.html                  # Original demo
├── tag-filter-demo.html        # Tag filtering feature demo
├── styles.css                  # Shared styles
├── script.js                   # Original functionality
├── tag-filter-script.js        # Tag filtering logic
├── testimonials.json           # Original data
├── testimonials-with-tags.json # Enhanced data with tags
├── images/                     # Placeholder images
└── README.md                   # Documentation
```

---

## Creating New Prototypes

### 1. Plan the Feature
- Define the user story and use case
- Sketch the UI/UX flow
- Identify data requirements
- List interactive elements

### 2. Set Up Files
```bash
# Create prototype directory
mkdir -p prototypes/[feature-name]
cd prototypes/[feature-name]

# Create base files
touch index.html styles.css script.js data.json README.md
```

### 3. Build the HTML Structure
- Use semantic HTML5 elements
- Include HRCEF brand classes and structure
- Add data attributes for JavaScript hooks
- Keep markup clean and readable

### 4. Style with HRCEF Brand Guidelines
- Use colors from `/context-docs/hrcef-style-guide.md`
- Apply consistent spacing and typography
- Ensure responsive design (mobile-first)
- Match existing component styles

### 5. Implement JavaScript Functionality
- Use vanilla JavaScript (no jQuery)
- Fetch data from JSON files
- Handle user interactions
- Add smooth transitions and animations
- Include error handling

### 6. Test Thoroughly
- Test in multiple browsers (Chrome, Firefox, Safari, Edge)
- Test responsive breakpoints (mobile, tablet, desktop)
- Test all interactive features
- Verify data loading and display
- Check console for errors

---

## Data Files

### JSON Structure
- Use realistic sample data
- Include all required fields
- Add optional fields for flexibility
- Use consistent naming conventions

### Example: Testimonial with Tags
```json
{
  "id": 1,
  "quote": "The scholarship changed my life...",
  "author": "Student Name",
  "institution": "School Name",
  "image": "images/placeholder.svg",
  "tags": ["student", "scholarship", "college"]
}
```

---

## HRCEF Brand Consistency

### Colors
```css
/* Primary Colors */
--primary-blue: #0066B3;
--teal: #008B8B;
--gradient: linear-gradient(135deg, #0066B3, #008B8B);

/* Secondary Colors */
--dark-gray: #374151;
--medium-gray: #6B7280;
--light-gray: #F5F5F5;
```

### Typography
- Headings: 600-700 weight
- Body: 400 weight (1rem - 1.125rem)
- Line height: 1.6-1.8 for body text

### Components
- Border radius: 12px-16px for cards
- Shadows: `0 4px 16px rgba(0, 0, 0, 0.1)`
- Transitions: 0.3s ease
- Hover lift: `translateY(-5px to -8px)`

---

## Testing Checklist

### Before Sharing
- [ ] Server is running (not opening file directly)
- [ ] All JSON data loads correctly
- [ ] No console errors
- [ ] Responsive on mobile, tablet, desktop
- [ ] All interactive features work
- [ ] Animations are smooth
- [ ] Matches HRCEF brand guidelines
- [ ] Accessibility (keyboard navigation, focus states)

### Browser Testing
- [ ] Chrome/Chromium
- [ ] Firefox
- [ ] Safari (macOS/iOS)
- [ ] Edge

### Device Testing
- [ ] Desktop (1920px+)
- [ ] Laptop (1366px-1920px)
- [ ] Tablet (768px-1024px)
- [ ] Mobile (320px-767px)

---

## Converting Prototypes to WordPress

### 1. Analyze Prototype Structure
- Identify reusable components
- Note data requirements
- Document interactive features
- List dependencies

### 2. Plan WordPress Implementation
- Custom post type or taxonomy?
- Gutenberg block or shortcode?
- REST API endpoints needed?
- Admin interface requirements?

### 3. Create Plugin Structure
```
plugin-name/
├── plugin-name.php           # Main plugin file
├── blocks/                   # Gutenberg blocks
├── templates/                # Display templates
├── admin/                    # Admin pages
├── assets/
│   ├── css/                  # Styles
│   ├── js/                   # Scripts
│   └── images/               # Images
└── README.md
```

### 4. Port Code Systematically
- HTML → PHP templates
- CSS → WordPress-enqueued stylesheets
- JavaScript → WordPress-enqueued scripts
- JSON data → WordPress database/REST API
- Static content → Dynamic WordPress content

### 5. Add WordPress Integration
- Register custom post types
- Create Gutenberg blocks
- Set up REST API endpoints
- Add admin interfaces
- Implement security (nonces, sanitization)

---

## Common Pitfalls to Avoid

### ❌ Don't
- Open HTML files directly in browser
- Use absolute file paths
- Hardcode data in JavaScript
- Ignore responsive design
- Skip error handling
- Use colors outside brand palette
- Forget to test in multiple browsers

### ✅ Do
- Always run a local server
- Use relative paths
- Load data from JSON files
- Design mobile-first
- Handle errors gracefully
- Follow HRCEF style guide
- Test thoroughly before implementation

---

## Quick Reference Commands

### Start Server
```bash
# Navigate to prototype directory
cd /Users/barry/Projects/hrcef-wordpress/prototypes/[name]

# Start Python server
python3 -m http.server 8004
```

### Stop Server
```bash
# Press Ctrl+C in terminal
```

### Check Running Servers
```bash
# List processes using port 8004
lsof -i :8004
```

### Kill Server on Port
```bash
# Kill process on specific port
kill -9 $(lsof -t -i:8004)
```

---

## Documentation

### Prototype README Template
```markdown
# [Feature Name] Prototype

## Purpose
Brief description of what this prototype demonstrates.

## Features
- Feature 1
- Feature 2
- Feature 3

## Running the Prototype
1. Start local server: `python3 -m http.server 8004`
2. Open browser: http://localhost:8004
3. Navigate to demo page

## Files
- `index.html` - Main demo
- `styles.css` - Styles
- `script.js` - Functionality
- `data.json` - Sample data

## Next Steps
- [ ] Get feedback
- [ ] Refine design
- [ ] Implement in WordPress
```

---

## Resources

### Internal Documentation
- `/context-docs/hrcef-style-guide.md` - Brand guidelines
- `/context-docs/foundation-background.md` - Organization info
- `/context-docs/testimonials-plugin-summary.md` - Plugin example

### External Resources
- [MDN Web Docs](https://developer.mozilla.org/) - Web standards
- [Can I Use](https://caniuse.com/) - Browser compatibility
- [WordPress Block Editor Handbook](https://developer.wordpress.org/block-editor/)

---

**Last Updated:** October 26, 2025  
**Maintained by:** HRCEF Web Development Team
