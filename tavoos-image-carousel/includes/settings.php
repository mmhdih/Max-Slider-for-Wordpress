<?php
/**
 * Slider settings: defaults, field definitions and sanitizing.
 *
 * Every slider is a term of the `tavoos_ms_slider` taxonomy and its settings
 * are stored as term meta with a `tavoos_ms_` prefix (e.g. `tavoos_ms_layout`).
 *
 * @package TavoosImageCarousel
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default settings of a new slider.
 *
 * @return array
 */
function tavoos_ms_defaults() {
	return array(
		'layout'   => 'boxed',
		'ratio_d'  => '1600/560',
		'ratio_m'  => '1/1',
		'speed'    => 5,
		'autoplay' => 'yes',
		'effect'   => 'slide',
		'radius'   => 28,
		'arrows'   => 'yes',
		'dots'     => 'yes',
		'shadow'   => 'yes',
		'gap'      => 0,
		'accent'   => '#f5b301',
	);
}

/**
 * Field definitions for the slider settings form.
 *
 * @return array
 */
function tavoos_ms_fields() {
	$show_hide = array(
		'yes' => __( 'Show', 'tavoos-image-carousel' ),
		'no'  => __( 'Hide', 'tavoos-image-carousel' ),
	);

	return array(
		'layout'   => array(
			'label'   => __( 'Layout', 'tavoos-image-carousel' ),
			'choices' => array(
				'boxed' => __( 'Boxed (same width as the content)', 'tavoos-image-carousel' ),
				'full'  => __( 'Full page width', 'tavoos-image-carousel' ),
				'wide'  => __( 'Wide (1440 px)', 'tavoos-image-carousel' ),
			),
		),
		'ratio_d'  => array(
			'label'   => __( 'Desktop aspect ratio', 'tavoos-image-carousel' ),
			'choices' => array(
				'1600/560' => __( 'Wide 1600×560 (recommended for a main banner)', 'tavoos-image-carousel' ),
				'1920/600' => __( 'Extra wide 1920×600 (full width)', 'tavoos-image-carousel' ),
				'16/9'     => __( '16:9 (1600×900)', 'tavoos-image-carousel' ),
				'1200/400' => __( 'Strip 1200×400', 'tavoos-image-carousel' ),
				'1200/250' => __( 'Thin banner 1200×250', 'tavoos-image-carousel' ),
				'4/3'      => __( '4:3', 'tavoos-image-carousel' ),
				'1/1'      => __( 'Square', 'tavoos-image-carousel' ),
			),
		),
		'ratio_m'  => array(
			'label'   => __( 'Mobile aspect ratio', 'tavoos-image-carousel' ),
			'choices' => array(
				'1/1'  => __( 'Square 800×800 (recommended)', 'tavoos-image-carousel' ),
				'4/5'  => __( 'Portrait 800×1000', 'tavoos-image-carousel' ),
				'16/9' => __( '16:9', 'tavoos-image-carousel' ),
				'same' => __( 'Same as desktop', 'tavoos-image-carousel' ),
			),
		),
		'speed'    => array(
			'label' => __( 'Duration of each slide (seconds)', 'tavoos-image-carousel' ),
			'min'   => 1,
			'max'   => 30,
			'step'  => 0.5,
		),
		'autoplay' => array(
			'label'   => __( 'Autoplay', 'tavoos-image-carousel' ),
			'choices' => array(
				'yes' => __( 'On', 'tavoos-image-carousel' ),
				'no'  => __( 'Off', 'tavoos-image-carousel' ),
			),
		),
		'effect'   => array(
			'label'   => __( 'Transition effect', 'tavoos-image-carousel' ),
			'choices' => array(
				'slide' => _x( 'Slide', 'transition effect', 'tavoos-image-carousel' ),
				'fade'  => __( 'Fade', 'tavoos-image-carousel' ),
			),
		),
		'radius'   => array(
			'label' => __( 'Corner radius (px)', 'tavoos-image-carousel' ),
			'min'   => 0,
			'max'   => 60,
			'step'  => 1,
		),
		'arrows'   => array(
			'label'   => __( 'Arrows', 'tavoos-image-carousel' ),
			'choices' => $show_hide,
		),
		'dots'     => array(
			'label'   => __( 'Dots', 'tavoos-image-carousel' ),
			'choices' => $show_hide,
		),
		'shadow'   => array(
			'label'   => __( 'Shadow', 'tavoos-image-carousel' ),
			'choices' => array(
				'yes' => __( 'Yes', 'tavoos-image-carousel' ),
				'no'  => __( 'No', 'tavoos-image-carousel' ),
			),
		),
		'gap'      => array(
			'label' => __( 'Top and bottom spacing (px)', 'tavoos-image-carousel' ),
			'min'   => 0,
			'max'   => 120,
			'step'  => 1,
		),
		'accent'   => array(
			'label' => __( 'Accent color (active dot, arrow hover)', 'tavoos-image-carousel' ),
			'type'  => 'color',
		),
	);
}

/**
 * Settings of a slider, merged with the defaults.
 *
 * @param int $term_id Slider term ID.
 * @return array
 */
function tavoos_ms_opts( $term_id ) {
	$o = tavoos_ms_defaults();
	foreach ( $o as $k => $v ) {
		$m = get_term_meta( $term_id, 'tavoos_ms_' . $k, true );
		if ( '' !== $m && false !== $m ) {
			$o[ $k ] = $m;
		}
	}
	return $o;
}

/**
 * Sanitize one setting value against its field definition.
 *
 * @param string $key   Setting key (without prefix).
 * @param mixed  $value Raw value.
 * @return string|float|int Clean value, the default when invalid.
 */
function tavoos_ms_sanitize( $key, $value ) {
	$fields   = tavoos_ms_fields();
	$defaults = tavoos_ms_defaults();
	$value    = sanitize_text_field( (string) $value );

	if ( isset( $fields[ $key ]['choices'] ) ) {
		return array_key_exists( $value, $fields[ $key ]['choices'] ) ? $value : $defaults[ $key ];
	}

	if ( isset( $fields[ $key ]['type'] ) && 'color' === $fields[ $key ]['type'] ) {
		$color = sanitize_hex_color( $value );
		return $color ? $color : $defaults[ $key ];
	}

	if ( ! is_numeric( $value ) ) {
		return $defaults[ $key ];
	}
	return min( $fields[ $key ]['max'], max( $fields[ $key ]['min'], (float) $value ) );
}
