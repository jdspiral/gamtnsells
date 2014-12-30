<?php
/**
 * Register Custom Widgets
 *
 * @package Winning Agent Pro / Widgets
 * @author  Carrie Dils
 * @license GPL-2.0+
 * @link    https://store.winningagent.com/themes/winning-agent-pro/
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'widgets_init', 'wap_register_widget' );
/**
* Register Genesis Featured Community widget.
*
* @since 1.0.0
*/
function wap_register_widget() {

	register_widget( 'Winning_Agent_Pro_Featured_Community' );

}

require 'featured-community-widget.php';