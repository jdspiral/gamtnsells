<?php

/**
 * Registers and Formats post types
 *
 * @package Winning Agent Pro
 * @subpackage Customizations
 * @author  Carrie Dils
 * @license GPL-2.0+
 *
 */

//registers "community" post type
register_post_type( 'wap-community',
	array(
		'labels'				=> array(
			'name'				=> __( 'Communities', 'wap' ),
			'singular_name'		=> __( 'Community', 'wap' ),
		),
		'has_archive'			=> true,
		'hierarchical'			=> true,
		'menu_icon'				=> 'dashicons-admin-home',
		'public'				=> true,
		'rewrite'				=> array( 'slug' => 'community', 'with_front' => false ),
		'supports'				=> array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-seo', 'genesis-cpt-archives-settings' ),
		'taxonomies'			=> array( 'category' ),

	)
);