<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package MEDEUS
 * @since MEDEUS 1.0
 */

$medeus_template_args = get_query_var( 'medeus_template_args' );

if ( is_array( $medeus_template_args ) ) {
	$medeus_columns    = empty( $medeus_template_args['columns'] ) ? 2 : max( 1, $medeus_template_args['columns'] );
	$medeus_blog_style = array( $medeus_template_args['type'], $medeus_columns );
    $medeus_columns_class = medeus_get_column_class( 1, $medeus_columns, ! empty( $medeus_template_args['columns_tablet']) ? $medeus_template_args['columns_tablet'] : '', ! empty($medeus_template_args['columns_mobile']) ? $medeus_template_args['columns_mobile'] : '' );
} else {
	$medeus_template_args = array();
	$medeus_blog_style = explode( '_', medeus_get_theme_option( 'blog_style' ) );
	$medeus_columns    = empty( $medeus_blog_style[1] ) ? 2 : max( 1, $medeus_blog_style[1] );
    $medeus_columns_class = medeus_get_column_class( 1, $medeus_columns );
}
$medeus_expanded   = ! medeus_sidebar_present() && medeus_get_theme_option( 'expand_content' ) == 'expand';

$medeus_post_format = get_post_format();
$medeus_post_format = empty( $medeus_post_format ) ? 'standard' : str_replace( 'post-format-', '', $medeus_post_format );

?><div class="<?php
	if ( ! empty( $medeus_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( medeus_is_blog_style_use_masonry( $medeus_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $medeus_columns ) : esc_attr( $medeus_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $medeus_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $medeus_columns )
				. ' post_layout_' . esc_attr( $medeus_blog_style[0] )
				. ' post_layout_' . esc_attr( $medeus_blog_style[0] ) . '_' . esc_attr( $medeus_columns )
	);
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
								: explode( ',', $medeus_template_args['meta_parts'] )
								)
							: medeus_array_get_keys_by_value( medeus_get_theme_option( 'meta_parts' ) );

	medeus_show_post_featured( apply_filters( 'medeus_filter_args_featured',
		array(
			'thumb_size' => ! empty( $medeus_template_args['thumb_size'] )
				? $medeus_template_args['thumb_size']
				: medeus_get_thumb_size(
				'classic' == $medeus_blog_style[0]
						? ( strpos( medeus_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $medeus_columns > 2 ? 'big' : 'huge' )
								: ( $medeus_columns > 2
									? ( $medeus_expanded ? 'square' : 'square' )
									: ($medeus_columns > 1 ? 'square' : ( $medeus_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( medeus_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $medeus_columns > 2 ? 'masonry-big' : 'full' )
								: ($medeus_columns === 1 ? ( $medeus_expanded ? 'huge' : 'big' ) : ( $medeus_columns <= 2 && $medeus_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $medeus_hover,
			'meta_parts' => $medeus_components,
			'no_links'   => ! empty( $medeus_template_args['no_links'] ),
        ),
        'content-classic',
        $medeus_template_args
    ) );

	// Title and post meta
	$medeus_show_title = get_the_title() != '';
	$medeus_show_meta  = count( $medeus_components ) > 0 && ! in_array( $medeus_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $medeus_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'medeus_filter_show_blog_meta', $medeus_show_meta, $medeus_components, 'classic' ) ) {
				if ( count( $medeus_components ) > 0 ) {
					do_action( 'medeus_action_before_post_meta' );
					medeus_show_post_meta(
						apply_filters(
							'medeus_filter_post_meta_args', array(
							'components' => join( ',', $medeus_components ),
							'seo'        => false,
							'echo'       => true,
						), $medeus_blog_style[0], $medeus_columns
						)
					);
					do_action( 'medeus_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'medeus_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'medeus_action_before_post_title' );
				if ( empty( $medeus_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'medeus_action_after_post_title' );
			}

			if( !in_array( $medeus_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'medeus_filter_show_blog_readmore', ! $medeus_show_title || ! empty( $medeus_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $medeus_template_args['no_links'] ) ) {
						do_action( 'medeus_action_before_post_readmore' );
						medeus_show_post_more_link( $medeus_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'medeus_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $medeus_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('medeus_filter_show_blog_excerpt', empty($medeus_template_args['hide_excerpt']) && medeus_get_theme_option('excerpt_length') > 0, 'classic')) {
			medeus_show_post_content($medeus_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $medeus_template_args['more_button'] )) {
			if ( empty( $medeus_template_args['no_links'] ) ) {
				do_action( 'medeus_action_before_post_readmore' );
				medeus_show_post_more_link( $medeus_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'medeus_action_after_post_readmore' );
			}
		}
		$medeus_content = ob_get_contents();
		ob_end_clean();
		medeus_show_layout($medeus_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
