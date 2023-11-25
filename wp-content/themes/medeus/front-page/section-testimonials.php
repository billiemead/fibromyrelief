<div class="front_page_section front_page_section_testimonials<?php
	$medeus_scheme = medeus_get_theme_option( 'front_page_testimonials_scheme' );
	if ( ! empty( $medeus_scheme ) && ! medeus_is_inherit( $medeus_scheme ) ) {
		echo ' scheme_' . esc_attr( $medeus_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( medeus_get_theme_option( 'front_page_testimonials_paddings' ) );
	if ( medeus_get_theme_option( 'front_page_testimonials_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$medeus_css      = '';
		$medeus_bg_image = medeus_get_theme_option( 'front_page_testimonials_bg_image' );
		if ( ! empty( $medeus_bg_image ) ) {
			$medeus_css .= 'background-image: url(' . esc_url( medeus_get_attachment_url( $medeus_bg_image ) ) . ');';
		}
		if ( ! empty( $medeus_css ) ) {
			echo ' style="' . esc_attr( $medeus_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$medeus_anchor_icon = medeus_get_theme_option( 'front_page_testimonials_anchor_icon' );
	$medeus_anchor_text = medeus_get_theme_option( 'front_page_testimonials_anchor_text' );
if ( ( ! empty( $medeus_anchor_icon ) || ! empty( $medeus_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_testimonials"'
									. ( ! empty( $medeus_anchor_icon ) ? ' icon="' . esc_attr( $medeus_anchor_icon ) . '"' : '' )
									. ( ! empty( $medeus_anchor_text ) ? ' title="' . esc_attr( $medeus_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_testimonials_inner
	<?php
	if ( medeus_get_theme_option( 'front_page_testimonials_fullheight' ) ) {
		echo ' medeus-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$medeus_css      = '';
			$medeus_bg_mask  = medeus_get_theme_option( 'front_page_testimonials_bg_mask' );
			$medeus_bg_color_type = medeus_get_theme_option( 'front_page_testimonials_bg_color_type' );
			if ( 'custom' == $medeus_bg_color_type ) {
				$medeus_bg_color = medeus_get_theme_option( 'front_page_testimonials_bg_color' );
			} elseif ( 'scheme_bg_color' == $medeus_bg_color_type ) {
				$medeus_bg_color = medeus_get_scheme_color( 'bg_color', $medeus_scheme );
			} else {
				$medeus_bg_color = '';
			}
			if ( ! empty( $medeus_bg_color ) && $medeus_bg_mask > 0 ) {
				$medeus_css .= 'background-color: ' . esc_attr(
					1 == $medeus_bg_mask ? $medeus_bg_color : medeus_hex2rgba( $medeus_bg_color, $medeus_bg_mask )
				) . ';';
			}
			if ( ! empty( $medeus_css ) ) {
				echo ' style="' . esc_attr( $medeus_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_testimonials_content_wrap content_wrap">
			<?php
			// Caption
			$medeus_caption = medeus_get_theme_option( 'front_page_testimonials_caption' );
			if ( ! empty( $medeus_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_testimonials_caption front_page_block_<?php echo ! empty( $medeus_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $medeus_caption, 'medeus_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$medeus_description = medeus_get_theme_option( 'front_page_testimonials_description' );
			if ( ! empty( $medeus_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_testimonials_description front_page_block_<?php echo ! empty( $medeus_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $medeus_description ), 'medeus_kses_content' ); ?></div>
				<?php
			}

			// Content (widgets)
			?>
			<div class="front_page_section_output front_page_section_testimonials_output">
				<?php
				if ( is_active_sidebar( 'front_page_testimonials_widgets' ) ) {
					dynamic_sidebar( 'front_page_testimonials_widgets' );
				} elseif ( current_user_can( 'edit_theme_options' ) ) {
					if ( ! medeus_exists_trx_addons() ) {
						medeus_customizer_need_trx_addons_message();
					} else {
						medeus_customizer_need_widgets_message( 'front_page_testimonials_caption', 'ThemeREX Addons - Testimonials' );
					}
				}
				?>
			</div>
		</div>
	</div>
</div>
