<?php
/**
 * Required plugins
 *
 * @package MEDEUS
 * @since MEDEUS 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$medeus_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'medeus' ),
	'page_builders' => esc_html__( 'Page Builders', 'medeus' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'medeus' ),
	'socials'       => esc_html__( 'Socials and Communities', 'medeus' ),
	'events'        => esc_html__( 'Events and Appointments', 'medeus' ),
	'content'       => esc_html__( 'Content', 'medeus' ),
	'other'         => esc_html__( 'Other', 'medeus' ),
);
$medeus_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'medeus' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'medeus' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $medeus_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'medeus' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'medeus' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $medeus_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'medeus' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'medeus' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $medeus_theme_required_plugins_groups['page_builders'],
	),
	'js_composer'                => array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'medeus' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'medeus' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'js_composer.jpg',
		'group'       => $medeus_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'medeus' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'medeus' ),
		'required'    => false,
		'logo'        => 'woocommerce.png',
		'group'       => $medeus_theme_required_plugins_groups['ecommerce'],
	),
	'elegro-payment'             => array(
		'title'       => esc_html__( 'Elegro Crypto Payment', 'medeus' ),
		'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'medeus' ),
		'required'    => false,
		'logo'        => 'elegro-payment.png',
		'group'       => $medeus_theme_required_plugins_groups['ecommerce'],
	),
	'instagram-feed'             => array(
		'title'       => esc_html__( 'Instagram Feed', 'medeus' ),
		'description' => esc_html__( "Displays the latest photos from your profile on Instagram", 'medeus' ),
		'required'    => false,
		'logo'        => 'instagram-feed.png',
		'group'       => $medeus_theme_required_plugins_groups['socials'],
	),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'medeus' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'medeus' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $medeus_theme_required_plugins_groups['socials'],
	),
	'booked'                     => array(
		'title'       => esc_html__( 'Booked Appointments', 'medeus' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'booked.png',
		'group'       => $medeus_theme_required_plugins_groups['events'],
	),
	'the-events-calendar'        => array(
		'title'       => esc_html__( 'The Events Calendar', 'medeus' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'the-events-calendar.png',
		'group'       => $medeus_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'medeus' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'medeus' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $medeus_theme_required_plugins_groups['content'],
	),

	'latepoint'                  => array(
		'title'       => esc_html__( 'LatePoint', 'medeus' ),
		'description' => '',
		'required'    => false,
		'logo'        => medeus_get_file_url( 'plugins/latepoint/latepoint.png' ),
		'group'       => $medeus_theme_required_plugins_groups['events'],
	),
	'advanced-popups'                  => array(
		'title'       => esc_html__( 'Advanced Popups', 'medeus' ),
		'description' => '',
		'required'    => false,
		'logo'        => medeus_get_file_url( 'plugins/advanced-popups/advanced-popups.jpg' ),
		'group'       => $medeus_theme_required_plugins_groups['content'],
	),
	'devvn-image-hotspot'                  => array(
		'title'       => esc_html__( 'Image Hotspot by DevVN', 'medeus' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => medeus_get_file_url( 'plugins/devvn-image-hotspot/devvn-image-hotspot.png' ),
		'group'       => $medeus_theme_required_plugins_groups['content'],
	),
	'ti-woocommerce-wishlist'                  => array(
		'title'       => esc_html__( 'TI WooCommerce Wishlist', 'medeus' ),
		'description' => '',
		'required'    => false,
		'logo'        => medeus_get_file_url( 'plugins/ti-woocommerce-wishlist/ti-woocommerce-wishlist.png' ),
		'group'       => $medeus_theme_required_plugins_groups['ecommerce'],
	),
	'woo-smart-quick-view'                  => array(
		'title'       => esc_html__( 'WPC Smart Quick View for WooCommerce', 'medeus' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => medeus_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.png' ),
		'group'       => $medeus_theme_required_plugins_groups['ecommerce'],
	),
	'twenty20'                  => array(
		'title'       => esc_html__( 'Twenty20 Image Before-After', 'medeus' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => medeus_get_file_url( 'plugins/twenty20/twenty20.png' ),
		'group'       => $medeus_theme_required_plugins_groups['content'],
	),
	'essential-grid'             => array(
		'title'       => esc_html__( 'Essential Grid', 'medeus' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'essential-grid.png',
		'group'       => $medeus_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'medeus' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'revslider.png',
		'group'       => $medeus_theme_required_plugins_groups['content'],
	),
	'sitepress-multilingual-cms' => array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'medeus' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'medeus' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'sitepress-multilingual-cms.png',
		'group'       => $medeus_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'Cookie Information', 'medeus' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'medeus' ),
		'required'    => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $medeus_theme_required_plugins_groups['other'],
	),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'medeus' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'medeus' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $medeus_theme_required_plugins_groups['other'],
	),
);

if ( MEDEUS_THEME_FREE ) {
	unset( $medeus_theme_required_plugins['js_composer'] );
	unset( $medeus_theme_required_plugins['booked'] );
	unset( $medeus_theme_required_plugins['the-events-calendar'] );
	unset( $medeus_theme_required_plugins['calculated-fields-form'] );
	unset( $medeus_theme_required_plugins['essential-grid'] );
	unset( $medeus_theme_required_plugins['revslider'] );
	unset( $medeus_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $medeus_theme_required_plugins['trx_updater'] );
	unset( $medeus_theme_required_plugins['trx_popup'] );
}

// Add plugins list to the global storage
medeus_storage_set( 'required_plugins', $medeus_theme_required_plugins );
