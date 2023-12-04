<?php
/**
 * The template to display default site footer
 *
 * @package MEDEUS
 * @since MEDEUS 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$medeus_footer_scheme = medeus_get_theme_option( 'footer_scheme' );
if ( ! empty( $medeus_footer_scheme ) && ! medeus_is_inherit( $medeus_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $medeus_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'medeus_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
