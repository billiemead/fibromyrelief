<?php
/**
 * The template to display the socials in the footer
 *
 * @package MEDEUS
 * @since MEDEUS 1.0.10
 */


// Socials
if ( medeus_is_on( medeus_get_theme_option( 'socials_in_footer' ) ) ) {
	$medeus_output = medeus_get_socials_links();
	if ( '' != $medeus_output ) {
		?>
		<div class="footer_socials_wrap socials_wrap">
			<div class="footer_socials_inner">
				<?php medeus_show_layout( $medeus_output ); ?>
			</div>
		</div>
		<?php
	}
}
