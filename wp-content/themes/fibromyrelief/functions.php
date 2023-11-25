<?php
/**
 * Child-Theme functions and definitions
 */

// Load rtl.css because it is not autoloaded from the child theme
if ( ! function_exists( 'medeus_child_load_rtl' ) ) {
	add_filter( 'wp_enqueue_scripts', 'medeus_child_load_rtl', 3000 );
	function medeus_child_load_rtl() {
		if ( is_rtl() ) {
			wp_enqueue_style( 'medeus-style-rtl', get_template_directory_uri() . '/rtl.css' );
		}
	}
}
// Register & Enqueue all CSS & JS
function fibromyrelief_assets()
{
    wp_register_style('fibromyrelief-stylesheet', get_theme_file_uri() . '/dist/css/bundle.css', array(), '1.0.0', 'all');
    wp_enqueue_style('fibromyrelief-stylesheet');
    wp_enqueue_script('fibromyrelief_js', get_theme_file_uri() . '/dist/js/bundle.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('custom_js', get_stylesheet_directory_uri() . '/fibromyrelief-scripts.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'fibromyrelief_assets', 99);

// WordPress FMR Admin CSS
function fibromyrelief_admin_style()
{
    wp_enqueue_style('admin-styles', get_stylesheet_directory_uri() . '/adminstyles.css');
}
add_action('admin_enqueue_scripts', 'fibromyrelief_admin_style');

?>