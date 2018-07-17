<?php
/**
 * Boostrap the application.
 *
 * @since 1.0.0
 *
 * @package BigBox\Child
 * @category Bootstrap
 * @author Spencer Finnell
 */

namespace BigBox\Child;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action(
	'after_setup_theme', function() {
		ThemeFactory::create()
			->register();
	},
	1	
);
