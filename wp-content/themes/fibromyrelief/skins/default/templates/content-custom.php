<?php
/**
 * The custom template to display the content
 *
 * Used for index/archive/search.
 *
 * @package MEDEUS
 * @since MEDEUS 1.0.50
 */

$medeus_template_args = get_query_var( 'medeus_template_args' );
if ( is_array( $medeus_template_args ) ) {
	$medeus_columns    = empty( $medeus_template_args['columns'] ) ? 2 : max( 1, $medeus_template_args['columns'] );
	$medeus_blog_style = array( $medeus_template_args['type'], $medeus_columns );
} else {
	$medeus_template_args = array();
	$medeus_blog_style = explode( '_', medeus_get_theme_option( 'blog_style' ) );
	$medeus_columns    = empty( $medeus_blog_style[1] ) ? 2 : max( 1, $medeus_blog_style[1] );
}
$medeus_blog_id       = medeus_get_custom_blog_id( join( '_', $medeus_blog_style ) );
$medeus_blog_style[0] = str_replace( 'blog-custom-', '', $medeus_blog_style[0] );
$medeus_expanded      = ! medeus_sidebar_present() && medeus_get_theme_option( 'expand_content' ) == 'expand';
$medeus_components    = ! empty( $medeus_template_args['meta_parts'] )
							? ( is_array( $medeus_template_args['meta_parts'] )
								? join( ',', $medeus_template_args['meta_parts'] )
								: $medeus_template_args['meta_parts']
								)
							: medeus_array_get_keys_by_value( medeus_get_theme_option( 'meta_parts' ) );
$medeus_post_format   = get_post_format();
$medeus_post_format   = empty( $medeus_post_format ) ? 'standard' : str_replace( 'post-format-', '', $medeus_post_format );

$medeus_blog_meta     = medeus_get_custom_layout_meta( $medeus_blog_id );
$medeus_custom_style  = ! empty( $medeus_blog_meta['scripts_required'] ) ? $medeus_blog_meta['scripts_required'] : 'none';

if ( ! empty( $medeus_template_args['slider'] ) || $medeus_columns > 1 || ! medeus_is_off( $medeus_custom_style ) ) {
	?><div class="
		<?php
		if ( ! empty( $medeus_template_args['slider'] ) ) {
			echo 'slider-slide swiper-slide';
		} else {
			echo esc_attr( ( medeus_is_off( $medeus_custom_style ) ? 'column' : sprintf( '%1$s_item %1$s_item', $medeus_custom_style ) ) . "-1_{$medeus_columns}" );
		}
		?>
	">
	<?php
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
			'post_item post_item_container post_format_' . esc_attr( $medeus_post_format )
					. ' post_layout_custom post_layout_custom_' . esc_attr( $medeus_columns )
					. ' post_layout_' . esc_attr( $medeus_blog_style[0] )
					. ' post_layout_' . esc_attr( $medeus_blog_style[0] ) . '_' . esc_attr( $medeus_columns )
					. ( ! medeus_is_off( $medeus_custom_style )
						? ' post_layout_' . esc_attr( $medeus_custom_style )
							. ' post_layout_' . esc_attr( $medeus_custom_style ) . '_' . esc_attr( $medeus_columns )
						: ''
						)
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
	// Custom layout
	do_action( 'medeus_action_show_layout', $medeus_blog_id, get_the_ID() );
	?>
</article><?php
if ( ! empty( $medeus_template_args['slider'] ) || $medeus_columns > 1 || ! medeus_is_off( $medeus_custom_style ) ) {
	?></div><?php
	// Need opening PHP-tag above just after </div>, because <div> is a inline-block element (used as column)!
}
