<?php
/**
 * Front-end: assets, slider markup and shortcodes.
 *
 * @package TavoosImageCarousel
 */

defined( 'ABSPATH' ) || exit;

/**
 * Shortcode tags that display a slider.
 *
 * @return string[]
 */
function tavoos_ms_shortcode_tags() {
	$tags = array( 'tavoos_slider' );
	if ( get_option( 'tavoos_ms_legacy_shortcodes' ) ) {
		// Kept for pages built with version 1.x of this plugin / Sepanta Slider.
		$tags = array_merge( $tags, array( 'sp_slider', 'sp_home_slider', 'max_slider' ) );
	}
	return $tags;
}

add_action( 'wp_enqueue_scripts', function() {
	wp_register_style( 'tavoos-image-carousel', TAVOOS_MS_URL . 'assets/css/tavoos-image-carousel.css', array(), TAVOOS_MS_VERSION );
	wp_register_script( 'tavoos-image-carousel', TAVOOS_MS_URL . 'assets/js/tavoos-image-carousel.js', array(), TAVOOS_MS_VERSION, array(
		'in_footer' => true,
		'strategy'  => 'defer',
	) );

	// Load the stylesheet in <head> when the current page contains a slider, so it
	// never flashes unstyled. Sliders found later (widgets, theme code) enqueue it
	// themselves while rendering.
	if ( is_singular() ) {
		$post    = get_post();
		$content = $post ? $post->post_content . get_post_meta( $post->ID, '_elementor_data', true ) : '';
		foreach ( tavoos_ms_shortcode_tags() as $tag ) {
			if ( false !== strpos( $content, '[' . $tag ) ) {
				wp_enqueue_style( 'tavoos-image-carousel' );
				break;
			}
		}
	}
} );

/**
 * Build the HTML of a slider.
 *
 * @param string $slug Slider (term) slug.
 * @return string
 */
function tavoos_ms_render( $slug ) {
	$t = get_term_by( 'slug', $slug, 'tavoos_ms_slider' );
	if ( ! $t ) {
		return '';
	}
	$o = tavoos_ms_opts( $t->term_id );
	$q = get_posts( array(
		'post_type'   => 'tavoos_ms_slide',
		'post_status' => 'publish',
		'numberposts' => 30,
		'orderby'     => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
		'tax_query'   => array( // phpcs:ignore WordPress.DB.SlowDBQuery
			array(
				'taxonomy'         => 'tavoos_ms_slider',
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

	wp_enqueue_style( 'tavoos-image-carousel' );
	wp_enqueue_script( 'tavoos-image-carousel' );

	$count = count( $slides );
	$rd    = tavoos_ms_sanitize( 'ratio_d', $o['ratio_d'] );
	$rm    = tavoos_ms_sanitize( 'ratio_m', $o['ratio_m'] );
	$rm    = 'same' === $rm ? $rd : $rm;
	$cls   = 'tavoos-slider tavoos-slider--' . sanitize_html_class( $o['layout'] ) . ' tavoos-slider--' . sanitize_html_class( $o['effect'] ) . ( 'yes' === $o['shadow'] ? ' has-shadow' : '' );
	$style = '--tavoos-rd:' . $rd . ';--tavoos-rm:' . $rm . ';--tavoos-radius:' . (int) $o['radius'] . 'px;--tavoos-gap:' . (int) $o['gap'] . 'px;--tavoos-accent:' . tavoos_ms_sanitize( 'accent', $o['accent'] );

	$h = '<div class="' . esc_attr( $cls ) . '" style="' . esc_attr( $style ) . '" data-speed="' . (int) ( floatval( $o['speed'] ) * 1000 ) . '" data-autoplay="' . esc_attr( $o['autoplay'] ) . '" role="region" aria-roledescription="carousel" aria-label="' . esc_attr( $t->name ) . '"><div class="tavoos-slider__track">';

	foreach ( $slides as $i => $p ) {
		$d    = wp_get_attachment_url( get_post_thumbnail_id( $p ) );
		$mid  = (int) get_post_meta( $p->ID, '_tavoos_ms_mobile_img', true );
		$m    = $mid ? wp_get_attachment_url( $mid ) : '';
		$link = get_post_meta( $p->ID, '_tavoos_ms_link', true );
		$img  = '<picture>' . ( $m ? '<source media="(max-width:767px)" srcset="' . esc_url( $m ) . '">' : '' ) . '<img src="' . esc_url( $d ) . '" alt="' . esc_attr( get_the_title( $p ) ) . '" ' . ( 0 === $i ? 'fetchpriority="high"' : 'fetchpriority="low"' ) . ' decoding="async"></picture>';

		/* translators: 1: slide number, 2: total number of slides. */
		$label = sprintf( __( '%1$d of %2$d', 'tavoos-image-carousel' ), $i + 1, $count );
		$h    .= '<div class="tavoos-slide' . ( 0 === $i ? ' is-active' : '' ) . '" role="group" aria-roledescription="slide" aria-label="' . esc_attr( $label ) . '">' . ( $link ? '<a href="' . esc_url( $link ) . '">' . $img . '</a>' : $img ) . '</div>';
	}
	$h .= '</div>';

	if ( $count > 1 ) {
		if ( 'yes' === $o['arrows'] ) {
			$h .= '<button type="button" class="tavoos-slider__nav tavoos-slider__prev" aria-label="' . esc_attr__( 'Previous slide', 'tavoos-image-carousel' ) . '">‹</button>';
			$h .= '<button type="button" class="tavoos-slider__nav tavoos-slider__next" aria-label="' . esc_attr__( 'Next slide', 'tavoos-image-carousel' ) . '">›</button>';
		}
		if ( 'yes' === $o['dots'] ) {
			$h .= '<div class="tavoos-slider__dots">';
			foreach ( $slides as $i => $p ) {
				/* translators: %d: slide number. */
				$h .= '<button type="button" class="' . ( 0 === $i ? 'is-on' : '' ) . '" aria-label="' . esc_attr( sprintf( __( 'Slide %d', 'tavoos-image-carousel' ), $i + 1 ) ) . '"></button>';
			}
			$h .= '</div>';
		}
	}

	return $h . '</div>';
}

/**
 * [tavoos_slider id="slug"] — shows the slider with that slug.
 *
 * @param array  $a   Shortcode attributes.
 * @param string $c   Content (unused).
 * @param string $tag Shortcode tag.
 * @return string
 */
function tavoos_ms_shortcode( $a, $c = '', $tag = '' ) {
	$a = shortcode_atts( array( 'id' => '' ), $a );
	if ( 'sp_home_slider' === $tag ) {
		$a['id'] = 'home';
	}
	return tavoos_ms_render( sanitize_title( $a['id'] ) );
}

add_action( 'init', function() {
	foreach ( tavoos_ms_shortcode_tags() as $tag ) {
		add_shortcode( $tag, 'tavoos_ms_shortcode' );
	}
} );
