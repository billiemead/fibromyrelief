<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package MEDEUS
 * @since MEDEUS 1.71.0
 */

$medeus_template_args = get_query_var( 'medeus_template_args' );
if ( ! is_array( $medeus_template_args ) ) {
	$medeus_template_args = array(
								'type'    => 'band',
								'columns' => 1
								);
}

$medeus_columns       = 1;

$medeus_expanded      = ! medeus_sidebar_present() && medeus_get_theme_option( 'expand_content' ) == 'expand';

$medeus_post_format   = get_post_format();
$medeus_post_format   = empty( $medeus_post_format ) ? 'standard' : str_replace( 'post-format-', '', $medeus_post_format );

if ( is_array( $medeus_template_args ) ) {
	$medeus_columns    = empty( $medeus_template_args['columns'] ) ? 1 : max( 1, $medeus_template_args['columns'] );
	$medeus_blog_style = array( $medeus_template_args['type'], $medeus_columns );
	if ( ! empty( $medeus_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $medeus_columns > 1 ) {
	    $medeus_columns_class = medeus_get_column_class( 1, $medeus_columns, ! empty( $medeus_template_args['columns_tablet']) ? $medeus_template_args['columns_tablet'] : '', ! empty($medeus_template_args['columns_mobile']) ? $medeus_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $medeus_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $medeus_post_format ) );
	medeus_add_blog_animation( $medeus_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$medeus_hover      = ! empty( $medeus_template_args['hover'] ) && ! medeus_is_inherit( $medeus_template_args['hover'] )
							? $medeus_template_args['hover']
							: medeus_get_theme_option( 'image_hover' );
	$medeus_components = ! empty( $medeus_template_args['meta_parts'] )
							? ( is_array( $medeus_template_args['meta_parts'] )
								? $medeus_template_args['meta_parts']
								: array_map( 'trim', explode( ',', $medeus_template_args['meta_parts'] ) )
								)
							: medeus_array_get_keys_by_value( medeus_get_theme_option( 'meta_parts' ) );
	medeus_show_post_featured( apply_filters( 'medeus_filter_args_featured',
		array(
			'no_links'   => ! empty( $medeus_template_args['no_links'] ),
			'hover'      => $medeus_hover,
			'meta_parts' => $medeus_components,
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $medeus_template_args['thumb_size'] )
								? $medeus_template_args['thumb_size']
								: medeus_get_thumb_size( 
								in_array( $medeus_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( medeus_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $medeus_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$medeus_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$medeus_show_title = get_the_title() != '';
		$medeus_show_meta  = count( $medeus_components ) > 0 && ! in_array( $medeus_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $medeus_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'medeus_filter_show_blog_categories', $medeus_show_meta && in_array( 'categories', $medeus_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'medeus_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						medeus_show_post_meta( apply_filters(
															'medeus_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $medeus_hover, 1
															)
											);
						?>
					</div>
					<?php
					$medeus_components = medeus_array_delete_by_value( $medeus_components, 'categories' );
					do_action( 'medeus_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'medeus_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'medeus_action_before_post_title' );
					if ( empty( $medeus_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'medeus_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $medeus_template_args['excerpt_length'] ) && ! in_array( $medeus_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$medeus_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'medeus_filter_show_blog_excerpt', empty( $medeus_template_args['hide_excerpt'] ) && medeus_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				medeus_show_post_content( $medeus_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'medeus_filter_show_blog_meta', $medeus_show_meta, $medeus_components, 'band' ) ) {
			if ( count( $medeus_components ) > 0 ) {
				do_action( 'medeus_action_before_post_meta' );
				medeus_show_post_meta(
					apply_filters(
						'medeus_filter_post_meta_args', array(
							'components' => join( ',', $medeus_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'medeus_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'medeus_filter_show_blog_readmore', ! $medeus_show_title || ! empty( $medeus_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $medeus_template_args['no_links'] ) ) {
				do_action( 'medeus_action_before_post_readmore' );
				medeus_show_post_more_link( $medeus_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'medeus_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $medeus_template_args ) ) {
	if ( ! empty( $medeus_template_args['slider'] ) || $medeus_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
