<?php

/**
 * This file adds the Home Page to the Winning Agent Pro Theme.
 *
 * @author Carrie Dils
 * @package Winning Agent Pro
 * @subpackage Customizations
 */

// Add widget support for homepage if widgets are being used
add_action( 'genesis_meta', 'wap_front_page_genesis_meta' );
function wap_front_page_genesis_meta() {

	if ( is_active_sidebar( 'home-welcome' ) || is_active_sidebar( 'home-featured-1' ) || is_active_sidebar( 'home-featured-2' ) || is_active_sidebar( 'home-featured-3' ) || is_active_sidebar( 'home-listings' ) || is_active_sidebar( 'home-communities' ) ) {
		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_after_header', 'wap_home_widgets', 15 );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
	}
}

// Add welcome widget below header
add_action( 'genesis_after_header', 'wap_welcome_bar', 5 );
function wap_welcome_bar() {

	genesis_widget_area( 'home-welcome', array(
		'before'=> '<div class="home-welcome"><div class="wrap">',
		'after'	=> '</div></div>',
	) );

}

//* Add markup for homepage widgets
function wap_home_widgets() {

	printf( '<div %s>', genesis_attr( 'home-featured' ) );
	genesis_structural_wrap( 'home-featured' );

		genesis_widget_area( 'home-featured-1', array(
			'before' => '<div class="home-featured-1 widget-area">',
			'after'  => '</div>',
		) );

		// genesis_widget_area( 'home-featured-2', array(
		// 	'before' => '<div class="home-featured-2 widget-area">',
		// 	'after'  => '</div>',
		// ) );

		// genesis_widget_area( 'home-featured-3', array(
		// 	'before' => '<div class="home-featured-3 widget-area">',
		// 	'after'  => '</div>',
		// ) );

	genesis_structural_wrap( 'home-featured', 'close' );
	echo '</div>'; //* end .home-featured

	genesis_widget_area( 'home-listings', array(
		'before' => '<div class="home-listings"><div class="wrap">',
		'after'  => '</div></div>',
	) );

	genesis_widget_area( 'home-communities', array(
		'before' => '<div class="home-communities"><div class="wrap">',
		'after'  => '</div></div>',
	) );

}

//* Run the Genesis loop
genesis();
