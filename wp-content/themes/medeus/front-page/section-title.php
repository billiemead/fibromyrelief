<?php
$medeus_slider_sc = medeus_get_theme_option( 'front_page_title_shortcode' );
if ( ! empty( $medeus_slider_sc ) && strpos( $medeus_slider_sc, '[' ) !== false && strpos( $medeus_slider_sc, ']' ) !== false ) {

	?><div class="front_page_section front_page_section_title front_page_section_slider front_page_section_title_slider
		<?php
		if ( medeus_get_theme_option( 'front_page_title_stack' ) ) {
			echo ' sc_stack_section_on';
		}
		?>
	">
	<?php
		// Add anchor
		$medeus_anchor_icon = medeus_get_theme_option( 'front_page_title_anchor_icon' );
		$medeus_anchor_text = medeus_get_theme_option( 'front_page_title_anchor_text' );
	if ( ( ! empty( $medeus_anchor_icon ) || ! empty( $medeus_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
		echo do_shortcode(
			'[trx_sc_anchor id="front_page_section_title"'
									. ( ! empty( $medeus_anchor_icon ) ? ' icon="' . esc_attr( $medeus_anchor_icon ) . '"' : '' )
									. ( ! empty( $medeus_anchor_text ) ? ' title="' . esc_attr( $medeus_anchor_text ) . '"' : '' )
									. ']'
		);
	}
		// Show slider (or any other content, generated by shortcode)
		echo do_shortcode( $medeus_slider_sc );
	?>
	</div>
	<?php

} else {

	?>
	<div class="front_page_section front_page_section_title
		<?php
		$medeus_scheme = medeus_get_theme_option( 'front_page_title_scheme' );
		if ( ! empty( $medeus_scheme ) && ! medeus_is_inherit( $medeus_scheme ) ) {
			echo ' scheme_' . esc_attr( $medeus_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( medeus_get_theme_option( 'front_page_title_paddings' ) );
		if ( medeus_get_theme_option( 'front_page_title_stack' ) ) {
			echo ' sc_stack_section_on';
		}
		?>
		"
		<?php
		$medeus_css      = '';
		$medeus_bg_image = medeus_get_theme_option( 'front_page_title_bg_image' );
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
		$medeus_anchor_icon = medeus_get_theme_option( 'front_page_title_anchor_icon' );
		$medeus_anchor_text = medeus_get_theme_option( 'front_page_title_anchor_text' );
	if ( ( ! empty( $medeus_anchor_icon ) || ! empty( $medeus_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
		echo do_shortcode(
			'[trx_sc_anchor id="front_page_section_title"'
									. ( ! empty( $medeus_anchor_icon ) ? ' icon="' . esc_attr( $medeus_anchor_icon ) . '"' : '' )
									. ( ! empty( $medeus_anchor_text ) ? ' title="' . esc_attr( $medeus_anchor_text ) . '"' : '' )
									. ']'
		);
	}
	?>
		<div class="front_page_section_inner front_page_section_title_inner
		<?php
		if ( medeus_get_theme_option( 'front_page_title_fullheight' ) ) {
			echo ' medeus-full-height sc_layouts_flex sc_layouts_columns_middle';
		}
		?>
			"
			<?php
			$medeus_css      = '';
			$medeus_bg_mask  = medeus_get_theme_option( 'front_page_title_bg_mask' );
			$medeus_bg_color_type = medeus_get_theme_option( 'front_page_title_bg_color_type' );
			if ( 'custom' == $medeus_bg_color_type ) {
				$medeus_bg_color = medeus_get_theme_option( 'front_page_title_bg_color' );
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
			<div class="front_page_section_content_wrap front_page_section_title_content_wrap content_wrap">
				<?php
				// Caption
				$medeus_caption = medeus_get_theme_option( 'front_page_title_caption' );
				if ( ! empty( $medeus_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h1 class="front_page_section_caption front_page_section_title_caption front_page_block_<?php echo ! empty( $medeus_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $medeus_caption, 'medeus_kses_content' ); ?></h1>
					<?php
				}

				// Description (text)
				$medeus_description = medeus_get_theme_option( 'front_page_title_description' );
				if ( ! empty( $medeus_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_title_description front_page_block_<?php echo ! empty( $medeus_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $medeus_description ), 'medeus_kses_content' ); ?></div>
					<?php
				}

				// Buttons
				if ( medeus_get_theme_option( 'front_page_title_button1_link' ) != '' || medeus_get_theme_option( 'front_page_title_button2_link' ) != '' ) {
					?>
					<div class="front_page_section_buttons front_page_section_title_buttons">
					<?php
						medeus_show_layout( medeus_customizer_partial_refresh_front_page_title_button1_link() );
						medeus_show_layout( medeus_customizer_partial_refresh_front_page_title_button2_link() );
					?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php
}
