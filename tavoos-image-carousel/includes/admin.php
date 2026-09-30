<?php
/**
 * Admin screens: slider settings form, slide meta box and list columns.
 *
 * @package TavoosImageCarousel
 */

defined( 'ABSPATH' ) || exit;

/**
 * The shortcode that displays a slider.
 *
 * @param WP_Term $term Slider term.
 * @return string
 */
function tavoos_ms_shortcode_for( $term ) {
	return '[tavoos_slider id="' . $term->slug . '"]';
}

/**
 * Print the input of one setting.
 *
 * @param string $key   Setting key.
 * @param array  $f     Field definition.
 * @param mixed  $value Current value.
 */
function tavoos_ms_print_input( $key, $f, $value ) {
	$name = 'tavoos_ms_' . $key;

	if ( isset( $f['choices'] ) ) {
		echo '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '">';
		foreach ( $f['choices'] as $v => $l ) {
			echo '<option value="' . esc_attr( $v ) . '" ' . selected( (string) $value, (string) $v, false ) . '>' . esc_html( $l ) . '</option>';
		}
		echo '</select>';
	} elseif ( isset( $f['type'] ) && 'color' === $f['type'] ) {
		echo '<input type="color" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" style="width:90px;height:34px;padding:2px">';
	} else {
		echo '<input type="number" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" min="' . esc_attr( $f['min'] ) . '" max="' . esc_attr( $f['max'] ) . '" step="' . esc_attr( $f['step'] ) . '" value="' . esc_attr( $value ) . '" style="width:90px">';
	}
}

/**
 * Print the slider settings fields.
 *
 * @param array  $o    Current settings.
 * @param string $wrap `tr` for the edit screen table, `div` for the add form.
 */
function tavoos_ms_print_fields( $o, $wrap ) {
	wp_nonce_field( 'tavoos_ms_term_save', 'tavoos_ms_term_nonce' );

	foreach ( tavoos_ms_fields() as $key => $f ) {
		$id = 'tavoos_ms_' . $key;
		if ( 'tr' === $wrap ) {
			echo '<tr class="form-field"><th scope="row"><label for="' . esc_attr( $id ) . '">' . esc_html( $f['label'] ) . '</label></th><td>';
			tavoos_ms_print_input( $key, $f, $o[ $key ] );
			echo '</td></tr>';
		} else {
			echo '<div class="form-field"><label for="' . esc_attr( $id ) . '">' . esc_html( $f['label'] ) . '</label>';
			tavoos_ms_print_input( $key, $f, $o[ $key ] );
			echo '</div>';
		}
	}
}

add_action( 'tavoos_ms_slider_add_form_fields', function() {
	tavoos_ms_print_fields( tavoos_ms_defaults(), 'div' );
} );

add_action( 'tavoos_ms_slider_edit_form_fields', function( $t ) {
	echo '<tr class="form-field"><th scope="row">' . esc_html__( 'Display code', 'tavoos-image-carousel' ) . '</th><td><code style="font-size:15px;padding:6px 10px;user-select:all">' . esc_html( tavoos_ms_shortcode_for( $t ) ) . '</code><p class="description">' . esc_html__( 'Put this code in the Elementor "Shortcode" widget, a Shortcode block or any page.', 'tavoos-image-carousel' ) . '</p></td></tr>';
	tavoos_ms_print_fields( tavoos_ms_opts( $t->term_id ), 'tr' );
} );

/**
 * Save slider settings when a slider is created or edited.
 *
 * @param int $term_id Slider term ID.
 */
function tavoos_ms_save_term( $term_id ) {
	if ( ! isset( $_POST['tavoos_ms_term_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tavoos_ms_term_nonce'] ) ), 'tavoos_ms_term_save' ) ) {
		return;
	}
	if ( ! current_user_can( 'manage_categories' ) ) {
		return;
	}
	foreach ( array_keys( tavoos_ms_defaults() ) as $k ) {
		if ( isset( $_POST[ 'tavoos_ms_' . $k ] ) ) {
			$value = tavoos_ms_sanitize( $k, sanitize_text_field( wp_unslash( $_POST[ 'tavoos_ms_' . $k ] ) ) );
			update_term_meta( $term_id, 'tavoos_ms_' . $k, (string) $value );
		}
	}
}
add_action( 'created_tavoos_ms_slider', 'tavoos_ms_save_term' );
add_action( 'edited_tavoos_ms_slider', 'tavoos_ms_save_term' );

add_filter( 'manage_edit-tavoos_ms_slider_columns', function( $c ) {
	$n = array();
	foreach ( $c as $k => $v ) {
		$n[ $k ] = $v;
		if ( 'name' === $k ) {
			$n['tavoos_ms_code'] = __( 'Display code', 'tavoos-image-carousel' );
		}
	}
	unset( $n['description'] );
	return $n;
} );

add_filter( 'manage_tavoos_ms_slider_custom_column', function( $out, $col, $id ) {
	if ( 'tavoos_ms_code' === $col ) {
		$t   = get_term( $id );
		$out = '<code style="user-select:all">' . esc_html( tavoos_ms_shortcode_for( $t ) ) . '</code>';
	}
	return $out;
}, 10, 3 );

/* ----- Slide meta box ----- */

add_action( 'add_meta_boxes_tavoos_ms_slide', function() {
	add_meta_box( 'tavoos_ms_slide_box', __( 'Slide settings', 'tavoos-image-carousel' ), 'tavoos_ms_slide_box', 'tavoos_ms_slide', 'normal', 'high' );
} );

/**
 * Render the slide settings meta box.
 *
 * @param WP_Post $post Slide.
 */
function tavoos_ms_slide_box( $post ) {
	wp_nonce_field( 'tavoos_ms_slide_save', 'tavoos_ms_slide_nonce' );
	$link = get_post_meta( $post->ID, '_tavoos_ms_link', true );
	$mid  = (int) get_post_meta( $post->ID, '_tavoos_ms_mobile_img', true );
	$murl = $mid ? wp_get_attachment_url( $mid ) : '';
	?>
	<p>
		<label for="tavoos_ms_link"><b><?php esc_html_e( 'Slide link', 'tavoos-image-carousel' ); ?></b> <?php esc_html_e( '(optional)', 'tavoos-image-carousel' ); ?></label><br>
		<input type="url" name="tavoos_ms_link" id="tavoos_ms_link" value="<?php echo esc_attr( $link ); ?>" style="width:100%;direction:ltr" placeholder="https://example.com/shop/">
	</p>
	<p><b><?php esc_html_e( 'Mobile image', 'tavoos-image-carousel' ); ?></b> <?php esc_html_e( '(optional)', 'tavoos-image-carousel' ); ?></p>
	<input type="hidden" name="tavoos_ms_mobile_img" id="tavoos_ms_mobile_img" value="<?php echo esc_attr( $mid ? $mid : '' ); ?>">
	<div id="tavoos_ms_mobile_prev"><?php if ( $murl ) : ?><img src="<?php echo esc_url( $murl ); ?>" style="max-width:220px;border-radius:8px" alt=""><?php endif; ?></div>
	<p>
		<button type="button" class="button" id="tavoos_ms_mobile_btn"><?php esc_html_e( 'Choose mobile image', 'tavoos-image-carousel' ); ?></button>
		<button type="button" class="button" id="tavoos_ms_mobile_del"><?php esc_html_e( 'Remove', 'tavoos-image-carousel' ); ?></button>
	</p>
	<p style="color:#666"><?php esc_html_e( 'Formats: JPG, PNG, WEBP and animated GIF. Choose the slider(s) this slide is shown in from the "Sliders (placements)" box. Set the order in "Page Attributes → Order" (lower number = shown first).', 'tavoos-image-carousel' ); ?></p>
	<?php
}

add_action( 'admin_enqueue_scripts', function( $hook ) {
	$screen = get_current_screen();

	// Sliders can't be nested, so hide the "Parent" field that hierarchical taxonomies get.
	if ( in_array( $hook, array( 'edit-tags.php', 'term.php' ), true ) && 'tavoos_ms_slider' === $screen->taxonomy ) {
		wp_add_inline_style( 'common', '.term-parent-wrap{display:none}' );
	}

	if ( in_array( $hook, array( 'post.php', 'post-new.php' ), true ) && 'tavoos_ms_slide' === $screen->post_type ) {
		wp_enqueue_media();
		wp_enqueue_script( 'tavoos-image-carousel-admin', TAVOOS_MS_URL . 'assets/js/admin.js', array( 'jquery' ), TAVOOS_MS_VERSION, true );
		wp_localize_script( 'tavoos-image-carousel-admin', 'tavoosImageCarouselAdmin', array(
			'title' => __( 'Mobile image', 'tavoos-image-carousel' ),
		) );
	}
} );

add_action( 'save_post_tavoos_ms_slide', function( $id ) {
	if ( ! isset( $_POST['tavoos_ms_slide_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tavoos_ms_slide_nonce'] ) ), 'tavoos_ms_slide_save' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $id ) ) {
		return;
	}
	$link   = isset( $_POST['tavoos_ms_link'] ) ? esc_url_raw( wp_unslash( $_POST['tavoos_ms_link'] ) ) : '';
	$mobile = isset( $_POST['tavoos_ms_mobile_img'] ) ? absint( $_POST['tavoos_ms_mobile_img'] ) : 0;
	update_post_meta( $id, '_tavoos_ms_link', $link );
	update_post_meta( $id, '_tavoos_ms_mobile_img', $mobile );
} );

add_filter( 'manage_tavoos_ms_slide_posts_columns', function( $c ) {
	return array(
		'cb'                        => $c['cb'],
		'tavoos_ms_img'             => __( 'Image', 'tavoos-image-carousel' ),
		'title'                     => __( 'Title', 'tavoos-image-carousel' ),
		'taxonomy-tavoos_ms_slider' => __( 'Slider', 'tavoos-image-carousel' ),
		'tavoos_ms_order'           => __( 'Order', 'tavoos-image-carousel' ),
		'date'                      => $c['date'],
	);
} );

add_action( 'manage_tavoos_ms_slide_posts_custom_column', function( $col, $id ) {
	if ( 'tavoos_ms_img' === $col ) {
		$u = get_the_post_thumbnail_url( $id, 'medium' );
		if ( $u ) {
			echo '<img src="' . esc_url( $u ) . '" style="width:160px;height:auto;border-radius:6px" alt="">';
		}
	}
	if ( 'tavoos_ms_order' === $col ) {
		echo (int) get_post_field( 'menu_order', $id );
	}
}, 10, 2 );

// Warn when an older version (Sepanta Slider, its code snippet or version 1.x of this plugin) is still active.
add_action( 'admin_notices', function() {
	if ( tavoos_ms_legacy_code_active() && current_user_can( 'activate_plugins' ) ) {
		echo '<div class="notice notice-warning"><p>' . esc_html__( 'Tavoos Image Carousel: an older version of this slider (version 1.x of this plugin, the Sepanta Slider plugin or its code snippet) is still active. Deactivate or remove it — your slides are moved to Tavoos Image Carousel automatically once it is gone.', 'tavoos-image-carousel' ) . '</p></div>';
	}
} );
