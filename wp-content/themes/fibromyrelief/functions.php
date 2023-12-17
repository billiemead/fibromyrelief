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
add_action('wp_enqueue_scripts', 'fibromyrelief_assets', 99999);

// WordPress FMR Admin CSS
function fibromyrelief_admin_style()
{
    wp_enqueue_style('admin-styles', get_stylesheet_directory_uri() . '/adminstyles.css');
}
add_action('admin_enqueue_scripts', 'fibromyrelief_admin_style');

/**
 * @snippet FMR Duplicate posts/pages without plugins
 */
// Add the duplicate link to action list for post_row_actions
// for "post" and custom post types
add_filter( 'post_row_actions', 'fmr_duplicate_post_link', 10, 2 );
// for "page" post type
add_filter( 'page_row_actions', 'fmr_duplicate_post_link', 10, 2 );
function fmr_duplicate_post_link( $actions, $post ) {

	if( ! current_user_can( 'edit_posts' ) ) {
		return $actions;
	}

	$url = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'fmr_duplicate_post_as_draft',
				'post' => $post->ID,
			),
			'admin.php'
		),
		basename(__FILE__),
		'duplicate_nonce'
	);

	$actions[ 'duplicate' ] = '<a href="' . $url . '" title="Duplicate this item" rel="permalink">Duplicate</a>';

	return $actions;
}
/*
 * Function creates post duplicate as a draft and redirects then to the edit post screen
 */
add_action( 'admin_action_fmr_duplicate_post_as_draft', 'fmr_duplicate_post_as_draft' );
function fmr_duplicate_post_as_draft(){

	// check if post ID has been provided and action
	if ( empty( $_GET[ 'post' ] ) ) {
		wp_die( 'No post to duplicate has been provided!' );
	}

	// Nonce verification
	if ( ! isset( $_GET[ 'duplicate_nonce' ] ) || ! wp_verify_nonce( $_GET[ 'duplicate_nonce' ], basename( __FILE__ ) ) ) {
		return;
	}

	// Get the original post id
	$post_id = absint( $_GET[ 'post' ] );

	// And all the original post data then
	$post = get_post( $post_id );

	/*
	 * if you don't want current user to be the new post author,
	 * then change next couple of lines to this: $new_post_author = $post->post_author;
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;

	// if post data exists (I am sure it is, but just in a case), create the post duplicate
	if ( $post ) {

		// new post data array
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_name'      => $post->post_name,
			'post_parent'    => $post->post_parent,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft',
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);

		// insert the post by wp_insert_post() function
		$new_post_id = wp_insert_post( $args );

		/*
		 * get all current post terms ad set them to the new post draft
		 */
		$taxonomies = get_object_taxonomies( get_post_type( $post ) ); // returns array of taxonomy names for post type, ex array("category", "post_tag");
		if( $taxonomies ) {
			foreach ( $taxonomies as $taxonomy ) {
				$post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
				wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
			}
		}

		// duplicate all post meta
		$post_meta = get_post_meta( $post_id );
		if( $post_meta ) {

			foreach ( $post_meta as $meta_key => $meta_values ) {

				if( '_wp_old_slug' == $meta_key ) { // do nothing for this meta key
					continue;
				}

				foreach ( $meta_values as $meta_value ) {
					add_post_meta( $new_post_id, $meta_key, $meta_value );
				}
			}
		}

		// finally, redirect to the edit post screen for the new draft
		// wp_safe_redirect(
		// 	add_query_arg(
		// 		array(
		// 			'action' => 'edit',
		// 			'post' => $new_post_id
		// 		),
		// 		admin_url( 'post.php' )
		// 	)
		// );
		// exit;
		// or we can redirect to all posts with a message
		wp_safe_redirect(
			add_query_arg(
				array(
					'post_type' => ( 'post' !== get_post_type( $post ) ? get_post_type( $post ) : false ),
					'saved' => 'post_duplication_created' // just a custom slug here
				),
				admin_url( 'edit.php' )
			)
		);
		exit;

	} else {
		wp_die( 'Post creation failed, could not find original post.' );
	}

}
/*
 * In case we decided to add admin notices
 */
add_action( 'admin_notices', 'fimr_duplication_admin_notice' );
function fimr_duplication_admin_notice() {

	// Get the current screen
	$screen = get_current_screen();

	if ( 'edit' !== $screen->base ) {
		return;
	}

    //Checks if settings updated
    if ( isset( $_GET[ 'saved' ] ) && 'post_duplication_created' == $_GET[ 'saved' ] ) {

		 echo '<div class="notice notice-success is-dismissible"><p>Post copy created.</p></div>';

    }
}
add_filter('body_class', 'custom_class');
function custom_class($classes)
{
    if (is_front_page()) {
        $classes[] = 'home-page';
    }
    if (is_page('store')) {
        $classes[] = 'store-page';
    }
    if (is_page('about')) {
        $classes[] = 'about-page';
    }
    if (is_page('news-blog')) {
        $classes[] = 'news-blog-page';
    }
    if (is_page('contact')) {
        $classes[] = 'contact-page';
    }
    if (is_page('privacy-policy')) {
        $classes[] = 'privacy-policy-page';
    }
    if (is_page('terms-and-conditions')) {
        $classes[] = 'terms-conditions-page';
    }
    return $classes;
}

?>