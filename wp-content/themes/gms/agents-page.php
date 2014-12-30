<?php
/**
 *
 * @package Genesis\Templates
 * @author  Josh Hathcock
 * @license GPL-2.0+
 * @link    http://my.studiopress.com/themes/genesis/
 */

/*
Template Name: Agents Template
*/

//* Remove Genesis Layout Settings
remove_theme_support( 'genesis-inpost-layouts' );

//* Remove the entry header markup open (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_entry_header_markup_open' );

remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_post_title' );

//* Remove the entry header markup (requires HTML5 theme support)
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_entry_header_markup_close' );


// Edit title
add_filter('genesis_post_title_text','ism_post_title_text');
function ism_post_title_text() {
	echo '<h4>Our Agents</h4>';
	$ism_title = sprintf(get_the_title());
	return $ism_title;
}

remove_action('genesis_loop','genesis_do_loop');
add_action('genesis_loop', 'ism_do_loop');
function ism_do_loop() {
	$ism_do_loop = sprintf(genesis_do_loop());
	return $ism_do_loop;
	echo '</div>';
}

// Move featured image
add_action( 'genesis_sidebar', 'single_post_featured_image', 5 );
function single_post_featured_image() {
	if ( ! is_singular() )
		return;
	$img = genesis_get_image( array( 'format' => 'html', 'size' => genesis_get_option( 'medium' ), 'attr' => array( 'class' => 'alignnone' ) ) );
	printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $img );
}

//* Force sidebar-content layout setting
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_sidebar_content' );

genesis();