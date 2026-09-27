<?php
/**
 * Admin screens: slider settings form, slide meta box and list columns.
 *
 * @package MaxSlider
 */

defined( 'ABSPATH' ) || exit;

/**
 * The shortcode that displays a slider.
 *
 * @param WP_Term $term Slider term.
 * @return string
 */
function max_slider_shortcode_for( $term ) {
	return '[sp_slider id="' . $term->slug . '"]';
}

/**
 * Print the slider settings fields.
 *
 * @param array  $o    Current settings.
 * @param string $wrap `tr` for the edit screen table, `div` for the add form.
 */
function max_slider_print_fields( $o, $wrap ) {
	foreach ( max_slider_fields() as $key => $f ) {
		$name = 'sp_' . $key;

		if ( isset( $f['choices'] ) ) {
			$input = '<select name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '">';
			foreach ( $f['choices'] as $v => $l ) {
				$input .= '<option value="' . esc_attr( $v ) . '"' . selected( (string) $o[ $key ], (string) $v, false ) . '>' . esc_html( $l ) . '</option>';
			}
			$input .= '</select>';
		} elseif ( isset( $f['type'] ) && 'color' === $f['type'] ) {
			$input = '<input type="color" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" value="' . esc_attr( $o[ $key ] ) . '" style="width:90px;height:34px;padding:2px">';
		} else {
			$input = '<input type="number" name="' . esc_attr( $name ) . '" id="' . esc_attr( $name ) . '" min="' . esc_attr( $f['min'] ) . '" max="' . esc_attr( $f['max'] ) . '" step="' . esc_attr( $f['step'] ) . '" value="' . esc_attr( $o[ $key ] ) . '" style="width:90px">';
		}

		$label = '<label for="' . esc_attr( $name ) . '">' . esc_html( $f['label'] ) . '</label>';
		if ( 'tr' === $wrap ) {
			echo '<tr class="form-field"><th scope="row">' . $label . '</th><td>' . $input . '</td></tr>'; // phpcs:ignore WordPress.Security.EscapeOutput -- built from escaped parts.
		} else {
			echo '<div class="form-field">' . $label . $input . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput -- built from escaped parts.
		}
	}
}

// Sliders can't be nested, so hide the "Parent" field that hierarchical taxonomies get.
add_action( 'admin_head-edit-tags.php', 'max_slider_hide_parent_field' );
add_action( 'admin_head-term.php', 'max_slider_hide_parent_field' );
function max_slider_hide_parent_field() {
	if ( 'sp_slider' === get_current_screen()->taxonomy ) {
		echo '<style>.term-parent-wrap{display:none}</style>';
	}
}

add_action( 'sp_slider_add_form_fields', function() {
	max_slider_print_fields( max_slider_defaults(), 'div' );
} );

add_action( 'sp_slider_edit_form_fields', function( $t ) {
	echo '<tr class="form-field"><th scope="row">' . esc_html__( 'Display code', 'max-slider' ) . '</th><td><code style="font-size:15px;padding:6px 10px;user-select:all">' . esc_html( max_slider_shortcode_for( $t ) ) . '</code><p class="description">' . esc_html__( 'Put this code in the Elementor "Shortcode" widget, a Shortcode block or any page.', 'max-slider' ) . '</p></td></tr>';
	max_slider_print_fields( max_slider_opts( $t->term_id ), 'tr' );
} );

/**
 * Save slider settings when a slider is created or edited.
 * Nonce and capability are checked by WordPress before these hooks fire.
 *
 * @param int $term_id Slider term ID.
 */
function max_slider_save_term( $term_id ) {
	if ( ! current_user_can( 'manage_categories' ) ) {
		return;
	}
	foreach ( array_keys( max_slider_defaults() ) as $k ) {
		if ( isset( $_POST[ 'sp_' . $k ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			update_term_meta( $term_id, 'sp_' . $k, (string) max_slider_sanitize( $k, wp_unslash( $_POST[ 'sp_' . $k ] ) ) ); // phpcs:ignore WordPress.Security.NonceVerification
		}
	}
}
add_action( 'created_sp_slider', 'max_slider_save_term' );
add_action( 'edited_sp_slider', 'max_slider_save_term' );

add_filter( 'manage_edit-sp_slider_columns', function( $c ) {
	$n = array();
	foreach ( $c as $k => $v ) {
		$n[ $k ] = $v;
		if ( 'name' === $k ) {
			$n['sp_code'] = __( 'Display code', 'max-slider' );
		}
	}
	unset( $n['description'] );
	return $n;
} );

add_filter( 'manage_sp_slider_custom_column', function( $out, $col, $id ) {
	if ( 'sp_code' === $col ) {
		$t   = get_term( $id );
		$out = '<code style="user-select:all">' . esc_html( max_slider_shortcode_for( $t ) ) . '</code>';
	}
	return $out;
}, 10, 3 );

/* ----- Slide meta box ----- */

add_action( 'add_meta_boxes_sp_slide', function() {
	add_meta_box( 'sp_slide_box', __( 'Slide settings', 'max-slider' ), 'max_slider_slide_box', 'sp_slide', 'normal', 'high' );
} );

/**
 * Render the slide settings meta box.
 *
 * @param WP_Post $post Slide.
 */
function max_slider_slide_box( $post ) {
	wp_nonce_field( 'sp_slide_save', 'sp_slide_nonce' );
	$link = get_post_meta( $post->ID, 'sp_link', true );
	$mid  = (int) get_post_meta( $post->ID, 'sp_mobile_img', true );
	$murl = $mid ? wp_get_attachment_url( $mid ) : '';
	?>
	<p>
		<label for="sp_link"><b><?php esc_html_e( 'Slide link', 'max-slider' ); ?></b> <?php esc_html_e( '(optional)', 'max-slider' ); ?></label><br>
		<input type="url" name="sp_link" id="sp_link" value="<?php echo esc_attr( $link ); ?>" style="width:100%;direction:ltr" placeholder="https://example.com/shop/">
	</p>
	<p><b><?php esc_html_e( 'Mobile image', 'max-slider' ); ?></b> <?php esc_html_e( '(optional)', 'max-slider' ); ?></p>
	<input type="hidden" name="sp_mobile_img" id="sp_mobile_img" value="<?php echo esc_attr( $mid ? $mid : '' ); ?>">
	<div id="sp_mobile_prev"><?php if ( $murl ) : ?><img src="<?php echo esc_url( $murl ); ?>" style="max-width:220px;border-radius:8px" alt=""><?php endif; ?></div>
	<p>
		<button type="button" class="button" id="sp_mobile_btn"><?php esc_html_e( 'Choose mobile image', 'max-slider' ); ?></button>
		<button type="button" class="button" id="sp_mobile_del"><?php esc_html_e( 'Remove', 'max-slider' ); ?></button>
	</p>
	<p style="color:#666"><?php esc_html_e( 'Formats: JPG, PNG, WEBP and animated GIF. Choose the slider(s) this slide is shown in from the "Sliders (placements)" box. Set the order in "Page Attributes → Order" (lower number = shown first).', 'max-slider' ); ?></p>
	<?php
}

add_action( 'admin_enqueue_scripts', function( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) || 'sp_slide' !== get_current_screen()->post_type ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script( 'max-slider-admin', MAX_SLIDER_URL . 'assets/js/admin.js', array( 'jquery' ), MAX_SLIDER_VERSION, true );
	wp_localize_script( 'max-slider-admin', 'maxSliderAdmin', array(
		'title' => __( 'Mobile image', 'max-slider' ),
	) );
} );

add_action( 'save_post_sp_slide', function( $id ) {
	if ( ! isset( $_POST['sp_slide_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['sp_slide_nonce'] ), 'sp_slide_save' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $id ) ) {
		return;
	}
	update_post_meta( $id, 'sp_link', esc_url_raw( wp_unslash( $_POST['sp_link'] ?? '' ) ) );
	update_post_meta( $id, 'sp_mobile_img', absint( $_POST['sp_mobile_img'] ?? 0 ) );
} );

add_filter( 'manage_sp_slide_posts_columns', function( $c ) {
	return array(
		'cb'                 => $c['cb'],
		'sp_img'             => __( 'Image', 'max-slider' ),
		'title'              => __( 'Title', 'max-slider' ),
		'taxonomy-sp_slider' => __( 'Slider', 'max-slider' ),
		'sp_order'           => __( 'Order', 'max-slider' ),
		'date'               => $c['date'],
	);
} );

add_action( 'manage_sp_slide_posts_custom_column', function( $col, $id ) {
	if ( 'sp_img' === $col ) {
		$u = get_the_post_thumbnail_url( $id, 'medium' );
		if ( $u ) {
			echo '<img src="' . esc_url( $u ) . '" style="width:160px;height:auto;border-radius:6px" alt="">';
		}
	}
	if ( 'sp_order' === $col ) {
		echo (int) get_post_field( 'menu_order', $id );
	}
}, 10, 2 );

// Warn when the original code snippet is still active next to the plugin.
add_action( 'admin_notices', function() {
	if ( function_exists( 'sp_render_slider' ) && current_user_can( 'activate_plugins' ) ) {
		echo '<div class="notice notice-warning"><p>' . esc_html__( 'Max Slider: the old Sepanta Slider plugin or [sp_slider] code snippet is still active. Remove it — the plugin already does the same job and keeps all your slides.', 'max-slider' ) . '</p></div>';
	}
} );
