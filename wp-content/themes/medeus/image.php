<?php
/**
 * The template to display the attachment
 *
 * @package MEDEUS
 * @since MEDEUS 1.0
 */


get_header();

while ( have_posts() ) {
	the_post();

	// Display post's content
	get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/content', 'single-' . medeus_get_theme_option( 'single_style' ) ), 'single-' . medeus_get_theme_option( 'single_style' ) );

	// Parent post navigation.
	$medeus_posts_navigation = medeus_get_theme_option( 'posts_navigation' );
	if ( 'links' == $medeus_posts_navigation ) {
		?>
		<div class="nav-links-single<?php
			if ( ! medeus_is_off( medeus_get_theme_option( 'posts_navigation_fixed' ) ) ) {
				echo ' nav-links-fixed fixed';
			}
		?>">
			<?php
			the_post_navigation( apply_filters( 'medeus_filter_post_navigation_args', array(
					'prev_text' => '<span class="nav-arrow"></span>'
						. '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Published in', 'medeus' ) . '</span> '
						. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'medeus' ) . '</span> '
						. '<h5 class="post-title">%title</h5>'
						. '<span class="post_date">%date</span>',
			), 'image' ) );
			?>
		</div>
		<?php
	}

	// Comments
	do_action( 'medeus_action_before_comments' );
	comments_template();
	do_action( 'medeus_action_after_comments' );
}

get_footer();
