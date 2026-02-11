# Hannari Theme Development Guide

A comprehensive guide to customizing and extending the Hannari WordPress theme.

---

## Table of Contents

1. [Theme Architecture](#theme-architecture)
2. [Template Hierarchy](#template-hierarchy)
3. [Adding Custom Functions](#adding-custom-functions)
4. [Hooks and Filters](#hooks-and-filters)
5. [Creating Custom Templates](#creating-custom-templates)
6. [Adding Widget Areas](#adding-widget-areas)
7. [Customizer API](#customizer-api)
8. [Enqueueing Assets](#enqueueing-assets)
9. [Security Best Practices](#security-best-practices)
10. [Performance Optimization](#performance-optimization)

---

## Theme Architecture

### Directory Structure

```
theme/
├── style.css          # Theme metadata (required)
├── functions.php      # Theme functions (required)
├── index.php          # Fallback template (required)
├── header.php         # Header partial
├── footer.php         # Footer partial
├── sidebar.php        # Sidebar partial
├── single.php         # Single post
├── page.php           # Single page
├── archive.php        # Archives
├── search.php         # Search results
├── 404.php            # Not found
├── comments.php       # Comments
├── assets/
│   ├── css/
│   │   └── main.css
│   └── js/
│       └── main.js
├── inc/               # PHP includes (create as needed)
│   ├── customizer.php
│   ├── template-tags.php
│   └── custom-post-types.php
└── template-parts/    # Reusable template parts
    ├── content.php
    ├── content-single.php
    └── content-none.php
```

### Core Files

| File | Purpose |
|------|---------|
| `style.css` | Theme metadata in header comment block |
| `functions.php` | Theme setup, hooks, functions |
| `index.php` | Ultimate fallback for all templates |

---

## Template Hierarchy

WordPress uses a specific order to find templates. Understanding this helps you create targeted templates.

### Hierarchy Flow

```
Request → Specific Template → General Template → index.php
```

### Common Hierarchies

**Single Post:**
```
single-{post-type}-{slug}.php
single-{post-type}.php
single.php
singular.php
index.php
```

**Page:**
```
{custom-template}.php
page-{slug}.php
page-{id}.php
page.php
singular.php
index.php
```

**Category Archive:**
```
category-{slug}.php
category-{id}.php
category.php
archive.php
index.php
```

**Author Archive:**
```
author-{nicename}.php
author-{id}.php
author.php
archive.php
index.php
```

### Creating Specific Templates

```php
<?php
// theme/single-product.php - For custom post type "product"

get_header();
?>
<main id="primary" class="site-main product-single">
    <?php
    while ( have_posts() ) :
        the_post();
        // Custom product display
    endwhile;
    ?>
</main>
<?php
get_footer();
```

---

## Adding Custom Functions

### Method 1: Direct in functions.php

For small additions:

```php
<?php
// In functions.php

/**
 * Custom function example
 */
function hannari_custom_function() {
    // Your code here
}
```

### Method 2: Separate Include Files (Recommended)

For organization, split into files:

```php
<?php
// In functions.php

// Include custom functionality
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/custom-post-types.php';
```

```php
<?php
// In inc/custom-post-types.php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register custom post types
 */
function hannari_register_post_types() {
    register_post_type( 'portfolio', array(
        'labels' => array(
            'name'          => __( 'Portfolio', 'hannari' ),
            'singular_name' => __( 'Portfolio Item', 'hannari' ),
        ),
        'public'       => true,
        'has_archive'  => true,
        'supports'     => array( 'title', 'editor', 'thumbnail' ),
        'menu_icon'    => 'dashicons-portfolio',
        'rewrite'      => array( 'slug' => 'portfolio' ),
    ) );
}
add_action( 'init', 'hannari_register_post_types' );
```

### Method 3: Child Theme (For Modifications)

Create a child theme for safe customization:

```
hannari-child/
├── style.css
└── functions.php
```

```css
/* hannari-child/style.css */
/*
Theme Name: Hannari Child
Template: hannari
*/
```

```php
<?php
// hannari-child/functions.php

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'hannari-child', get_stylesheet_uri() );
}, 20 );
```

---

## Hooks and Filters

WordPress uses hooks to allow code injection at specific points.

### Action Hooks

Actions execute code at specific points:

```php
<?php
// Add code after theme setup
add_action( 'after_setup_theme', 'my_custom_setup' );

function my_custom_setup() {
    // Runs after theme is initialized
}
```

#### Common Action Hooks

| Hook | When It Fires |
|------|---------------|
| `after_setup_theme` | After theme is loaded |
| `init` | After WordPress loads |
| `wp_enqueue_scripts` | When enqueueing assets |
| `widgets_init` | When registering widgets |
| `wp_head` | In `<head>` section |
| `wp_footer` | Before `</body>` |
| `wp_body_open` | After `<body>` tag |
| `save_post` | When a post is saved |

#### Creating Custom Actions

```php
<?php
// In your template
do_action( 'hannari_before_content' );

// In functions.php (or child theme)
add_action( 'hannari_before_content', function() {
    echo '<div class="custom-banner">Welcome!</div>';
} );
```

### Filter Hooks

Filters modify data before it's used:

```php
<?php
// Modify excerpt length
add_filter( 'excerpt_length', function( $length ) {
    return 30; // 30 words
} );

// Modify excerpt "more" text
add_filter( 'excerpt_more', function( $more ) {
    return '... <a href="' . get_permalink() . '">Read more</a>';
} );
```

#### Common Filter Hooks

| Hook | What It Filters |
|------|-----------------|
| `the_content` | Post content |
| `the_title` | Post title |
| `excerpt_length` | Excerpt word count |
| `excerpt_more` | Excerpt suffix |
| `body_class` | Body CSS classes |
| `post_class` | Post CSS classes |
| `wp_nav_menu_items` | Menu HTML |
| `the_password_form` | Password form HTML |

#### Example: Add Social Share Buttons

```php
<?php
add_filter( 'the_content', 'hannari_add_social_share' );

function hannari_add_social_share( $content ) {
    if ( ! is_singular( 'post' ) ) {
        return $content;
    }

    $url   = urlencode( get_permalink() );
    $title = urlencode( get_the_title() );

    $share = '<div class="social-share">';
    $share .= '<span>' . esc_html__( 'Share:', 'hannari' ) . '</span>';
    $share .= '<a href="https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title . '" target="_blank" rel="noopener">Twitter</a>';
    $share .= '<a href="https://www.facebook.com/sharer/sharer.php?u=' . $url . '" target="_blank" rel="noopener">Facebook</a>';
    $share .= '</div>';

    return $content . $share;
}
```

### Hook Priority

Control execution order with priority (default: 10):

```php
<?php
// Runs first (low number)
add_action( 'wp_head', 'my_early_function', 1 );

// Runs last (high number)
add_action( 'wp_head', 'my_late_function', 99 );
```

### Removing Hooks

```php
<?php
// Remove a previously added action
remove_action( 'wp_head', 'wp_generator' );

// Remove a filter
remove_filter( 'the_content', 'wpautop' );
```

---

## Creating Custom Templates

### Page Templates

Create templates selectable in the editor:

```php
<?php
// theme/template-full-width.php

/**
 * Template Name: Full Width
 * Template Post Type: page, post
 */

get_header();
?>
<main id="primary" class="site-main full-width">
    <?php
    while ( have_posts() ) :
        the_post();
        the_content();
    endwhile;
    ?>
</main>
<?php
get_footer();
```

### Template Parts

Reusable template fragments:

```php
<?php
// theme/template-parts/content-card.php

<article <?php post_class( 'card' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="card-image">
            <?php the_post_thumbnail( 'medium' ); ?>
        </div>
    <?php endif; ?>

    <div class="card-body">
        <h3 class="card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <p class="card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
    </div>
</article>
```

Use in templates:

```php
<?php
// In archive.php or index.php
while ( have_posts() ) :
    the_post();
    get_template_part( 'template-parts/content', 'card' );
endwhile;
```

### Dynamic Template Parts

Pass format or post type:

```php
<?php
// Loads template-parts/content-{format}.php
get_template_part( 'template-parts/content', get_post_format() );

// Loads template-parts/content-{post-type}.php
get_template_part( 'template-parts/content', get_post_type() );
```

---

## Adding Widget Areas

### Register Widget Areas

```php
<?php
// In functions.php

function hannari_widgets_init() {
    // Sidebar
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'hannari' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Main sidebar widgets', 'hannari' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Footer columns
    for ( $i = 1; $i <= 3; $i++ ) {
        register_sidebar( array(
            'name'          => sprintf( __( 'Footer Column %d', 'hannari' ), $i ),
            'id'            => 'footer-' . $i,
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
    }
}
add_action( 'widgets_init', 'hannari_widgets_init' );
```

### Display Widget Areas

```php
<?php
// In sidebar.php or footer.php

if ( is_active_sidebar( 'sidebar-1' ) ) :
    ?>
    <aside class="widget-area">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </aside>
    <?php
endif;
```

### Create Custom Widgets

```php
<?php
// In inc/widgets.php

class Hannari_Recent_Posts_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'hannari_recent_posts',
            __( 'Hannari: Recent Posts', 'hannari' ),
            array( 'description' => __( 'Display recent posts with thumbnails', 'hannari' ) )
        );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        $count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 5;

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }

        $query = new WP_Query( array(
            'posts_per_page' => $count,
            'post_status'    => 'publish',
        ) );

        if ( $query->have_posts() ) :
            echo '<ul class="recent-posts-widget">';
            while ( $query->have_posts() ) :
                $query->the_post();
                ?>
                <li>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <a href="<?php the_permalink(); ?>" class="post-thumb">
                            <?php the_post_thumbnail( 'thumbnail' ); ?>
                        </a>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </li>
                <?php
            endwhile;
            echo '</ul>';
            wp_reset_postdata();
        endif;

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $count = ! empty( $instance['count'] ) ? absint( $instance['count'] ) : 5;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
                <?php esc_html_e( 'Title:', 'hannari' ); ?>
            </label>
            <input class="widefat" type="text"
                   id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
                   value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>">
                <?php esc_html_e( 'Number of posts:', 'hannari' ); ?>
            </label>
            <input class="tiny-text" type="number" min="1" max="10"
                   id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"
                   name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>"
                   value="<?php echo esc_attr( $count ); ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['count'] = absint( $new_instance['count'] );
        return $instance;
    }
}

// Register widget
add_action( 'widgets_init', function() {
    register_widget( 'Hannari_Recent_Posts_Widget' );
} );
```

---

## Customizer API

Add theme options to the WordPress Customizer.

### Basic Setup

```php
<?php
// In inc/customizer.php

function hannari_customize_register( $wp_customize ) {

    // Add Section
    $wp_customize->add_section( 'hannari_options', array(
        'title'    => __( 'Theme Options', 'hannari' ),
        'priority' => 30,
    ) );

    // Add Setting
    $wp_customize->add_setting( 'hannari_accent_color', array(
        'default'           => '#222222',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage', // Live preview
    ) );

    // Add Control
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize,
        'hannari_accent_color',
        array(
            'label'   => __( 'Accent Color', 'hannari' ),
            'section' => 'hannari_options',
        )
    ) );
}
add_action( 'customize_register', 'hannari_customize_register' );
```

### Common Control Types

```php
<?php
// Text Input
$wp_customize->add_control( 'setting_id', array(
    'label'   => __( 'Text', 'hannari' ),
    'section' => 'section_id',
    'type'    => 'text',
) );

// Textarea
$wp_customize->add_control( 'setting_id', array(
    'label'   => __( 'Textarea', 'hannari' ),
    'section' => 'section_id',
    'type'    => 'textarea',
) );

// Checkbox
$wp_customize->add_control( 'setting_id', array(
    'label'   => __( 'Enable Feature', 'hannari' ),
    'section' => 'section_id',
    'type'    => 'checkbox',
) );

// Select
$wp_customize->add_control( 'setting_id', array(
    'label'   => __( 'Layout', 'hannari' ),
    'section' => 'section_id',
    'type'    => 'select',
    'choices' => array(
        'left'  => __( 'Left Sidebar', 'hannari' ),
        'right' => __( 'Right Sidebar', 'hannari' ),
        'none'  => __( 'No Sidebar', 'hannari' ),
    ),
) );

// Image Upload
$wp_customize->add_control( new WP_Customize_Image_Control(
    $wp_customize,
    'setting_id',
    array(
        'label'   => __( 'Header Image', 'hannari' ),
        'section' => 'section_id',
    )
) );
```

### Using Customizer Values

```php
<?php
// In template
$accent_color = get_theme_mod( 'hannari_accent_color', '#222222' );
?>
<style>
    :root {
        --accent-color: <?php echo esc_attr( $accent_color ); ?>;
    }
</style>
```

### Live Preview with JavaScript

```php
<?php
// In functions.php
function hannari_customize_preview_js() {
    wp_enqueue_script(
        'hannari-customizer',
        get_template_directory_uri() . '/assets/js/customizer.js',
        array( 'customize-preview' ),
        HANNARI_VERSION,
        true
    );
}
add_action( 'customize_preview_init', 'hannari_customize_preview_js' );
```

```javascript
// assets/js/customizer.js
( function( $ ) {
    wp.customize( 'hannari_accent_color', function( value ) {
        value.bind( function( newval ) {
            document.documentElement.style.setProperty( '--accent-color', newval );
        } );
    } );
} )( jQuery );
```

---

## Enqueueing Assets

### Scripts and Styles

```php
<?php
function hannari_scripts() {
    $version = HANNARI_VERSION;
    $uri     = get_template_directory_uri();

    // Styles
    wp_enqueue_style( 'hannari-style', get_stylesheet_uri(), array(), $version );
    wp_enqueue_style( 'hannari-main', $uri . '/assets/css/main.css', array(), $version );

    // Scripts
    wp_enqueue_script( 'hannari-main', $uri . '/assets/js/main.js', array(), $version, true );

    // Conditional loading
    if ( is_singular() && comments_open() ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // Localize script (pass PHP data to JS)
    wp_localize_script( 'hannari-main', 'hannariData', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'hannari_nonce' ),
        'i18n'    => array(
            'loading' => __( 'Loading...', 'hannari' ),
            'error'   => __( 'An error occurred', 'hannari' ),
        ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'hannari_scripts' );
```

### Admin Scripts

```php
<?php
function hannari_admin_scripts( $hook ) {
    // Only on specific admin pages
    if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
        return;
    }

    wp_enqueue_style( 'hannari-admin', get_template_directory_uri() . '/assets/css/admin.css' );
    wp_enqueue_script( 'hannari-admin', get_template_directory_uri() . '/assets/js/admin.js' );
}
add_action( 'admin_enqueue_scripts', 'hannari_admin_scripts' );
```

### Inline Styles (Dynamic CSS)

```php
<?php
function hannari_dynamic_css() {
    $accent = get_theme_mod( 'hannari_accent_color', '#222222' );

    $css = "
        :root {
            --accent-color: {$accent};
        }
        a:hover { color: {$accent}; }
    ";

    wp_add_inline_style( 'hannari-style', $css );
}
add_action( 'wp_enqueue_scripts', 'hannari_dynamic_css', 20 );
```

---

## Security Best Practices

### Escaping Output

**Always escape data before outputting:**

```php
<?php
// HTML content
echo esc_html( $user_input );

// HTML attributes
echo '<input value="' . esc_attr( $value ) . '">';

// URLs
echo '<a href="' . esc_url( $url ) . '">';

// JavaScript
echo '<script>var data = ' . esc_js( $data ) . ';</script>';

// Textarea content
echo '<textarea>' . esc_textarea( $content ) . '</textarea>';

// Allow specific HTML (use carefully)
echo wp_kses_post( $content ); // Allows post HTML tags
echo wp_kses( $content, array(
    'a' => array( 'href' => array(), 'title' => array() ),
    'br' => array(),
    'strong' => array(),
) );
```

### Sanitizing Input

**Always sanitize data before saving:**

```php
<?php
// Text field
$clean = sanitize_text_field( $_POST['field'] );

// Textarea
$clean = sanitize_textarea_field( $_POST['field'] );

// Email
$clean = sanitize_email( $_POST['email'] );

// URL
$clean = esc_url_raw( $_POST['url'] );

// Integer
$clean = absint( $_POST['number'] );

// Filename
$clean = sanitize_file_name( $_FILES['file']['name'] );

// HTML content (careful!)
$clean = wp_kses_post( $_POST['content'] );
```

### Nonces (CSRF Protection)

```php
<?php
// Create nonce field in form
wp_nonce_field( 'hannari_save_action', 'hannari_nonce' );

// Verify nonce on submission
if ( ! isset( $_POST['hannari_nonce'] ) ||
     ! wp_verify_nonce( $_POST['hannari_nonce'], 'hannari_save_action' ) ) {
    die( 'Security check failed' );
}

// For AJAX requests
check_ajax_referer( 'hannari_ajax_nonce', 'nonce' );
```

### Capability Checks

```php
<?php
// Check user permissions
if ( ! current_user_can( 'edit_posts' ) ) {
    wp_die( __( 'You do not have permission to do this.', 'hannari' ) );
}

// Common capabilities
current_user_can( 'manage_options' );  // Admin
current_user_can( 'edit_posts' );      // Editor/Author
current_user_can( 'read' );            // Subscriber
```

### Database Queries

```php
<?php
global $wpdb;

// Use prepare() for all queries with variables
$results = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM {$wpdb->posts} WHERE post_author = %d AND post_status = %s",
        $user_id,
        'publish'
    )
);

// Insert with proper escaping
$wpdb->insert(
    $wpdb->prefix . 'custom_table',
    array(
        'column1' => $value1,
        'column2' => $value2,
    ),
    array( '%s', '%d' ) // Format specifiers
);
```

---

## Performance Optimization

### Minimize Database Queries

```php
<?php
// Bad: Query in loop
while ( have_posts() ) {
    the_post();
    $author = get_user_by( 'id', get_the_author_meta( 'ID' ) ); // Query each time
}

// Good: Single query with update_post_author_caches
update_post_author_caches( $posts );
```

### Use Transients for Caching

```php
<?php
function hannari_get_popular_posts() {
    $cache_key = 'hannari_popular_posts';
    $posts = get_transient( $cache_key );

    if ( false === $posts ) {
        $posts = new WP_Query( array(
            'posts_per_page' => 5,
            'meta_key'       => 'post_views',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC',
        ) );

        // Cache for 1 hour
        set_transient( $cache_key, $posts, HOUR_IN_SECONDS );
    }

    return $posts;
}

// Clear cache when posts are updated
add_action( 'save_post', function() {
    delete_transient( 'hannari_popular_posts' );
} );
```

### Lazy Loading

```php
<?php
// WordPress 5.5+ adds loading="lazy" automatically
// For manual control:
add_filter( 'wp_lazy_loading_enabled', '__return_true' );

// Or in img tags
echo '<img src="' . esc_url( $src ) . '" loading="lazy" alt="">';
```

### Defer Non-Critical Scripts

```php
<?php
function hannari_defer_scripts( $tag, $handle, $src ) {
    $defer_scripts = array( 'hannari-main', 'comment-reply' );

    if ( in_array( $handle, $defer_scripts, true ) ) {
        return str_replace( ' src', ' defer src', $tag );
    }

    return $tag;
}
add_filter( 'script_loader_tag', 'hannari_defer_scripts', 10, 3 );
```

### Preload Critical Assets

```php
<?php
function hannari_preload_assets() {
    ?>
    <link rel="preload" href="<?php echo esc_url( get_template_directory_uri() . '/assets/css/main.css' ); ?>" as="style">
    <link rel="preload" href="<?php echo esc_url( get_template_directory_uri() . '/assets/fonts/font.woff2' ); ?>" as="font" type="font/woff2" crossorigin>
    <?php
}
add_action( 'wp_head', 'hannari_preload_assets', 1 );
```

---

## Quick Reference

### Essential Functions

| Function | Purpose |
|----------|---------|
| `get_template_directory()` | Theme folder path |
| `get_template_directory_uri()` | Theme folder URL |
| `get_stylesheet_directory()` | Child theme path |
| `get_theme_mod( 'key', 'default' )` | Get customizer value |
| `wp_enqueue_style()` | Load CSS |
| `wp_enqueue_script()` | Load JS |
| `register_nav_menu()` | Register menu location |
| `register_sidebar()` | Register widget area |
| `add_theme_support()` | Enable theme feature |

### Template Tags

| Tag | Output |
|-----|--------|
| `the_title()` | Post title |
| `the_content()` | Post content |
| `the_excerpt()` | Post excerpt |
| `the_permalink()` | Post URL |
| `the_post_thumbnail()` | Featured image |
| `the_author()` | Author name |
| `the_date()` | Post date |
| `the_category()` | Categories |
| `the_tags()` | Tags |
| `comments_template()` | Load comments |
| `get_header()` | Load header.php |
| `get_footer()` | Load footer.php |
| `get_sidebar()` | Load sidebar.php |
| `get_template_part()` | Load template part |

### Conditional Tags

| Tag | True When |
|-----|-----------|
| `is_home()` | Blog posts page |
| `is_front_page()` | Front page |
| `is_single()` | Single post |
| `is_page()` | Single page |
| `is_singular()` | Single post/page |
| `is_archive()` | Any archive |
| `is_category()` | Category archive |
| `is_tag()` | Tag archive |
| `is_author()` | Author archive |
| `is_search()` | Search results |
| `is_404()` | 404 page |
| `is_admin()` | Admin area |

---

## Further Resources

- [WordPress Theme Handbook](https://developer.wordpress.org/themes/)
- [Template Hierarchy](https://developer.wordpress.org/themes/basics/template-hierarchy/)
- [Theme Functions](https://developer.wordpress.org/themes/basics/theme-functions/)
- [Customizer API](https://developer.wordpress.org/themes/customize-api/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
