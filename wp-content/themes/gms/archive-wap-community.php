<?php
/**
 * This file adds the custom community post type archive template to the Winning Agent Pro Theme.
 *
 * @author Carrie Dils
 * @package Winning Agent Pro
 * @subpackage Customizations
 */

// Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// Remove the breadcrumb navigation
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

// Remove the post info function
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );

// Remove the post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

// Remove the post image
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );

// Add community body class to the head
add_filter( 'body_class', 'wap_add_community_body_class' );
function wap_add_community_body_class( $classes ) {
   $classes[] = 'wap-community';
   return $classes;
}

// Add the featured image after post title
add_action( 'genesis_entry_header', 'wap_community_grid' );
function wap_community_grid() {

    if ( $image = genesis_get_image( 'format=url&size=feature-community' ) ) {
        printf( '<div class="community-featured-image"><a href="%s" rel="bookmark"><img src="%s" alt="%s" /></a></div>', get_permalink(), $image, the_title_attribute( 'echo=0' ) );

    }

}

// Remove the post meta function
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

genesis();
