<?php
/**
 * Template tag helpers.
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
 * Return the current version of the parent theme.
 *
 * @since 1.0.0
 *
 * @return string
 */
function bigbox_child_get_theme_version() {
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || ! defined( 'BIGBOX_CHILD_VERSION' ) ) {
		return time();
	}

	return BIGBOX_CHILD_VERSION;
}
