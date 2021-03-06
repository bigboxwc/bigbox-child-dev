<?php
/**
 * Do not modify this file.
 *
 * @since 1.0.0
 *
 * @package BigBox\Child
 * @category Bootstrap
 * @author Spencer Finnell
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Current version -- automatically updated on release.
define( 'BIGBOX_CHILD_VERSION', '%BIGBOX_CHILD_VERSION%' );

// Composer autoloader.
require_once __DIR__ . '/bootstrap/autoload.php';

// Start things.
require_once __DIR__ . '/bootstrap/app.php';
