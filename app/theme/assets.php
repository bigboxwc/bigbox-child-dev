<?php
/**
 * Load public assets.
 *
 * @since 1.0.0
 *
 * @package BigBox\Child
 * @category Theme
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Enqueue styles.
 *
 * @since 1.0.0
 */
function bigbox_child_enqueue_styles() {
	$version           = bigbox_child_get_theme_version();
	$stylesheet_parent = bigbox_get_theme_name();
	$stylesheet_child  = $stylesheet_parent . '-child';

	wp_dequeue_style( $stylesheet_parent );
	wp_enqueue_style( $stylesheet_child, get_stylesheet_directory_uri() . '/public/css/app.min.css', [], $version );

	// Remove attachment from parent stylesheet and output with our own.
	add_filter( 'bigbox_customize_css_inline', '__return_false' );
	wp_add_inline_style( $stylesheet_child, bigbox_customize_inline_css() );
}
add_action( 'wp_enqueue_scripts', 'bigbox_child_enqueue_styles' );
