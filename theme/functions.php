<?php
/**
 * Hannari Theme Functions
 *
 * @package Hannari
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define theme constants
 */
define( 'HANNARI_VERSION', '1.0.0' );
define( 'HANNARI_DIR', get_template_directory() );
define( 'HANNARI_URI', get_template_directory_uri() );

/**
 * Theme Setup
 */
function hannari_setup() {
	// Make theme available for translation
	load_theme_textdomain( 'hannari', HANNARI_DIR . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );

	// Register navigation menus
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'hannari' ),
			'footer'  => esc_html__( 'Footer Menu', 'hannari' ),
		)
	);

	// Switch default core markup to valid HTML5
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add support for custom logo
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 100,
			'width'       => 300,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Add support for post formats
	add_theme_support(
		'post-formats',
		array(
			'aside',
			'gallery',
			'link',
			'image',
			'quote',
			'status',
			'video',
			'audio',
		)
	);

	// Add support for responsive embeds
	add_theme_support( 'responsive-embeds' );

	// Add support for editor styles
	add_theme_support( 'editor-styles' );

	// Add support for wide alignment
	add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'hannari_setup' );

/**
 * Set the content width
 */
function hannari_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hannari_content_width', 800 );
}
add_action( 'after_setup_theme', 'hannari_content_width', 0 );

/**
 * Register widget areas
 */
function hannari_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'hannari' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in the sidebar.', 'hannari' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'hannari' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here to appear in the footer.', 'hannari' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'hannari_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function hannari_scripts() {
	// Main stylesheet
	wp_enqueue_style(
		'hannari-style',
		get_stylesheet_uri(),
		array(),
		HANNARI_VERSION
	);

	// Additional styles
	wp_enqueue_style(
		'hannari-main',
		HANNARI_URI . '/assets/css/main.css',
		array( 'hannari-style' ),
		HANNARI_VERSION
	);

	// Main script
	wp_enqueue_script(
		'hannari-main',
		HANNARI_URI . '/assets/js/main.js',
		array(),
		HANNARI_VERSION,
		true
	);

	// Comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hannari_scripts' );

/**
 * Add preconnect for Google Fonts (if used in future)
 */
function hannari_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'hannari_resource_hints', 10, 2 );

/**
 * Custom excerpt length
 */
function hannari_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'hannari_excerpt_length' );

/**
 * Custom excerpt more
 */
function hannari_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'hannari_excerpt_more' );

/**
 * Add custom body classes
 */
function hannari_body_classes( $classes ) {
	// Add class if sidebar is active
	if ( is_active_sidebar( 'sidebar-1' ) && ! is_page_template( 'template-full-width.php' ) ) {
		$classes[] = 'has-sidebar';
	}

	// Add class for singular pages
	if ( is_singular() ) {
		$classes[] = 'singular';
	}

	return $classes;
}
add_filter( 'body_class', 'hannari_body_classes' );

/**
 * Add custom post classes
 */
function hannari_post_classes( $classes ) {
	$classes[] = 'clearfix';
	return $classes;
}
add_filter( 'post_class', 'hannari_post_classes' );

/**
 * Security: Remove WordPress version from head
 */
remove_action( 'wp_head', 'wp_generator' );

/**
 * Security: Disable XML-RPC
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Pingback URL removal for security
 */
function hannari_remove_pingback_url( $output, $show ) {
	if ( 'pingback_url' === $show ) {
		return '';
	}
	return $output;
}
add_filter( 'bloginfo_url', 'hannari_remove_pingback_url', 10, 2 );

/**
 * Custom template tags
 */
if ( ! function_exists( 'hannari_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time
	 */
	function hannari_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		printf(
			'<span class="posted-on">%1$s <a href="%2$s" rel="bookmark">%3$s</a></span>',
			esc_html__( 'Posted on', 'hannari' ),
			esc_url( get_permalink() ),
			$time_string
		);
	}
}

if ( ! function_exists( 'hannari_posted_by' ) ) {
	/**
	 * Prints HTML with meta information for the current author
	 */
	function hannari_posted_by() {
		printf(
			'<span class="byline"> %1$s <span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span></span>',
			esc_html__( 'by', 'hannari' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		);
	}
}

if ( ! function_exists( 'hannari_entry_footer' ) ) {
	/**
	 * Prints HTML with meta information for the categories, tags and comments
	 */
	function hannari_entry_footer() {
		if ( 'post' === get_post_type() ) {
			$categories_list = get_the_category_list( esc_html__( ', ', 'hannari' ) );
			if ( $categories_list ) {
				printf(
					'<span class="cat-links">%1$s %2$s</span>',
					esc_html__( 'Posted in', 'hannari' ),
					$categories_list
				);
			}

			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'hannari' ) );
			if ( $tags_list ) {
				printf(
					'<span class="tags-links">%1$s %2$s</span>',
					esc_html__( 'Tagged', 'hannari' ),
					$tags_list
				);
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'hannari' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}
	}
}

if ( ! function_exists( 'hannari_post_thumbnail' ) ) {
	/**
	 * Displays the post thumbnail
	 */
	function hannari_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) {
			?>
			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'large' ); ?>
			</div>
			<?php
		} else {
			?>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php the_post_thumbnail( 'medium_large' ); ?>
			</a>
			<?php
		}
	}
}

/**
 * Check if sidebar should be displayed
 */
function hannari_has_sidebar() {
	return is_active_sidebar( 'sidebar-1' ) && ! is_page_template( 'template-full-width.php' );
}
