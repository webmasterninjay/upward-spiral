<?php

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );
include_once( get_stylesheet_directory() . '/lib/theme-options.php' );
include_once( get_stylesheet_directory() . '/lib/theme-cpt.php' );
include_once( get_stylesheet_directory() . '/lib/theme-widgets.php' );

// Set Localization (do not remove).
add_action( 'after_setup_theme', 'upward_spiral_localization_setup' );
function upward_spiral_localization_setup(){
	load_child_theme_textdomain( 'upward-spiral', get_stylesheet_directory() . '/languages' );
}

// Add the helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Add WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the required WooCommerce styles and Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Add the Genesis Connect WooCommerce notice.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Upward Spiral Consulting' );
define( 'CHILD_THEME_URL', 'http://webpagesthatsell.com/' );
define( 'CHILD_THEME_VERSION', '2.3.0' );

// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'upward_spiral_enqueue_scripts_styles' );
function upward_spiral_enqueue_scripts_styles() {

	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'upward-spiral-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'upward-spiral-responsive-menu',
		'genesis_responsive_menu',
		upward_spiral_responsive_menu_settings()
	);

	// bx slider
	wp_enqueue_script( 'upward-spiral-bxslider', get_stylesheet_directory_uri() . "/lib/bxslider/jquery.bxslider.min.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_enqueue_style( 'upward-spiral-bxslider', get_stylesheet_directory_uri() . "/lib/bxslider/jquery.bxslider.min.css", array(), CHILD_THEME_VERSION, true );

}

// Define our responsive menu settings.
function upward_spiral_responsive_menu_settings() {

	$settings = array(
		'mainMenu'          => __( 'Menu', 'upward-spiral' ),
		'menuIconClass'     => 'dashicons-before dashicons-menu',
		'subMenu'           => __( 'Submenu', 'upward-spiral' ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'       => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'           => 180,
	'height'          => 208,
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'flex-height'     => true,
	'default-image'		=> get_stylesheet_directory_uri() . '/images/logo.png',
) );

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 4 );

// Add Image Sizes.
add_image_size( 'featured-image', 720, 400, TRUE );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Header Menu', 'upward-spiral' ) ) );

// Reposition the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header_right', 'genesis_do_nav' );

// Reduce the secondary navigation menu to one level depth.
add_filter( 'wp_nav_menu_args', 'upward_spiral_secondary_menu_args' );
function upward_spiral_secondary_menu_args( $args ) {

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;

}

// Modify size of the Gravatar in the author box.
add_filter( 'genesis_author_box_gravatar_size', 'upward_spiral_author_box_gravatar' );
function upward_spiral_author_box_gravatar( $size ) {
	return 90;
}

// Modify size of the Gravatar in the entry comments.
add_filter( 'genesis_comment_list_args', 'upward_spiral_comments_gravatar' );
function upward_spiral_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;

	return $args;

}

// Unregister sidebar/content layout setting
genesis_unregister_layout( 'sidebar-content' );

// Unregister content/sidebar/sidebar layout setting
genesis_unregister_layout( 'content-sidebar-sidebar' );

// Unregister sidebar/sidebar/content layout setting
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Unregister sidebar/content/sidebar layout setting
genesis_unregister_layout( 'sidebar-content-sidebar' );

// Remove the header right widget area
unregister_sidebar( 'header-right' );

// Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

// Top header
add_action('genesis_before_header','upward_spiral_top_header', 5);
function upward_spiral_top_header() {
	$usc_phone = strip_tags( genesis_get_option('upward-spiral-phone', 'upward-spiral-settings') );
	if ( empty($usc_phone) ) return;

	?>
	<div class="top-header">
		<div class="wrap">
			<p><span class="dashicons dashicons-phone"></span> <?php echo $usc_phone; ?></p>
		</div>
	</div>
	<?php
}

// Nav extra
add_filter( 'wp_nav_menu_items', 'theme_menu_extras', 10, 2 );
function theme_menu_extras( $menu, $args ) {
	// Change 'primary' to 'secondary' to add extras to the secondary navigation menu
	if ( 'primary' !== $args->theme_location )
		return $menu;


	$usc_appointment = genesis_get_option('upward-spiral-appointment', 'upward-spiral-settings');

	if (! $usc_appointment)
		return $menu;

	$menu .= '<li class="right appointment-page"><a href="' . $usc_appointment . '" title="'.__('Contact','upward-spiral').'">'.__('Contact','upward-spiral').'</a></li>';

	return $menu;
}

// Register front-welcome widget area
genesis_register_widget_area(
	array(
		'id'          => 'front-welcome',
		'name'        => __( 'Front - Welcome', 'upward-spiral' ),
		'description' => __( 'Diplay widgets on homepage welcome area.', 'upward-spiral' ),
	)
);

// Register front-signup widget area
genesis_register_widget_area(
	array(
		'id'          => 'front-signup',
		'name'        => __( 'Front - Signup', 'upward-spiral' ),
		'description' => __( 'Display widget on homepage sign up area.', 'upward-spiral' ),
	)
);

// Register front-services widget area
genesis_register_widget_area(
	array(
		'id'          => 'front-services',
		'name'        => __( 'Front - Services', 'upward-spiral' ),
		'description' => __( 'Display widget on homepage services area.', 'upward-spiral' ),
	)
);

// Register front-about widget area
genesis_register_widget_area(
	array(
		'id'          => 'front-about',
		'name'        => __( 'Front - About', 'upward-spiral' ),
		'description' => __( 'Display widgets on homepage about page area.', 'upward-spiral' ),
	)
);

// Register front-blog widget area
genesis_register_widget_area(
	array(
		'id'          => 'front-blog',
		'name'        => __( 'Front - Blog', 'upward-spiral' ),
		'description' => __( 'Display widgets on homepage recent blog posts.', 'upward-spiral' ),
	)
);

// Register front-organizations widget area
genesis_register_widget_area(
	array(
		'id'          => 'front-organizations',
		'name'        => __( 'Front - Organizations', 'upward-spiral' ),
		'description' => __( 'Display widgets on homepage organization area.', 'upward-spiral' ),
	)
);

add_image_size( 'front-blog-thumbnail', 624, 468, true );

// Customize the entire footer
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'sp_custom_footer' );
function sp_custom_footer() {
	?>
	<p>&copy; Copyright <?php echo date('Y'); ?> &middot; <a href="<?php echo home_url(); ?>"><?php echo get_bloginfo('name');?></a> &middot; <?php echo __('All Rights Reserved.','upward-spiral'); ?></p>
	<?php
}

//* Customize search form input button text
add_filter( 'genesis_search_button_text', 'bg_search_form_button_text' );
function bg_search_form_button_text( $text ) {
	return esc_attr( 'Go' );
}

//* Remove the entry footer markup (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

//* Remove the entry meta in the entry footer (requires HTML5 theme support)
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

//* Customize the entry meta in the entry header
add_filter( 'genesis_post_info', 'bg_entry_meta_header' );
function bg_entry_meta_header($post_info) {
	$post_info = 'Posted [post_date] // by [post_author_posts_link] [post_edit]';
	return $post_info;
}

remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );


//* Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'sp_read_more_link' );
add_filter( 'the_content_more_link', 'sp_read_more_link' );
function sp_read_more_link() {
	return '<a class="more-link more-btn" href="' . get_permalink() . '">Read More</a>';
}

// shortcodes
function upward_spiral_hr() {
	return '<div class="hr"></div>';
}
add_shortcode('hr','upward_spiral_hr');

function upward_spiral_clearfix() {
	return '<div class="clearfix"></div>';
}
add_shortcode('clear','upward_spiral_clearfix');

function upward_spiral_div_shortcode( $atts ) {

	$atts = shortcode_atts( array(
		'class' => '',
		'id'    => '',
	), $atts, 'div-shortcode' );

	$return = '<div';
	if ( !empty( $atts['class'] ) )
		$return .= ' class="'. esc_attr( $atts['class'] ) .'"';
	if ( !empty( $atts['id'] ) )
		$return .= ' id="'. esc_attr( $atts['id'] ) .'"';
	$return .= '>';
	return $return;
}
add_shortcode( 'div', 'upward_spiral_div_shortcode' );

function upward_spiral_end_div_shortcode( $atts ) {
	return '</div>';
}
add_shortcode( 'end-div', 'upward_spiral_end_div_shortcode' );
