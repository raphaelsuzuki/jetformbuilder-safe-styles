<?php
/**
 * Plugin Name: JetFormBuilder Safe Styles
 * Description: Adds a safe, scoped stylesheet for JetFormBuilder forms. Child-theme override supported via /jetformbuilder-combined.css.
 * Version:     1.0.0
 * Author:      raphaelsuzuki
 * Author URI:  https://github.com/raphaelsuzuki
 * Text Domain: jfb-safe-styles
 *
 * Usage:
 * 1. Upload the folder "jetformbuilder-styles" into wp-content/plugins/
 * 2. Activate the plugin in WordPress admin.
 * 3. Optionally place a file named "jetformbuilder-combined.css" in your child theme root to override the plugin CSS.
 */

// Abort if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants
if ( ! defined( 'JFB_SAFE_STYLES_PATH' ) ) {
	define( 'JFB_SAFE_STYLES_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'JFB_SAFE_STYLES_URL' ) ) {
	define( 'JFB_SAFE_STYLES_URL', plugin_dir_url( __FILE__ ) );
}

require_once JFB_SAFE_STYLES_PATH . 'includes/enqueue.php';
