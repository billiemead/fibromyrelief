<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package MEDEUS
 * @since MEDEUS 1.0
 */

							do_action( 'medeus_action_page_content_end_text' );
							
							// Widgets area below the content
							medeus_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'medeus_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'medeus_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'medeus_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'medeus_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$medeus_body_style = medeus_get_theme_option( 'body_style' );
					$medeus_widgets_name = medeus_get_theme_option( 'widgets_below_page' );
					$medeus_show_widgets = ! medeus_is_off( $medeus_widgets_name ) && is_active_sidebar( $medeus_widgets_name );
					$medeus_show_related = medeus_is_single() && medeus_get_theme_option( 'related_position' ) == 'below_page';
					if ( $medeus_show_widgets || $medeus_show_related ) {
						if ( 'fullscreen' != $medeus_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $medeus_show_related ) {
							do_action( 'medeus_action_related_posts' );
						}

						// Widgets area below page content
						if ( $medeus_show_widgets ) {
							medeus_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $medeus_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'medeus_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'medeus_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! medeus_is_singular( 'post' ) && ! medeus_is_singular( 'attachment' ) ) || ! in_array ( medeus_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="medeus_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'medeus_action_before_footer' );

				// Footer
				$medeus_footer_type = medeus_get_theme_option( 'footer_type' );
				if ( 'custom' == $medeus_footer_type && ! medeus_is_layouts_available() ) {
					$medeus_footer_type = 'default';
				}
				get_template_part( apply_filters( 'medeus_filter_get_template_part', "templates/footer-" . sanitize_file_name( $medeus_footer_type ) ) );

				do_action( 'medeus_action_after_footer' );

			}
			?>

			<?php do_action( 'medeus_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'medeus_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'medeus_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>