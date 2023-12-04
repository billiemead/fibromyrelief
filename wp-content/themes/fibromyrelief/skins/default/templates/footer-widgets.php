<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package MEDEUS
 * @since MEDEUS 1.0.10
 */

// Footer sidebar
$medeus_footer_name    = medeus_get_theme_option( 'footer_widgets' );
$medeus_footer_present = ! medeus_is_off( $medeus_footer_name ) && is_active_sidebar( $medeus_footer_name );
if ( $medeus_footer_present ) {
	medeus_storage_set( 'current_sidebar', 'footer' );
	$medeus_footer_wide = medeus_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $medeus_footer_name ) ) {
		dynamic_sidebar( $medeus_footer_name );
	}
	$medeus_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $medeus_out ) ) {
		$medeus_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $medeus_out );
		$medeus_need_columns = true;   //or check: strpos($medeus_out, 'columns_wrap')===false;
		if ( $medeus_need_columns ) {
			$medeus_columns = max( 0, (int) medeus_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $medeus_columns ) {
				$medeus_columns = min( 4, max( 1, medeus_tags_count( $medeus_out, 'aside' ) ) );
			}
			if ( $medeus_columns > 1 ) {
				$medeus_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $medeus_columns ) . ' widget', $medeus_out );
			} else {
				$medeus_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $medeus_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'medeus_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $medeus_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $medeus_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'medeus_action_before_sidebar', 'footer' );
				medeus_show_layout( $medeus_out );
				do_action( 'medeus_action_after_sidebar', 'footer' );
				if ( $medeus_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $medeus_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'medeus_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
