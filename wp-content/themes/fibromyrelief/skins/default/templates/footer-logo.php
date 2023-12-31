<?php
/**
 * The template to display the site logo in the footer
 *
 * @package MEDEUS
 * @since MEDEUS 1.0.10
 */

// Logo
if ( medeus_is_on( medeus_get_theme_option( 'logo_in_footer' ) ) ) {
	$medeus_logo_image = medeus_get_logo_image( 'footer' );
	$medeus_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $medeus_logo_image['logo'] ) || ! empty( $medeus_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $medeus_logo_image['logo'] ) ) {
					$medeus_attr = medeus_getimagesize( $medeus_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $medeus_logo_image['logo'] ) . '"'
								. ( ! empty( $medeus_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $medeus_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'medeus' ) . '"'
								. ( ! empty( $medeus_attr[3] ) ? ' ' . wp_kses_data( $medeus_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $medeus_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $medeus_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
