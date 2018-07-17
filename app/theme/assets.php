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
	$version    = bigbox_child_get_theme_version();
	$stylesheet = bigbox_get_theme_name();

	// Base and dynamic styles.
	wp_enqueue_style( $stylesheet . '-child', get_stylesheet_directory_uri() . '/public/css/app.min.css', [ $stylesheet ], $version );
}
add_action( 'wp_enqueue_scripts', 'bigbox_child_enqueue_styles' );
