<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package MEDEUS
 * @since MEDEUS 1.0.10
 */

// Copyright area
?> 
<div class="footer_copyright_wrap
<?php
$medeus_copyright_scheme = medeus_get_theme_option( 'copyright_scheme' );
if ( ! empty( $medeus_copyright_scheme ) && ! medeus_is_inherit( $medeus_copyright_scheme  ) ) {
	echo ' scheme_' . esc_attr( $medeus_copyright_scheme );
}
?>
				">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text">
			<?php
				$medeus_copyright = medeus_get_theme_option( 'copyright' );
			if ( ! empty( $medeus_copyright ) ) {
				// Replace {{Y}} or {Y} with the current year
				$medeus_copyright = str_replace( array( '{{Y}}', '{Y}' ), date( 'Y' ), $medeus_copyright );
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$medeus_copyright = medeus_prepare_macros( $medeus_copyright );
				// Display copyright
				echo wp_kses( nl2br( $medeus_copyright ), 'medeus_kses_content' );
			}
			?>
			</div>
		</div>
	</div>
</div>
