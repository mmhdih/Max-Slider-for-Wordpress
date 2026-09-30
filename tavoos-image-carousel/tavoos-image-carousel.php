<?php
/**
 * Plugin Name:       Tavoos Image Carousel
 * Plugin URI:        https://tavoosweb.ir/free-wordpress-plugins/
 * Description:       Lightweight, dependency-free image sliders. Build as many sliders as you need, give every slide a separate mobile image and a link, and place them anywhere with a shortcode (works with Elementor and every page builder). RTL ready.
 * Version:           2.1.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            mmhdih
 * Author URI:        https://github.com/mmhdih
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       tavoos-image-carousel
 * Domain Path:       /languages
 *
 * @package TavoosImageCarousel
 */

defined( 'ABSPATH' ) || exit;

// Another copy of this plugin (an earlier version in a different folder) is already loaded or active.
if ( defined( 'TAVOOS_MS_VERSION' ) || in_array( 'tavoos-max-slider/tavoos-max-slider.php', (array) get_option( 'active_plugins', array() ), true ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="notice notice-error"><p>' . esc_html__( 'Tavoos Image Carousel: another copy of this plugin is already active. Deactivate the older copy, then activate this one again.', 'tavoos-image-carousel' ) . '</p></div>';
	} );
	return;
}

define( 'TAVOOS_MS_VERSION', '2.1.0' );
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

// "Manage sliders" link on the Plugins screen.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), function( $links ) {
	$url = admin_url( 'edit-tags.php?taxonomy=tavoos_ms_slider&post_type=tavoos_ms_slide' );
	array_unshift( $links, '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Manage sliders', 'tavoos-image-carousel' ) . '</a>' );
	return $links;
} );

// Designer credit under the plugin description on the Plugins screen.
add_filter( 'plugin_row_meta', function( $meta, $file ) {
	if ( plugin_basename( TAVOOS_MS_FILE ) === $file ) {
		$meta[] = '<a href="https://tavoosweb.ir/" target="_blank" rel="noopener">' . esc_html__( 'Designed by Mahdi Habibi | Tavoos Web', 'tavoos-image-carousel' ) . '</a>';
	}
	return $meta;
}, 10, 2 );
