<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'medeus_mailchimp_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'medeus_mailchimp_theme_setup9', 9 );
	function medeus_mailchimp_theme_setup9() {
		if ( medeus_exists_mailchimp() ) {
			add_action( 'wp_enqueue_scripts', 'medeus_mailchimp_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_mailchimp', 'medeus_mailchimp_frontend_scripts', 10, 1 );
			add_filter( 'medeus_filter_merge_styles', 'medeus_mailchimp_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'medeus_filter_tgmpa_required_plugins', 'medeus_mailchimp_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'medeus_mailchimp_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('medeus_filter_tgmpa_required_plugins',	'medeus_mailchimp_tgmpa_required_plugins');
	function medeus_mailchimp_tgmpa_required_plugins( $list = array() ) {
		if ( medeus_storage_isset( 'required_plugins', 'mailchimp-for-wp' ) && medeus_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'install' ) !== false ) {
			$list[] = array(
				'name'     => medeus_storage_get_array( 'required_plugins', 'mailchimp-for-wp', 'title' ),
				'slug'     => 'mailchimp-for-wp',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( ! function_exists( 'medeus_exists_mailchimp' ) ) {
	function medeus_exists_mailchimp() {
		return function_exists( '__mc4wp_load_plugin' ) || defined( 'MC4WP_VERSION' );
	}
}



// Custom styles and scripts
//------------------------------------------------------------------------

// Enqueue styles for frontend
if ( ! function_exists( 'medeus_mailchimp_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'medeus_mailchimp_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_mailchimp', 'medeus_mailchimp_frontend_scripts', 10, 1 );
	function medeus_mailchimp_frontend_scripts( $force = false ) {
		medeus_enqueue_optimized( 'mailchimp', $force, array(
			'css' => array(
				'medeus-mailchimp-for-wp' => array( 'src' => 'plugins/mailchimp-for-wp/mailchimp-for-wp.css' ),
			)
		) );
	}
}

// Merge custom styles
if ( ! function_exists( 'medeus_mailchimp_merge_styles' ) ) {
	//Handler of the add_filter( 'medeus_filter_merge_styles', 'medeus_mailchimp_merge_styles');
	function medeus_mailchimp_merge_styles( $list ) {
		$list[ 'plugins/mailchimp-for-wp/mailchimp-for-wp.css' ] = false;
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if ( medeus_exists_mailchimp() ) {
	$medeus_fdir = medeus_get_file_dir( 'plugins/mailchimp-for-wp/mailchimp-for-wp-style.php' );
	if ( ! empty( $medeus_fdir ) ) {
		require_once $medeus_fdir;
	}
}

