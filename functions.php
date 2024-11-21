<?php
/**
 * Viva Master functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Viva_Master
 */

define('VTROOT', get_template_directory_uri(__FILE__));


if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

//for correct work integration elements - required to be at top for funtion work
require_once ABSPATH . 'wp-admin/includes/plugin.php';


//debug function
if (!function_exists('dd')) {
    function dd($var, $die = true)
    {
        // echo '<pre>';
        // print_r($die);
        // echo '</pre>';
        echo '<pre>';
        print_r($var);
        echo '</pre>';
        if ($die ) {
            die();
        }

    }
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function viva_master_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Viva Master, use a find and replace
		* to change 'viva-master' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'viva-master', get_template_directory() . '/languages' );

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
			'menu-1' => esc_html__( 'Primary', 'viva-master' ),
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
/*
//dev
 	add_theme_support(
		'custom-background',
		apply_filters(
			'viva_master_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);*/

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
	//vv funcs
	//
}

add_action( 'after_setup_theme', 'viva_master_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function viva_master_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'viva_master_content_width', 640 );
}
add_action( 'after_setup_theme', 'viva_master_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function viva_master_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'viva-master' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'viva-master' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Left', 'viva-master' ),
			'id'            => 'sidebar-11',
			'description'   => esc_html__( 'Add widgets here.', 'viva-master' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Center', 'viva-master' ),
			'id'            => 'sidebar-12',
			'description'   => esc_html__( 'Add widgets here.', 'viva-master' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Right', 'viva-master' ),
			'id'            => 'sidebar-13',
			'description'   => esc_html__( 'Add widgets here.', 'viva-master' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'viva_master_widgets_init' );





/**
 * theme kit functions
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function v_user_got_kit($id) {
	if (is_plugin_active( 'woocommerce/woocommerce.php')) {
		if (is_user_logged_in()) {
		    global $woocommerce;
		    $user_id = get_current_user_id();
		    $current_user= wp_get_current_user();
		    $customer_email = $current_user->email; 
			if ( wc_customer_bought_product( $customer_email, $user_id, $id )) {  
			   return true;
			 }else{
			   return false;  
			 }
		}
	}

}
add_action( 'woocommerce_after_shop_loop_item', 'v_user_got_kit', 30 );

//removes admin bar for not admin//todo add it as option
function remove_admin_login_header() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'remove_admin_login_header');


// show element if 0-show in all, 1-selected, 2 on all exept selected
function v_show($tp,$ids){
	$pid = get_the_ID();
	if ($tp == 1 ) {
		// code...
	} elseif ($tp == 2) {
		if (in_array($pid, $ids)) {
		    return false;
		}else{
			return true;
		}
	} else {
		return true;
	}
}
/**
 * Enqueue scripts and styles.
 */
function viva_master_scripts() {
	wp_enqueue_style( 'viva-master-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( 'viva-fa', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css', array(), _S_VERSION );
	wp_enqueue_style( 'viva-uikit', get_template_directory_uri() . '/assets/css/uikit.css', array(), _S_VERSION );
	wp_enqueue_style( 'viva-style', get_template_directory_uri() . '/assets/css/style.css', array(), _S_VERSION ); //dev master
	wp_enqueue_style( 'viva-st1', 'http://vivapro.net/wp-content/themes/storefront/assets/css/style.css', array(), _S_VERSION ); //child
	//wp_enqueue_style( 'viva-dev', site_url() . '/wp-content/plugins/viva-theme-maker/assets/css/style.css', array(), _S_VERSION );//dev only
	wp_style_add_data( 'viva-master-style', 'rtl', 'replace' );
	wp_enqueue_script( 'viva-master-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'viva-uikit', get_template_directory_uri() . '/assets/js/uikit.min.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'viva-script', get_template_directory_uri() . '/assets/js/viva.js', array('jquery'), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'viva_master_scripts' );




//incs-------

require get_template_directory() . '/inc/autoload.php';

require get_template_directory() . '/inc/custom-header.php';


require get_template_directory() . '/inc/template-tags.php';

//Functions which enhance the theme by hooking into WordPress.

require get_template_directory() . '/inc/template-functions.php';

require get_template_directory() . '/inc/customizer.php';


if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

 //todo temp debugging function



//my
require get_template_directory() . '/inc/class-theme.php';
$GLOBALS['vv'] = new Viva_Theme();

