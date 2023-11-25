<?php
/* Elegro Crypto Payment support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'medeus_elegro_payment_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'medeus_elegro_payment_theme_setup9', 9 );
	function medeus_elegro_payment_theme_setup9() {
		if ( medeus_exists_elegro_payment() ) {
			add_action( 'wp_enqueue_scripts', 'medeus_elegro_payment_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_elegro_payment', 'medeus_elegro_payment_frontend_scripts', 10, 1 );
			add_filter( 'medeus_filter_merge_styles', 'medeus_elegro_payment_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'medeus_filter_tgmpa_required_plugins', 'medeus_elegro_payment_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'medeus_elegro_payment_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('medeus_filter_tgmpa_required_plugins',	'medeus_elegro_payment_tgmpa_required_plugins');
	function medeus_elegro_payment_tgmpa_required_plugins( $list = array() ) {
		if ( medeus_storage_isset( 'required_plugins', 'woocommerce' ) && medeus_storage_isset( 'required_plugins', 'elegro-payment' ) && medeus_storage_get_array( 'required_plugins', 'elegro-payment', 'install' ) !== false ) {
			$list[] = array(
				'name'     => medeus_storage_get_array( 'required_plugins', 'elegro-payment', 'title' ),
				'slug'     => 'elegro-payment',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'medeus_exists_elegro_payment' ) ) {
	function medeus_exists_elegro_payment() {
		return class_exists( 'WC_Elegro_Payment' );
	}
}


// Enqueue styles for frontend
if ( ! function_exists( 'medeus_elegro_payment_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'medeus_elegro_payment_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_elegro_payment', 'medeus_elegro_payment_frontend_scripts', 10, 1 );
	function medeus_elegro_payment_frontend_scripts( $force = false ) {
		medeus_enqueue_optimized( 'elegro_payment', $force, array(
			'css' => array(
				'medeus-elegro-payment' => array( 'src' => 'plugins/elegro-payment/elegro-payment.css' ),
			)
		) );
	}
}

// Merge custom styles
if ( ! function_exists( 'medeus_elegro_payment_merge_styles' ) ) {
	//Handler of the add_filter('medeus_filter_merge_styles', 'medeus_elegro_payment_merge_styles');
	function medeus_elegro_payment_merge_styles( $list ) {
		$list[ 'plugins/elegro-payment/elegro-payment.css' ] = false;
		return $list;
	}
}
