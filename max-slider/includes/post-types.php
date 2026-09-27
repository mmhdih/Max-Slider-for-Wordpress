<?php
/**
 * Post type (slides), taxonomy (sliders) and meta registration.
 *
 * @package MaxSlider
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
	register_post_type( 'sp_slide', array(
		'labels'        => array(
			'name'                  => __( 'Sliders', 'max-slider' ),
			'menu_name'             => __( 'Sliders', 'max-slider' ),
			'singular_name'         => __( 'Slide', 'max-slider' ),
			'add_new'               => __( 'Add slide', 'max-slider' ),
			'add_new_item'          => __( 'Add new slide', 'max-slider' ),
			'edit_item'             => __( 'Edit slide', 'max-slider' ),
			'all_items'             => __( 'All slides', 'max-slider' ),
			'featured_image'        => __( 'Slide image (desktop)', 'max-slider' ),
			'set_featured_image'    => __( 'Set slide image', 'max-slider' ),
			'remove_featured_image' => __( 'Remove image', 'max-slider' ),
			'use_featured_image'    => __( 'Use as slide image', 'max-slider' ),
			'search_items'          => __( 'Search slides', 'max-slider' ),
			'not_found'             => __( 'No slides found.', 'max-slider' ),
			'not_found_in_trash'    => __( 'No slides found in Trash.', 'max-slider' ),
		),
		'public'        => false,
		'show_ui'       => true,
		'show_in_menu'  => true,
		'menu_position' => 21,
		'menu_icon'     => 'dashicons-images-alt2',
		'supports'      => array( 'title', 'thumbnail', 'page-attributes', 'custom-fields' ),
		'show_in_rest'  => true,
	) );

	register_taxonomy( 'sp_slider', 'sp_slide', array(
		'labels'            => array(
			'name'          => __( 'Sliders (placements)', 'max-slider' ),
			'menu_name'     => __( 'Manage sliders', 'max-slider' ),
			'singular_name' => __( 'Slider', 'max-slider' ),
			'add_new_item'  => __( 'Create new slider', 'max-slider' ),
			'edit_item'     => __( 'Slider settings', 'max-slider' ),
			'all_items'     => __( 'All sliders', 'max-slider' ),
			'search_items'  => __( 'Search sliders', 'max-slider' ),
			'not_found'     => __( 'No sliders found.', 'max-slider' ),
			'back_to_items' => __( '← Back to sliders', 'max-slider' ),
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
	register_post_meta( 'sp_slide', 'sp_link', array(
		'type'              => 'string',
		'single'            => true,
		'show_in_rest'      => true,
		'sanitize_callback' => 'esc_url_raw',
		'auth_callback'     => $can_edit,
	) );
	register_post_meta( 'sp_slide', 'sp_mobile_img', array(
		'type'              => 'integer',
		'single'            => true,
		'show_in_rest'      => true,
		'sanitize_callback' => 'absint',
		'auth_callback'     => $can_edit,
	) );

	foreach ( array_keys( max_slider_defaults() ) as $k ) {
		register_term_meta( 'sp_slider', 'sp_' . $k, array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => function( $value ) use ( $k ) {
				return (string) max_slider_sanitize( $k, $value );
			},
			'auth_callback'     => function() {
				return current_user_can( 'manage_categories' );
			},
		) );
	}
} );

// Keep the slide fields out of the generic "Custom Fields" box; the
// "Slide settings" box edits them.
add_filter( 'is_protected_meta', function( $protected, $key, $type ) {
	return ( 'post' === $type && in_array( $key, array( 'sp_link', 'sp_mobile_img' ), true ) ) ? true : $protected;
}, 10, 3 );
