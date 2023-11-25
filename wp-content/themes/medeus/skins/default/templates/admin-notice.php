<?php
/**
 * The template to display Admin notices
 *
 * @package MEDEUS
 * @since MEDEUS 1.0.1
 */

$medeus_theme_slug = get_option( 'template' );
$medeus_theme_obj  = wp_get_theme( $medeus_theme_slug );
?>
<div class="medeus_admin_notice medeus_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$medeus_theme_img = medeus_get_file_url( 'screenshot.jpg' );
	if ( '' != $medeus_theme_img ) {
		?>
		<div class="medeus_notice_image"><img src="<?php echo esc_url( $medeus_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'medeus' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="medeus_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'medeus' ),
				$medeus_theme_obj->get( 'Name' ) . ( MEDEUS_THEME_FREE ? ' ' . __( 'Free', 'medeus' ) : '' ),
				$medeus_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="medeus_notice_text">
		<p class="medeus_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $medeus_theme_obj->description ) );
			?>
		</p>
		<p class="medeus_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'medeus' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="medeus_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=medeus_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'medeus' );
			?>
		</a>
	</div>
</div>
