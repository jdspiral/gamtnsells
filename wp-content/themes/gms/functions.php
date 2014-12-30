<?php
/**
 * Georgia Mountain Sales child theme
 *
 * @package      Georgia Mountain Sales
 * @license      GPL-2.0+
 */

// Start the engine
include_once( get_template_directory() . '/lib/init.php' );

// Set Localization (do not remove)
load_child_theme_textdomain( 'wap', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'wap' ) );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Winning Agent Pro Theme' );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/winning-agent/' );
define( 'CHILD_THEME_VERSION', '1.0' );

// Include custom functions
include_once( get_stylesheet_directory() . '/lib/post-types.php' );
include_once( get_stylesheet_directory() . '/lib/widgets/wap-widgets.php' );

// Add HTML5 markup structure
add_theme_support( 'html5' );

// Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom background
add_theme_support( 'custom-background', array(
	'wp-head-callback' => '__return_false' )
);

// Add support for custom header
add_theme_support( 'custom-header', array(
	'width'           => 300,
	'height'          => 80,
	'header-selector' => '.site-title a',
	'header-text'     => false
) );

// Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array(
	'header',
	'nav',
	'subnav',
	'home-featured',
	'site-inner',
	'footer-widgets',
	'footer'
) );

// Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'wap-blue'   => __( 'Winning Agent Pro Blue/Green', 'wap' ),
	'wap-red'    => __( 'Winning Agent Pro Red/Gray', 'wap' ),
	'wap-orange' => __( 'Winning Agent Pro White/Orange', 'wap' ),
) );

// Add support for 2-column footer widgets
add_theme_support( 'genesis-footer-widgets', 4 );

// Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );

// Unregister unused site layouts
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );

// Remove site description
remove_action( 'genesis_site_description', 'genesis_seo_site_description' );

// Add custom image sizes
add_image_size( 'feature-community', 440, 300, true );
add_image_size( 'feature-small', 340, 140, true );
add_image_size( 'feature-wide', 740, 285, true );

// Register the default widget areas
wap_register_widget_areas();

/**
 * Register the widget areas enabled by default in Winning Agent Pro.
 * Applies the `wap_default_widget_areas` filter.
 */
function wap_register_widget_areas() {

	$widget_areas = array(
		'home-welcome'    => array(
			'id'          => 'home-welcome',
			'name'        => __( 'Home Welcome', 'wap' ),
			'description' => __( 'This is the home welcome section at the top of the home page.', 'wap' ),
		),
		'search-bar'      => array(
			'id'          => 'search-bar',
			'name'        => __( 'Search Bar', 'wap' ),
			'description' => __( 'This is the search bar under the header.', 'wap' ),
		),
		'home-featured-1' => array(
			'id'          => 'home-featured-1',
			'name'        => __( 'Home Featured 1', 'wap' ),
			'description' => __( 'This is the 1st featured section in the middle of the home page.', 'wap' ),
		),
		// 'home-featured-2' => array(
		// 	'id'          => 'home-featured-2',
		// 	'name'        => __( 'Home Featured 2', 'wap' ),
		// 	'description' => __( 'This is the 2nd featured section in the middle of the home page.', 'wap' ),
		// ),
		// 'home-featured-3' => array(
		// 	'id'          => 'home-featured-3',
		// 	'name'        => __( 'Home Featured 3', 'wap' ),
		// 	'description' => __( 'This is the 3rd featured section in the middle of the home page.', 'wap' ),
		// ),
		'home-listings'   => array(
			'id'          => 'home-listings',
			'name'        => __( 'Home Listings', 'wap' ),
			'description' => __( 'This is the listings section in the middle of the home page.', 'wap' ),
		),
		'home-communities'=> array(
			'id'          => 'home-communities',
			'name'        => __( 'Home Communities', 'wap' ),
			'description' => __( 'This is the communities section at the bottom of the home page.', 'wap' ),
		),
	);

	$widget_areas = apply_filters( 'wap_default_widget_areas', $widget_areas );

	foreach( $widget_areas as $widget_area ) {
		genesis_register_sidebar( $widget_area );
	}
}

// Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'wap_enqueue_scripts_styles' );
function wap_enqueue_scripts_styles() {

	// Enqueue the Google Web Font styles
	wp_enqueue_style( 'wap-google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700,900', array(), CHILD_THEME_VERSION );

	// Enqueue responsive menu
	wp_enqueue_script( 'wap-responsive-menu', get_stylesheet_directory_uri() . '/lib/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );

	// Enqueue Backstretch scripts only if custom background is being used
	if ( get_background_image() ) {

		wp_enqueue_script( 'wap-backstretch', get_stylesheet_directory_uri() . '/lib/js/backstretch.js', array( 'jquery' ), '1.0.0' );
		wp_enqueue_script( 'wap-backstretch-set', get_stylesheet_directory_uri() .'/lib/js/backstretch-set.js' , array( 'jquery', 'wap-backstretch' ), '1.0.0' );
		wp_localize_script( 'wap-backstretch-set', 'BackStretchImg', array( 'src' => get_background_image() ) );

	}
}

// Add search widget below header.
add_action( 'genesis_after_header', 'wap_search_bar' );
function wap_search_bar() {
	genesis_widget_area( 'search-bar', array(
		'before'=> '<div class="search-bar"><div class="wrap">',
		'after'	=> '</div></div>',
	) );
}

// Add featured image above single posts.
add_action( 'genesis_before_entry_content', 'wap_featured_image' );
function wap_featured_image() {

	// Return early if not a singular or does not have thumbnail
	if ( ! is_singular() || ! has_post_thumbnail() || is_page( 31)) {
		return;
	}

	echo '<div class="featured-image">';
		echo get_the_post_thumbnail( $thumbnail->ID, 'feature-wide' );
	echo '</div>';
}

// Reposition the secondary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 7 );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_after_header', 'genesis_do_nav', 5 );

// Reduce the secondary navigation menu to one level depth
add_filter( 'wp_nav_menu_args', 'wap_secondary_menu_args' );
function wap_secondary_menu_args( $args ){

	if ( 'secondary' != $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;
	return $args;

}

// Modify the Genesis content limit read more link
add_filter( 'get_the_content_more_link', 'wap_read_more_link' );
function wap_read_more_link() {

	if ( is_post_type_archive( 'listing' ) ) {
		return '<a class="more-link" href="' . get_permalink() . '"> View Listing </a>';
	}
	else {
		return '<a class="more-link" href="' . get_permalink() . '"> Continue Reading </a>';
	}

}

add_filter( 'agentpress_featured_listings_widget_loop', 'agentpress_featured_listings_widget_loop_filter' );
/**
 * Filter the loop output of the AgentPress Featured Listings Widget.
 *
 */
function agentpress_featured_listings_widget_loop_filter( $loop ) {

    $loop = ''; /** initialze the $loop variable */

    $loop .= sprintf( '<a href="%s">%s</a>', get_permalink(), genesis_get_image( array( 'size' => 'feature-community' ) ) );
	if ( genesis_get_custom_field('_listing_price') !== '')
    	$loop .= sprintf( '<div class="listing-price">$%s</div>', genesis_get_custom_field('_listing_price') );

	if ( genesis_get_custom_field('_listing_address') !== '')
    	$loop .= sprintf( '<div class="listing-address">%s</div>', genesis_get_custom_field('_listing_address') );

    $custom_text = genesis_get_custom_field( '_listing_text' );
    if( strlen( $custom_text ) )
        $loop .= sprintf( '<div class="listing-text">%s</div>', esc_html( $custom_text ) );

    //$loop .= sprintf( '<span class="listing-address">%s</span>', genesis_get_custom_field('_listing_address') );
	if ( genesis_get_custom_field('_listing_city') && genesis_get_custom_field('_listing_state') && genesis_get_custom_field('_listing_zip')!== '')
    	$loop .= sprintf( '<div class="listing-city-state-zip">%s %s, %s</div>', genesis_get_custom_field('_listing_city'), genesis_get_custom_field('_listing_state'), genesis_get_custom_field('_listing_zip') );
	if ( genesis_get_custom_field('_listing_bedrooms') !== '')
    	$loop .= sprintf( '<span class="listing-bedrooms">%s Beds</span> ', genesis_get_custom_field('_listing_bedrooms') );
	if ( genesis_get_custom_field('_listing_bathrooms') !== '')
    	$loop .= sprintf( '<span class="listing-bathrooms">%s Baths</span> ', genesis_get_custom_field('_listing_bathrooms') );

    // Output Square footage if not empty
    if ( genesis_get_custom_field('_listing_sqft') !== '')
    	$loop .= sprintf( '<span class="listing-sqft">%s SqFt</span>', genesis_get_custom_field('_listing_sqft') );

    //$loop .= sprintf( '<a href="%s" class="more-link">%s</a>', get_permalink(), __( 'View Listing', 'apl' ) );

    return $loop;

}