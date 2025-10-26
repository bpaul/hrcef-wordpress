# WordPress Plugin Development Tips & Tricks

Lessons learned from developing HRCEF WordPress plugins, with a focus on common pitfalls and practical solutions.

---

## Table of Contents
1. [Custom Admin Menus & Taxonomies](#custom-admin-menus--taxonomies)
2. [Gutenberg Block Development](#gutenberg-block-development)
3. [REST API Best Practices](#rest-api-best-practices)
4. [Custom Post Types](#custom-post-types)
5. [Hook Priorities & Timing](#hook-priorities--timing)
6. [Debugging Strategies](#debugging-strategies)

---

## Custom Admin Menus & Taxonomies

### The Problem: Taxonomy Breaking Custom Admin Menus

**Scenario**: You have a custom post type with a custom "Add New" page that replaces the default WordPress editor. Everything works fine until you add a taxonomy with `show_ui => true`, then your custom menu disappears or stops working.

**Why It Happens**:
- When you register a taxonomy with `show_ui => true`, WordPress rebuilds the admin menu structure for that post type
- The taxonomy menu items get inserted automatically
- Standard menu removal functions like `remove_submenu_page()` become unreliable due to timing issues
- The menu structure is finalized differently than before the taxonomy was added

**Solutions That DON'T Work Well**:
1. ❌ Using `remove_submenu_page()` - timing issues with taxonomy registration
2. ❌ Increasing `admin_menu` hook priority - still unreliable
3. ❌ Manipulating global `$submenu` directly - brittle and can break
4. ❌ Custom capabilities to prevent menu creation - can break user access

**Solution That WORKS**:

**Hybrid Approach: CSS + Redirect**

```php
public function add_admin_menu() {
    // Add your custom "Add New" page
    add_submenu_page(
        'edit.php?post_type=your_post_type',
        __('Add New Item', 'your-plugin'),
        __('Add New Item', 'your-plugin'),
        'edit_posts',
        'your-custom-add-new',
        array($this, 'render_custom_page')
    );
    
    // Hide the default "Add New" menu item with CSS
    add_action('admin_head', function() {
        echo '<style>
            #menu-posts-your_post_type .wp-submenu li:has(a[href="post-new.php?post_type=your_post_type"]) {
                display: none !important;
            }
        </style>';
    });
    
    // Redirect default "Add New" to your custom page
    add_action('admin_init', function() {
        global $pagenow;
        if ($pagenow === 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] === 'your_post_type') {
            wp_redirect(admin_url('edit.php?post_type=your_post_type&page=your-custom-add-new'));
            exit;
        }
    });
}
```

**Why This Works**:
- ✅ CSS hiding is reliable regardless of menu timing
- ✅ Redirect catches any access attempts (bookmarks, direct URLs, etc.)
- ✅ Works with taxonomies without conflicts
- ✅ Simple to understand and maintain
- ✅ No complex capability mapping needed

**Key Takeaway**: Sometimes the pragmatic solution (CSS + redirect) is better than trying to fight WordPress's internal menu building process.

---

## Gutenberg Block Development

### Deprecated Dependencies

**Problem**: Using `wp-editor` as a dependency causes blocks to not appear in the editor.

**Solution**: Use `wp-block-editor` instead:

```javascript
// ❌ OLD (deprecated)
array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components')

// ✅ NEW (correct)
array('wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-data')
```

### ServerSideRender vs Frontend JavaScript

**When to Use Each**:

**ServerSideRender** (Editor Preview):
- Use for editor preview when you need PHP data
- Prevents JavaScript errors in editor context
- Separates editor rendering from frontend rendering

```php
public function render_block($attributes) {
    $is_editor = defined('REST_REQUEST') && REST_REQUEST;
    
    if ($is_editor) {
        return $this->render_editor_preview($attributes);
    }
    
    // Frontend template
    ob_start();
    include plugin_dir_path(__FILE__) . 'templates/display.php';
    return ob_get_clean();
}
```

**Frontend JavaScript**:
- Use for dynamic, interactive content
- Better for loading random items
- Allows click-to-refresh functionality

### Block Attributes for Filtering

When adding filtering (like tags), structure attributes properly:

```javascript
attributes: {
    selectedTags: {
        type: 'array',
        default: [],
        items: {
            type: 'number'
        }
    }
}
```

And use `wp.data.useSelect` to fetch taxonomy terms:

```javascript
var tags = useSelect(function(select) {
    return select('core').getEntityRecords('taxonomy', 'your_taxonomy', { per_page: -1 });
}, []);
```

---

## REST API Best Practices

### Optional Parameters for Filtering

Always make filtering parameters optional to maintain backward compatibility:

```php
public function get_items_api($request) {
    $count = $request->get_param('count') ? intval($request->get_param('count')) : 3;
    $tags = $request->get_param('tags') ? $request->get_param('tags') : '';
    
    $args = array(
        'post_type' => 'your_post_type',
        'posts_per_page' => $count,
        'orderby' => 'rand',
        'post_status' => 'publish'
    );
    
    // Add filtering only if tags are specified
    if (!empty($tags)) {
        $tag_ids = array_map('intval', explode(',', $tags));
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'your_taxonomy',
                'field'    => 'term_id',
                'terms'    => $tag_ids,
                'operator' => 'IN'  // OR logic
            )
        );
    }
    
    $query = new WP_Query($args);
    // ... return results
}
```

### Frontend JavaScript Integration

Pass filter data via data attributes:

```php
// In template
$tags_string = !empty($selected_tags) ? implode(',', $selected_tags) : '';
?>
<div class="container" data-tags="<?php echo esc_attr($tags_string); ?>">
```

```javascript
// In frontend JS
const tags = container.getAttribute('data-tags') || '';
let url = '/wp-json/your-plugin/v1/items';
if (tags) {
    url += '?tags=' + tags;
}
```

---

## Custom Post Types

### Taxonomy Integration

When registering taxonomies for custom post types:

```php
public function register_taxonomy() {
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => false,
        'public'            => false,
        'show_ui'           => true,        // Shows in admin
        'show_admin_column' => true,        // Shows in post list
        'show_in_rest'      => true,        // Required for Gutenberg
        'query_var'         => true,
        'rewrite'           => array('slug' => 'your-taxonomy'),
    );
    
    register_taxonomy('your_taxonomy', array('your_post_type'), $args);
}
```

**Important**: Always set `show_in_rest => true` if you want to use the taxonomy in Gutenberg blocks.

### Meta Fields

Register meta fields for REST API access:

```php
register_post_meta('your_post_type', 'field_name', array(
    'type'         => 'string',
    'single'       => true,
    'show_in_rest' => true,  // Makes it available in REST API
));
```

---

## Hook Priorities & Timing

### Understanding WordPress Hook Execution Order

**Init Hook** (priority 10 by default):
- Post types registered
- Taxonomies registered
- Blocks registered

**Admin Menu Hook** (priority 10 by default):
- Admin menus built
- Submenus added

**Key Insight**: Taxonomies with `show_ui => true` modify the menu structure during their registration, which happens during `init`. This is BEFORE `admin_menu` runs, but the menu finalization happens in a complex way that makes removal unreliable.

### When to Use Different Priorities

```php
// Standard priority (10) - most cases
add_action('admin_menu', array($this, 'add_menu'));

// Higher priority (100) - run after other plugins
add_action('admin_menu', array($this, 'add_menu'), 100);

// Lower priority (5) - run before other plugins
add_action('admin_menu', array($this, 'add_menu'), 5);
```

**Lesson Learned**: Higher priorities don't always solve timing issues. Sometimes you need a different approach entirely (like CSS + redirect).

---

## Debugging Strategies

### Finding Menu Issues

1. **Check the HTML**: Inspect the admin menu HTML to see what's actually being rendered
2. **Check Global Variables**: Use `var_dump($GLOBALS['submenu'])` to see the menu structure
3. **Check Hook Execution**: Add `error_log()` statements to see when hooks fire
4. **Check Capabilities**: Verify users have the right capabilities to see menu items

### Common Issues & Solutions

**Issue**: Block doesn't appear in editor
- Check dependencies (use `wp-block-editor` not `wp-editor`)
- Check console for JavaScript errors
- Verify block registration in PHP

**Issue**: Styles not loading in editor
- Register styles with `wp_register_style()`
- Add `editor_style` and `style` to `register_block_type()`
- Check that CSS file path is correct

**Issue**: REST API returns empty
- Check post status (should be 'publish')
- Verify `show_in_rest => true` for post type and taxonomies
- Check user permissions

**Issue**: Frontend JavaScript not loading data
- Verify REST API endpoint works (test in browser)
- Check for CORS issues (use local server for prototypes)
- Check console for fetch errors
- Verify data attributes are set correctly

---

## Best Practices Summary

### DO:
✅ Use `wp-block-editor` for Gutenberg dependencies  
✅ Test with taxonomies if you plan to add them later  
✅ Make REST API parameters optional for backward compatibility  
✅ Use CSS + redirect for stubborn menu issues  
✅ Set `show_in_rest => true` for Gutenberg integration  
✅ Use data attributes to pass PHP data to JavaScript  
✅ Test in multiple browsers and devices  
✅ Document your workarounds and why they're needed  

### DON'T:
❌ Rely solely on `remove_submenu_page()` with taxonomies  
❌ Use deprecated WordPress functions/dependencies  
❌ Hardcode data in JavaScript (use REST API)  
❌ Forget to sanitize and escape user input  
❌ Ignore timing issues between hooks  
❌ Over-engineer solutions when simple ones work  
❌ Assume higher hook priorities solve all timing issues  

---

## Plugin Development Workflow

### 1. Prototype First
- Create HTML/CSS/JS prototypes before WordPress integration
- Test functionality in isolation
- Iterate on design without WordPress overhead

### 2. Plan Data Structure
- Design custom post types and taxonomies
- Plan meta fields and their types
- Consider REST API needs upfront

### 3. Build Incrementally
- Start with basic post type
- Add REST API
- Add Gutenberg block
- Add taxonomies LAST (they can break things)
- Test after each addition

### 4. Version Control
- Increment version numbers for each change
- Keep changelog updated
- Create zip files for deployment
- Delete old versions to avoid confusion

### 5. Document Workarounds
- Note any non-standard solutions
- Explain WHY you did something unusual
- Future you (or other developers) will thank you

---

## Resources

### Official Documentation
- [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/)
- [Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- [REST API Handbook](https://developer.wordpress.org/rest-api/)
- [WordPress Code Reference](https://developer.wordpress.org/reference/)

### Useful Functions
- `register_post_type()` - Create custom post types
- `register_taxonomy()` - Create taxonomies
- `register_block_type()` - Register Gutenberg blocks
- `register_rest_route()` - Create REST API endpoints
- `add_submenu_page()` - Add admin menu items
- `wp_enqueue_script()` / `wp_enqueue_style()` - Load assets

### Testing Tools
- Browser DevTools (inspect HTML, check console)
- WordPress Debug Mode (`WP_DEBUG` in wp-config.php)
- Query Monitor plugin (for debugging queries and hooks)
- REST API test tools (Postman, browser)

---

## Conclusion

WordPress plugin development often requires pragmatic solutions rather than "perfect" ones. The key lessons:

1. **Test with all features enabled** - Don't add taxonomies as an afterthought
2. **Simple solutions are often better** - CSS + redirect beats complex capability mapping
3. **Timing matters** - But higher priorities aren't always the answer
4. **Document your workarounds** - Future developers need to understand WHY
5. **Prototype first** - Test ideas before WordPress integration

Remember: If a solution works reliably, is maintainable, and doesn't break other functionality, it's a good solution—even if it's not the "textbook" approach.

---

**Last Updated**: October 26, 2025  
**Maintained by**: HRCEF Web Development Team
