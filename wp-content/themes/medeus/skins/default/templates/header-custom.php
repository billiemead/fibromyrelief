<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package MEDEUS
 * @since MEDEUS 1.0.06
 */

$medeus_header_css   = '';
$medeus_header_image = get_header_image();
$medeus_header_video = medeus_get_header_video();
if ( ! empty( $medeus_header_image ) && medeus_trx_addons_featured_image_override( is_singular() || medeus_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$medeus_header_image = medeus_get_current_mode_image( $medeus_header_image );
}

$medeus_header_id = medeus_get_custom_header_id();
$medeus_header_meta = get_post_meta( $medeus_header_id, 'trx_addons_options', true );
if ( ! empty( $medeus_header_meta['margin'] ) ) {
	medeus_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( medeus_prepare_css_value( $medeus_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $medeus_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $medeus_header_id ) ) ); ?>
				<?php
				echo ! empty( $medeus_header_image ) || ! empty( $medeus_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
				if ( '' != $medeus_header_video ) {
					echo ' with_bg_video';
				}
				if ( '' != $medeus_header_image ) {
					echo ' ' . esc_attr( medeus_add_inline_css_class( 'background-image: url(' . esc_url( $medeus_header_image ) . ');' ) );
				}
				if ( is_single() && has_post_thumbnail() ) {
					echo ' with_featured_image';
				}
				if ( medeus_is_on( medeus_get_theme_option( 'header_fullheight' ) ) ) {
					echo ' header_fullheight medeus-full-height';
				}
				$medeus_header_scheme = medeus_get_theme_option( 'header_scheme' );
				if ( ! empty( $medeus_header_scheme ) && ! medeus_is_inherit( $medeus_header_scheme  ) ) {
					echo ' scheme_' . esc_attr( $medeus_header_scheme );
				}
				?>
">
	<?php

	// Background video
	if ( ! empty( $medeus_header_video ) ) {
		get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/header-video' ) );
	}

	// Custom header's layout
	do_action( 'medeus_action_show_layout', $medeus_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
