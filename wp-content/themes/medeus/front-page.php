<?php
/**
 * The Front Page template file.
 *
 * @package MEDEUS
 * @since MEDEUS 1.0.31
 */

get_header();

// If front-page is a static page
if ( get_option( 'show_on_front' ) == 'page' ) {

	// If Front Page Builder is enabled - display sections
	if ( medeus_is_on( medeus_get_theme_option( 'front_page_enabled', false ) ) ) {

		if ( have_posts() ) {
			the_post();
		}

		$medeus_sections = medeus_array_get_keys_by_value( medeus_get_theme_option( 'front_page_sections' ) );
		if ( is_array( $medeus_sections ) ) {
			foreach ( $medeus_sections as $medeus_section ) {
				get_template_part( apply_filters( 'medeus_filter_get_template_part', 'front-page/section', $medeus_section ), $medeus_section );
			}
		}

		// Else if this page is a blog archive
	} elseif ( is_page_template( 'blog.php' ) ) {
		get_template_part( apply_filters( 'medeus_filter_get_template_part', 'blog' ) );

		// Else - display a native page content
	} else {
		get_template_part( apply_filters( 'medeus_filter_get_template_part', 'page' ) );
	}

	// Else get the template 'index.php' to show posts
} else {
	get_template_part( apply_filters( 'medeus_filter_get_template_part', 'index' ) );
}

get_footer();
