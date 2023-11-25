<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package MEDEUS
 * @since MEDEUS 1.0
 */

if ( medeus_sidebar_present() ) {
	
	$medeus_sidebar_type = medeus_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $medeus_sidebar_type && ! medeus_is_layouts_available() ) {
		$medeus_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $medeus_sidebar_type ) {
		// Default sidebar with widgets
		$medeus_sidebar_name = medeus_get_theme_option( 'sidebar_widgets' );
		medeus_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $medeus_sidebar_name ) ) {
			dynamic_sidebar( $medeus_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$medeus_sidebar_id = medeus_get_custom_sidebar_id();
		do_action( 'medeus_action_show_layout', $medeus_sidebar_id );
	}
	$medeus_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $medeus_out ) ) {
		$medeus_sidebar_position    = medeus_get_theme_option( 'sidebar_position' );
		$medeus_sidebar_position_ss = medeus_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $medeus_sidebar_position );
			echo ' sidebar_' . esc_attr( $medeus_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $medeus_sidebar_type );

			$medeus_sidebar_scheme = apply_filters( 'medeus_filter_sidebar_scheme', medeus_get_theme_option( 'sidebar_scheme' ) );
			if ( ! empty( $medeus_sidebar_scheme ) && ! medeus_is_inherit( $medeus_sidebar_scheme ) && 'custom' != $medeus_sidebar_type ) {
				echo ' scheme_' . esc_attr( $medeus_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="medeus_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'medeus_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $medeus_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$medeus_title = apply_filters( 'medeus_filter_sidebar_control_title', 'float' == $medeus_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'medeus' ) : '' );
				$medeus_text  = apply_filters( 'medeus_filter_sidebar_control_text', 'above' == $medeus_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'medeus' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $medeus_title ); ?>"><?php echo esc_html( $medeus_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'medeus_action_before_sidebar', 'sidebar' );
				medeus_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $medeus_out ) );
				do_action( 'medeus_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'medeus_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
