<?php
/**
 * Post type (slides), taxonomy (sliders) and meta registration.
 *
 * @package TavoosMaxSlider
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
	register_post_type( 'tavoos_ms_slide', array(
		'labels'        => array(
			'name'                  => __( 'Sliders', 'tavoos-max-slider' ),
			'menu_name'             => __( 'Sliders', 'tavoos-max-slider' ),
			'singular_name'         => __( 'Slide', 'tavoos-max-slider' ),
			'add_new'               => __( 'Add slide', 'tavoos-max-slider' ),
			'add_new_item'          => __( 'Add new slide', 'tavoos-max-slider' ),
			'edit_item'             => __( 'Edit slide', 'tavoos-max-slider' ),
			'all_items'             => __( 'All slides', 'tavoos-max-slider' ),
			'featured_image'        => __( 'Slide image (desktop)', 'tavoos-max-slider' ),
			'set_featured_image'    => __( 'Set slide image', 'tavoos-max-slider' ),
			'remove_featured_image' => __( 'Remove image', 'tavoos-max-slider' ),
			'use_featured_image'    => __( 'Use as slide image', 'tavoos-max-slider' ),
			'search_items'          => __( 'Search slides', 'tavoos-max-slider' ),
			'not_found'             => __( 'No slides found.', 'tavoos-max-slider' ),
			'not_found_in_trash'    => __( 'No slides found in Trash.', 'tavoos-max-slider' ),
		),
		'public'        => false,
		'show_ui'       => true,
		'show_in_menu'  => true,
		'menu_position' => 21,
		'menu_icon'     => 'dashicons-images-alt2',
		'supports'      => array( 'title', 'thumbnail', 'page-attributes', 'custom-fields' ),
		'show_in_rest'  => true,
	) );

	register_taxonomy( 'tavoos_ms_slider', 'tavoos_ms_slide', array(
		'labels'            => array(
			'name'          => __( 'Sliders (placements)', 'tavoos-max-slider' ),
			'menu_name'     => __( 'Manage sliders', 'tavoos-max-slider' ),
			'singular_name' => __( 'Slider', 'tavoos-max-slider' ),
			'add_new_item'  => __( 'Create new slider', 'tavoos-max-slider' ),
			'edit_item'     => __( 'Slider settings', 'tavoos-max-slider' ),
			'all_items'     => __( 'All sliders', 'tavoos-max-slider' ),
			'search_items'  => __( 'Search sliders', 'tavoos-max-slider' ),
			'not_found'     => __( 'No sliders found.', 'tavoos-max-slider' ),
			'back_to_items' => __( '← Back to sliders', 'tavoos-max-slider' ),
		),
		'public'            => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'show_in_rest'      => true,
		'meta_box_cb'       => 'post_categories_meta_box',
	) );

	$can_edit = function() {
		return current_user_can( 'edit_posts' );
	};
	register_post_meta( 'tavoos_ms_slide', '_tavoos_ms_link', array(
		'type'              => 'string',
		'single'            => true,
		'show_in_rest'      => true,
		'sanitize_callback' => 'esc_url_raw',
		'auth_callback'     => $can_edit,
	) );
	register_post_meta( 'tavoos_ms_slide', '_tavoos_ms_mobile_img', array(
		'type'              => 'integer',
		'single'            => true,
		'show_in_rest'      => true,
		'sanitize_callback' => 'absint',
		'auth_callback'     => $can_edit,
	) );

	foreach ( array_keys( tavoos_ms_defaults() ) as $k ) {
		register_term_meta( 'tavoos_ms_slider', 'tavoos_ms_' . $k, array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => function( $value ) use ( $k ) {
				return (string) tavoos_ms_sanitize( $k, $value );
			},
			'auth_callback'     => function() {
				return current_user_can( 'manage_categories' );
			},
		) );
	}
} );

