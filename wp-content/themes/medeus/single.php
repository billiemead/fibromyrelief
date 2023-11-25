<?php
/**
 * The template to display single post
 *
 * @package MEDEUS
 * @since MEDEUS 1.0
 */

// Full post loading
$full_post_loading          = medeus_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = medeus_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = medeus_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$medeus_related_position   = medeus_get_theme_option( 'related_position' );

// Type of the prev/next post navigation
$medeus_posts_navigation   = medeus_get_theme_option( 'posts_navigation' );
$medeus_prev_post          = false;
$medeus_prev_post_same_cat = medeus_get_theme_option( 'posts_navigation_scroll_same_cat' );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( medeus_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	medeus_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'medeus_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $medeus_posts_navigation ) {
		$medeus_prev_post = get_previous_post( $medeus_prev_post_same_cat );  // Get post from same category
		if ( ! $medeus_prev_post && $medeus_prev_post_same_cat ) {
			$medeus_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $medeus_prev_post ) {
			$medeus_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $medeus_prev_post ) ) {
		medeus_sc_layouts_showed( 'featured', false );
		medeus_sc_layouts_showed( 'title', false );
		medeus_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $medeus_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/content', 'single-' . medeus_get_theme_option( 'single_style' ) ), 'single-' . medeus_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $medeus_related_position, 'inside' ) === 0 ) {
		$medeus_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'medeus_action_related_posts' );
		$medeus_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $medeus_related_content ) ) {
			$medeus_related_position_inside = max( 0, min( 9, medeus_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $medeus_related_position_inside ) {
				$medeus_related_position_inside = mt_rand( 1, 9 );
			}

			$medeus_p_number         = 0;
			$medeus_related_inserted = false;
			$medeus_in_block         = false;
			$medeus_content_start    = strpos( $medeus_content, '<div class="post_content' );
			$medeus_content_end      = strrpos( $medeus_content, '</div>' );

			for ( $i = max( 0, $medeus_content_start ); $i < min( strlen( $medeus_content ) - 3, $medeus_content_end ); $i++ ) {
				if ( $medeus_content[ $i ] != '<' ) {
					continue;
				}
				if ( $medeus_in_block ) {
					if ( strtolower( substr( $medeus_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$medeus_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $medeus_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $medeus_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$medeus_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $medeus_content[ $i + 1 ] && in_array( $medeus_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$medeus_p_number++;
					if ( $medeus_related_position_inside == $medeus_p_number ) {
						$medeus_related_inserted = true;
						$medeus_content = ( $i > 0 ? substr( $medeus_content, 0, $i ) : '' )
											. $medeus_related_content
											. substr( $medeus_content, $i );
					}
				}
			}
			if ( ! $medeus_related_inserted ) {
				if ( $medeus_content_end > 0 ) {
					$medeus_content = substr( $medeus_content, 0, $medeus_content_end ) . $medeus_related_content . substr( $medeus_content, $medeus_content_end );
				} else {
					$medeus_content .= $medeus_related_content;
				}
			}
		}

		medeus_show_layout( $medeus_content );
	}

	// Comments
	do_action( 'medeus_action_before_comments' );
	comments_template();
	do_action( 'medeus_action_after_comments' );

	// Related posts
	if ( 'below_content' == $medeus_related_position
		&& ( 'scroll' != $medeus_posts_navigation || medeus_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || medeus_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'medeus_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $medeus_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $medeus_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $medeus_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $medeus_prev_post ) ); ?>"
			<?php do_action( 'medeus_action_nav_links_single_scroll_data', $medeus_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
