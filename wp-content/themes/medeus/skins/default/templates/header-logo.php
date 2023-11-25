<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package MEDEUS
 * @since MEDEUS 1.0
 */

$medeus_args = get_query_var( 'medeus_logo_args' );

// Site logo
$medeus_logo_type   = isset( $medeus_args['type'] ) ? $medeus_args['type'] : '';
$medeus_logo_image  = medeus_get_logo_image( $medeus_logo_type );
$medeus_logo_text   = medeus_is_on( medeus_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$medeus_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $medeus_logo_image['logo'] ) || ! empty( $medeus_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $medeus_logo_image['logo'] ) ) {
			if ( empty( $medeus_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($medeus_logo_image['logo']) && (int) $medeus_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$medeus_attr = medeus_getimagesize( $medeus_logo_image['logo'] );
				echo '<img src="' . esc_url( $medeus_logo_image['logo'] ) . '"'
						. ( ! empty( $medeus_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $medeus_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $medeus_logo_text ) . '"'
						. ( ! empty( $medeus_attr[3] ) ? ' ' . wp_kses_data( $medeus_attr[3] ) : '' )
						. '>';
			}
		} else {
			medeus_show_layout( medeus_prepare_macros( $medeus_logo_text ), '<span class="logo_text">', '</span>' );
			medeus_show_layout( medeus_prepare_macros( $medeus_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
