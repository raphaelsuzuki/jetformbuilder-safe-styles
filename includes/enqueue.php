<?php
/**
 * Enqueue logic for JetFormBuilder Safe Styles plugin
 *
 * - Looks for 'jetformbuilder-combined.css' in the child theme (get_stylesheet_directory())
 *   then parent theme (get_template_directory()). If not found, falls back to plugin assets.
 * - Uses filemtime for versioning when file exists on filesystem.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'jfb_safe_styles_enqueue' ) ) {
	/**
	 * Register & enqueue the JetFormBuilder safe stylesheet.
	 */
	function jfb_safe_styles_enqueue() {
		$handle = 'jet-form-builder-safe-styles';

		// Candidate filesystem paths and corresponding URLs (checked in this order)
		$checks = array(
			// Child theme override (preferred)
			array(
				'path' => get_stylesheet_directory() . '/jetformbuilder-combined.css',
				'url'  => get_stylesheet_directory_uri() . '/jetformbuilder-combined.css',
			),
			// Parent theme
			array(
				'path' => get_template_directory() . '/jetformbuilder-combined.css',
				'url'  => get_template_directory_uri() . '/jetformbuilder-combined.css',
			),
			// Plugin asset fallback
			array(
				'path' => JFB_SAFE_STYLES_PATH . 'assets/css/jetformbuilder-combined.css',
				'url'  => JFB_SAFE_STYLES_URL . 'assets/css/jetformbuilder-combined.css',
			),
		);

		$found = null;
		foreach ( $checks as $c ) {
			if ( isset( $c['path'], $c['url'] ) ) {
				// If file exists on disk, prefer it
				if ( file_exists( $c['path'] ) ) {
					$found = $c;
					break;
				}
			}
		}

		// If nothing exists, try plugin asset as fallback
		if ( ! $found ) {
			$found = array(
				'path' => JFB_SAFE_STYLES_PATH . 'assets/css/jetformbuilder-combined.css',
				'url'  => JFB_SAFE_STYLES_URL . 'assets/css/jetformbuilder-combined.css',
			);
		}

		$version = false;
		if ( ! empty( $found['path'] ) && file_exists( $found['path'] ) ) {
			$version = filemtime( $found['path'] );
		}

		// Register & enqueue
		if ( ! wp_style_is( $handle, 'registered' ) ) {
			wp_register_style( $handle, $found['url'], array(), $version );
		}

		if ( ! wp_style_is( $handle, 'enqueued' ) ) {
			wp_enqueue_style( $handle );
		}
	}

	add_action( 'wp_enqueue_scripts', 'jfb_safe_styles_enqueue', 20 );
}
