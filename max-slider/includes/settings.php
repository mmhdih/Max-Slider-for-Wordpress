<?php
/**
 * Slider settings: defaults, field definitions and sanitizing.
 *
 * Every slider is a term of the `sp_slider` taxonomy and its settings are
 * stored as term meta with an `sp_` prefix (e.g. `sp_layout`).
 *
 * @package MaxSlider
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default settings of a new slider.
 *
 * @return array
 */
function max_slider_defaults() {
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
function max_slider_fields() {
	$show_hide = array(
		'yes' => __( 'Show', 'max-slider' ),
		'no'  => __( 'Hide', 'max-slider' ),
	);

	return array(
		'layout'   => array(
			'label'   => __( 'Layout', 'max-slider' ),
			'choices' => array(
				'boxed' => __( 'Boxed (same width as the content)', 'max-slider' ),
				'full'  => __( 'Full page width', 'max-slider' ),
				'wide'  => __( 'Wide (1440 px)', 'max-slider' ),
			),
		),
		'ratio_d'  => array(
			'label'   => __( 'Desktop aspect ratio', 'max-slider' ),
			'choices' => array(
				'1600/560' => __( 'Wide 1600×560 (recommended for a main banner)', 'max-slider' ),
				'1920/600' => __( 'Extra wide 1920×600 (full width)', 'max-slider' ),
				'16/9'     => __( '16:9 (1600×900)', 'max-slider' ),
				'1200/400' => __( 'Strip 1200×400', 'max-slider' ),
				'1200/250' => __( 'Thin banner 1200×250', 'max-slider' ),
				'4/3'      => __( '4:3', 'max-slider' ),
				'1/1'      => __( 'Square', 'max-slider' ),
			),
		),
		'ratio_m'  => array(
			'label'   => __( 'Mobile aspect ratio', 'max-slider' ),
			'choices' => array(
				'1/1'  => __( 'Square 800×800 (recommended)', 'max-slider' ),
				'4/5'  => __( 'Portrait 800×1000', 'max-slider' ),
				'16/9' => __( '16:9', 'max-slider' ),
				'same' => __( 'Same as desktop', 'max-slider' ),
			),
		),
		'speed'    => array(
			'label' => __( 'Duration of each slide (seconds)', 'max-slider' ),
			'min'   => 1,
			'max'   => 30,
			'step'  => 0.5,
		),
		'autoplay' => array(
			'label'   => __( 'Autoplay', 'max-slider' ),
			'choices' => array(
				'yes' => __( 'On', 'max-slider' ),
				'no'  => __( 'Off', 'max-slider' ),
			),
		),
		'effect'   => array(
			'label'   => __( 'Transition effect', 'max-slider' ),
			'choices' => array(
				'slide' => _x( 'Slide', 'transition effect', 'max-slider' ),
				'fade'  => __( 'Fade', 'max-slider' ),
			),
		),
		'radius'   => array(
			'label' => __( 'Corner radius (px)', 'max-slider' ),
			'min'   => 0,
			'max'   => 60,
			'step'  => 1,
		),
		'arrows'   => array(
			'label'   => __( 'Arrows', 'max-slider' ),
			'choices' => $show_hide,
		),
		'dots'     => array(
			'label'   => __( 'Dots', 'max-slider' ),
			'choices' => $show_hide,
		),
		'shadow'   => array(
			'label'   => __( 'Shadow', 'max-slider' ),
			'choices' => array(
				'yes' => __( 'Yes', 'max-slider' ),
				'no'  => __( 'No', 'max-slider' ),
			),
		),
		'gap'      => array(
			'label' => __( 'Top and bottom spacing (px)', 'max-slider' ),
			'min'   => 0,
			'max'   => 120,
			'step'  => 1,
		),
		'accent'   => array(
			'label' => __( 'Accent color (active dot, arrow hover)', 'max-slider' ),
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
function max_slider_opts( $term_id ) {
	$o = max_slider_defaults();
	foreach ( $o as $k => $v ) {
		$m = get_term_meta( $term_id, 'sp_' . $k, true );
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
function max_slider_sanitize( $key, $value ) {
	$fields   = max_slider_fields();
	$defaults = max_slider_defaults();
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
