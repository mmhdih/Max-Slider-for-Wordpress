<?php
/**
 * Plugin Name:       Max Slider
 * Plugin URI:        https://github.com/mmhdih/Max-Slider-for-Wordpress
 * Description:       Lightweight, dependency-free image sliders for WordPress. Build as many sliders as you need, give every slide a separate mobile image and a link, and place them anywhere with a shortcode (works with Elementor and every page builder). RTL ready.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            mmhdih
 * Author URI:        https://github.com/mmhdih
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       max-slider
 * Domain Path:       /languages
 *
 * @package MaxSlider
 */

defined( 'ABSPATH' ) || exit;

define( 'MAX_SLIDER_VERSION', '1.0.0' );
define( 'MAX_SLIDER_FILE', __FILE__ );
define( 'MAX_SLIDER_URL', plugin_dir_url( __FILE__ ) );
define( 'MAX_SLIDER_DIR', plugin_dir_path( __FILE__ ) );

require_once MAX_SLIDER_DIR . 'includes/settings.php';
require_once MAX_SLIDER_DIR . 'includes/post-types.php';
require_once MAX_SLIDER_DIR . 'includes/render.php';

if ( is_admin() ) {
	require_once MAX_SLIDER_DIR . 'includes/admin.php';
}

add_action( 'init', function() {
	load_plugin_textdomain( 'max-slider', false, dirname( plugin_basename( MAX_SLIDER_FILE ) ) . '/languages' );
}, 0 );

// Show the "Display code" of every slider right from the Plugins screen.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), function( $links ) {
	$url = admin_url( 'edit-tags.php?taxonomy=sp_slider&post_type=sp_slide' );
	array_unshift( $links, '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Manage sliders', 'max-slider' ) . '</a>' );
	return $links;
} );
