<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package MEDEUS
 * @since MEDEUS 1.0
 */

$medeus_template = apply_filters( 'medeus_filter_get_template_part', medeus_blog_archive_get_template() );

if ( ! empty( $medeus_template ) && 'index' != $medeus_template ) {

	get_template_part( $medeus_template );

} else {

	medeus_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$medeus_stickies   = is_home()
								|| ( in_array( medeus_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) medeus_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$medeus_post_type  = medeus_get_theme_option( 'post_type' );
		$medeus_args       = array(
								'blog_style'     => medeus_get_theme_option( 'blog_style' ),
								'post_type'      => $medeus_post_type,
								'taxonomy'       => medeus_get_post_type_taxonomy( $medeus_post_type ),
								'parent_cat'     => medeus_get_theme_option( 'parent_cat' ),
								'posts_per_page' => medeus_get_theme_option( 'posts_per_page' ),
								'sticky'         => medeus_get_theme_option( 'sticky_style' ) == 'columns'
															&& is_array( $medeus_stickies )
															&& count( $medeus_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		medeus_blog_archive_start();

		do_action( 'medeus_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'medeus_action_before_page_author' );
			get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'medeus_action_after_page_author' );
		}

		if ( medeus_get_theme_option( 'show_filters' ) ) {
			do_action( 'medeus_action_before_page_filters' );
			medeus_show_filters( $medeus_args );
			do_action( 'medeus_action_after_page_filters' );
		} else {
			do_action( 'medeus_action_before_page_posts' );
			medeus_show_posts( array_merge( $medeus_args, array( 'cat' => $medeus_args['parent_cat'] ) ) );
			do_action( 'medeus_action_after_page_posts' );
		}

		do_action( 'medeus_action_blog_archive_end' );

		medeus_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
