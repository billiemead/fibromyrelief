<?php
/**
 * The Portfolio template to display the content
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

$medeus_post_format = get_post_format();
$medeus_post_format = empty( $medeus_post_format ) ? 'standard' : str_replace( 'post-format-', '', $medeus_post_format );

?><div class="
<?php
if ( ! empty( $medeus_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( medeus_is_blog_style_use_masonry( $medeus_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $medeus_columns ) : esc_attr( $medeus_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $medeus_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $medeus_columns )
		. ( 'portfolio' != $medeus_blog_style[0] ? ' ' . esc_attr( $medeus_blog_style[0] )  . '_' . esc_attr( $medeus_columns ) : '' )
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

	$medeus_hover   = ! empty( $medeus_template_args['hover'] ) && ! medeus_is_inherit( $medeus_template_args['hover'] )
								? $medeus_template_args['hover']
								: medeus_get_theme_option( 'image_hover' );

	if ( 'dots' == $medeus_hover ) {
		$medeus_post_link = empty( $medeus_template_args['no_links'] )
								? ( ! empty( $medeus_template_args['link'] )
									? $medeus_template_args['link']
									: get_permalink()
									)
								: '';
		$medeus_target    = ! empty( $medeus_post_link ) && false === strpos( $medeus_post_link, home_url() )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$medeus_components = ! empty( $medeus_template_args['meta_parts'] )
							? ( is_array( $medeus_template_args['meta_parts'] )
								? $medeus_template_args['meta_parts']
								: explode( ',', $medeus_template_args['meta_parts'] )
								)
							: medeus_array_get_keys_by_value( medeus_get_theme_option( 'meta_parts' ) );

	// Featured image
	medeus_show_post_featured( apply_filters( 'medeus_filter_args_featured',
		array(
			'hover'         => $medeus_hover,
			'no_links'      => ! empty( $medeus_template_args['no_links'] ),
			'thumb_size'    => ! empty( $medeus_template_args['thumb_size'] )
								? $medeus_template_args['thumb_size']
								: medeus_get_thumb_size(
									medeus_is_blog_style_use_masonry( $medeus_blog_style[0] )
										? (	strpos( medeus_get_theme_option( 'body_style' ), 'full' ) !== false || $medeus_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( medeus_get_theme_option( 'body_style' ), 'full' ) !== false || $medeus_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => medeus_is_blog_style_use_masonry( $medeus_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $medeus_components,
			'class'         => 'dots' == $medeus_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $medeus_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $medeus_post_link )
												? '<a href="' . esc_url( $medeus_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $medeus_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $medeus_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $medeus_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!