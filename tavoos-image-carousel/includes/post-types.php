<?php
/**
 * Post type (slides), taxonomy (sliders) and meta registration.
 *
 * @package TavoosImageCarousel
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
	register_post_type( 'tavoos_ms_slide', array(
		'labels'        => array(
			'name'                  => __( 'Sliders', 'tavoos-image-carousel' ),
			'menu_name'             => __( 'Sliders', 'tavoos-image-carousel' ),
			'singular_name'         => __( 'Slide', 'tavoos-image-carousel' ),
			'add_new'               => __( 'Add slide', 'tavoos-image-carousel' ),
			'add_new_item'          => __( 'Add new slide', 'tavoos-image-carousel' ),
			'edit_item'             => __( 'Edit slide', 'tavoos-image-carousel' ),
			'all_items'             => __( 'All slides', 'tavoos-image-carousel' ),
			'featured_image'        => __( 'Slide image (desktop)', 'tavoos-image-carousel' ),
			'set_featured_image'    => __( 'Set slide image', 'tavoos-image-carousel' ),
			'remove_featured_image' => __( 'Remove image', 'tavoos-image-carousel' ),
			'use_featured_image'    => __( 'Use as slide image', 'tavoos-image-carousel' ),
			'search_items'          => __( 'Search slides', 'tavoos-image-carousel' ),
			'not_found'             => __( 'No slides found.', 'tavoos-image-carousel' ),
			'not_found_in_trash'    => __( 'No slides found in Trash.', 'tavoos-image-carousel' ),
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
			'name'          => __( 'Sliders (placements)', 'tavoos-image-carousel' ),
			'menu_name'     => __( 'Manage sliders', 'tavoos-image-carousel' ),
			'singular_name' => __( 'Slider', 'tavoos-image-carousel' ),
			'add_new_item'  => __( 'Create new slider', 'tavoos-image-carousel' ),
			'edit_item'     => __( 'Slider settings', 'tavoos-image-carousel' ),
			'all_items'     => __( 'All sliders', 'tavoos-image-carousel' ),
			'search_items'  => __( 'Search sliders', 'tavoos-image-carousel' ),
			'not_found'     => __( 'No sliders found.', 'tavoos-image-carousel' ),
			'back_to_items' => __( '← Back to sliders', 'tavoos-image-carousel' ),
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

