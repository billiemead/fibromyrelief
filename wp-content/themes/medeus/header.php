<?php
/**
 * The Header: Logo and main menu
 *
 * @package MEDEUS
 * @since MEDEUS 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js<?php
	// Class scheme_xxx need in the <html> as context for the <body>!
	echo ' scheme_' . esc_attr( medeus_get_theme_option( 'color_scheme' ) );
?>">

<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
	do_action( 'medeus_action_before_body' );
	?>

	<div class="<?php echo esc_attr( apply_filters( 'medeus_filter_body_wrap_class', 'body_wrap' ) ); ?>" <?php do_action('medeus_action_body_wrap_attributes'); ?>>

		<?php do_action( 'medeus_action_before_page_wrap' ); ?>

		<div class="<?php echo esc_attr( apply_filters( 'medeus_filter_page_wrap_class', 'page_wrap' ) ); ?>" <?php do_action('medeus_action_page_wrap_attributes'); ?>>

			<?php do_action( 'medeus_action_page_wrap_start' ); ?>

			<?php
			$medeus_full_post_loading = ( medeus_is_singular( 'post' ) || medeus_is_singular( 'attachment' ) ) && medeus_get_value_gp( 'action' ) == 'full_post_loading';
			$medeus_prev_post_loading = ( medeus_is_singular( 'post' ) || medeus_is_singular( 'attachment' ) ) && medeus_get_value_gp( 'action' ) == 'prev_post_loading';

			// Don't display the header elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ! $medeus_full_post_loading && ! $medeus_prev_post_loading ) {

				// Short links to fast access to the content, sidebar and footer from the keyboard
				?>
				<a class="medeus_skip_link skip_to_content_link" href="#content_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'medeus_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to content", 'medeus' ); ?></a>
				<?php if ( medeus_sidebar_present() ) { ?>
				<a class="medeus_skip_link skip_to_sidebar_link" href="#sidebar_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'medeus_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to sidebar", 'medeus' ); ?></a>
				<?php } ?>
				<a class="medeus_skip_link skip_to_footer_link" href="#footer_skip_link_anchor" tabindex="<?php echo esc_attr( apply_filters( 'medeus_filter_skip_links_tabindex', 1 ) ); ?>"><?php esc_html_e( "Skip to footer", 'medeus' ); ?></a>

				<?php
				do_action( 'medeus_action_before_header' );

				// Header
				$medeus_header_type = medeus_get_theme_option( 'header_type' );
				if ( 'custom' == $medeus_header_type && ! medeus_is_layouts_available() ) {
					$medeus_header_type = 'default';
				}
				get_template_part( apply_filters( 'medeus_filter_get_template_part', "templates/header-" . sanitize_file_name( $medeus_header_type ) ) );

				// Side menu
				if ( in_array( medeus_get_theme_option( 'menu_side' ), array( 'left', 'right' ) ) ) {
					get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/header-navi-side' ) );
				}

				// Mobile menu
				get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/header-navi-mobile' ) );

				do_action( 'medeus_action_after_header' );

			}
			?>

			<?php do_action( 'medeus_action_before_page_content_wrap' ); ?>

			<div class="page_content_wrap<?php
				if ( medeus_is_off( medeus_get_theme_option( 'remove_margins' ) ) ) {
					if ( empty( $medeus_header_type ) ) {
						$medeus_header_type = medeus_get_theme_option( 'header_type' );
					}
					if ( 'custom' == $medeus_header_type && medeus_is_layouts_available() ) {
						$medeus_header_id = medeus_get_custom_header_id();
						if ( $medeus_header_id > 0 ) {
							$medeus_header_meta = medeus_get_custom_layout_meta( $medeus_header_id );
							if ( ! empty( $medeus_header_meta['margin'] ) ) {
								?> page_content_wrap_custom_header_margin<?php
							}
						}
					}
					$medeus_footer_type = medeus_get_theme_option( 'footer_type' );
					if ( 'custom' == $medeus_footer_type && medeus_is_layouts_available() ) {
						$medeus_footer_id = medeus_get_custom_footer_id();
						if ( $medeus_footer_id ) {
							$medeus_footer_meta = medeus_get_custom_layout_meta( $medeus_footer_id );
							if ( ! empty( $medeus_footer_meta['margin'] ) ) {
								?> page_content_wrap_custom_footer_margin<?php
							}
						}
					}
				}
				do_action( 'medeus_action_page_content_wrap_class', $medeus_prev_post_loading );
				?>"<?php
				if ( apply_filters( 'medeus_filter_is_prev_post_loading', $medeus_prev_post_loading ) ) {
					?> data-single-style="<?php echo esc_attr( medeus_get_theme_option( 'single_style' ) ); ?>"<?php
				}
				do_action( 'medeus_action_page_content_wrap_data', $medeus_prev_post_loading );
			?>>
				<?php
				do_action( 'medeus_action_page_content_wrap', $medeus_full_post_loading || $medeus_prev_post_loading );

				// Single posts banner
				if ( apply_filters( 'medeus_filter_single_post_header', medeus_is_singular( 'post' ) || medeus_is_singular( 'attachment' ) ) ) {
					if ( $medeus_prev_post_loading ) {
						if ( medeus_get_theme_option( 'posts_navigation_scroll_which_block' ) != 'article' ) {
							do_action( 'medeus_action_between_posts' );
						}
					}
					// Single post thumbnail and title
					$medeus_path = apply_filters( 'medeus_filter_get_template_part', 'templates/single-styles/' . medeus_get_theme_option( 'single_style' ) );
					if ( medeus_get_file_dir( $medeus_path . '.php' ) != '' ) {
						get_template_part( $medeus_path );
					}
				}

				// Widgets area above page
				$medeus_body_style   = medeus_get_theme_option( 'body_style' );
				$medeus_widgets_name = medeus_get_theme_option( 'widgets_above_page' );
				$medeus_show_widgets = ! medeus_is_off( $medeus_widgets_name ) && is_active_sidebar( $medeus_widgets_name );
				if ( $medeus_show_widgets ) {
					if ( 'fullscreen' != $medeus_body_style ) {
						?>
						<div class="content_wrap">
							<?php
					}
					medeus_create_widgets_area( 'widgets_above_page' );
					if ( 'fullscreen' != $medeus_body_style ) {
						?>
						</div>
						<?php
					}
				}

				// Content area
				do_action( 'medeus_action_before_content_wrap' );
				?>
				<div class="content_wrap<?php echo 'fullscreen' == $medeus_body_style ? '_fullscreen' : ''; ?>">

					<?php do_action( 'medeus_action_content_wrap_start' ); ?>

					<div class="content">
						<?php
						do_action( 'medeus_action_page_content_start' );

						// Skip link anchor to fast access to the content from keyboard
						?>
						<a id="content_skip_link_anchor" class="medeus_skip_link_anchor" href="#"></a>
						<?php
						// Single posts banner between prev/next posts
						if ( ( medeus_is_singular( 'post' ) || medeus_is_singular( 'attachment' ) )
							&& $medeus_prev_post_loading 
							&& medeus_get_theme_option( 'posts_navigation_scroll_which_block' ) == 'article'
						) {
							do_action( 'medeus_action_between_posts' );
						}

						// Widgets area above content
						medeus_create_widgets_area( 'widgets_above_content' );

						do_action( 'medeus_action_page_content_start_text' );
