<?php
/**
 * One-time upgrade from older versions.
 *
 * Version 1.x of this plugin, the Sepanta Slider plugin and its code snippet stored slides
 * as the `sp_slide` post type, sliders as the `sp_slider` taxonomy and settings
 * as `sp_*` meta. This moves that data to the prefixed names used now, so all
 * existing sliders keep working after switching plugins.
 *
 * @package TavoosImageCarousel
 */

defined( 'ABSPATH' ) || exit;

define( 'TAVOOS_MS_DB_VERSION', 2 );

/**
 * Whether an older copy of the slider code is still running.
 *
 * @return bool
 */
function tavoos_ms_legacy_code_active() {
	return function_exists( 'sp_render_slider' ) || function_exists( 'max_slider_render' );
}

/**
 * Move data of older versions to the current names (runs once).
 */
function tavoos_ms_maybe_migrate() {
	if ( (int) get_option( 'tavoos_ms_db_version', 0 ) >= TAVOOS_MS_DB_VERSION ) {
		return;
	}
	// The old code would keep registering the old names; wait until it is gone.
	if ( tavoos_ms_legacy_code_active() ) {
		return;
	}

	global $wpdb;

	// phpcs:disable WordPress.DB.DirectDatabaseQuery -- One-time rename of stored data; no API exists to change a post type/taxonomy in place.
	$old_slides = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = %s", 'sp_slide' ) );
	$old_terms  = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->term_taxonomy} WHERE taxonomy = %s", 'sp_slider' ) );

	if ( $old_slides || $old_terms ) {
		$wpdb->query( $wpdb->prepare(
			"UPDATE {$wpdb->postmeta} SET meta_key = %s WHERE meta_key = %s AND post_id IN ( SELECT ID FROM {$wpdb->posts} WHERE post_type = %s )",
			'_tavoos_ms_link',
			'sp_link',
			'sp_slide'
		) );
		$wpdb->query( $wpdb->prepare(
			"UPDATE {$wpdb->postmeta} SET meta_key = %s WHERE meta_key = %s AND post_id IN ( SELECT ID FROM {$wpdb->posts} WHERE post_type = %s )",
			'_tavoos_ms_mobile_img',
			'sp_mobile_img',
			'sp_slide'
		) );
		$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->posts} SET post_type = %s WHERE post_type = %s", 'tavoos_ms_slide', 'sp_slide' ) );

		foreach ( array_keys( tavoos_ms_defaults() ) as $k ) {
			$wpdb->query( $wpdb->prepare(
				"UPDATE {$wpdb->termmeta} SET meta_key = %s WHERE meta_key = %s AND term_id IN ( SELECT term_id FROM {$wpdb->term_taxonomy} WHERE taxonomy = %s )",
				'tavoos_ms_' . $k,
				'sp_' . $k,
				'sp_slider'
			) );
		}
		$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->term_taxonomy} SET taxonomy = %s WHERE taxonomy = %s", 'tavoos_ms_slider', 'sp_slider' ) );

		wp_cache_flush();

		// Pages built with the old version still contain [sp_slider] shortcodes.
		update_option( 'tavoos_ms_legacy_shortcodes', 1 );
	}
	// phpcs:enable

	update_option( 'tavoos_ms_db_version', TAVOOS_MS_DB_VERSION );
}
add_action( 'init', 'tavoos_ms_maybe_migrate', 5 );
