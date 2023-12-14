<?php
/**
 * automate life functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package automate_life
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if(!defined('company_socials')) {
	$urls = array(
		'twitter-social-url', 'facebook-social-url', 'tiktok-social-url', 'youtube-social-url',
		'pinterest-social-url', 'instagram-social-url',
	);

	define('COMPANY_SOCIALS_URLS', $urls);
}

if(!defined('site_layout_space')) {
	define('site_layout_space', strtolower(get_option('layout-space')));
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function automate_life_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on automate life, use a find and replace
		* to change 'automate-life' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'automate-life', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
        array(
            'primary_menu'   => esc_html__('Primary Menu', 'automate-life'),
            'footer_menu'    => esc_html__('Footer Menu', 'automate-life'),
            'off_canvas_menu' => esc_html__('Off Canvas Menu', 'automate-life'),
        )
    );

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
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

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'automate_life_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'automate_life_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function automate_life_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'automate_life_content_width', 640 );
}
add_action( 'after_setup_theme', 'automate_life_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function automate_life_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'automate-life' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'automate-life' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'automate_life_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function automate_life_scripts() {
	wp_enqueue_style( 'automate-life-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'automate-life-style', 'rtl', 'replace' );
	wp_enqueue_style( 'automate-life-bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '5.3.2', 'all' );
	wp_enqueue_style( 'automate-life-bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css', array(), '5.3.2', 'all' );
	wp_enqueue_style( 'automate-life-template-style', get_template_directory_uri() . '/assets/css/style.css', array(), _S_VERSION, 'all' );
	
	$styleFilePath = get_template_directory() . '/global-options-styles.css';
	if (file_exists($styleFilePath)) {
		// Enqueue the style only if the file exists
		wp_enqueue_style('global-options-styles', get_template_directory_uri() . '/global-options-styles.css', array(), '1.0', 'all');
	} else {
		/*
		 *** Log a warning message in case 
		 *** global options style file is not found */

		echo "Warning: The style file 'global-options-styles.css' was not found.";
	}
	
	wp_enqueue_script( 'automate-life-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'automate_life_scripts' );

/**
 * Enqueue scripts and styles in admin dashboard.
 */
function automate_life_admin_scripts() {
	
	if ( isset( $_GET['page'] ) && $_GET['page'] === 'automate-life-settings' ) {
        wp_enqueue_style( 'automate-life-bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', array(), '5.3.2', 'all' );
		wp_enqueue_script('automate-life-bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.2', true);
    }
	
	wp_enqueue_style( 'automate-life-template-style', get_template_directory_uri() . '/assets/css/style.css', array(), _S_VERSION, 'all' );
	wp_enqueue_style( 'automate-life-bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css', array(), '1.11.2', 'all' );
	// Enqueue your script
	wp_enqueue_script('automate-life-script', get_template_directory_uri() . '/assets/js/script.js?unique='.time(), array(), _S_VERSION, true);
	// Enqueue WordPress Media Script
	if (!did_action('wp_enqueue_media')) {
        wp_enqueue_media();
    }
	// Localize the script for Ajax
	wp_localize_script('automate-life-script', 'admin_ajax', array('ajax_url' => admin_url('admin-ajax.php')));

}
add_action( 'admin_enqueue_scripts', 'automate_life_admin_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
/**
 * Add options page in WordPress dashboard
 */
function automate_life_add_options_page() {
	add_theme_page(
        'Automate Life',
        'Automate Life', 
        'manage_options',
        'automate-life-settings', 
        'custom_theme_page_content'
    );
}

// Callback function to display the content of the custom page
function custom_theme_page_content() {
	require_once get_template_directory() . '/template-parts/options-page.php';
	echo automate_life_options_page();
}

// Hook to add the options page to the "Appearance" menu
add_action('admin_menu', 'automate_life_add_options_page');


// AJAX callback
function automate_life_create_css_callback() {
    $options = isset($_POST['optionsArr']) ? $_POST['optionsArr'] : array();
	$response = array();
    // Access values like this
    $optionsArr = array(
        'base_font_size' => $options['font-size-dropdown'],
        'h1_font_size' => $options['h1-font-size'],
        'body_font_family' => $options['body-font-family'],
        'heading_font_family' => $options['heading-font-family'],
        'base_logo_height' => $options['change-logo-height'],
		'apply-to-h1-headings' => $options['apply-to-h1-headings'],
		'featured-image-size' => $options['featured-image-siz'],
		'hide-promotion-footer-links' => $options['hide-promotion-footer-links'],
		'site-primary-color' => $options['site-primary-color'],
		'site-secondary-color' => $options['site-secondary-color'],
		'site-accent-color' => $options['site-accent-color'],
		'site-h1-color' => $options['site-h1-color'],
		'apply-colors-to-h1-headings' => $options['apply-colors-to-h1-headings'],
		'display-blog-featured-images' => $options['display-blog-featured-images'],
		'hide-blog-featured-images-from-small-screen' => $options['hide-blog-featured-images-from-small-screen'],
		'post-meta-display-date' => $options['post-meta-display-date'],
		'footer-copyright-text' => $options['footer-copyright-text'],
		'enable-search-bar' => $options['enable-search-bar'],
		'display-tag-links' => $options['display-tag-links'],
		'article-navigation' => $options['article-navigation'],
		'enable-trellis-comments' => $options['enable-trellis-comments'],
		'layout-space' => $options['layout-space'],
		'facebook-social-url' => $options['facebook-social-url'],
		'instagram-social-url' => $options['instagram-social-url'],
		'twitter-social-url' => $options['twitter-social-url'],
		'pinterest-social-url' => $options['pinterest-social-url'],
		'tiktok-social-url' => $options['tiktok-social-url'],
		'youtube-social-url' => $options['youtube-social-url'],
    );

  // Iterate through options and create CSS rules
$cssContent = '';

foreach ($optionsArr as $selector => $value) {
    if ($selector === 'base_font_size') {
        $cssContent .= "body {\n" .
            "    font-size: $value;\n" .
            "}\n";
    } else if ($selector === 'body_font_family') {
		$decodedFontFamily = preg_replace('/[\\\\]/', '', $value);
        $cssContent .= "body {\n" .
            "    font-family: $decodedFontFamily;\n" .
            "}\n";
    } else if ($selector === 'h1_font_size') {
        $cssContent .= "h1 {\n" .
            "    font-size: $value;\n" .
            "}\n";
    } else if ($selector === 'heading_font_family') {
        $decodedHeadingFontFamily = preg_replace('/[\\\\]/', '', $value);
        $cssContent .= "h1, h2, h3, h4, h5, h6 {\n" .
            "    font-family: $decodedHeadingFontFamily;\n" .
            "}\n";
    } else if ($selector === 'base_logo_height') {
        $cssContent .= ".site-logo img, .site-branding img {\n" .
            "    height: $value;\n" .
			"    object-fit: contain;\n".
            "}\n";
    } else if ($selector === 'apply-to-h1-headings' && intval($value) === 1) {
		$h1FontSize = $optionsArr['h1_font_size'];
		$cssContent .= "h1, h2, h3, h4, h5, h6 {\n" .
			"    font-size: $h1FontSize;\n" .
			"}\n";
	}else if ($selector === 'featured-image-size' && intval($value) === 1) {
		$featuredImageSize = $optionsArr['featured-image-size'];
        $cssContent .= ".post-thumbnail-wrap {\n" .
            "    height: $featuredImageSize\n" .
            "}\n";
    } else if ($selector === 'hide-promotion-footer-links' && intval($value) === 1) {
        $cssContent .= ".hidden-footer-promotion {\n" .
            "    display: none;\n" .
            "}\n";
    }else if($selector === 'site-primary-color') {
		$cssContent .= ".bg-primary, button {\n" .
            "    background-color: $value !important;\n" .
            "}\n";
			$cssContent .= ".text-primary-user, a, .text-link, a[href] {\n" .
			"    color: $value;\n" .
			"}\n";
	}else if($selector === 'site-secondary-color') {
		$cssContent .= ".bg-secondary, button {\n" .
            "    background-color: $value !important;\n" .
            "}\n";
			$cssContent .= ".text-secondary {\n" .
			"    color: $value !important;\n" .
			"}\n";
	}else if($selector === 'site-accent-color') {
		$cssContent .= ".bg-accent, button {\n" .
            "    background-color: $value !important;\n" .
            "}\n";
			$cssContent .= ".text-accent,a, .text-link, a[href] {\n" .
			"    color: $value;\n" .
			"}\n";
	}else if($selector === 'site-h1-color') {
		$cssContent .= ".bg-headings-color {\n" .
            "    background-color: $value !important;\n" .
            "}\n";
			$cssContent .= ".text-headings-color, h1 {\n" .
			"    color: $value;\n" .
			"}\n";
	}else if($selector === 'apply-colors-to-h1-headings' && intval($value) === 1) {
		$colorValue = $optionsArr['site-h1-color'];
		$cssContent .= "h1, h2, h3, h4, h5, h6 {\n" .
            "    color: $colorValue !important;\n" .
            "}\n";
	}else if($selector === 'hide-blog-featured-images-from-small-screen') {
		$cssContent .= "@media (max-width: 575px) {\n".
			"    .thumbnail-mobile-hidden {\n".
			"        display: none !important;\n".
			"    }\n".
			"}\n";
	}else if($selector === 'layout-space') {
		if($value === 'Comfortable') {
			$cssContent .= ".layout-space {\n" .
				"    margin-top: 6px !important;\n" .
				"    margin-bottom: 12px !important;\n" .
				"}\n";
		}else if($value === 'Compact'){
			$cssContent .= ".layout-space {\n" .
				"    margin-top: 24px !important;\n" .
				"    margin-bottom: 48px !important;\n" .
				"}\n";
		}
	}
}

    // Path to the CSS file
    $cssFilePath = get_template_directory() . '/global-options-styles.css';

    // Save the CSS content to the file
    file_put_contents($cssFilePath, $cssContent);

    // Optionally, enqueue the dynamically generated CSS file in your theme
    
    foreach ($optionsArr as $key => $value) {
		if(in_array($key, ['facebook-social-url','instagram-social-url','twitter-social-url',
		'tiktok-social-url','pinterest-social-url', 'youtube-social-url']) && !empty($value)) {
			$filteredValue = filter_var($value, FILTER_VALIDATE_URL);
			
			// If the social url is valid
			if($filteredValue) {
				update_option($key, $value);
			}else {
				$response = array(
					'response' => 'Please correct the entered urls',
				);
			}
		}else {
			update_option($key, $value);
		}
    }

	echo json_encode($response);

    wp_die();
}

// Hook the AJAX callback function
add_action('wp_ajax_automate_life_create_css', 'automate_life_create_css_callback');
add_action('wp_ajax_nopriv_automate_life_create_css', 'automate_life_create_css_callback');

// Update site logo in response to update site logo option in control panel
add_action('wp_ajax_automate_life_update_site_logo', 'automate_life_update_site_logo_callback');
add_action('wp_ajax_nopriv_automate_life_update_site_logo', 'automate_life_update_site_logo_callback');
function automate_life_update_site_logo_callback() {
    $id = isset($_REQUEST['LogoId']) ? $_REQUEST['LogoId'] : null;
    $removeAction = isset($_REQUEST['removeAction']) ? $_REQUEST['removeAction'] : 'false'; // Default to 'false' if not set

	
    // Convert 'null' string to null
	$id = (strtolower($id) === 'null' || empty(trim($id))) ? null : trim($id);
    // Convert 'true' or 'false' strings to actual booleans
    $removeAction = filter_var($removeAction, FILTER_VALIDATE_BOOLEAN);

    if(is_null($id) && $removeAction === true) {
		delete_option('site_logo');
		$response = array(
			'response' => 'Site Logo Removed',
			'status' => 3,
		);

	}else if(!is_null($id) && $removeAction === false) {
		update_option('site_logo', $id);
		$response = array(
			'response' => 'Site Logo Updated',
			'status' => 1,
		);
	}

	echo json_encode($response);

    wp_die();
}