<div class="front_page_section front_page_section_contacts<?php
	$medeus_scheme = medeus_get_theme_option( 'front_page_contacts_scheme' );
	if ( ! empty( $medeus_scheme ) && ! medeus_is_inherit( $medeus_scheme ) ) {
		echo ' scheme_' . esc_attr( $medeus_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( medeus_get_theme_option( 'front_page_contacts_paddings' ) );
	if ( medeus_get_theme_option( 'front_page_contacts_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$medeus_css      = '';
		$medeus_bg_image = medeus_get_theme_option( 'front_page_contacts_bg_image' );
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
	$medeus_anchor_icon = medeus_get_theme_option( 'front_page_contacts_anchor_icon' );
	$medeus_anchor_text = medeus_get_theme_option( 'front_page_contacts_anchor_text' );
if ( ( ! empty( $medeus_anchor_icon ) || ! empty( $medeus_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_contacts"'
									. ( ! empty( $medeus_anchor_icon ) ? ' icon="' . esc_attr( $medeus_anchor_icon ) . '"' : '' )
									. ( ! empty( $medeus_anchor_text ) ? ' title="' . esc_attr( $medeus_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_contacts_inner
	<?php
	if ( medeus_get_theme_option( 'front_page_contacts_fullheight' ) ) {
		echo ' medeus-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$medeus_css      = '';
			$medeus_bg_mask  = medeus_get_theme_option( 'front_page_contacts_bg_mask' );
			$medeus_bg_color_type = medeus_get_theme_option( 'front_page_contacts_bg_color_type' );
			if ( 'custom' == $medeus_bg_color_type ) {
				$medeus_bg_color = medeus_get_theme_option( 'front_page_contacts_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_contacts_content_wrap content_wrap">
			<?php

			// Title and description
			$medeus_caption     = medeus_get_theme_option( 'front_page_contacts_caption' );
			$medeus_description = medeus_get_theme_option( 'front_page_contacts_description' );
			if ( ! empty( $medeus_caption ) || ! empty( $medeus_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				// Caption
				if ( ! empty( $medeus_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<h2 class="front_page_section_caption front_page_section_contacts_caption front_page_block_<?php echo ! empty( $medeus_caption ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( $medeus_caption, 'medeus_kses_content' );
					?>
					</h2>
					<?php
				}

				// Description
				if ( ! empty( $medeus_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					?>
					<div class="front_page_section_description front_page_section_contacts_description front_page_block_<?php echo ! empty( $medeus_description ) ? 'filled' : 'empty'; ?>">
					<?php
						echo wp_kses( wpautop( $medeus_description ), 'medeus_kses_content' );
					?>
					</div>
					<?php
				}
			}

			// Content (text)
			$medeus_content = medeus_get_theme_option( 'front_page_contacts_content' );
			$medeus_layout  = medeus_get_theme_option( 'front_page_contacts_layout' );
			if ( 'columns' == $medeus_layout && ( ! empty( $medeus_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_columns front_page_section_contacts_columns columns_wrap">
					<div class="column-1_3">
				<?php
			}

			if ( ( ! empty( $medeus_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				<div class="front_page_section_content front_page_section_contacts_content front_page_block_<?php echo ! empty( $medeus_content ) ? 'filled' : 'empty'; ?>">
					<?php
					echo wp_kses( $medeus_content, 'medeus_kses_content' );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $medeus_layout && ( ! empty( $medeus_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div><div class="column-2_3">
				<?php
			}

			// Shortcode output
			$medeus_sc = medeus_get_theme_option( 'front_page_contacts_shortcode' );
			if ( ! empty( $medeus_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_contacts_output front_page_block_<?php echo ! empty( $medeus_sc ) ? 'filled' : 'empty'; ?>">
					<?php
					medeus_show_layout( do_shortcode( $medeus_sc ) );
					?>
				</div>
				<?php
			}

			if ( 'columns' == $medeus_layout && ( ! empty( $medeus_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) ) {
				?>
				</div></div>
				<?php
			}
			?>

		</div>
	</div>
</div>
