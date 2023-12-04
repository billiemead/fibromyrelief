<?php
/**
 * The template to display the widgets area in the header
 *
 * @package MEDEUS
 * @since MEDEUS 1.0
 */

// Header sidebar
$medeus_header_name    = medeus_get_theme_option( 'header_widgets' );
$medeus_header_present = ! medeus_is_off( $medeus_header_name ) && is_active_sidebar( $medeus_header_name );
if ( $medeus_header_present ) {
	medeus_storage_set( 'current_sidebar', 'header' );
	$medeus_header_wide = medeus_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $medeus_header_name ) ) {
		dynamic_sidebar( $medeus_header_name );
	}
	$medeus_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $medeus_widgets_output ) ) {
		$medeus_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $medeus_widgets_output );
		$medeus_need_columns   = strpos( $medeus_widgets_output, 'columns_wrap' ) === false;
		if ( $medeus_need_columns ) {
			$medeus_columns = max( 0, (int) medeus_get_theme_option( 'header_columns' ) );
			if ( 0 == $medeus_columns ) {
				$medeus_columns = min( 6, max( 1, medeus_tags_count( $medeus_widgets_output, 'aside' ) ) );
			}
			if ( $medeus_columns > 1 ) {
				$medeus_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $medeus_columns ) . ' widget', $medeus_widgets_output );
			} else {
				$medeus_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $medeus_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'medeus_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $medeus_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $medeus_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'medeus_action_before_sidebar', 'header' );
				medeus_show_layout( $medeus_widgets_output );
				do_action( 'medeus_action_after_sidebar', 'header' );
				if ( $medeus_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $medeus_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'medeus_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
