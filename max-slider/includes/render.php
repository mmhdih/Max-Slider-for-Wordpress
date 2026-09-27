<?php
/**
 * Front-end: assets, slider markup and shortcodes.
 *
 * @package MaxSlider
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function() {
	// The stylesheet is tiny and loaded on every page, so sliders placed by
	// page builders never flash unstyled. The script only loads when a slider is shown.
	wp_enqueue_style( 'max-slider', MAX_SLIDER_URL . 'assets/css/max-slider.css', array(), MAX_SLIDER_VERSION );
	wp_register_script( 'max-slider', MAX_SLIDER_URL . 'assets/js/max-slider.js', array(), MAX_SLIDER_VERSION, true );
} );

/**
 * Build the HTML of a slider.
 *
 * @param string $slug Slider (term) slug.
 * @return string
 */
function max_slider_render( $slug ) {
	$t = get_term_by( 'slug', $slug, 'sp_slider' );
	if ( ! $t ) {
		return '';
	}
	$o = max_slider_opts( $t->term_id );
	$q = get_posts( array(
		'post_type'   => 'sp_slide',
		'post_status' => 'publish',
		'numberposts' => 30,
		'orderby'     => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
		'tax_query'   => array( // phpcs:ignore WordPress.DB.SlowDBQuery
			array(
				'taxonomy'         => 'sp_slider',
				'field'            => 'term_id',
				'terms'            => $t->term_id,
				'include_children' => false,
			),
		),
	) );

	$slides = array_values( array_filter( $q, function( $p ) {
		return (bool) get_post_thumbnail_id( $p );
	} ) );
	if ( ! $slides ) {
		return '';
	}

	wp_enqueue_script( 'max-slider' );

	$count = count( $slides );
	$rd    = max_slider_sanitize( 'ratio_d', $o['ratio_d'] );
	$rm    = max_slider_sanitize( 'ratio_m', $o['ratio_m'] );
	$rm    = 'same' === $rm ? $rd : $rm;
	$cls   = 'sp-slider sp-slider--' . sanitize_html_class( $o['layout'] ) . ' sp-slider--' . sanitize_html_class( $o['effect'] ) . ( 'yes' === $o['shadow'] ? ' has-shadow' : '' );
	$style = '--sp-rd:' . $rd . ';--sp-rm:' . $rm . ';--sp-radius:' . (int) $o['radius'] . 'px;--sp-gap:' . (int) $o['gap'] . 'px;--sp-accent:' . max_slider_sanitize( 'accent', $o['accent'] );

	$h = '<div class="' . esc_attr( $cls ) . '" style="' . esc_attr( $style ) . '" data-speed="' . (int) ( floatval( $o['speed'] ) * 1000 ) . '" data-autoplay="' . esc_attr( $o['autoplay'] ) . '" role="region" aria-roledescription="carousel" aria-label="' . esc_attr( $t->name ) . '"><div class="sp-slider__track">';

	foreach ( $slides as $i => $p ) {
		$d    = wp_get_attachment_url( get_post_thumbnail_id( $p ) );
		$mid  = (int) get_post_meta( $p->ID, 'sp_mobile_img', true );
		$m    = $mid ? wp_get_attachment_url( $mid ) : '';
		$link = get_post_meta( $p->ID, 'sp_link', true );
		$img  = '<picture>' . ( $m ? '<source media="(max-width:767px)" srcset="' . esc_url( $m ) . '">' : '' ) . '<img src="' . esc_url( $d ) . '" alt="' . esc_attr( get_the_title( $p ) ) . '" ' . ( 0 === $i ? 'fetchpriority="high"' : 'fetchpriority="low"' ) . ' decoding="async"></picture>';

		/* translators: 1: slide number, 2: total number of slides. */
		$label = sprintf( __( '%1$d of %2$d', 'max-slider' ), $i + 1, $count );
		$h    .= '<div class="sp-slide' . ( 0 === $i ? ' is-active' : '' ) . '" role="group" aria-roledescription="slide" aria-label="' . esc_attr( $label ) . '">' . ( $link ? '<a href="' . esc_url( $link ) . '">' . $img . '</a>' : $img ) . '</div>';
	}
	$h .= '</div>';

	if ( $count > 1 ) {
		if ( 'yes' === $o['arrows'] ) {
			$h .= '<button type="button" class="sp-slider__nav sp-slider__prev" aria-label="' . esc_attr__( 'Previous slide', 'max-slider' ) . '">‹</button>';
			$h .= '<button type="button" class="sp-slider__nav sp-slider__next" aria-label="' . esc_attr__( 'Next slide', 'max-slider' ) . '">›</button>';
		}
		if ( 'yes' === $o['dots'] ) {
			$h .= '<div class="sp-slider__dots">';
			foreach ( $slides as $i => $p ) {
				/* translators: %d: slide number. */
				$h .= '<button type="button" class="' . ( 0 === $i ? 'is-on' : '' ) . '" aria-label="' . esc_attr( sprintf( __( 'Slide %d', 'max-slider' ), $i + 1 ) ) . '"></button>';
			}
			$h .= '</div>';
		}
	}

	return $h . '</div>';
}

/**
 * [sp_slider id="slug"] and its alias [max_slider id="slug"].
 *
 * @param array $a Shortcode attributes.
 * @return string
 */
function max_slider_shortcode( $a ) {
	$a = shortcode_atts( array( 'id' => '' ), $a );
	return max_slider_render( sanitize_title( $a['id'] ) );
}
add_shortcode( 'sp_slider', 'max_slider_shortcode' );
add_shortcode( 'max_slider', 'max_slider_shortcode' );

// Shortcut for the slider with the slug "home".
add_shortcode( 'sp_home_slider', function() {
	return max_slider_render( 'home' );
} );
