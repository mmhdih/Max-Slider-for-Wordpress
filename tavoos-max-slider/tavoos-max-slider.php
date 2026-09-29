<?php
/**
 * Plugin Name:       Tavoos Max Slider
 * Plugin URI:        https://github.com/mmhdih/Max-Slider-for-Wordpress
 * Description:       Lightweight, dependency-free image sliders. Build as many sliders as you need, give every slide a separate mobile image and a link, and place them anywhere with a shortcode (works with Elementor and every page builder). RTL ready.
 * Version:           2.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            mmhdih
 * Author URI:        https://github.com/mmhdih
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tavoos-max-slider
 * Domain Path:       /languages
 *
 * @package TavoosMaxSlider
 */

defined( 'ABSPATH' ) || exit;

define( 'TAVOOS_MS_VERSION', '2.0.0' );
define( 'TAVOOS_MS_FILE', __FILE__ );
define( 'TAVOOS_MS_URL', plugin_dir_url( __FILE__ ) );
define( 'TAVOOS_MS_DIR', plugin_dir_path( __FILE__ ) );

require_once TAVOOS_MS_DIR . 'includes/settings.php';
require_once TAVOOS_MS_DIR . 'includes/migrate.php';
require_once TAVOOS_MS_DIR . 'includes/post-types.php';
require_once TAVOOS_MS_DIR . 'includes/render.php';

if ( is_admin() ) {
	require_once TAVOOS_MS_DIR . 'includes/admin.php';
}

// Use the translations bundled in /languages when WordPress.org has none installed.
add_filter( 'lang_dir_for_domain', function( $path, $domain, $locale ) {
	if ( 'tavoos-max-slider' === $domain && ! $path && is_readable( TAVOOS_MS_DIR . 'languages/tavoos-max-slider-' . $locale . '.mo' ) ) {
		$path = TAVOOS_MS_DIR . 'languages/';
	}
	return $path;
}, 10, 3 );

// WordPress before 6.6 has no lang_dir_for_domain filter.
add_action( 'init', function() {
	global $wp_version;
	if ( version_compare( $wp_version, '6.6', '<' ) && ! is_textdomain_loaded( 'tavoos-max-slider' ) ) {
		load_textdomain( 'tavoos-max-slider', TAVOOS_MS_DIR . 'languages/tavoos-max-slider-' . determine_locale() . '.mo' );
	}
}, 0 );

// "Manage sliders" link on the Plugins screen.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), function( $links ) {
	$url = admin_url( 'edit-tags.php?taxonomy=tavoos_ms_slider&post_type=tavoos_ms_slide' );
	array_unshift( $links, '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Manage sliders', 'tavoos-max-slider' ) . '</a>' );
	return $links;
} );

// Designer credit under the plugin description on the Plugins screen.
add_filter( 'plugin_row_meta', function( $meta, $file ) {
	if ( plugin_basename( TAVOOS_MS_FILE ) === $file ) {
		$meta[] = '<a href="https://tavoosweb.ir/" target="_blank" rel="noopener">' . esc_html__( 'Designed by Mahdi Habibi | Tavoos Web', 'tavoos-max-slider' ) . '</a>';
	}
	return $meta;
}, 10, 2 );
