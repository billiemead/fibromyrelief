<?php
/**
 * The template to display default site header
 *
 * @package MEDEUS
 * @since MEDEUS 1.0
 */

$medeus_header_css   = '';
$medeus_header_image = get_header_image();
$medeus_header_video = medeus_get_header_video();
if ( ! empty( $medeus_header_image ) && medeus_trx_addons_featured_image_override( is_singular() || medeus_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$medeus_header_image = medeus_get_current_mode_image( $medeus_header_image );
}

?><header class="top_panel top_panel_default
	<?php
	echo ! empty( $medeus_header_image ) || ! empty( $medeus_header_video ) ? ' with_bg_image' : ' without_bg_image';
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

	// Main menu
	get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/header-navi' ) );

	// Mobile header
	if ( medeus_is_on( medeus_get_theme_option( 'header_mobile_enabled' ) ) ) {
		get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/header-mobile' ) );
	}

	// Page title and breadcrumbs area
	if ( ! is_single() ) {
		get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/header-title' ) );
	}

	// Header widgets area
	get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/header-widgets' ) );
	?>
</header>
