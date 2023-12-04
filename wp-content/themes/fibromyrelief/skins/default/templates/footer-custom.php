<?php
/**
 * The template to display default site footer
 *
 * @package MEDEUS
 * @since MEDEUS 1.0.10
 */

$medeus_footer_id = medeus_get_custom_footer_id();
$medeus_footer_meta = get_post_meta( $medeus_footer_id, 'trx_addons_options', true );
if ( ! empty( $medeus_footer_meta['margin'] ) ) {
	medeus_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( medeus_prepare_css_value( $medeus_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $medeus_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $medeus_footer_id ) ) ); ?>
						<?php
						$medeus_footer_scheme = medeus_get_theme_option( 'footer_scheme' );
						if ( ! empty( $medeus_footer_scheme ) && ! medeus_is_inherit( $medeus_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $medeus_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'medeus_action_show_layout', $medeus_footer_id );
	?>
</footer><!-- /.footer_wrap -->
