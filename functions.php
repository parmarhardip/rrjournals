<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */

/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentyseventeen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyseventeen
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'twentyseventeen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyseventeen' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'twentyseventeen-featured-image', 2000, 1200, true );

	add_image_size( 'twentyseventeen-thumbnail-avatar', 100, 100, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'twentyseventeen' ),
		'social' => __( 'Social Links Menu', 'twentyseventeen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', twentyseventeen_fonts_url() ) );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets' => array(
			// Place three core-defined widgets in the sidebar area.
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area.
			'sidebar-2' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area.
			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x( 'Espresso', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
			),
			'image-sandwich' => array(
				'post_title' => _x( 'Sandwich', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/sandwich.jpg',
			),
			'image-coffee' => array(
				'post_title' => _x( 'Coffee', 'Theme starter content', 'twentyseventeen' ),
				'file' => 'assets/images/coffee.jpg',
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods' => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'top' => array(
				'name' => __( 'Top Menu', 'twentyseventeen' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

			// Assign a menu to the "social" location.
			'social' => array(
				'name' => __( 'Social Links Menu', 'twentyseventeen' ),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
		),
	);

	/**
	 * Filters Twenty Seventeen array of starter content.
	 *
	 * @since Twenty Seventeen 1.1
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'twentyseventeen_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'twentyseventeen_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function twentyseventeen_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( twentyseventeen_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter Twenty Seventeen content width of the theme.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'twentyseventeen_content_width', $content_width );
}
add_action( 'template_redirect', 'twentyseventeen_content_width', 0 );

/**
 * Register custom fonts.
 */
function twentyseventeen_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'twentyseventeen' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function twentyseventeen_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'twentyseventeen-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'twentyseventeen_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentyseventeen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'twentyseventeen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'twentyseventeen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'twentyseventeen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyseventeen_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function twentyseventeen_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'twentyseventeen_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function twentyseventeen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyseventeen_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function twentyseventeen_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'twentyseventeen_pingback_header' );

/**
 * Display custom color CSS.
 */
function twentyseventeen_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}

	require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
?>
	<style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"'; } ?>>
		<?php echo twentyseventeen_custom_colors_css(); ?>
	</style>
<?php }
add_action( 'wp_head', 'twentyseventeen_colors_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function twentyseventeen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyseventeen-fonts', twentyseventeen_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'twentyseventeen-style', get_stylesheet_uri() );

	// Load the dark colorscheme.
	if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'twentyseventeen-style' ), '1.0' );
	}

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'twentyseventeen-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'twentyseventeen-style' ), '1.0' );
		wp_style_add_data( 'twentyseventeen-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'twentyseventeen-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'twentyseventeen-style' ), '1.0' );
	wp_style_add_data( 'twentyseventeen-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'twentyseventeen-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	$twentyseventeen_l10n = array(
		'quote'          => twentyseventeen_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	if ( has_nav_menu( 'top' ) ) {
		wp_enqueue_script( 'twentyseventeen-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '1.0', true );
		$twentyseventeen_l10n['expand']         = __( 'Expand child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['collapse']       = __( 'Collapse child menu', 'twentyseventeen' );
		$twentyseventeen_l10n['icon']           = twentyseventeen_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
	}

	wp_enqueue_script( 'twentyseventeen-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

	wp_localize_script( 'twentyseventeen-skip-link-focus-fix', 'twentyseventeenScreenReaderText', $twentyseventeen_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	$params = array ( 'ajaxurl' => admin_url( 'admin-ajax.php' ) );
	wp_enqueue_script( 'rrjournal_ajax_handle', get_theme_file_uri( '/assets/js/rr-form-ajax-handler.js'), array( 'jquery' ), '1.0', false );				
	wp_localize_script( 'rrjournal_ajax_handle', 'params', $params );	
}
add_action( 'wp_enqueue_scripts', 'twentyseventeen_scripts' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentyseventeen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentyseventeen_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function twentyseventeen_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'twentyseventeen_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function twentyseventeen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentyseventeen_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function twentyseventeen_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'twentyseventeen_front_page_template' );

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Twenty Seventeen 1.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function twentyseventeen_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'twentyseventeen_widget_tag_cloud_args' );

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );


/**
* Create Logo Setting and Upload Control
*/
function hp_new_customizer_settings($wp_customize) {
	// add a setting for the site logo
	$wp_customize->add_setting( 'rrjournals_text_ugc_id', array(
	  'capability' => 'edit_theme_options',  
	  'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'rrjournals_text_ugc_id', array(
	  'type' => 'text',
	  'section' => 'title_tagline', // // Add a default or your own section
	  'label' => __( 'UGC' ),  
	) );
	// add a setting for the site logo
	$wp_customize->add_setting( 'rrjournals_text_impact_id', array(
	  'capability' => 'edit_theme_options',  
	  'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'rrjournals_text_impact_id', array(
	  'type' => 'text',
	  'section' => 'title_tagline', // // Add a default or your own section
	  'label' => __( 'Impact' ),  
	) );
}
add_action('customize_register', 'hp_new_customizer_settings');

// Register Custom Post Type
function hp_custom_post_type() {

	$labels = array(
		'name'                  => _x( 'Editorial Members', 'Post Type General Name', 'rrjournals' ),
		'singular_name'         => _x( 'Editorial Member', 'Post Type Singular Name', 'rrjournals' ),
		'menu_name'             => __( 'Editorial Member', 'rrjournals' ),
		'name_admin_bar'        => __( 'Editorial Member', 'rrjournals' ),
		'archives'              => __( 'Editorial Member Archives', 'rrjournals' ),
		'attributes'            => __( 'Editorial Member Attributes', 'rrjournals' ),
		'parent_item_colon'     => __( 'Parent Editorial Member:', 'rrjournals' ),
		'all_items'             => __( 'All Editorial Members', 'rrjournals' ),
		'add_new_item'          => __( 'Add New Editorial Member', 'rrjournals' ),
		'add_new'               => __( 'Add New', 'rrjournals' ),
		'new_item'              => __( 'New Editorial Member', 'rrjournals' ),
		'edit_item'             => __( 'Edit Editorial Member', 'rrjournals' ),
		'update_item'           => __( 'Update Editorial Member', 'rrjournals' ),
		'view_item'             => __( 'View Editorial Member', 'rrjournals' ),
		'view_items'            => __( 'View Editorial Members', 'rrjournals' ),
		'search_items'          => __( 'Search Editorial Member', 'rrjournals' ),
		'not_found'             => __( 'Not found', 'rrjournals' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'rrjournals' ),
		'featured_image'        => __( 'Featured Image', 'rrjournals' ),
		'set_featured_image'    => __( 'Set featured image', 'rrjournals' ),
		'remove_featured_image' => __( 'Remove featured image', 'rrjournals' ),
		'use_featured_image'    => __( 'Use as featured image', 'rrjournals' ),
		'insert_into_item'      => __( 'Insert into Editorial Member', 'rrjournals' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Editorial Member', 'rrjournals' ),
		'items_list'            => __( 'Editorial Member list', 'rrjournals' ),
		'items_list_navigation' => __( 'Editorial Member list navigation', 'rrjournals' ),
		'filter_items_list'     => __( 'Filter editorial Member list', 'rrjournals' ),
	);
	$args = array(
		'label'                 => __( 'Editorial Member', 'rrjournals' ),
		'description'           => __( 'Editorial Member Description', 'rrjournals' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'revisions','custom-fields' ),		
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
	);
	register_post_type( 'hr_em', $args );
	
	// Enable the custom fields option in custom post types and others.
	add_filter('acf/settings/remove_wp_meta_box', '__return_false');
	
	$labels = array(
		'name'                  => _x( 'Issue', 'Post Type General Name', 'rrjournals' ),
		'singular_name'         => _x( 'Issue', 'Post Type Singular Name', 'rrjournals' ),
		'menu_name'             => __( 'Issue', 'rrjournals' ),
		'name_admin_bar'        => __( 'Issue', 'rrjournals' ),
		'archives'              => __( 'Issue Archives', 'rrjournals' ),
		'attributes'            => __( 'Issue Attributes', 'rrjournals' ),
		'parent_item_colon'     => __( 'Parent Issue:', 'rrjournals' ),
		'all_items'             => __( 'All Issue', 'rrjournals' ),
		'add_new_item'          => __( 'Add New Issue', 'rrjournals' ),
		'add_new'               => __( 'Add New', 'rrjournals' ),
		'new_item'              => __( 'New Issue', 'rrjournals' ),
		'edit_item'             => __( 'Edit Issue', 'rrjournals' ),
		'update_item'           => __( 'Update Issue', 'rrjournals' ),
		'view_item'             => __( 'View Issue', 'rrjournals' ),
		'view_items'            => __( 'View Issue', 'rrjournals' ),
		'search_items'          => __( 'Search Issue', 'rrjournals' ),
		'not_found'             => __( 'Not found', 'rrjournals' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'rrjournals' ),
		'featured_image'        => __( 'Featured Image', 'rrjournals' ),
		'set_featured_image'    => __( 'Set featured image', 'rrjournals' ),
		'remove_featured_image' => __( 'Remove featured image', 'rrjournals' ),
		'use_featured_image'    => __( 'Use as featured image', 'rrjournals' ),
		'insert_into_item'      => __( 'Insert into Issue', 'rrjournals' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Editorial Member', 'rrjournals' ),
		'items_list'            => __( 'Issue list', 'rrjournals' ),
		'items_list_navigation' => __( 'Issue list navigation', 'rrjournals' ),
		'filter_items_list'     => __( 'Filter Issue list', 'rrjournals' ),
	);
	$args = array(
		'label'                 => __( 'Past Issue', 'rrjournals' ),
		'description'           => __( '', 'rrjournals' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'revisions','custom-fields' ),		
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,		
		'rewrite'            => array( 'slug' => 'past-issue' ),
		'menu_position'         => 10,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'rr_issue', $args );
	
	
	$labels = array(
		'name'                  => _x( 'Submitted Papers', 'Post Type General Name', 'rrjournals' ),
		'singular_name'         => _x( 'Submitted Papers', 'Post Type Singular Name', 'rrjournals' ),
		'menu_name'             => __( 'Submitted Papers', 'rrjournals' ),
		'name_admin_bar'        => __( 'Submitted Papers', 'rrjournals' ),
		'archives'              => __( 'Submitted Papers Archives', 'rrjournals' ),
		'attributes'            => __( 'Submitted Papers Attributes', 'rrjournals' ),
		'parent_item_colon'     => __( 'Parent Submitted Papers:', 'rrjournals' ),
		'all_items'             => __( 'All Submitted Papers', 'rrjournals' ),
		'add_new_item'          => __( 'Add New Submitted Papers', 'rrjournals' ),
		'add_new'               => __( 'Add New', 'rrjournals' ),
		'new_item'              => __( 'New Submitted Papers', 'rrjournals' ),
		'edit_item'             => __( 'Edit Submitted Papers', 'rrjournals' ),
		'update_item'           => __( 'Update Submitted Papers', 'rrjournals' ),
		'view_item'             => __( 'View Submitted Papers', 'rrjournals' ),
		'view_items'            => __( 'View Submitted Papers', 'rrjournals' ),
		'search_items'          => __( 'Search Submitted Papers', 'rrjournals' ),
		'not_found'             => __( 'Not found', 'rrjournals' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'rrjournals' ),
		'featured_image'        => __( 'Featured Image', 'rrjournals' ),
		'set_featured_image'    => __( 'Set featured image', 'rrjournals' ),
		'remove_featured_image' => __( 'Remove featured image', 'rrjournals' ),
		'use_featured_image'    => __( 'Use as featured image', 'rrjournals' ),
		'insert_into_item'      => __( 'Insert into Submitted Papers', 'rrjournals' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Submitted Papers', 'rrjournals' ),
		'items_list'            => __( 'Submitted Papers list', 'rrjournals' ),
		'items_list_navigation' => __( 'Submitted Papers list navigation', 'rrjournals' ),
		'filter_items_list'     => __( 'Filter Submitted Papers list', 'rrjournals' ),
	);
	$args = array(
		'label'                 => __( 'Submitted Papers', 'rrjournals' ),		
		'labels'                => $labels,
		'supports'              => array( 'title','editor', 'revisions','custom-fields' ),		
		'hierarchical'          => false,
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
	);
	register_post_type( 'rr_submited_paper', $args );
	
	$labels = array(
		'name'                  => _x( 'Certificate', 'Post Type General Name', 'rrjournals' ),
		'singular_name'         => _x( 'Certificate', 'Post Type Singular Name', 'rrjournals' ),
		'menu_name'             => __( 'Certificate', 'rrjournals' ),
		'name_admin_bar'        => __( 'Certificate', 'rrjournals' ),
		'archives'              => __( 'Certificate Archives', 'rrjournals' ),
		'attributes'            => __( 'Certificate Attributes', 'rrjournals' ),
		'parent_item_colon'     => __( 'Parent Certificate:', 'rrjournals' ),
		'all_items'             => __( 'All Certificate', 'rrjournals' ),
		'add_new_item'          => __( 'Add New Certificate', 'rrjournals' ),
		'add_new'               => __( 'Add New', 'rrjournals' ),
		'new_item'              => __( 'New Certificate', 'rrjournals' ),
		'edit_item'             => __( 'Edit Certificate', 'rrjournals' ),
		'update_item'           => __( 'Update Certificate', 'rrjournals' ),
		'view_item'             => __( 'View Certificate', 'rrjournals' ),
		'view_items'            => __( 'View Certificate', 'rrjournals' ),
		'search_items'          => __( 'Search Certificate', 'rrjournals' ),
		'not_found'             => __( 'Not found', 'rrjournals' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'rrjournals' ),
		'featured_image'        => __( 'Featured Image', 'rrjournals' ),
		'set_featured_image'    => __( 'Set featured image', 'rrjournals' ),
		'remove_featured_image' => __( 'Remove featured image', 'rrjournals' ),
		'use_featured_image'    => __( 'Use as featured image', 'rrjournals' ),
		'insert_into_item'      => __( 'Insert into Certificate', 'rrjournals' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Editorial Member', 'rrjournals' ),
		'items_list'            => __( 'Certificate list', 'rrjournals' ),
		'items_list_navigation' => __( 'Certificate list navigation', 'rrjournals' ),
		'filter_items_list'     => __( 'Filter Certificate list', 'rrjournals' ),
	);
	$args = array(
		'label'                 => __( 'Certificate Verification', 'rrjournals' ),
		'description'           => __( '', 'rrjournals' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'revisions','custom-fields','thumbnail' ),		
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,		
		'rewrite'            	=> array( 'slug' => 'view-certificate-page' ),
		'menu_position'         => 10,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'rr_cv', $args );
	
	$labels = array(
		'name'                  => _x( 'Special Issue', 'Post Type General Name', 'rrjournals' ),
		'singular_name'         => _x( 'Special Issue', 'Post Type Singular Name', 'rrjournals' ),
		'menu_name'             => __( 'Special Issue', 'rrjournals' ),
		'name_admin_bar'        => __( 'Special Issue', 'rrjournals' ),
		'archives'              => __( 'Special Issue Archives', 'rrjournals' ),
		'attributes'            => __( 'Special Issue Attributes', 'rrjournals' ),
		'parent_item_colon'     => __( 'Parent Special Issue:', 'rrjournals' ),
		'all_items'             => __( 'All Special Issue', 'rrjournals' ),
		'add_new_item'          => __( 'Add New Special Issue', 'rrjournals' ),
		'add_new'               => __( 'Add New', 'rrjournals' ),
		'new_item'              => __( 'New Special Issue', 'rrjournals' ),
		'edit_item'             => __( 'Edit Special Issue', 'rrjournals' ),
		'update_item'           => __( 'Update Special Issue', 'rrjournals' ),
		'view_item'             => __( 'View Special Issue', 'rrjournals' ),
		'view_items'            => __( 'View Special Issue', 'rrjournals' ),
		'search_items'          => __( 'Search Special Issue', 'rrjournals' ),
		'not_found'             => __( 'Not found', 'rrjournals' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'rrjournals' ),
		'featured_image'        => __( 'Featured Image', 'rrjournals' ),
		'set_featured_image'    => __( 'Set featured image', 'rrjournals' ),
		'remove_featured_image' => __( 'Remove featured image', 'rrjournals' ),
		'use_featured_image'    => __( 'Use as featured image', 'rrjournals' ),
		'insert_into_item'      => __( 'Insert into Special Issue', 'rrjournals' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Editorial Member', 'rrjournals' ),
		'items_list'            => __( 'Special Issue list', 'rrjournals' ),
		'items_list_navigation' => __( 'Special Issue list navigation', 'rrjournals' ),
		'filter_items_list'     => __( 'Filter Special Issue list', 'rrjournals' ),
	);
	$args = array(
		'label'                 => __( 'Special Issue', 'rrjournals' ),
		'description'           => __( '', 'rrjournals' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'revisions','custom-fields' ),		
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,		
		'rewrite'            => array( 'slug' => 'spcial-issue' ),
		'menu_position'         => 10,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'rr_special_issue', $args );
	
	$labels = array(
		'name'                  => _x( 'Paper List', 'Post Type General Name', 'rrjournals' ),
		'singular_name'         => _x( 'Paper List', 'Post Type Singular Name', 'rrjournals' ),
		'menu_name'             => __( 'Paper List', 'rrjournals' ),
		'name_admin_bar'        => __( 'Paper List', 'rrjournals' ),
		'archives'              => __( 'Paper List Archives', 'rrjournals' ),
		'attributes'            => __( 'Paper List Attributes', 'rrjournals' ),
		'parent_item_colon'     => __( 'Parent Paper List:', 'rrjournals' ),
		'all_items'             => __( 'All Paper List', 'rrjournals' ),
		'add_new_item'          => __( 'Add New Paper List', 'rrjournals' ),
		'add_new'               => __( 'Add New', 'rrjournals' ),
		'new_item'              => __( 'New Paper List', 'rrjournals' ),
		'edit_item'             => __( 'Edit Paper List', 'rrjournals' ),
		'update_item'           => __( 'Update Paper List', 'rrjournals' ),
		'view_item'             => __( 'View Paper List', 'rrjournals' ),
		'view_items'            => __( 'View Paper List', 'rrjournals' ),
		'search_items'          => __( 'Search Paper List', 'rrjournals' ),
		'not_found'             => __( 'Not found', 'rrjournals' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'rrjournals' ),
		'featured_image'        => __( 'Featured Image', 'rrjournals' ),
		'set_featured_image'    => __( 'Set featured image', 'rrjournals' ),
		'remove_featured_image' => __( 'Remove featured image', 'rrjournals' ),
		'use_featured_image'    => __( 'Use as featured image', 'rrjournals' ),
		'insert_into_item'      => __( 'Insert into Paper List', 'rrjournals' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Editorial Member', 'rrjournals' ),
		'items_list'            => __( 'Special Paper List', 'rrjournals' ),
		'items_list_navigation' => __( 'Special Paper List navigation', 'rrjournals' ),
		'filter_items_list'     => __( 'Filter Paper List list', 'rrjournals' ),
	);
	$args = array(
		'label'                 => __( 'Paper List', 'rrjournals' ),
		'description'           => __( '', 'rrjournals' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'revisions','custom-fields' ),		
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,		
		'rewrite'            => array( 'slug' => 'paper-list' ),
		'menu_position'         => 10,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'rr_sp_paper_list', $args );
	
	
	$labels = array(
		'name'                  => _x( 'Conference Proceeding', 'Post Type General Name', 'rrjournals' ),
		'singular_name'         => _x( 'Conference Proceedings', 'Post Type Singular Name', 'rrjournals' ),
		'menu_name'             => __( 'Conference Proceeding', 'rrjournals' ),
		'name_admin_bar'        => __( 'Conference Proceeding', 'rrjournals' ),
		'archives'              => __( 'Conference Proceeding Archives', 'rrjournals' ),
		'attributes'            => __( 'Conference Proceeding Attributes', 'rrjournals' ),
		'parent_item_colon'     => __( 'Parent Conference Proceeding:', 'rrjournals' ),
		'all_items'             => __( 'All Conference Proceeding', 'rrjournals' ),
		'add_new_item'          => __( 'Add New Conference Proceeding', 'rrjournals' ),
		'add_new'               => __( 'Add New', 'rrjournals' ),
		'new_item'              => __( 'New Conference Proceeding', 'rrjournals' ),
		'edit_item'             => __( 'Edit Conference Proceeding', 'rrjournals' ),
		'update_item'           => __( 'Update Conference Proceeding', 'rrjournals' ),
		'view_item'             => __( 'View Conference Proceeding', 'rrjournals' ),
		'view_items'            => __( 'View Conference Proceeding', 'rrjournals' ),
		'search_items'          => __( 'Search Conference Proceeding', 'rrjournals' ),
		'not_found'             => __( 'Not found', 'rrjournals' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'rrjournals' ),
		'featured_image'        => __( 'Featured Image', 'rrjournals' ),
		'set_featured_image'    => __( 'Set featured image', 'rrjournals' ),
		'remove_featured_image' => __( 'Remove featured image', 'rrjournals' ),
		'use_featured_image'    => __( 'Use as featured image', 'rrjournals' ),
		'insert_into_item'      => __( 'Insert into Special Issue', 'rrjournals' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Editorial Member', 'rrjournals' ),
		'items_list'            => __( 'Conference Proceeding list', 'rrjournals' ),
		'items_list_navigation' => __( 'Conference Proceeding list navigation', 'rrjournals' ),
		'filter_items_list'     => __( 'Filter Conference Proceeding list', 'rrjournals' ),
	);
	$args = array(
		'label'                 => __( 'Conference Proceedings', 'rrjournals' ),
		'description'           => __( '', 'rrjournals' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'revisions','custom-fields' ),		
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'rewrite'            => array( 'slug' => 'conference-proceeding' ),
		'menu_position'         => 10,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'capability_type'       => 'post',
	);
	register_post_type( 'rr_cp_post', $args );
	
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'CP Category', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'CP Category', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Search CP Categorys', 'textdomain' ),
		'all_items'         => __( 'All CP Categorys', 'textdomain' ),
		'parent_item'       => __( 'Parent CP Category', 'textdomain' ),
		'parent_item_colon' => __( 'Parent CP Category:', 'textdomain' ),
		'edit_item'         => __( 'Edit CP Category', 'textdomain' ),
		'update_item'       => __( 'Update CP Category', 'textdomain' ),
		'add_new_item'      => __( 'Add New CP Category', 'textdomain' ),
		'new_item_name'     => __( 'New CP Category Name', 'textdomain' ),
		'menu_name'         => __( 'CP Category', 'textdomain' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => 'cp-category',
		'rewrite'           => array( 'slug' => 'cp-category' ),
	);

	register_taxonomy( 'rr_cp_cat', array( 'rr_cp_post' ), $args );

}
add_action( 'init', 'hp_custom_post_type', 0 );

function hp_editor_board_member_callback( $atts ) {
	?>
	<style>
	.container-form form#ebm_form_id {
		width: 100%;
	}
	.container-form input[type=text],.container-form input[type=email], .container-form select	{
		box-sizing: border-box;
		resize: vertical;
	}

	.container-form input[type=submit],.container-form input[type=reset] {
		background-color: #003366;
		color: white;		
		border: none;		
		cursor: pointer;
		margin: 12px 6px;
	}

	.container-form input[type=subject]:hover ,.container-form input[type=reset]:hover {
		background-color: #003366;
		
	}

	.container-form {
		border-radius: 5px;
		padding: 20px;		
	}
	.container-form input[type=file] {
		resize: vertical;
		width: 100%;
	}
	.container-form select#ebm_subjectArea {
		width: 100%;
	}

	.container-form input#ebm_first_name {
		width: 76%;
	}
	#ebm_name_pre {
		width: 22.5%;
	}
	.container-form input[type=text], .container-form input[type=email] {
		width: 100%;
	}
	.ebm_response {
		text-align: center;
		margin-top:  20px;
		margin-right:  97px;
	}
	
	#ebm_residential_address{
		width:98%;
	}

	.success {
		color:  green;
	}

	input#captcha1 {
		width:  30%;
	}
	</style>
	<div class="container-form">
	<form action="javascript:void(0);" name="ebm_form_id" id="ebm_form_id" enctype="multipart/form-data">
		<table>
			<tr>
				<td>
					<label for="ebm_first_name">First Name <span class="error">*<span></label>
				</td>
				<td>
					<select id="ebm_name_pre" name="ebm_name_pre" required>
						<option value="Mr">Mr.</option>				
						<option value="Mrs">Mrs.</option>
						<option value="Ms">Ms.</option>
						<option value="Prof">Prof.</option>
						<option value="Dr">Dr.</option>
					</select>
					<input type="text" name="ebm_first_name" id="ebm_first_name" maxlength="50" size="30">
				</td>
			</tr>			
			<tr>
				<td>
					<label for="ebm_last_name">Last Name <span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="ebm_last_name" id="ebm_last_name" maxlength="50 " size="30 ">
				</td>
			</tr>
			<tr>
				<td>
					<label for="ebm_contact_no">Contact no.<span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="ebm_contact_no" id="ebm_contact_no" maxlength="50 " size="30 ">
				</td>
			</tr>
			<tr>
				<td>
					<label for="ebm_email">Email <span class="error">*<span></label>
				</td>
				<td>
					<input type="email" name="ebm_email" id="ebm_email" maxlength="80" size="30">
				</td>
			</tr>
			<tr>
				<td>
					<label for="ebm_designation">Designation<span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="ebm_designation" id="ebm_designation" maxlength="50 " size="30 ">
				</td>
			</tr>
			<tr>
				<td>
					<label for="ebm_institute_name_address">Institute name and Address <span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="ebm_institute_name_address" id="ebm_institute_name_address">
				</td>
			</tr>
			<tr>
				<td>
					<label for="ebm_residential_address">Residential Address <span class="error">*<span></label>
				</td>
				<td>
					<textarea cols="25" rows="3" name="ebm_residential_address" id="ebm_residential_address"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label for="ebm_degree_qualification">Degree / Qualifications<span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="ebm_degree_qualification" id="ebm_degree_qualification">
				</td>
			</tr>
			<tr>
				<td>
					<label for="ebm_subjectArea">Subject <span class="error">*<span></label>
				</td>
				<td>
					<select class="" id="ebm_subjectArea" name="ebm_subjectArea">
						<option value="">Select subject</option>
						<option value="Accounting"> Accounting </option>
						<option value="Advances in Engineering Software"> Advances in Engineering Software </option>
						<option value="Aeronautics"> Aeronautics </option>
						<option value="Aerospace Engineering"> Aerospace Engineering </option>
						<option value="Agricultural"> Agricultural </option>
						<option value="Agricultural Economics"> Agricultural Economics </option>
						<option value="Agricultural engineering"> Agricultural engineering </option>
						<option value="Agriculture"> Agriculture </option>
						<option value="Agronomy Science"> Agronomy Science </option>
						<option value="Anatomy"> Anatomy </option>
						<option value="Anatomy Science"> Anatomy Science </option>
						<option value="Anthropology Science"> Anthropology Science </option>
						<option value="Applied Entomology and Zoology"> Applied Entomology and Zoology </option>
						<option value="Aquaculture Microbiology"> Aquaculture Microbiology </option>
						<option value="Arachnology"> Arachnology </option>
						<option value="Archaeology"> Archaeology </option>
						<option value="Architecture"> Architecture </option>
						<option value="Arts and Humanities"> Arts and Humanities </option>
						<option value="Astronomy Science"> Astronomy Science </option>
						<option value="Automobile Engineering"> Automobile Engineering </option>
						<option value="Automobiles"> Automobiles </option>
						<option value="Bio Mechanics Engineering"> Bio Mechanics Engineering </option>
						<option value="Biochemistry"> Biochemistry </option>
						<option value="Biochemistry Science"> Biochemistry Science </option>
						<option value="Biodiversity and Conservation"> Biodiversity and Conservation </option>
						<option value="Biological Engineering"> Biological Engineering </option>
						<option value="Biological Sciences"> Biological Sciences </option>
						<option value="Biology Science"> Biology Science </option>
						<option value="Biomedical Sciences"> Biomedical Sciences </option>
						<option value="Biotechnology"> Biotechnology </option>
						<option value="Botany Science"> Botany Science </option>
						<option value="Business Management"> Business Management </option>
						<option value="Cardiology Science"> Cardiology Science </option>
						<option value="Cellular Microbiology"> Cellular Microbiology </option>
						<option value="Chemical Engineering"> Chemical Engineering </option>
						<option value="Chemical Pathology"> Chemical Pathology </option>
						<option value="Chemical Sciences"> Chemical Sciences </option>
						<option value="Chemistry"> Chemistry </option>
						<option value="Chemistry Science"> Chemistry Science </option>
						<option value="Civil Engineering"> Civil Engineering </option>
						<option value="Clinical Chemistry"> Clinical Chemistry </option>
						<option value="Cognition"> Cognition </option>
						<option value="Cognitive Systems Research"> Cognitive Systems Research </option>
						<option value="Communication or Media Studies"> Communication or Media Studies </option>
						<option value="Computer Engineering"> Computer Engineering </option>
						<option value="Computer Methods in Applied Mechanics and Engineering"> Computer Methods in Applied Mechanics and Engineering </option>
						<option value="Computer Science"> Computer Science </option>
						<option value="Computers &amp; Electrical Engineering"> Computers &amp; Electrical Engineering </option>
						<option value="Computers and Electronics in Agriculture"> Computers and Electronics in Agriculture </option>
						<option value="Computers in Biology and Medicine"> Computers in Biology and Medicine </option>
						<option value="Computers in Industry"> Computers in Industry </option>
						<option value="Control Engineering Practice"> Control Engineering Practice </option>
						<option value="Control Systems Engineering"> Control Systems Engineering </option>
						<option value="Data &amp; Knowledge Engineering"> Data &amp; Knowledge Engineering </option>
						<option value="Decision Science"> Decision Science </option>
						<option value="Decision Support Systems"> Decision Support Systems </option>
						<option value="Dental Science"> Dental Science </option>
						<option value="Diabetology"> Diabetology </option>
						<option value="Digital Investigation"> Digital Investigation </option>
						<option value="Digital Signal Processing"> Digital Signal Processing </option>
						<option value="Earth and Planetary Science"> Earth and Planetary Science </option>
						<option value="Earth Science and Engineering"> Earth Science and Engineering </option>
						<option value="Ecology"> Ecology </option>
						<option value="Ecology Science"> Ecology Science </option>
						<option value="Economics"> Economics </option>
						<option value="Education"> Education </option>
						<option value="Electrical Engineering"> Electrical Engineering </option>
						<option value="Electronics and Communication Engineering"> Electronics and Communication Engineering </option>
						<option value="Energy"> Energy </option>
						<option value="Engineering"> Engineering </option>
						<option value="Engineering Analysis with Boundary Elements"> Engineering Analysis with Boundary Elements </option>
						<option value="Engineering Applications of Artificial Intelligence"> Engineering Applications of Artificial Intelligence </option>
						<option value="Engineering Science"> Engineering Science </option>
						<option value="English Literature"> English Literature </option>
						<option value="Entomology"> Entomology </option>
						<option value="Entomology Science"> Entomology Science </option>
						<option value="Environment Science"> Environment Science </option>
						<option value="Environmental Engineering"> Environmental Engineering </option>
						<option value="Environmental Microbiology"> Environmental Microbiology </option>
						<option value="Environmental Science"> Environmental Science </option>
						<option value="Finance"> Finance </option>
						<option value="Financial Engineering"> Financial Engineering </option>
						<option value="Food and Nutrition"> Food and Nutrition </option>
						<option value="Food Science and Technology"> Food Science and Technology </option>
						<option value="Forestry Science"> Forestry Science </option>
						<option value="Genetics"> Genetics </option>
						<option value="Genetics Science"> Genetics Science </option>
						<option value="Geography Science"> Geography Science </option>
						<option value="Geology Science"> Geology Science </option>
						<option value="Geophysics Science"> Geophysics Science </option>
						<option value="Gynaecology"> Gynaecology </option>
						<option value="Hematology Science"> Hematology Science </option>
						<option value="Herbal Medicine"> Herbal Medicine </option>
						<option value="Histopathology"> Histopathology </option>
						<option value="History"> History </option>
						<option value="Home Science"> Home Science </option>
						<option value="Hotel Management"> Hotel Management </option>
						<option value="Ichthyology"> Ichthyology </option>
						<option value="Ichthyology Science"> Ichthyology Science </option>
						<option value="Immunology"> Immunology </option>
						<option value="Immunology and Microbiology"> Immunology and Microbiology </option>
						<option value="Industrial Engineering"> Industrial Engineering </option>
						<option value="Industrial Microbiology"> Industrial Microbiology </option>
						<option value="Industrial Process Monitoring Techniques and Systems"> Industrial Process Monitoring Techniques and Systems </option>
						<option value="Info security"> Info security </option>
						<option value="Information Technology"> Information Technology </option>
						<option value="Interacting with Computers"> Interacting with Computers </option>
						<option value="Knowledge Management"> Knowledge Management </option>
						<option value="Knowledge-Based Systems"> Knowledge-Based Systems </option>
						<option value="Language Research"> Language Research </option>
						<option value="Law"> Law </option>
						<option value="Leisure and Recreation"> Leisure and Recreation </option>
						<option value="Library Science"> Library Science </option>
						<option value="Limnology"> Limnology </option>
						<option value="Linguistics Science"> Linguistics Science </option>
						<option value="Magnetic Resonance Imaging"> Magnetic Resonance Imaging </option>
						<option value="Malacology"> Malacology </option>
						<option value="Management"> Management </option>
						<option value="Manufacturing Engineering"> Manufacturing Engineering </option>
						<option value="Manufacturing Technology"> Manufacturing Technology </option>
						<option value="Marine Biology"> Marine Biology </option>
						<option value="Marine Microbiology"> Marine Microbiology </option>
						<option value="Material Science"> Material Science </option>
						<option value="Material Science and Engineering"> Material Science and Engineering </option>
						<option value="Materials Engineering"> Materials Engineering </option>
						<option value="Materials Science and Engineering"> Materials Science and Engineering </option>
						<option value="Mathematics"> Mathematics </option>
						<option value="Mechanical Engineering"> Mechanical Engineering </option>
						<option value="Mechanics"> Mechanics </option>
						<option value="Mechanics Science"> Mechanics Science </option>
						<option value="Mechatronics"> Mechatronics </option>
						<option value="Medical Microbiology"> Medical Microbiology </option>
						<option value="Medical Surgical"> Medical Surgical </option>
						<option value="Medicinal Plants"> Medicinal Plants </option>
						<option value="Medicine and Dentistry"> Medicine and Dentistry </option>
						<option value="Medicine Science"> Medicine Science </option>
						<option value="Meteorology Science"> Meteorology Science </option>
						<option value="Microbial Ecology"> Microbial Ecology </option>
						<option value="Microbial Genetics"> Microbial Genetics </option>
						<option value="Microbiology"> Microbiology </option>
						<option value="Microbiology Science"> Microbiology Science </option>
						<option value="Microelectronic Engineering"> Microelectronic Engineering </option>
						<option value="Microelectronics Reliability"> Microelectronics Reliability </option>
						<option value="Microprocessors and Microsystems"> Microprocessors and Microsystems </option>
						<option value="Mineralogy Science"> Mineralogy Science </option>
						<option value="Molecular Biology"> Molecular Biology </option>
						<option value="Molecular Engineering"> Molecular Engineering </option>
						<option value="Music Education"> Music Education </option>
						<option value="Musicology"> Musicology </option>
						<option value="Mycology Science"> Mycology Science </option>
						<option value="Nanotechnology"> Nanotechnology </option>
						<option value="Neural Networks"> Neural Networks </option>
						<option value="Neurocomputing"> Neurocomputing </option>
						<option value="Neuroscience"> Neuroscience </option>
						<option value="Nuclear Engineering"> Nuclear Engineering </option>
						<option value="Nursing"> Nursing </option>
						<option value="Nursing and Health Professions"> Nursing and Health Professions </option>
						<option value="Nutrition Science"> Nutrition Science </option>
						<option value="Ocean Engineering"> Ocean Engineering </option>
						<option value="Ocean Modeling"> Ocean Modeling </option>
						<option value="Oceanography Science"> Oceanography Science </option>
						<option value="Offshore Engineering"> Offshore Engineering </option>
						<option value="Oncology"> Oncology </option>
						<option value="Optical Engineering"> Optical Engineering </option>
						<option value="Optical Switching and Networking"> Optical Switching and Networking </option>
						<option value="Optics &amp; Laser Technology"> Optics &amp; Laser Technology </option>
						<option value="Optics and Lasers in Engineering"> Optics and Lasers in Engineering </option>
						<option value="Parallel Computing"> Parallel Computing </option>
						<option value="Pathology Science"> Pathology Science </option>
						<option value="Pattern Recognition"> Pattern Recognition </option>
						<option value="Peace and Conflict Studies"> Peace and Conflict Studies </option>
						<option value="Pedagogy"> Pedagogy </option>
						<option value="Pediatric Nursing"> Pediatric Nursing </option>
						<option value="Pediatric Specialty"> Pediatric Specialty </option>
						<option value="Petroleum Engineering"> Petroleum Engineering </option>
						<option value="Pharmaceutical Science"> Pharmaceutical Science </option>
						<option value="Pharmacology and Toxicology"> Pharmacology and Toxicology </option>
						<option value="Pharmacology Science"> Pharmacology Science </option>
						<option value="Pharmacology Science"> Pharmacology Science </option>
						<option value="Philosophy"> Philosophy </option>
						<option value="Philosophy of Physics"> Philosophy of Physics </option>
						<option value="Physical Education"> Physical Education </option>
						<option value="Physics and Astronomy"> Physics and Astronomy </option>
						<option value="Physics Science"> Physics Science </option>
						<option value="Physiology Science"> Physiology Science </option>
						<option value="Physiotherapy"> Physiotherapy </option>
						<option value="Plant Physiology and Botany"> Plant Physiology and Botany </option>
						<option value="Political Science"> Political Science </option>
						<option value="Power Engineering"> Power Engineering </option>
						<option value="Production Engineering"> Production Engineering </option>
						<option value="Psychology"> Psychology </option>
						<option value="Psychology Science"> Psychology Science </option>
						<option value="Public Health Education"> Public Health Education </option>
						<option value="Radiological Sciences"> Radiological Sciences </option>
						<option value="Radiology Science"> Radiology Science </option>
						<option value="Religion and Theology"> Religion and Theology </option>
						<option value="Robotics Science"> Robotics Science </option>
						<option value="Signal Processing"> Signal Processing </option>
						<option value="Social Science"> Social Science </option>
						<option value="Social Work and History"> Social Work and History </option>
						<option value="Software Engineering"> Software Engineering </option>
						<option value="Soil and Agricultural"> Soil and Agricultural </option>
						<option value="Statistics"> Statistics </option>
						<option value="Systematic Science"> Systematic Science </option>
						<option value="Systems and Structures"> Systems and Structures </option>
						<option value="Textile Engineering"> Textile Engineering </option>
						<option value="Tourism"> Tourism </option>
						<option value="Toxicology Science"> Toxicology Science </option>
						<option value="Vermitechnology"> Vermitechnology </option>
						<option value="Veterinary Medicine"> Veterinary Medicine </option>
						<option value="Veterinary Science"> Veterinary Science </option>
						<option value="Water Treatment"> Water Treatment </option>
						<option value="Welding"> Welding </option>
						<option value="Yoga and Meditation"> Yoga and Meditation </option>
						<option value="Zoology Science"> Zoology Science </option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td>
					<label for="ebm_institute_url">URL of Profile on Website of Institute</label>
				</td>
				<td>
					<input type="text" name="ebm_institute_url" id="ebm_institute_url">
				</td>
			</tr>
			<tr>
				<td>
					<label for="ebm_personal_blog">URL of Personal Website / Blog </label>
				</td>
				<td>
					<input type="text" name="ebm_personal_blog" id="ebm_personal_blog">
				</td>
			</tr>
			<tr>
				<td>
					<label for="ebm_google_scholar_profile">URL of Google Scholar profile <span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="ebm_google_scholar_profile" id="ebm_google_scholar_profile">
				</td>
			</tr>
			<tr>
				<td>
					<label for="ebm_research_gate_url">URL of Research Gate <span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="ebm_research_gate_url" id="ebm_research_gate_url">
				</td>
			</tr>
			<tr>
				<td>
					<label for="ebm_orcid_id">URL of ORCID ID <span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="ebm_orcid_id" id="ebm_orcid_id">
				</td>
			</tr>
			<tr>
				<td>
					<label for="ebm_ssrn_id">SSRN ID/ URL</label>
				</td>
				<td>
					<input type="text" name="ebm_ssrn_id" id="ebm_ssrn_id">
				</td>
			</tr>
			<tr>
				<td>
					<label for="ebm_file">Upload resume <span class="error">*<span></label>
				</td>
				<td>
					<input type="file" name="ebm_file" id="ebm_file" accept="application/msword, application/pdf, image/*">
				</td>
			</tr>
			<tr>
				<td>Captcha Code:</td>
				<td id="imgparent">
					<div id="imgdiv">
					<img id="img" src="<?php echo get_template_directory_uri(); ?>/captcha.php">
					</div>					
				</td>
			</tr>
			<tr>
				<td>Enter Image Text:</td>
				<td>
					<input type="text"name="captcha1" autocomplete="off" id="captcha1" maxlength="5" >
				</td>
			</tr>
			<tr>
				<td style="text-align: right;">				
					<input type="submit" name="submit" value="Submit">
				</td>
				<td style="text-align: left;">
					<input type="reset" name="resetform" id="resetform" value="Clear">
				</td>
			</tr>
		</table>
	</form>
	<div class="ebm_response"></div>
	</div>
	<?php
}
add_shortcode( 'board_member_form', 'hp_editor_board_member_callback' );


function hp_ebm_form_ajax_request(){	
	session_start();
	$ebm_name_pre = !empty( $_POST['ebm_name_pre'] )? $_POST['ebm_name_pre'] : '';
	$ebm_first_name = !empty( $_POST['ebm_first_name'] )? $_POST['ebm_first_name'] : '';
	$ebm_last_name = !empty( $_POST['ebm_last_name'] )? $_POST['ebm_last_name'] : '';
	$ebm_contact_no = !empty( $_POST['ebm_contact_no'] )? $_POST['ebm_contact_no'] : '';
	$ebm_email = !empty( $_POST['ebm_email'] )? $_POST['ebm_email'] : '';
	$ebm_designation = !empty( $_POST['ebm_designation'] )? $_POST['ebm_designation'] : '';
	$ebm_institute_name_address = !empty( $_POST['ebm_institute_name_address'] )? $_POST['ebm_institute_name_address'] : '';
	$ebm_residential_address = !empty( $_POST['ebm_residential_address'] )? $_POST['ebm_residential_address'] : '';
	$ebm_degree_qualification = !empty( $_POST['ebm_degree_qualification'] )? $_POST['ebm_degree_qualification'] : '';
	$ebm_subjectArea = !empty( $_POST['ebm_subjectArea'] )? $_POST['ebm_subjectArea'] : '';
	$ebm_institute_url = !empty( $_POST['ebm_institute_url'] )? $_POST['ebm_institute_url'] : '';
	$ebm_personal_blog = !empty( $_POST['ebm_personal_blog'] )? $_POST['ebm_personal_blog'] : '';
	$ebm_google_scholar_profile = !empty( $_POST['ebm_google_scholar_profile'] )? $_POST['ebm_google_scholar_profile'] : '';
	$ebm_research_gate_url = !empty( $_POST['ebm_research_gate_url'] )? $_POST['ebm_research_gate_url'] : '';
	$ebm_orcid_id = !empty( $_POST['ebm_orcid_id'] )? $_POST['ebm_orcid_id'] : '';
	$ebm_ssrn_id = !empty( $_POST['ebm_ssrn_id'] )? $_POST['ebm_ssrn_id'] : '';
	$captcha1 = !empty( $_POST['captcha1'] )? $_POST['captcha1'] : '';
	
	if( isset( $captcha1 ) && $captcha1 == $_SESSION['code'] ) {
		
		$ebm_form_array = array(
			'ebm_name_pre' => $ebm_name_pre,
			'ebm_first_name' => $ebm_first_name,
			'ebm_last_name' => $ebm_last_name,
			'ebm_contact_no' => $ebm_contact_no,
			'ebm_email' => $ebm_email,
			'ebm_designation' => $ebm_designation,
			'ebm_institute_name_address' => $ebm_institute_name_address,
			'ebm_residential_address' => $ebm_residential_address,
			'ebm_degree_qualification' => $ebm_degree_qualification,
			'ebm_subjectArea' => $ebm_subjectArea,
			'ebm_institute_url' => $ebm_institute_url,
			'ebm_personal_blog' => $ebm_personal_blog,
			'ebm_google_scholar_profile' => $ebm_google_scholar_profile,
			'ebm_research_gate_url' => $ebm_research_gate_url,
			'ebm_orcid_id' => $ebm_orcid_id,
			'ebm_ssrn_id' => $ebm_ssrn_id,
		);
		
		$post_title_text = $ebm_name_pre . ' ' . $ebm_first_name . ' ' . $ebm_last_name;
		$post_content_text = get_ebm_html_table($ebm_form_array);
		
		$post_id = wp_insert_post( array(
			'post_status' => 'draft',
			'post_type' => 'hr_em',
			'post_title' => $post_title_text,
			'post_content' => $post_content_text,
		) );
		
		update_post_meta($post_id,'ebm_form_submitted_data',$ebm_form_array);
		
		foreach( $_FILES as $file ) {  
			  if( is_array( $file ) ) {
					$attach_id =upload_user_file( $file );  //Call function 
					update_post_meta($post_id,'attached_file_id',$attach_id);
					$attachment_url = wp_get_attachment_url( $attach_id );
					update_post_meta($post_id,'attached_file_url',$attachment_url);
			  }
		}
		
		if( isset( $post_id ) && $post_id !=0 ) {
			$json_response = array(
				'message'  => 'Your profile is sumitted.',
				'success'       => true
			);
		} else {
			$json_response = array(
				'message'  => 'Your profile is sumitted faild. Please try again.',
				'success'       => false,
				'recaptchaimage' => get_template_directory_uri() .'/captcha.php',
			);
		}
	} else {		
		$json_response = array(
			'message'  => 'Please enter valid captcha.',
			'success'       => false,
			'recaptchaimage' => get_template_directory_uri() .'/captcha.php',
		);
	}
	

	wp_send_json($json_response);
	die(0);	
}
add_action( 'wp_ajax_ebm_form_ajax_request', 'hp_ebm_form_ajax_request' );
add_action( 'wp_ajax_nopriv_ebm_form_ajax_request', 'hp_ebm_form_ajax_request' );

function get_ebm_html_table($editorial_member_details){
		ob_start();
        ?>
		<table>
			<?php if( isset( $editorial_member_details['ebm_name_pre'] ) && '' !== $editorial_member_details['ebm_name_pre'] ) { ?>
				<tr> 
					<td><label for="ebm_first_name">First Name</label></td>
					<td><?php esc_html_e($editorial_member_details['ebm_name_pre']) . esc_html_e($editorial_member_details['ebm_first_name']) ; ?></td>
				</tr>
			<?php } ?>
			<?php if( isset( $editorial_member_details['ebm_last_name'] ) && '' !== $editorial_member_details['ebm_last_name'] ) { ?>
				<tr> 
					<td><label for="ebm_last_name">Last Name</label></td>
					<td><?php esc_html_e($editorial_member_details['ebm_last_name']); ?></td>
				</tr>
			<?php } ?>
			<?php if( isset( $editorial_member_details['ebm_contact_no'] ) && '' !== $editorial_member_details['ebm_contact_no'] ) { ?>
				<tr>
					<td><label for="ebm_contact_no">Contact no.</label></td>
					<td><?php esc_html_e($editorial_member_details['ebm_contact_no']); ?></td>
				</tr>
			<?php } ?>
			<?php if( isset( $editorial_member_details['ebm_email'] ) && '' !== $editorial_member_details['ebm_email'] ) { ?>
				<tr>
					<td><label for="ebm_email">Email</label></td>
					<td><?php esc_html_e($editorial_member_details['ebm_email']); ?></td>
				</tr>
			<?php } ?>
			<?php if( isset( $editorial_member_details['ebm_designation'] ) && '' !== $editorial_member_details['ebm_designation'] ) { ?>
				<tr>
					<td><label for="ebm_designation">Designation</label></td>
					<td><?php esc_html_e($editorial_member_details['ebm_designation']); ?></td>
				</tr>
			<?php } ?>
			<?php if( isset( $editorial_member_details['ebm_institute_name_address'] ) && '' !== $editorial_member_details['ebm_institute_name_address'] ) { ?>
				<tr>
					<td><label for="ebm_institute_name_address">Institute name and Address</label></td>
					<td><?php esc_html_e($editorial_member_details['ebm_institute_name_address']); ?></td>
				</tr>
			<?php } ?>
			<?php if( isset( $editorial_member_details['ebm_residential_address'] ) && '' !== $editorial_member_details['ebm_residential_address'] ) { ?>
				<tr>
					<td><label for="ebm_residential_address">Residential Address</label></td>
					<td><?php esc_html_e($editorial_member_details['ebm_residential_address']); ?></td>
				</tr>
			<?php } ?>
			<?php if( isset( $editorial_member_details['ebm_degree_qualification'] ) && '' !== $editorial_member_details['ebm_degree_qualification'] ) { ?>
				<tr>
					<td><label for="ebm_degree_qualification">Degree / Qualifications</label></td>
					<td><?php esc_html_e($editorial_member_details['ebm_degree_qualification']); ?></td>
				</tr>
			<?php } ?>
			<?php if( isset( $editorial_member_details['ebm_subjectArea'] ) && '' !== $editorial_member_details['ebm_subjectArea'] ) { ?>
				<tr>
					<td><label for="ebm_subjectArea">Subject</label></td>
					<td><?php esc_html_e($editorial_member_details['ebm_subjectArea']); ?></td>
				</tr>
			<?php } ?>
			<?php if( isset( $editorial_member_details['ebm_institute_url'] ) && '' !== $editorial_member_details['ebm_institute_url'] ) { ?>
				<tr>
					<td><label for="ebm_institute_url">URL of Profile on Website of Institute</label></td>
					<td><?php echo esc_url($editorial_member_details['ebm_institute_url']); ?></td>
				</tr>
			<?php } ?>
			<?php if( isset( $editorial_member_details['ebm_personal_blog'] ) && '' !== $editorial_member_details['ebm_personal_blog'] ) { ?>
				<tr>
					<td><label for="ebm_personal_blog">URL of Personal Website / Blog </label></td>
					<td><?php echo esc_url($editorial_member_details['ebm_personal_blog']); ?></td>
				</tr>
			<?php } ?>
			<?php if( isset( $editorial_member_details['ebm_google_scholar_profile'] ) && '' !== $editorial_member_details['ebm_google_scholar_profile'] ) { ?>
				<tr>
					<td><label for="ebm_google_scholar_profile">URL of Google Scholar profile</label></td>
					<td><?php echo esc_url($editorial_member_details['ebm_google_scholar_profile']); ?></td>
				</tr>
			<?php } ?>
			<?php if( isset( $editorial_member_details['ebm_research_gate_url'] ) && '' !== $editorial_member_details['ebm_research_gate_url'] ) { ?>
				<tr>
					<td><label for="ebm_research_gate_url">URL of Research Gate</label></td>
					<td><?php echo esc_url($editorial_member_details['ebm_research_gate_url']); ?></td>
				</tr>
			<?php } ?>
			<?php if( isset( $editorial_member_details['ebm_orcid_id'] ) && '' !== $editorial_member_details['ebm_orcid_id'] ) { ?>
				<tr>
					<td><label for="ebm_orcid_id">URL of ORCID ID</label></td>
					<td><?php echo esc_url($editorial_member_details['ebm_orcid_id']); ?></td>
				</tr>
			<?php } ?>
			<?php if( isset( $editorial_member_details['ebm_ssrn_id'] ) && '' !== $editorial_member_details['ebm_ssrn_id'] ) { ?>
				<tr>
					<td><label for="ebm_ssrn_id">SSRN ID/ URL</label></td>
					<td><?php esc_html_e($editorial_member_details['ebm_ssrn_id']); ?></td>
				</tr>
			<?php } ?>
		</table>
        <?php
        
	return ob_get_clean();
}

function upload_user_file( $file = array() ) {    
    require_once( ABSPATH . 'wp-admin/includes/admin.php' );
    $file_return = wp_handle_upload( $file, array('test_form' => false ) );
    if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {		
        return false;
    } else {
        $filename = $file_return['file'];
        $attachment = array(
            'post_mime_type' => $file_return['type'],
            'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $file_return['url']
        );
        $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );        
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
		require_once(ABSPATH . "wp-admin" . '/includes/media.php');
        $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
        wp_update_attachment_metadata( $attachment_id, $attachment_data );		
        if( 0 < intval( $attachment_id ) ) {
          return $attachment_id;
        }
    }
    return false;
}


function rrjournals_submit_paper_callback( $atts ) {
	?>
	<style>
	.container-form form#rr_sp_form_id {
		width: 80%;
	}
	.container-form input[type=text],.container-form input[type=email], .container-form select	{
		box-sizing: border-box;
		resize: vertical;
	}

	.container-form input[type=submit],.container-form input[type=reset] {
		background-color: #003366;
		color: white;		
		border: none;		
		cursor: pointer;
		margin: 12px 6px;
	}

	.container-form input[type=subject]:hover ,.container-form input[type=reset]:hover {
		background-color: #003366;
		
	}

	.container-form {
		border-radius: 5px;
		padding: 20px;		
	}
	.container-form input[type=file] {
		resize: vertical;
		width: 100%;
	}
	.container-form select#article_type,.container-form select#subject_area {
		width: 100%;
	}

	.container-form input#first_name {
		width: 78%;
	}
	.container-form input[type=text], .container-form input[type=email] {
		width: 100%;
	}
	.rr_sp_response {
		text-align: center;
		margin-top:  20px;
		margin-right:  97px;
	}

	.success {
		color:  green;
	}

	input#captcha1 {
		width:  30%;
	}
	</style>
	<div class="container-form">
	<form action="javascript:void(0);" method="post" name="rr_sp_form_id" id="rr_sp_form_id" enctype="multipart/form-data">
		<table>
			<tr>
				<td>
					<label for="article_type">Article Type</label>
				</td>
				<td>
					<select class="" id="article_type" name="article_type">
						<option selected="" value="selectcard" disabled="disabled">--- Please select ---</option>
						<option value="Research Paper"> Research Paper </option>
						<option value="Review Paper"> Review Paper </option>						
						<option value="Article"> Article </option>						
						<option value="Short Communication"> Short Communication </option>						
						<option value="Case Study"> Case Study </option>						
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="subject_area">Subject Area</label>
				</td>
				<td>
					<select class="" id="subject_area" name="subject_area">
						<option selected="" value="selectcard" disabled="disabled">--- Please select ---</option>
						<option value="Agricultural Science">Agricultural Science </option>
						<option value="Anaesthesiology">Anaesthesiology </option>
						<option value="Anatomy">Anatomy </option>
						<option value="Anesthesiology">Anesthesiology </option>
						<option value="Arts">Arts </option>
						<option value="Ayurveda">Ayurveda </option>
						<option value="Biochemistry">Biochemistry </option>
						<option value="Biological Science">Biological Science </option>
						<option value="Botany">Botany </option>
						<option value="Cardiology">Cardiology </option>
						<option value="Chemical Science">Chemical Science </option>
						<option value="Chemistry">Chemistry </option>
						<option value="Clinical Research">Clinical Research </option>
						<option value="Clinical Science">Clinical Science </option>
						<option value="Commerce">Commerce </option>
						<option value="Community Medicine">Community Medicine </option>
						<option value="Computer Science">Computer Science </option>
						<option value="Cosmetology">Cosmetology </option>
						<option value="Dairy Technology">Dairy Technology </option>
						<option value="Dental Science">Dental Science </option>
						<option value="Dermatology">Dermatology </option>
						<option value="Diabetology">Diabetology </option>
						<option value="Drama">Drama </option>
						<option value="Earth Science">Earth Science </option>
						<option value="Economics">Economics </option>
						<option value="Education">Education </option>
						<option value="Electrotherapy">Electrotherapy </option>
						<option value="Endocrinology">Endocrinology </option>
						<option value="Endodontic">Endodontic </option>
						<option value="Engineering">Engineering </option>
						<option value="English">English </option>
						<option value="ENT">ENT </option>
						<option value="Entomology">Entomology </option>
						<option value="Environmental Science">Environmental Science </option>
						<option value="Epidemiology">Epidemiology </option>
						<option value="Foreignsic Science">Foreignsic Science </option>
						<option value="Forensic Medicine">Forensic Medicine </option>
						<option value="Forensic Science">Forensic Science </option>
						<option value="Forestry Science">Forestry Science </option>
						<option value="Gastroenterology">Gastroenterology </option>
						<option value="General Medicine">General Medicine </option>
						<option value="General Surgery">General Surgery </option>
						<option value="Genetics">Genetics </option>
						<option value="Geography">Geography </option>
						<option value="Gynaecology">Gynaecology </option>
						<option value="Gynecology">Gynecology </option>
						<option value="Hepatobiliary Surgery">Hepatobiliary Surgery </option>
						<option value="Hindi">Hindi </option>
						<option value="History">History </option>
						<option value="Home Science">Home Science </option>
						<option value="Homeopathic">Homeopathic </option>
						<option value="Immunohaematology">Immunohaematology </option>
						<option value="Immunohematology">Immunohematology </option>
						<option value="Immunology">Immunology </option>
						<option value="Information Technology">Information Technology </option>
						<option value="Journalism">Journalism </option>
						<option value="Law">Law </option>
						<option value="Linguistics">Linguistics </option>
						<option value="Management">Management </option>
						<option value="Mathematics">Mathematics </option>
						<option value="Media">Media </option>
						<option value="Medical Science">Medical Science </option>
						<option value="Medicine">Medicine </option>
						<option value="Microbiology">Microbiology </option>
						<option value="Morphology">Morphology </option>
						<option value="Nematology">Nematology </option>
						<option value="Neonatology">Neonatology </option>
						<option value="Nephrology">Nephrology </option>
						<option value="Neurology">Neurology </option>
						<option value="Neurosurgery">Neurosurgery </option>
						<option value="Nursing">Nursing </option>
						<option value="Obstetrics &amp; Gynaecology">Obstetrics &amp; Gynaecology </option>
						<option value="Obstetrics &amp; Gynecology">Obstetrics &amp; Gynecology </option>
						<option value="Oncology">Oncology </option>
						<option value="Ophthalmology">Ophthalmology </option>
						<option value="Oral Medicine">Oral Medicine </option>
						<option value="Oral Pathology">Oral Pathology </option>
						<option value="Orthodontology">Orthodontology </option>
						<option value="Orthopaedic">Orthopaedic </option>
						<option value="Orthopaedics">Orthopaedics </option>
						<option value="Orthopedics">Orthopedics </option>
						<option value="Otolaryngology">Otolaryngology </option>
						<option value="Paediatrics">Paediatrics </option>
						<option value="Pathology">Pathology </option>
						<option value="Pediatrics">Pediatrics </option>
						<option value="Periodontology">Periodontology </option>
						<option value="Pharma">Pharma </option>
						<option value="Pharmaceutical">Pharmaceutical </option>
						<option value="Pharmaceuticals">Pharmaceuticals </option>
						<option value="Pharmacology">Pharmacology </option>
						<option value="Pharmacy">Pharmacy </option>
						<option value="Physical Education">Physical Education </option>
						<option value="Physics">Physics </option>
						<option value="Physiology">Physiology </option>
						<option value="Physiotherapy">Physiotherapy </option>
						<option value="Plastic Surgery">Plastic Surgery </option>
						<option value="Political Science">Political Science </option>
						<option value="Prosthodontics">Prosthodontics </option>
						<option value="Radiodiagnosis">Radiodiagnosis </option>
						<option value="Radiology">Radiology </option>
						<option value="Rheumatology">Rheumatology </option>
						<option value="Sanskrit">Sanskrit </option>
						<option value="Social Science">Social Science </option>
						<option value="Sports Science">Sports Science </option>
						<option value="Statistics">Statistics </option>
						<option value="Surgery">Surgery </option>
						<option value="Tourism">Tourism </option>
						<option value="Unani Medicine">Unani Medicine </option>
						<option value="Urology">Urology </option>
						<option value="Veterinary Science">Veterinary Science </option>
						<option value="Zoology">Zoology </option>					
					</select>
				</td>
			</tr>			
			<tr>
				<td>
					<label for="title_of_the_paper ">Title of the paper <span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="title_of_the_paper" id="title_of_the_paper" maxlength="100 " size="30 ">
				</td>
			</tr>
			<tr>
				<td>
					<label for="first_author_name ">Name of 1<sup>st</sup> Author <span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="first_author_name" id="first_author_name" maxlength="50 " size="30 ">
				</td>
			</tr>
			<tr>
				<td>
					<label for="first_author_designation">Designation & Affiliation of 1<sup>St</sup> Author <span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="first_author_designation" id="first_author_designation">
				</td>
			</tr>
			<tr>
				<td>
					<label for="second_author_name ">Name of 2<sup>nd</sup> Author </label>
				</td>
				<td>
					<input type="text" name="second_author_name" id="second_author_name" maxlength="50 " size="30 ">
				</td>
			</tr>
			<tr>
				<td>
					<label for="second_author_designation">Designation & Affiliation of 2<sup>nd</sup> Author</label>
				</td>
				<td>
					<input type="text" name="second_author_designation" id="second_author_designation">
				</td>
			</tr>
			<tr>
				<td>
					<label for="third_author_name ">Name of 3<sup>rd</sup> Author </label>
				</td>
				<td>
					<input type="text" name="third_author_name" id="third_author_name" maxlength="50 " size="30 ">
				</td>
			</tr>
			<tr>
				<td>
					<label for="third_author_designation">Designation & Affiliation of 3<sup>rd</sup> Author</label>
				</td>
				<td>
					<input type="text" name="third_author_designation" id="third_author_designation">
				</td>
			</tr>
			<tr>
				<td>
					<label for="name_of_corresponding_author ">Name of Corresponding Author <span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="name_of_corresponding_author" id="name_of_corresponding_author">
				</td>
			</tr>
			<tr>
				<td>
					<label for="email_of_corresponding_author">Email of Corresponding Author <span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="email_of_corresponding_author" id="email_of_corresponding_author">
				</td>
			</tr>			
			<tr>
				<td>
					<label for="contact_no">Contact No. <span class="error">*<span></label>
				</td>
				<td>
					<input type="phone" name="contact_no" id="contact_no" maxlength="15" size="30">
				</td>
			</tr>
			<tr>
				<td>
					<label for="city_name">City</label>
				</td>
				<td>
					<input type="text" name="city_name" id="city_name" maxlength="80" size="30">
				</td>
			</tr>
			<tr>
				<td>
					<label for="state_name">State</label>
				</td>
				<td>
					<input type="text" name="state_name" id="state_name" maxlength="80" size="30">
				</td>
			</tr>
			<tr>
				<td>
					<label for="country_name">Country</label>
				</td>
				<td>
					<input type="text" name="country_name" id="country_name" maxlength="80" size="30">
				</td>
			</tr>
			<tr>
				<td>
					<label for="rr_sp_file">Upload MS-Word <span class="error">*<span></label>
				</td>
				<td>
					<input type="file" name="rr_sp_file" id="rr_sp_file" accept="application/msword">
				</td>
			</tr>
			<tr>
				<td>Captcha Code:</td>
				<td id="imgparent">
					<div id="imgdiv">
					<img id="img" src="<?php echo get_template_directory_uri(); ?>/captcha.php">
					</div>					
				</td>
			</tr>
			<tr>
				<td>Enter Image Text:</td>
				<td>
					<input type="text"name="captcha1"  id="captcha1" maxlength="5" >
				</td>
			</tr>
			<!--<tr>
			    <td>&bsp;</td>
			    <td><div class="g-recaptcha" data-sitekey="6Ld_wmIUAAAAAFTWIkSZLgMOFWlVvg6BZ6-On3iV"></div></td>
			</tr>-->
			<tr>
				<td colspan="2">
					<input type="checkbox" id="rrj_policy" name="rrj_policy" value="true"/> 
					I agree to the <a href="/disclaimer-policy/">terms and conditions</a> and <a href="/privacy-policy/">Privacy Policy</a> and <a href="/plagiarism-policy/">Plagiarism Policy</a>.
					<label style="float: none;" for="rrj_policy" class="error" generated="true"></label>
				</td>
			</tr>
			<tr>
				<td style="text-align: right;">				
				<?php
				    // Generate a custom nonce value.
	                $sp_form_meta_nonce = wp_create_nonce( 'rr_sp_meta_form_nonce' ); 
				    ?>
					<input type="hidden" name="sp_submit_meta_nonce" id="sp_submit_meta_nonce" value="<?php echo $sp_form_meta_nonce ?>" />
					<input type="hidden" name="action" value="rr_sp_form_ajax_request">
					<input type="submit" name="submit" value="Submit">
					
				</td>
				<td style="text-align: left;">
					<input type="reset" name="resetform" id="resetform" value="Clear">
				</td>
			</tr>
		</table>
	</form>
	<div class="rr_sp_response"></div>
	</div>
	<?php
}
add_shortcode( 'submit_paper_form', 'rrjournals_submit_paper_callback' );

function rr_sp_form_ajax_request_callback(){	
	session_start();
	if( isset( $_POST['sp_submit_meta_nonce'] ) && wp_verify_nonce( $_POST['sp_submit_meta_nonce'], 'rr_sp_meta_form_nonce') ) {
		
		if( empty( $_POST['rrj_policy'] ) ) {
			$json_response = array(
				'message'  => '<strong>ERROR</strong>: Please select Terms & Conditions and Privacy Policy and Plagiarism Policy checkbox.',
				'success'       => false
			);
			wp_send_json($json_response);
			wp_die(0);
		
		}
        
        $captcha1 					= ( isset( $_POST['captcha1'] ) && !empty( $_POST['captcha1'] ) )? $_POST['captcha1'] : '';
			if( !isset( $captcha1 ) && $captcha1 !== $_SESSION['code'] ) {
				$json_response = array(
						'message'  => '<strong>ERROR</strong>: Please retry CAPTCHA',
						'success'       => false
					);
					wp_send_json($json_response);
					wp_die(0);
			}
	
        $article_type 					= ( isset( $_POST['article_type'] ) && !empty( $_POST['article_type'] ) )? $_POST['article_type'] : '';
    	$subject_area 					= ( isset( $_POST['subject_area'] ) && !empty( $_POST['subject_area'] ) )? $_POST['subject_area'] : '';
    	$title_of_the_paper 			= ( isset( $_POST['title_of_the_paper'] ) && !empty( $_POST['title_of_the_paper'] ) )? sanitize_text_field( $_POST['title_of_the_paper'] ) : '';
    	$first_author_name 				= ( isset( $_POST['first_author_name'] ) && !empty( $_POST['first_author_name'] ) )? sanitize_text_field( $_POST['first_author_name'] ) : '';
    	$first_author_designation 		= ( isset( $_POST['first_author_designation'] ) && !empty( $_POST['first_author_designation'] ) )? sanitize_text_field( $_POST['first_author_designation'] ) : '';
    	$second_author_name 			= ( isset( $_POST['second_author_name'] ) && !empty( $_POST['second_author_name'] ) )? sanitize_text_field( $_POST['second_author_name'] ) : '';
    	$second_author_designation 		= ( isset( $_POST['second_author_designation'] ) && !empty( $_POST['second_author_designation'] ) )? sanitize_text_field( $_POST['second_author_designation'] ) : '';
    	$third_author_name 				= ( isset( $_POST['third_author_name'] ) && !empty( $_POST['third_author_name'] ) )? sanitize_text_field( $_POST['third_author_name'] ) : '';
    	$third_author_designation 		= ( isset( $_POST['third_author_designation'] ) && !empty( $_POST['third_author_designation'] ) )? sanitize_text_field( $_POST['third_author_designation'] ) : '';
    	$name_of_corresponding_author 	= ( isset( $_POST['name_of_corresponding_author'] ) && !empty( $_POST['name_of_corresponding_author'] ) )? sanitize_text_field( $_POST['name_of_corresponding_author'] ) : '';
    	$email_of_corresponding_author 	= ( isset( $_POST['email_of_corresponding_author'] ) && !empty( $_POST['email_of_corresponding_author'] ) )? sanitize_email( $_POST['email_of_corresponding_author'] ) : '';
    	$contact_no 					= ( isset( $_POST['contact_no'] ) && !empty( $_POST['contact_no'] ) )? sanitize_text_field( $_POST['contact_no'] ) : '';
    	$city_name 						= ( isset( $_POST['city_name'] ) && !empty( $_POST['city_name'] ) )? sanitize_text_field( $_POST['city_name'] ) : '';
    	$state_name 					= ( isset( $_POST['state_name'] ) && !empty( $_POST['state_name'] ) )? sanitize_text_field( $_POST['state_name'] ) : '';
    	$country_name			 		= ( isset( $_POST['country_name'] ) && !empty( $_POST['country_name'] ) )? sanitize_text_field( $_POST['country_name'] ) : '';
        $rrj_policy			 		= ( isset( $_POST['rrj_policy'] ) && !empty( $_POST['rrj_policy'] ) )? (bool) sanitize_text_field( $_POST['rrj_policy'] ) : 'false';
        
        
        $post_title_text = $title_of_the_paper;
        ob_start();
        ?>
        <table>
			<tr>
				<td><label for="article_type">Article Type</label></td>
				<td><?php echo esc_html($article_type); ?></td>
			</tr>
			<tr>
				<td><label for="subject_area">Subject Area</label></td>
				<td><?php echo esc_html($subject_area); ?></td>
			</tr>			
			<tr>
				<td><label for="title_of_the_paper ">Title of the paper </label></td>
				<td><?php echo esc_html($title_of_the_paper); ?></td>
			</tr>
			<tr>
				<td><label for="first_author_name ">Name of 1<sup>st</sup> Author <span class="error">*<span></label></td>
				<td><?php echo esc_html($first_author_name); ?></td>
			</tr>
			<tr>
				<td><label for="first_author_designation">Designation & Affiliation of 1<sup>St</sup> Author <span class="error">*<span></label></td>
				<td><?php echo esc_html($first_author_designation); ?></td>
			</tr>
			<tr>
				<td><label for="second_author_name ">Name of 2<sup>nd</sup> Author </label></td>
				<td><?php echo esc_html($second_author_name); ?></td>
			</tr>
			<tr>
				<td><label for="second_author_designation">Designation & Affiliation of 2<sup>nd</sup> Author</label></td>
				<td><?php echo esc_html($second_author_designation); ?></td>
			</tr>
			<tr>
				<td><label for="third_author_name ">Name of 3<sup>rd</sup> Author </label></td>
				<td><?php echo esc_html($third_author_name); ?></td>
			</tr>
			<tr>
				<td><label for="third_author_designation">Designation & Affiliation of 3<sup>rd</sup> Author</label></td>
				<td><?php echo esc_html($third_author_designation); ?></td>
			</tr>
			<tr>
				<td><label for="name_of_corresponding_author ">Name of Corresponding Author <span class="error">*<span></label></td>
				<td><?php echo esc_html($name_of_corresponding_author); ?></td>
			</tr>
			<tr>
				<td><label for="email_of_corresponding_author">Email of Corresponding Author <span class="error">*<span></label></td>
				<td><?php echo esc_html($email_of_corresponding_author); ?></td>
			</tr>			
			<tr>
				<td><label for="contact_no">Contact No. <span class="error">*<span></label></td>
				<td><?php echo esc_html($contact_no); ?></td>
			</tr>
			<tr>
				<td><label for="city_name">City</label></td>
				<td><?php echo esc_html($city_name); ?></td>
			</tr>
			<tr>
				<td><label for="state_name">State</label></td>
				<td><?php echo esc_html($state_name); ?></td>
			</tr>
			<tr>
				<td><label for="country_name">Country</label></td>
				<td><?php echo esc_html($country_name); ?></td>
			</tr>
			<tr>
				<td><label for="term&condiation">Term & Condition</label></td>
				<td><?php echo esc_html($rrj_policy); ?></td>
			</tr>
		</table>
        <?php
        
        $content_html = ob_get_clean();
		$post_content_text = $designation. ' ' . $education . ' ' . $institutename . ' ' . $country_name;
		
		$post_id = wp_insert_post( array(
			'post_status' => 'draft',
			'post_type' => 'rr_submited_paper',
			'post_title' => $title_of_the_paper,
			'post_content' => '',
		) );

		$email_response = rr_submit_paper_author_email_send($post_id,$email_of_corresponding_author,$name_of_corresponding_author);
	
		update_post_meta( $post_id, 'article_type',$article_type );
		update_post_meta( $post_id, 'subject_area',$subject_area );
		update_post_meta( $post_id, 'title_of_the_paper', $title_of_the_paper);
		update_post_meta( $post_id, 'first_author_name',$first_author_name );
		update_post_meta( $post_id, 'first_author_designation',$first_author_designation );
		update_post_meta( $post_id, 'second_author_name', $second_author_name);
		update_post_meta( $post_id, 'second_author_designation', $second_author_designation);
		update_post_meta( $post_id, 'third_author_name',$third_author_name );
		update_post_meta( $post_id, 'third_author_designation',$third_author_designation );
		update_post_meta( $post_id, 'name_of_corresponding_author',$name_of_corresponding_author );
		update_post_meta( $post_id, 'email_of_corresponding_author',$email_of_corresponding_author );
		update_post_meta( $post_id, 'contact_no',$contact_no );
		update_post_meta( $post_id, 'city_name',$city_name );
		update_post_meta( $post_id, 'state_name',$state_name );		
		update_post_meta( $post_id, 'country_name',$country_name );		
		$submitted_datetime = current_time( 'mysql' );
		update_post_meta( $post_id, 'submitted_date',$submitted_datetime);
		update_post_meta( $post_id, 'rrj_policy',$rrj_policy);
		update_post_meta( $post_id, '_authoer_email_sent', $email_response );
	
		foreach( $_FILES as $file ) {  
			  if( is_array( $file ) ) {
					$attach_id = upload_user_file( $file );  //Call function 
					update_post_meta($post_id,'attached_file_id',$attach_id);
					$attachment_url = wp_get_attachment_url( $attach_id );
					update_post_meta($post_id,'attached_file_url',$attachment_url);
					$content_html .= '<table><tr><td colspan="2"><button><a href="'.$attachment_url.'">Download Word file</a></button>';
					$post = array(
							'ID'           => $post_id,
							'post_content' => $content_html,
						);
					wp_update_post( $post );
			  }
		}
		$json_response = array(
                    'success'       => true,
                    'message' => 'Your article/paper submitted successfully'
                );
                wp_send_json($json_response);
	            wp_die(0);
		
	} else {		
		$json_response = array(
			'message'  => 'Please enter valid captcha.',
			'success'       => false
		);
	}
	
	wp_send_json($json_response);
	wp_die(0);	
}
add_action( 'wp_ajax_rr_sp_form_ajax_request', 'rr_sp_form_ajax_request_callback' );
add_action( 'wp_ajax_nopriv_rr_sp_form_ajax_request', 'rr_sp_form_ajax_request_callback' );

/**
 * This is a submit paper email function for sending email.
 *
 */
function rr_submit_paper_author_email_send($paper_id, $authoer_email,$author_name = ''){
	//$headers = array();
	
	$html_content = rr_sj_email_html($author_name,$paper_id);
	
	$subject = "Thank you for submitting your article";
	 
	$admin_email = "prakashrajkumavat@gmail.com";
	$site_title = get_bloginfo( 'name' );
	$headers = array('Content-Type: text/html; charset=UTF-8;');

	$sent_message = wp_mail( $authoer_email, $subject, $html_content, $headers );
	
	if ( $sent_message ) {
		return "Email sent";
	} else {
		return "Email not send";
	}
}
/**
 * This is a submit paper email html.
 * 
 * 
 */ 
function rr_sj_email_html($name = null,$paper_id = null){
	ob_start();
	?>
	<html>
    <head>
		<title>Thank you for submitting your article</title>
    </head>
    <body>
        <div id="email_container" style="background:#003366">
            <div style="width:570px; padding:0 0 0 20px; margin:50px auto 12px auto" id="email_header">
                <span style="background:#2161a0; color:#fff; padding:12px;font-family:trebuchet ms; letter-spacing:1px; 
                    -moz-border-radius-topleft:5px; -webkit-border-top-left-radius:5px; 
                    border-top-left-radius:5px;moz-border-radius-topright:5px; -webkit-border-top-right-radius:5px; 
                    border-top-right-radius:5px;">RESEARCH REVIEW International Journal of Multidisciplinary
                </span>
            </div>

            <div style="width:550px; padding:0 20px 20px 20px; background:#fff; margin:0 auto; border:3px #000 solid;
                moz-border-radius:5px; -webkit-border-radius:5px; border-radius:5px; color:#454545;line-height:1.5em; " id="email_content">

                <h1 style="padding:5px 0 0 0; font-family:georgia;font-weight:500;font-size:24px;color:#000;border-bottom:1px solid #bbb">
					Thank you for submitting your article
                </h1>

                <p>Dear Author (s),</p>
                <p>We thank you for submitting your article with Research Review Journals.</p> 
				<p>We have received your article with article Ref. No.<strong>#<?php echo $paper_id; ?></strong></p>
				<p>Kindly use above given reference number for future correspondence.</p>
				<p>Our all correspondence related to this article will be sent to the email address you submitted as corresponding author's email.</p>
				<p>Further notes;
				    <ol>
				        <li>Acceptance and rejection is sole decision of reviewer(s).</li>
				        <li>Article must have acceptable plagiarism.</li>
				        <li>We do not publish in back date issue.</li>
				        <li>We do not issue hard copy of the journal and certificate</li>
				        <li>We do not issue separate certificate to each author in case of jointly authored article.</li>
				        <li>Before submitting this article I have read and understood plagiarism policy, Privacy policy and other terms.</li>
				        <li>If any query please feel free to visit our website <a href="https://rrjournals.com/">https://rrjournals.com/</a></li>
				    </ol>
				</p>
                <p style="">
                    Thank You. ,<br>
                    The RRJournals.com
                </p>
            </div>
        </div>
    </body>
</html>
	<?php
	return ob_get_clean();
}

function get_tag_strings( $post_id ) {
	$tag_name = '';
	$tags_obj = wp_get_post_tags( $post_id );
	if( isset( $tags_obj ) && !empty( $tags_obj ) ) {
		$tag_name = array();
		foreach( $tags_obj as $tag_obj ){
			$tag_name[] = $tag_obj->name;
		}
		$tag_name = implode(',', $tag_name);
	}
	return $tag_name;
}

//Set the Post Custom Field in the WP dashboard as Name/Value pair 
function hr_articke_PostViews($post_ID) {
 
    //Set the name of the Posts Custom Field.
    $count_key = 'post_views_count'; 
     
    //Returns values of the custom field with the specified key from the specified post.
    $count = get_post_meta($post_ID, $count_key, true);
     
    //If the the Post Custom Field value is empty. 
    if($count == ''){
        $count = 1; // set the counter to zero.
         
        //Delete all custom fields with the specified key from the specified post. 
        delete_post_meta($post_ID, $count_key);
         
        //Add a custom (meta) field (Name/value)to the specified post.
        add_post_meta($post_ID, $count_key, '1');
        return $count . ' View';
     
    //If the the Post Custom Field value is NOT empty.
    }else{
        $count++; //increment the counter by 1.
        //Update the value of an existing meta key (custom field) for the specified post.
        update_post_meta($post_ID, $count_key, $count);
         
        //If statement, is just to have the singular form 'View' for the value '1'
        if($count == '1'){
        return $count;
        }
        //In all other cases return (count) Views
        else {
        return $count;
        }
    }
}

function get_issue( $year = '',$month = '' ) {
	
	if( empty( $year ) ){
		$year = date('Y');
	}
	if( empty( $month ) ){
		$month = date('m');
	}
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	$args = array(
		'posts_per_page' => 15,
		'post_type' => 'rr_issue',		
		'orderby' => 'date',
		'order' => 'ASC',
		'paged' => $paged
	);
	if( !empty( $year ) && !empty( $month ) ) {
		$args['date_query'] = array(
			array(
				'year'  => $year,
				'month' => $month
			),
		);
	} else if( !empty( $year ) ) {
		$args['date_query'] = array(
			array(
				'year'  => $year				
			),
		);
	}

	$posts = get_posts( $args );
	if( isset( $posts ) && !empty( $posts ) ) {
		return $posts;
	} else {
		return false;
	}
}

function wp_get_issue( $year = '',$month = '' ) {
	
	if( empty( $year ) ){
		$year = date('Y');
	}
	if( empty( $month ) ){
		$month = date('m');
	}
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	
	$args = array(
		'posts_per_page' => 15,
		'post_type' => 'rr_issue',		
		'orderby' => 'date',
		'order' => 'ASC',
		'paged' => $paged
	);
	if( !empty( $year ) && !empty( $month ) ) {
		$args['date_query'] = array(
			array(
				'year'  => $year,
				'month' => $month
			),
		);
	} else if( !empty( $year ) ) {
		$args['date_query'] = array(
			array(
				'year'  => $year				
			),
		);
	}

	$posts = new WP_Query( $args );
	if( isset( $posts ) && !empty( $posts ) ) {
		return $posts;
	} else {
		return false;
	}
}

function issue_content_html( $year = '',$month = '' ){
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$issue_posts = wp_get_issue( $year,$month );
	
	if ( $issue_posts->have_posts() ) {
    
		$count = get_post_count_by_page($paged);
	?>
	<table border="0" dir="ltr">
		<tbody>
			<?php
				while ($issue_posts -> have_posts()) : $issue_posts -> the_post(); 
					$issue_id = get_the_ID();
					$issue_title = get_the_title();
					$icp_year_and_month = CFS()->get( 'icp_year_and_month', $issue_id ); 
					$icp_page_number = CFS()->get( 'icp_page_number', $issue_id ); 
					$icp_authors_names_loop = CFS()->get( 'icp_authors_names', $issue_id ); 					
					$ice_paper_category = CFS()->get( 'ice_paper_category', $issue_id ); 					
					$ice_subject = CFS()->get( 'ice_subject', $issue_id ); 					
					$ice_pdf_upload = CFS()->get( 'ice_pdf_upload', $issue_id );
					$postcat = get_article_category( $issue_id );
					
					the_single_issue_content_html( $issue_id, $issue_title, $count);
			$count++; endwhile; ?>
		</tbody>
	</table>
	<nav class="navigation pagination custom-nav" role="navigation">
		
		<div class="nav-links">
		<?php
		$big = 999999999; // need an unlikely integer
		 echo paginate_links( array(
			'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $issue_posts	->max_num_pages
		) );
		?>
		</div>
	</nav>
	<?php
	} else {
		?>
		<table border="0" dir="ltr">
		<tbody>
		<tr>
			<td colspan="3">
				<hr class="hr">
			</td>
		</tr>
		<tr valign="top">			
			<td width="98%" valign="middle">
				<div>Articles are under review and uploaded soon.</div>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<hr class="hr">
			</td>
		</tr>
		</tbody>
	</table>
		<?php	
	}
}

function get_file_size( $file_id ){
	
	if( empty( $file_id ) ) {
		return false;
	}
	return $fileSize   = size_format( filesize( get_attached_file( $file_id ) ) );
}

function get_category_toggle_list() {
	$html = '';
	$taxonomyName = "category";
	$parent_terms = get_terms(
		$taxonomyName, 
			array(
				'parent' => 0, 
				'orderby' => 'slug', 
				'hide_empty' => false,
				'exclude' => array(1)
			)
		);   
	foreach ($parent_terms as $p_term) {
		$terms_child = get_terms($taxonomyName, array('parent' => $p_term->term_id, 'orderby' => 'slug', 'hide_empty' => false));
		$html.= '<div class="single_cat col-md-3">';
		$html.= '<h3>'.$p_term->name.'</h3>'; 
		$html.= "<ul>";
		foreach ($terms_child as $c_term) {		   
			$html.= '<li><a href="' . get_term_link( $c_term->name, $taxonomyName ) . '">' . $c_term->name . '</a></li>'; 			
		}
		$html.= "</ul>";
		$html.= '</div>'; 
	}	
	return $html;
}

function get_article_category( $post_id ) {
	$category_name_list = array();
	$postscat = get_the_category( $post_id );
	foreach( $postscat as $postcat ) {
		if( $postcat->parent == 0 ) {			
			$category_name_list['parent'] = $postcat->name;
		}
		if( $postcat->parent != 0 ) {
			$category_name_list['child'] = $postcat->name;
		}
	}
	return $category_name_list;
}

function get_list_years(){	
	global $wpdb;
	$results = $wpdb->get_results( "SELECT YEAR(post_date) AS year FROM {$wpdb->prefix}posts WHERE post_type = 'rr_issue' AND post_status = 'publish' GROUP BY year ASC", OBJECT );
	if( isset( $results ) && ! empty( $results ) ) {
		foreach( $results as $re_key=> $result ) {
			$volume_arr[$result->year] =  'Volume '. ( $re_key+1 );
		}
	}
	return $volume_arr;
}

function the_list_of_volumn() {
	$volume_arr = get_list_years();
						
	if( isset( $volume_arr ) && ! empty($volume_arr) ) {
		echo "<table><tr>";
		$int =1;
		foreach( $volume_arr as $volumn_key => $volumn_value ) {			
			if( $int %4 == 0 ) {
				echo "</tr>";
			}
			echo sprintf('<td class="volumn-btn"><a href="%s" title="">%s</a></td>',$volumn_key,$volumn_value);
			$int++;
		} 
		echo "</tr></table>";
	}
}



function get_year(){
	if( isset( $_GET['year'] ) && !empty( $_GET['year'] ) ) {
		return $_GET['year'];
	}
}

function get_month(){
	if( isset( $_GET['month'] ) && !empty( $_GET['month'] ) ) {
		return $_GET['month'];
	}
}
function get_month_table( $year ){
    
   if ( 2021 < $year || empty( $year ) ) {
		return array();
	}
	$issue_month_list = array();
	for( $month_num = 1; $month_num <= 12; $month_num++ ) {
		$month = str_pad($month_num, 2, "0", STR_PAD_LEFT);
		if( $month_num == date('m') && date('Y') == $year ) {
		   break;
		}
		if ( 11 < $month_num && ( 2021 <= $year ) ) {
    		break;
    	}
		$issue_month_list[$month] = 'Issue '. $month_num;		
	}
	return $issue_month_list;
}

function the_issue_month_list( $year ) {
	$issue_month_arr = get_month_table( $year );
	if( isset( $issue_month_arr ) && ! empty( $issue_month_arr ) ) {
		echo "<table><tr>";
		$int =1;
		foreach( $issue_month_arr as $issue_month => $issue_name ) {
			
			echo sprintf('<td class="volumn-btn"><a href="%s" title="">%s</a></td>',$issue_month,$issue_name);
			if( $int %4 == 0 ) {
				echo "</tr>";
			}
			$int++;
		} 
		echo "</tr></table>";
	}
}


/**
 * Custom post type specific rewrite rules
 * @return wp_rewrite Rewrite rules handled by WordPress
 */
function rrjournals_rewrite_rules($wp_rewrite) {
	//'rr_special_issue'
    // Here we're hardcoding the CPT in, article in this case
    $rules = rrjournals_generate_date_archives('rr_issue', $wp_rewrite);
    $rules_si = rrjournals_generate_date_archives('rr_special_issue', $wp_rewrite);
    $wp_rewrite->rules = $rules + $rules_si + $wp_rewrite->rules;
    return $wp_rewrite;
}
add_action('generate_rewrite_rules', 'rrjournals_rewrite_rules');

/**
 * Generate date archive rewrite rules for a given custom post type
 * @param  string $cpt slug of the custom post type
 * @return rules       returns a set of rewrite rules for WordPress to handle
 */
function rrjournals_generate_date_archives($cpt, $wp_rewrite){
    $rules = array();

    $post_type = get_post_type_object($cpt);
    $slug_archive = $post_type->has_archive;
    if ($slug_archive === false) {
        return $rules;
    }
    if ($slug_archive === true) {
        // Here's my edit to the original function, let's pick up
        // custom slug from the post type object if user has
        // specified one.
        $slug_archive = $post_type->rewrite['slug'];
    }

    $dates = array(
        array(
            'rule' => "([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})",
            'vars' => array('year', 'monthnum', 'day')
        ),
        array(
            'rule' => "([0-9]{4})/([0-9]{1,2})",
            'vars' => array('year', 'monthnum')
        ),
        array(
            'rule' => "([0-9]{4})",
            'vars' => array('year')
        )
    );

    foreach ($dates as $data) {
        $query = 'index.php?post_type='.$cpt;
        $rule = $slug_archive.'/'.$data['rule'];

        $i = 1;
        foreach ($data['vars'] as $var) {
            $query.= '&'.$var.'='.$wp_rewrite->preg_index($i);
            $i++;
        }

        $rules[$rule."/?$"] = $query;
        $rules[$rule."/feed/(feed|rdf|rss|rss2|atom)/?$"] = $query."&feed=".$wp_rewrite->preg_index($i);
        $rules[$rule."/(feed|rdf|rss|rss2|atom)/?$"] = $query."&feed=".$wp_rewrite->preg_index($i);
        $rules[$rule."/page/([0-9]{1,})/?$"] = $query."&paged=".$wp_rewrite->preg_index($i);
    }
    return $rules;
}

function rrjournals_sidebar_navigation(){
	?>
	<h2 class="widget-title">Tech Solutions</h2>
	<div id="menu">
      <ul>
        <li><a href="<?php echo site_url('/view-certificate/'); ?>">Certificate of Publication</a></li>
        <li><a href="<?php echo site_url('/paper-template/'); ?>">Paper Template</a></li>        
        <li><a href="<?php echo site_url('/copyright-agreement-form/'); ?>">Copyright Form</a></li>
        <li><a href="#">Reviewer’s Form</a></li>        
      </ul>
    </div>
	<?php
}
add_shortcode('sidebar_nav','rrjournals_sidebar_navigation');

function get_certificate_by_number(){
	
	if (  ! wp_verify_nonce( $_REQUEST['_wpnonce'] , 'valid_certificate' ) ) {
		print 'Sorry, your nonce did not verify.';exit;
		$post_id = !empty( $_POST['post_id'] ) ? $_POST['post_id'] : 0;
		$url = get_permalink( $post_id );
		wp_redirect($url.'?response=false&code=0');		
	} 	
	
	$certificate_number = !empty( $_POST['certificate_number'] )? $_POST['certificate_number'] : '';
	$page = get_page_by_title( $certificate_number, OBJECT, 'rr_cv' );
	if( isset( $page ) && !empty( $page ) ) {
		$url = get_permalink( $page->ID );
		wp_redirect($url);
	} else {
		$post_id = !empty( $_POST['post_id'] ) ? $_POST['post_id'] : 0;
		$url = get_permalink( $post_id );
		wp_redirect($url.'?response=false&code=1');
	}
	
	
}
add_action( 'admin_post_get_certificate_by_number', 'get_certificate_by_number' );
add_action( 'admin_post_nopriv_get_certificate_by_number', 'get_certificate_by_number' );

function my_default_image_size () {
    return 'large'; 
}

add_filter( 'pre_option_image_default_size', 'my_default_image_size' );

add_action('pre_get_posts','rr_journals_issue_default_order');
function rr_journals_issue_default_order( $query ){
    if( 'rr_issue' == $query->get('post_type') ){
        if( $query->get('order') == '' )
            $query->set('order','ASC');
    }
}

function the_single_issue_content_html( $issue_id, $issue_title, $issue_count ) {
	
	$icp_year_and_month        = CFS()->get( 'icp_year_and_month', $issue_id );
	$icp_doi                   = CFS()->get( 'icp_doi', $issue_id );
	$icp_page_number           = CFS()->get( 'icp_page_number', $issue_id );
	$icp_authors_names_loop    = CFS()->get( 'icp_authors_names', $issue_id );
	$ice_paper_category        = CFS()->get( 'ice_paper_category', $issue_id );
	$ice_subject               = CFS()->get( 'ice_subject', $issue_id );
	$ice_pdf_upload            = CFS()->get( 'ice_pdf_upload', $issue_id );
	$ice_google_drive_pdf_link = CFS()->get( 'ice_google_drive_pdf_link', $issue_id );
	$icp_abstract_content      = CFS()->get( 'icp_abstract_content', $issue_id );
	$postcat                   = get_article_category( $issue_id );
	?>
	<tr>
		<td colspan="3">
			<hr class="hr">
		</td>
	</tr>
	<tr valign="top" id="<?php echo "post-".$issue_id; ?>">
		<td id="ar_row_ind" align="right"><?php echo $issue_count; ?></td>				
		<td width="98%" valign="middle">
			<h2 class="citation_title"><a href="<?php echo esc_url(get_permalink($issue_id)); ?>"><?php echo $issue_title; ?></a></h2>
		</td>
	</tr>				
	<?php if( !empty( $icp_authors_names_loop  ) && is_array( $icp_authors_names_loop  ) ) { ?>
	<tr>
		<td></td>
		<td colspan="2">
		<?php
			$icp_loop = 1;
			$numItems = count( $icp_authors_names_loop );
			foreach ( $icp_authors_names_loop as $icp_authors_names ) {?>						
				<a href="#"><?php echo $icp_authors_names['icp_author_name']; ?></a>
				<sup><a href="#au1"><?php echo $icp_loop; ?></a></sup>
			<?php  if( $numItems != $icp_loop ) { echo '; ';} $icp_loop++; 
			} 
			?>
		</td>
	</tr>
	<?php } ?>
	<?php if( !empty( $ice_paper_category ) || !empty( $ice_subject ) || !empty( $icp_page_number ) ) { ?>
	<tr>
		<td></td>
		<td colspan="2" id="r_li_listing">
			<?php if( !empty( $ice_paper_category ) ) { ?>
				<span><strong>Category:</strong> <?php echo $ice_paper_category; ?></span> <strong>|</strong>
			<?php } ?>
			<?php if( !empty( $ice_subject ) ) { ?>
				<span><strong>Subject:</strong> <?php echo $ice_subject; ?></span> <strong>|</strong>
			<?php } ?>
			<?php if( !empty( $icp_page_number ) ) { ?>
				<span><strong>Page:</strong> <?php echo $icp_page_number; ?></span>
			<?php } ?>
		</td>
	</tr>
	<?php } ?>				
	<tr>
		<td></td>
		<?php					
		$file_id = CFS()->get( 'ice_pdf_upload',$issue_id ,array( 'format' => 'raw' ));					
		$fileSize = get_file_size($file_id);
		$abstract_after_line = false;
		?>
		<td colspan="2">
			<ul class="indLnk">
				<?php if( isset( $icp_abstract_content ) && !empty( $icp_abstract_content ) ) { ?>
				<li><a title="<?php echo $issue_title; ?>" href="<?php echo esc_url(get_permalink($issue_id)); ?>">Abstract</a></li>
				<?php $abstract_after_line = true; } ?>
				<?php if ( isset( $ice_google_drive_pdf_link ) && ! empty( $ice_google_drive_pdf_link ) ) { ?>
					<li>
						<?php if ( $abstract_after_line ) { echo '| '; } ?>
						<a title="<?php echo esc_attr( $issue_title ); ?>" href="<?php echo esc_url( $ice_google_drive_pdf_link ); ?>" target="_blank" class="pdf">PDF</a>
					</li>
				<?php } elseif ( isset( $ice_pdf_upload ) && ! empty( $ice_pdf_upload ) ) { ?>
					<li>
						<?php if ( $abstract_after_line ) { echo '| '; } ?>
						<a title="<?php echo esc_attr( $issue_title ); ?>" href="<?php echo $ice_pdf_upload; ?>" download target="_blank" class="pdf">PDF (<?php echo $fileSize; ?>)</a>
					</li>
				<?php } 
				
				$ice_mla 			= CFS()->get( 'ice_mla', $issue_id );
				$ice_apa 			= CFS()->get( 'ice_apa', $issue_id );
				$ice_chicago 		= CFS()->get( 'ice_chicago', $issue_id );
				$ice_harvard 		= CFS()->get( 'ice_harvard', $issue_id );
				$ice_vancouver 		= CFS()->get( 'ice_vancouver', $issue_id );
				if( !empty( $ice_mla ) || !empty( $ice_apa ) || !empty( $ice_chicago ) || !empty( $ice_harvard ) || !empty( $ice_vancouver ) ) {
				?>
				<li>| <a title="<?php echo $issue_title; ?>" class="cite_Btn" href="javascript:void(0);">Cite</a>
					<div class="cite_model modal">
					<span class="close">&times;</span>
					  <div class="modal-content">						
						<table class="cite-popup">
							<?php if( !empty( $ice_mla ) ) { ?>
							<tr>
								<td>MLA</td>
								<td><?php echo $ice_mla ; ?></td>
							</tr>
							<?php } 
							if( !empty( $ice_apa ) ) { ?>
							<tr>
								<td>APA</td>
								<td><?php echo $ice_apa ; ?></td>
							</tr>
							<?php } 
							if( !empty( $ice_chicago ) ) { ?>
							<tr>
								<td>CHICAGO</td>
								<td><?php echo $ice_chicago ; ?></td>
							</tr>
							<?php } 
							if( !empty( $ice_harvard ) ) { ?>
							<tr>
								<td>HARVARD</td>
								<td><?php echo $ice_harvard; ?></td>
							</tr>
							<?php } 
							if( !empty( $ice_vancouver ) ) { ?>
							<tr>
								<td>VANCOUVER</td>
								<td><?php echo $ice_vancouver; ?></td>
							</tr>
							<?php } ?>
						</table>
					  </div>
					</div>
				</li>
				<?php } ?>
			</ul>
		</td>
	</tr>
	<?php if( isset($icp_doi) && !empty($icp_doi) ){ ?>
	<tr>
		<td>
			<img id="img" src="<?php echo get_template_directory_uri(); ?>/assets/images/1024px-DOI_logo.svg.png">
		</td>
		<td>
			<a title="<?php echo $icp_doi; ?>" class="ico_doi_link" href="<?php echo $icp_doi; ?>"><?php echo $icp_doi; ?></a>
		</td>
	</tr>
	<?php } ?>
<?php
}

require 'select2_meta_box.php';
require 'taxonomy_backend_field.php';


function get_taxonomy_term(){
	 $tax_papers = get_terms('rr_cp_cat', 'hide_empty=1');
	 foreach( $tax_papers as $tax_paper ) : ?>
      <li><a href="<?php echo get_term_link( $tax_paper->slug, 'rr_cp_cat' ); ?>"><?php echo esc_html($tax_paper->name); ?></a></li>
    <?php endforeach; 
}

function get_post_count_by_page($page_num){
	if( $page_num != 1 ) {
		$display_count = 15;
		$offset = ( $page_num - 1 ) * $display_count;
		return $offset+1;
	}
	return $page_num;
	
}

/**
Special in sett offset.
*/
function special_offset_pregp_wpse_105496($qry) {
	if( is_admin() )
        return;
	
	if ($qry->is_main_query()) {
		$qry->set('posts_per_page',15);    
	}
}
add_action('pre_get_posts','special_offset_pregp_wpse_105496');


/**
 Search filter.
*/
function searchfilter($query) {
 
    if ($query->is_search && !is_admin() ) {		
        $query->set('post_type',array('post','page','rr_cp_post','rr_sp_paper_list','rr_special_issue','rr_issue'));
    }
 
return $query;
} 
add_filter('pre_get_posts','searchfilter');


/**
 * Register meta box(es).
 */
function wp_download_register_meta_boxes() {
    add_meta_box( 'download-submitted-id', __( 'Download Submitted Paper/ Resume', 'textdomain' ), 'submited_paper_download_callback', array('rr_submited_paper','hr_em') );
}
add_action( 'add_meta_boxes', 'wp_download_register_meta_boxes' );
 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function submited_paper_download_callback( $post ) {
    // Display code/markup goes here. Don't forget to include nonces!
	
    $paper_url = get_post_meta( $post->ID, 'attached_file_url', true );
    $email = get_post_meta( $post->ID, 'email_of_corresponding_author', true );
    if(!empty($paper_url)) {
    ?>	
	<a href="<?php echo esc_url($paper_url); ?>" download>Download here</a>
	<?php    
    } else {
    ?>	
	<a href="mailto:<?php echo $email; ?>">Please Contact to <strong>"<?php echo $email;?>"</strong> Becuase file is not upload propurly</a>
	<?php
    }
}

/**
* Add new columns for submitted paper.
**/
function set_custom_edit_rr_submited_paper_columns($columns) {
    unset( $columns['author'] );
    $columns['contact_no'] = __( 'Contact No.', 'rrjournals' );
    $columns['emails'] = __( 'Email', 'rrjournals' );
    $columns['first_author'] = __( '1st Author', 'rrjournals' );
    $columns['submission_date'] = __( 'Submitted Date', 'rrjournals' );

    return $columns;
}


/**
* Add new columns action for submitted paper.
**/
function custom_rr_submited_paper_column( $column, $post_id ) {
    switch ( $column ) {

        case 'contact_no' :
            echo get_post_meta( $post_id , 'contact_no' , true ); 
            break;

        case 'emails' :
            echo get_post_meta( $post_id , 'email_of_corresponding_author' , true ); 
            break;
		case 'first_author' :
            echo get_post_meta( $post_id , 'first_author_name' , true );             
            break;
		case 'submission_date' :            
            echo get_post_meta( $post_id , 'submitted_date' , true ); 
            break;
    }
}
add_filter( 'manage_rr_submited_paper_posts_columns', 'set_custom_edit_rr_submited_paper_columns' );
add_action( 'manage_rr_submited_paper_posts_custom_column' , 'custom_rr_submited_paper_column', 10, 2 );

/**
* Submitted order by date.
*
*/
function custom_submitted_paper_date_order( $query ) {	
	if( ! is_admin() )
        return;
 
    $orderby = $query->get( 'orderby');
    $post_type = $query->get( 'post_type');
	
    if('rr_submited_paper' == $post_type  ) {			
        $query->set('meta_key','submitted_date');
        $query->set('orderby','meta_value');
    }
}
add_filter( 'pre_get_posts' , 'custom_submitted_paper_date_order' );


function rrjournals_new_submit_paper_callback() {
	?>
	<style>
	.container-form form#rr_sp_form_id {
		width: 80%;
	}
	.container-form input[type=text],.container-form input[type=email], .container-form select	{
		box-sizing: border-box;
		resize: vertical;
	}

	.container-form input[type=submit],.container-form input[type=reset] {
		background-color: #003366;
		color: white;		
		border: none;		
		cursor: pointer;
		margin: 12px 6px;
	}

	.container-form input[type=subject]:hover ,.container-form input[type=reset]:hover {
		background-color: #003366;
		
	}

	.container-form {
		border-radius: 5px;
		padding: 20px;		
	}
	.container-form input[type=file] {
		resize: vertical;
		width: 100%;
	}
	.container-form select#article_type,.container-form select#subject_area {
		width: 100%;
	}

	.container-form input#first_name {
		width: 78%;
	}
	.container-form input[type=text], .container-form input[type=email] {
		width: 100%;
	}
	.rr_sp_response {
		text-align: center;
		margin-top:  20px;
		margin-right:  97px;
	}

	.success {
		color:  green;
	}

	input#captcha1 {
		width:  30%;
	}
	</style>
	<div class="container-form">
	<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" name="new_rr_sp_form_id" id="new_rr_sp_form_id" enctype="multipart/form-data">
		<table>
			<tr>
				<td>
					<label for="article_type">Article Type</label>
				</td>
				<td>
					<select class="" id="article_type" name="article_type">
						<option selected="" value="selectcard" disabled="disabled">--- Please select ---</option>
						<option value="Research Paper"> Research Paper </option>
						<option value="Review Paper"> Review Paper </option>						
						<option value="Article"> Article </option>						
						<option value="Short Communication"> Short Communication </option>						
						<option value="Case Study"> Case Study </option>						
					</select>
				</td>
			</tr>
			<tr>
				<td>
					<label for="subject_area">Subject Area</label>
				</td>
				<td>
					<select class="" id="subject_area" name="subject_area">
						<option selected="" value="selectcard" disabled="disabled">--- Please select ---</option>
						<option value="Agricultural Science">Agricultural Science </option>
						<option value="Anaesthesiology">Anaesthesiology </option>
						<option value="Anatomy">Anatomy </option>
						<option value="Anesthesiology">Anesthesiology </option>
						<option value="Arts">Arts </option>
						<option value="Ayurveda">Ayurveda </option>
						<option value="Biochemistry">Biochemistry </option>
						<option value="Biological Science">Biological Science </option>
						<option value="Botany">Botany </option>
						<option value="Cardiology">Cardiology </option>
						<option value="Chemical Science">Chemical Science </option>
						<option value="Chemistry">Chemistry </option>
						<option value="Clinical Research">Clinical Research </option>
						<option value="Clinical Science">Clinical Science </option>
						<option value="Commerce">Commerce </option>
						<option value="Community Medicine">Community Medicine </option>
						<option value="Computer Science">Computer Science </option>
						<option value="Cosmetology">Cosmetology </option>
						<option value="Dairy Technology">Dairy Technology </option>
						<option value="Dental Science">Dental Science </option>
						<option value="Dermatology">Dermatology </option>
						<option value="Diabetology">Diabetology </option>
						<option value="Drama">Drama </option>
						<option value="Earth Science">Earth Science </option>
						<option value="Economics">Economics </option>
						<option value="Education">Education </option>
						<option value="Electrotherapy">Electrotherapy </option>
						<option value="Endocrinology">Endocrinology </option>
						<option value="Endodontic">Endodontic </option>
						<option value="Engineering">Engineering </option>
						<option value="English">English </option>
						<option value="ENT">ENT </option>
						<option value="Entomology">Entomology </option>
						<option value="Environmental Science">Environmental Science </option>
						<option value="Epidemiology">Epidemiology </option>
						<option value="Foreignsic Science">Foreignsic Science </option>
						<option value="Forensic Medicine">Forensic Medicine </option>
						<option value="Forensic Science">Forensic Science </option>
						<option value="Forestry Science">Forestry Science </option>
						<option value="Gastroenterology">Gastroenterology </option>
						<option value="General Medicine">General Medicine </option>
						<option value="General Surgery">General Surgery </option>
						<option value="Genetics">Genetics </option>
						<option value="Geography">Geography </option>
						<option value="Gynaecology">Gynaecology </option>
						<option value="Gynecology">Gynecology </option>
						<option value="Hepatobiliary Surgery">Hepatobiliary Surgery </option>
						<option value="Hindi">Hindi </option>
						<option value="History">History </option>
						<option value="Home Science">Home Science </option>
						<option value="Homeopathic">Homeopathic </option>
						<option value="Immunohaematology">Immunohaematology </option>
						<option value="Immunohematology">Immunohematology </option>
						<option value="Immunology">Immunology </option>
						<option value="Information Technology">Information Technology </option>
						<option value="Journalism">Journalism </option>
						<option value="Law">Law </option>
						<option value="Linguistics">Linguistics </option>
						<option value="Management">Management </option>
						<option value="Mathematics">Mathematics </option>
						<option value="Media">Media </option>
						<option value="Medical Science">Medical Science </option>
						<option value="Medicine">Medicine </option>
						<option value="Microbiology">Microbiology </option>
						<option value="Morphology">Morphology </option>
						<option value="Nematology">Nematology </option>
						<option value="Neonatology">Neonatology </option>
						<option value="Nephrology">Nephrology </option>
						<option value="Neurology">Neurology </option>
						<option value="Neurosurgery">Neurosurgery </option>
						<option value="Nursing">Nursing </option>
						<option value="Obstetrics &amp; Gynaecology">Obstetrics &amp; Gynaecology </option>
						<option value="Obstetrics &amp; Gynecology">Obstetrics &amp; Gynecology </option>
						<option value="Oncology">Oncology </option>
						<option value="Ophthalmology">Ophthalmology </option>
						<option value="Oral Medicine">Oral Medicine </option>
						<option value="Oral Pathology">Oral Pathology </option>
						<option value="Orthodontology">Orthodontology </option>
						<option value="Orthopaedic">Orthopaedic </option>
						<option value="Orthopaedics">Orthopaedics </option>
						<option value="Orthopedics">Orthopedics </option>
						<option value="Otolaryngology">Otolaryngology </option>
						<option value="Paediatrics">Paediatrics </option>
						<option value="Pathology">Pathology </option>
						<option value="Pediatrics">Pediatrics </option>
						<option value="Periodontology">Periodontology </option>
						<option value="Pharma">Pharma </option>
						<option value="Pharmaceutical">Pharmaceutical </option>
						<option value="Pharmaceuticals">Pharmaceuticals </option>
						<option value="Pharmacology">Pharmacology </option>
						<option value="Pharmacy">Pharmacy </option>
						<option value="Physical Education">Physical Education </option>
						<option value="Physics">Physics </option>
						<option value="Physiology">Physiology </option>
						<option value="Physiotherapy">Physiotherapy </option>
						<option value="Plastic Surgery">Plastic Surgery </option>
						<option value="Political Science">Political Science </option>
						<option value="Prosthodontics">Prosthodontics </option>
						<option value="Radiodiagnosis">Radiodiagnosis </option>
						<option value="Radiology">Radiology </option>
						<option value="Rheumatology">Rheumatology </option>
						<option value="Sanskrit">Sanskrit </option>
						<option value="Social Science">Social Science </option>
						<option value="Sports Science">Sports Science </option>
						<option value="Statistics">Statistics </option>
						<option value="Surgery">Surgery </option>
						<option value="Tourism">Tourism </option>
						<option value="Unani Medicine">Unani Medicine </option>
						<option value="Urology">Urology </option>
						<option value="Veterinary Science">Veterinary Science </option>
						<option value="Zoology">Zoology </option>					
					</select>
				</td>
			</tr>			
			<tr>
				<td>
					<label for="title_of_the_paper ">Title of the paper <span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="title_of_the_paper" id="title_of_the_paper" maxlength="100 " size="30 ">
				</td>
			</tr>
			<tr>
				<td>
					<label for="first_author_name ">Name of 1<sup>st</sup> Author <span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="first_author_name" id="first_author_name" maxlength="50 " size="30 ">
				</td>
			</tr>
			<tr>
				<td>
					<label for="first_author_designation">Designation & Affiliation of 1<sup>St</sup> Author <span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="first_author_designation" id="first_author_designation">
				</td>
			</tr>
			<tr>
				<td>
					<label for="second_author_name ">Name of 2<sup>nd</sup> Author </label>
				</td>
				<td>
					<input type="text" name="second_author_name" id="second_author_name" maxlength="50 " size="30 ">
				</td>
			</tr>
			<tr>
				<td>
					<label for="second_author_designation">Designation & Affiliation of 2<sup>nd</sup> Author</label>
				</td>
				<td>
					<input type="text" name="second_author_designation" id="second_author_designation">
				</td>
			</tr>
			<tr>
				<td>
					<label for="third_author_name ">Name of 3<sup>rd</sup> Author </label>
				</td>
				<td>
					<input type="text" name="third_author_name" id="third_author_name" maxlength="50 " size="30 ">
				</td>
			</tr>
			<tr>
				<td>
					<label for="third_author_designation">Designation & Affiliation of 3<sup>rd</sup> Author</label>
				</td>
				<td>
					<input type="text" name="third_author_designation" id="third_author_designation">
				</td>
			</tr>
			<tr>
				<td>
					<label for="name_of_corresponding_author ">Name of Corresponding Author <span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="name_of_corresponding_author" id="name_of_corresponding_author">
				</td>
			</tr>
			<tr>
				<td>
					<label for="email_of_corresponding_author">Email of Corresponding Author <span class="error">*<span></label>
				</td>
				<td>
					<input type="text" name="email_of_corresponding_author" id="email_of_corresponding_author">
				</td>
			</tr>			
			<tr>
				<td>
					<label for="contact_no">Contact No. <span class="error">*<span></label>
				</td>
				<td>
					<input type="phone" name="contact_no" id="contact_no" maxlength="15" size="30">
				</td>
			</tr>
			<tr>
				<td>
					<label for="city_name">City</label>
				</td>
				<td>
					<input type="text" name="city_name" id="city_name" maxlength="80" size="30">
				</td>
			</tr>
			<tr>
				<td>
					<label for="state_name">State</label>
				</td>
				<td>
					<input type="text" name="state_name" id="state_name" maxlength="80" size="30">
				</td>
			</tr>
			<tr>
				<td>
					<label for="country_name">Country</label>
				</td>
				<td>
					<input type="text" name="country_name" id="country_name" maxlength="80" size="30">
				</td>
			</tr>
			<tr>
				<td>
					<label for="rr_sp_file">Upload MS-Word <span class="error">*<span></label>
				</td>
				<td>
					<input type="file" name="rr_sp_file" id="rr_sp_file" accept="application/msword">
				</td>
			</tr>
			
			<tr>
				<td>Enter Image Text:</td>
				<td>
					<div class="g-recaptcha" data-sitekey="6Ld_wmIUAAAAAFTWIkSZLgMOFWlVvg6BZ6-On3iV"></div>
				</td>
			</tr>
			<tr>
				<td style="text-align: right;">		
				    <?php
				    // Generate a custom nonce value.
	                $sp_form_meta_nonce = wp_create_nonce( 'rr_sp_meta_form_nonce' ); 
				    ?>
					<input type="hidden" name="action" value="sp_form_response">
		            <input type="hidden" name="sp_submit_meta_nonce" value="<?php echo $sp_form_meta_nonce ?>" />
					<input type="submit" name="submit" value="Submit">
				</td>
				<td style="text-align: left;">
					<input type="reset" name="resetform" id="resetform" value="Clear">
				</td>
			</tr>
		</table>
	</form>
	<?php
	echo "<pre>";
	print_r($_REQUEST);
	if( isset( $_GET['message'] ) && !empy( $_GET['message'] ) ) {
	?>
	<div class="rr_sp_response" id="rr_sp_response"><?php echo html_entity_decode($_GET['message']); ?></div>
	<?php
	}
	?>
	
	</div>
	<?php
}
add_shortcode( 'new_submit_paper_form', 'rrjournals_new_submit_paper_callback' );

//add_action( 'wp_ajax_sp_form_response', 'sp_form_response_callback');
//add_action( 'wp_ajax_nopriv_sp_form_response', 'sp_form_response_callback');
add_action( 'admin_post_sp_form_response', 'sp_form_response_callback');
add_action( 'admin_post_nopriv_sp_form_response', 'sp_form_response_callback');

function sp_form_response_callback(){
    if( isset( $_POST['sp_submit_meta_nonce'] ) && wp_verify_nonce( $_POST['sp_submit_meta_nonce'], 'rr_sp_meta_form_nonce') ) {
        
        if ( isset( $_POST['g-recaptcha-response'] ) && !recaptcha_validated() ) {
            $query_string = array(
                'response' => 'error',
                'message' => htmlentities( '<strong>ERROR</strong>: Please retry CAPTCHA' ),
            );
            wp_redirect(esc_url( add_query_arg( $query_string, get_permalink('5104') ) ));
	        exit;
        }
        
        $article_type 					= ( isset( $_POST['article_type'] ) && !empty( $_POST['article_type'] ) )? $_POST['article_type'] : '';
    	$subject_area 					= ( isset( $_POST['subject_area'] ) && !empty( $_POST['subject_area'] ) )? $_POST['subject_area'] : '';
    	$title_of_the_paper 			= ( isset( $_POST['title_of_the_paper'] ) && !empty( $_POST['title_of_the_paper'] ) )? sanitize_text_field( $_POST['title_of_the_paper'] ) : '';
    	$first_author_name 				= ( isset( $_POST['first_author_name'] ) && !empty( $_POST['first_author_name'] ) )? sanitize_text_field( $_POST['first_author_name'] ) : '';
    	$first_author_designation 		= ( isset( $_POST['first_author_designation'] ) && !empty( $_POST['first_author_designation'] ) )? sanitize_text_field( $_POST['first_author_designation'] ) : '';
    	$second_author_name 			= ( isset( $_POST['second_author_name'] ) && !empty( $_POST['second_author_name'] ) )? sanitize_text_field( $_POST['second_author_name'] ) : '';
    	$second_author_designation 		= ( isset( $_POST['second_author_designation'] ) && !empty( $_POST['second_author_designation'] ) )? sanitize_text_field( $_POST['second_author_designation'] ) : '';
    	$third_author_name 				= ( isset( $_POST['third_author_name'] ) && !empty( $_POST['third_author_name'] ) )? sanitize_text_field( $_POST['third_author_name'] ) : '';
    	$third_author_designation 		= ( isset( $_POST['third_author_designation'] ) && !empty( $_POST['third_author_designation'] ) )? sanitize_text_field( $_POST['third_author_designation'] ) : '';
    	$name_of_corresponding_author 	= ( isset( $_POST['name_of_corresponding_author'] ) && !empty( $_POST['name_of_corresponding_author'] ) )? sanitize_text_field( $_POST['name_of_corresponding_author'] ) : '';
    	$email_of_corresponding_author 	= ( isset( $_POST['email_of_corresponding_author'] ) && !empty( $_POST['email_of_corresponding_author'] ) )? sanitize_email( $_POST['email_of_corresponding_author'] ) : '';
    	$contact_no 					= ( isset( $_POST['contact_no'] ) && !empty( $_POST['contact_no'] ) )? sanitize_text_field( $_POST['contact_no'] ) : '';
    	$city_name 						= ( isset( $_POST['city_name'] ) && !empty( $_POST['city_name'] ) )? sanitize_text_field( $_POST['city_name'] ) : '';
    	$state_name 					= ( isset( $_POST['state_name'] ) && !empty( $_POST['state_name'] ) )? sanitize_text_field( $_POST['state_name'] ) : '';
    	$country_name			 		= ( isset( $_POST['country_name'] ) && !empty( $_POST['country_name'] ) )? sanitize_text_field( $_POST['country_name'] ) : '';
        
        
        $post_title_text = $title_of_the_paper;
        ob_start();
        ?>
        <table>
			<tr>
				<td><label for="article_type">Article Type</label></td>
				<td><?php echo esc_html($article_type); ?></td>
			</tr>
			<tr>
				<td><label for="subject_area">Subject Area</label></td>
				<td><?php echo esc_html($subject_area); ?></td>
			</tr>			
			<tr>
				<td><label for="title_of_the_paper ">Title of the paper </label></td>
				<td><?php echo esc_html($title_of_the_paper); ?></td>
			</tr>
			<tr>
				<td><label for="first_author_name ">Name of 1<sup>st</sup> Author <span class="error">*<span></label></td>
				<td><?php echo esc_html($first_author_name); ?></td>
			</tr>
			<tr>
				<td><label for="first_author_designation">Designation & Affiliation of 1<sup>St</sup> Author <span class="error">*<span></label></td>
				<td><?php echo esc_html($first_author_designation); ?></td>
			</tr>
			<tr>
				<td><label for="second_author_name ">Name of 2<sup>nd</sup> Author </label></td>
				<td><?php echo esc_html($second_author_name); ?></td>
			</tr>
			<tr>
				<td><label for="second_author_designation">Designation & Affiliation of 2<sup>nd</sup> Author</label></td>
				<td><?php echo esc_html($second_author_designation); ?></td>
			</tr>
			<tr>
				<td><label for="third_author_name ">Name of 3<sup>rd</sup> Author </label></td>
				<td><?php echo esc_html($third_author_name); ?></td>
			</tr>
			<tr>
				<td><label for="third_author_designation">Designation & Affiliation of 3<sup>rd</sup> Author</label></td>
				<td><?php echo esc_html($third_author_designation); ?></td>
			</tr>
			<tr>
				<td><label for="name_of_corresponding_author ">Name of Corresponding Author <span class="error">*<span></label></td>
				<td><?php echo esc_html($name_of_corresponding_author); ?></td>
			</tr>
			<tr>
				<td><label for="email_of_corresponding_author">Email of Corresponding Author <span class="error">*<span></label></td>
				<td><?php echo esc_html($email_of_corresponding_author); ?></td>
			</tr>			
			<tr>
				<td><label for="contact_no">Contact No. <span class="error">*<span></label></td>
				<td><?php echo esc_html($contact_no); ?></td>
			</tr>
			<tr>
				<td><label for="city_name">City</label></td>
				<td><?php echo esc_html($city_name); ?></td>
			</tr>
			<tr>
				<td><label for="state_name">State</label></td>
				<td><?php echo esc_html($state_name); ?></td>
			</tr>
			<tr>
				<td><label for="country_name">Country</label></td>
				<td><?php echo esc_html($country_name); ?></td>
			</tr>
		</table>
        <?php
        
        $content_html = ob_get_clean();
		
		$post_content_text = $designation. ' ' . $education . ' ' . $institutename . ' ' . $country_name;

		$post_id = wp_insert_post( array(
			'post_status' => 'draft',
			'post_type' => 'rr_submited_paper',
			'post_title' => $title_of_the_paper,
			'post_content' => $content_html,
		) );
		
		if( !$post_id ) {
		    $query_string = array(
                'response' => 'error',
                'message' => htmlentities( 'Please try again.' ),
            );
		}

		update_post_meta( $post_id, 'article_type',$article_type );
		update_post_meta( $post_id, 'subject_area',$subject_area );
		update_post_meta( $post_id, 'title_of_the_paper', $title_of_the_paper);
		update_post_meta( $post_id, 'first_author_name',$first_author_name );
		update_post_meta( $post_id, 'first_author_designation',$first_author_designation );
		update_post_meta( $post_id, 'second_author_name', $second_author_name);
		update_post_meta( $post_id, 'second_author_designation', $second_author_designation);
		update_post_meta( $post_id, 'third_author_name',$third_author_name );
		update_post_meta( $post_id, 'third_author_designation',$third_author_designation );
		update_post_meta( $post_id, 'name_of_corresponding_author',$name_of_corresponding_author );
		update_post_meta( $post_id, 'email_of_corresponding_author',$email_of_corresponding_author );
		update_post_meta( $post_id, 'contact_no',$contact_no );
		update_post_meta( $post_id, 'city_name',$city_name );
		update_post_meta( $post_id, 'state_name',$state_name );		
		update_post_meta( $post_id, 'country_name',$country_name );		
		$submitted_datetime = current_time( 'mysql' );
		update_post_meta( $post_id, 'submitted_date',$submitted_datetime);
        
        if(isset($_FILES['rr_sp_file']) && file_exists($_FILES['rr_sp_file']['tmp_name'])) {
          $uploadedFile = $_FILES['rr_sp_file'];

          //Get the uploaded file information
          $name_of_uploaded_file = basename($uploadedFile['name']);

          //get the file extension of the file
          $type_of_uploaded_file = substr($name_of_uploaded_file, strrpos($name_of_uploaded_file, '.') + 1);

          $size_of_uploaded_file = $uploadedFile["size"] / 1024; //size in KBs

          //Settings
          $max_allowed_file_size  = 2000; // size in KB
          $allowed_extensions     = array("jpg", "jpeg", "png", "pdf");
          $upload_overrides       = array( 'test_form' => false );

          //Validations
          if($size_of_uploaded_file > $max_allowed_file_size){
            $failedKeys[]     = 'rr_sp_file';
            $failedFields[]   = 'Uploaded File';
            $failedAttachment = true;
            $message = my_contact_form_generate_response("error", "Size of uploaded file should be less than ". round($max_allowed_file_size / 1024). "mb ");
            $query_string = array(
                'response' => 'error',
                'message' => htmlentities( $message ),
            );
          }
          
          //------ Validate the file extension 
          $allowed_ext = false;

          for($i = 0; $i <sizeof($allowed_extensions); $i++){
            if(strcasecmp($allowed_extensions[$i], $type_of_uploaded_file) == 0){
              $allowed_ext = true;
            }
          }

          if(!$allowed_ext) {
            $failedKeys[]     = 'attachmentFile';
            $failedFields[]   = 'Uploaded File';
            $failedAttachment = true;
            $message = my_contact_form_generate_response("error", "The uploaded file is not supported file type. Only the following file types are supported: ".implode(', ',$allowed_extensions));
            $query_string = array(
                'response' => 'error',
                'message' => htmlentities( $message ),
            );
            wp_redirect(esc_url( add_query_arg( $query_string, get_permalink('5104') ) ));
	        exit;
          }
          
          if( isset( $failedAttachment ) && true === $failedAttachment ) {
            $movefile = wp_handle_upload($uploadedFile, $upload_overrides);
            if($movefile && ! isset( $movefile['error'] ) ) {
                update_post_meta($post_id,'attached_file_id',$attach_id);
                $attachment_url = wp_get_attachment_url( $attach_id );
                update_post_meta($post_id,'attached_file_url',$attachment_url);
                $query_string = array(
                    'response' => 'success',
                    'message' => htmlentities( 'Your article/paper submitted successfully' ),
                );
                wp_redirect(esc_url( add_query_arg( $query_string, get_permalink('5104') ) ));
        	    exit;   
            } else {
                $query_string = array(
                    'response' => 'error',
                    'message' =>  'Your file is not uploaded. So Please contact with Site author.' ,
                );
                wp_redirect(esc_url( add_query_arg( $query_string, get_permalink('5104') ) ));
	            exit;
            }
          }
        }
        
        
		/*if( isset( $post_id ) && $post_id !=0 ) {
			$json_response = array(
				'message'  => 'Your article/paper submitted successfully…',
				'success'       => true
			);
		} else {
			$json_response = array(
				'message'  => 'Your profile is sumitted faild. Please try again.',
				'success'       => false
			);
		}*/
        
		// do the processing
		// add the admin notice
		$admin_notice = "success";
		// redirect the user to the appropriate page
		$query_string = array(
            'response' => 'success',
            'message' => htmlentities('Your profile is sumitted faild. Please try again.'),
        );
		wp_redirect(esc_url( add_query_arg( $query_string, get_permalink('5104') ) ));
	    exit;
	}			
	else {
		$query_string = array(
            'response' => 'error',
            'message' => htmlentities('Invalid nonce specified'),
        );
        wp_redirect(esc_url( add_query_arg( $query_string, get_permalink('5104') ) ));
	    exit;
	}

	wp_redirect(esc_url( add_query_arg( $query_string, get_permalink('5104') ) ));
	exit;
}

function my_contact_form_generate_response($type, $message){
    global $response;

    if($type == "success") { 
        $response = "<div class='success alert alert-success' role='alert' id='success-message'>{$message} <i class='glyphicon glyphicon-thumbs-up'></i></div>";
    } else { 
        $response = "<div class='error alert alert-danger' role='alert' id='error-message'>{$message} <i class='glyphicon glyphicon-thumbs-down'></i> </div>";
  
    }
    return $response;
}
function recaptcha_validated(){
    if( empty( $_POST['g-recaptcha-response'] ) ) return FALSE;
    $response = wp_remote_get( add_query_arg( array(
                                              'secret'   => '6Ld_wmIUAAAAAGiYmCowM2i5N-e7plSH78Dz0634',
                                              'response' => isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '',
                                              'remoteip' => isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']
                                          ), 'https://www.google.com/recaptcha/api/siteverify' ) );

    if( is_wp_error( $response ) || empty($response['body']) || ! ($json = json_decode( $response['body'] )) || ! $json->success ) {
        //return new WP_Error( 'validation-error',  __('reCAPTCHA validation failed. Please try again.' ) );
        return FALSE;
    }

    return TRUE;
}

function get_id_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if ($page) {
		return $page->ID;
	} else {
		return null;
	}
}

function rr_custom_pagination( $query ){
	$big = 999999999; // need an unlikely integer
	echo paginate_links( array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '/paged=%#%',  // if using pretty permalink
	    'current' => max( 1, get_query_var('paged') ),
		'total' => $query->max_num_pages ) );
}

function rr_change_posttype($query) {
	if( isset($query->tax_query->queries) && !empty($query->tax_query->queries) && is_array($query->tax_query->queries) && !is_admin() ) {
	  set_query_var( 'post_type', array( 'rr_cp_post', 'rr_cp_cat' ) );
	}
	return;
}
add_action( 'parse_query', 'rr_change_posttype',10,1 );

/**
 * Books functionality
 */
locate_template('hr-dev/hr-dev-books-functions.php',true);
