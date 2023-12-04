<?php
/**
 * Skin Setup
 *
 * @package MEDEUS
 * @since MEDEUS 1.76.0
 */


//--------------------------------------------
// SKIN DEFAULTS
//--------------------------------------------

// Return theme's (skin's) default value for the specified parameter
if ( ! function_exists( 'medeus_theme_defaults' ) ) {
	function medeus_theme_defaults( $name='', $value='' ) {
		$defaults = array(
			'page_width'          => 1290,
			'page_boxed_extra'  => 60,
			'page_fullwide_max' => 1920,
			'page_fullwide_extra' => 130,
			'sidebar_width'       => 410,
			'sidebar_gap'       => 40,
			'grid_gap'          => 30,
			'rad'               => 0,
		);
		if ( empty( $name ) ) {
			return $defaults;
		} else {
			if ( empty( $value ) && isset( $defaults[ $name ] ) ) {
				$value = $defaults[ $name ];
			}
			return $value;
		}
	}
}


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)


//--------------------------------------------
// SKIN SETTINGS
//--------------------------------------------
if ( ! function_exists( 'medeus_skin_setup' ) ) {
	add_action( 'after_setup_theme', 'medeus_skin_setup', 1 );
	function medeus_skin_setup() {

		$GLOBALS['MEDEUS_STORAGE'] = array_merge( $GLOBALS['MEDEUS_STORAGE'], array(

			// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
			'theme_pro_key'       => 'env-themerex',

			'theme_doc_url'       => '//medeus.themerex.net/doc',

			'theme_demofiles_url' => '//demofiles.themerex.net/medeus/',
			
			'theme_rate_url'      => '//themeforest.net/download',

			'theme_custom_url'    => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themeinstall',

			'theme_support_url'   => '//themerex.net/support/',

			'theme_download_url'  => 'https://themeforest.net/item/medeus-medical-multipurpose-doctor-wordpress-theme/40453203',        // Themerex

			'theme_video_url'     => '//www.youtube.com/channel/UCdIjRh7-lPVHqTTKpaf8PLA',   // Themerex

			'theme_privacy_url'   => '//themerex.net/privacy-policy/',                   // Themerex

			'portfolio_url'       => '//themeforest.net/user/themerex/portfolio',        // Themerex

			// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
			// (i.e. 'children,kindergarten')
			'theme_categories'    => '',
		) );
	}
}


// Add/remove/change Theme Settings
if ( ! function_exists( 'medeus_skin_setup_settings' ) ) {
	add_action( 'after_setup_theme', 'medeus_skin_setup_settings', 1 );
	function medeus_skin_setup_settings() {
		// Example: enable (true) / disable (false) thumbs in the prev/next navigation
		medeus_storage_set_array( 'settings', 'thumbs_in_navigation', false );
		medeus_storage_set_array2( 'required_plugins', 'latepoint', 'install', false);
		medeus_storage_set_array2( 'required_plugins', 'instagram-feed', 'install', false);
		medeus_storage_set_array2( 'required_plugins', 'twenty20', 'install', true);
	}
}



//--------------------------------------------
// SKIN FONTS
//--------------------------------------------
if ( ! function_exists( 'medeus_skin_setup_fonts' ) ) {
	add_action( 'after_setup_theme', 'medeus_skin_setup_fonts', 1 );
	function medeus_skin_setup_fonts() {
		// Fonts to load when theme start
		// It can be:
		// - Google fonts (specify name, family and styles)
		// - Adobe fonts (specify name, family and link URL)
		// - uploaded fonts (specify name, family), placed in the folder css/font-face/font-name inside the skin folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		medeus_storage_set(
			'load_fonts', array(
				array(
					'name'   => 'museo-sans',
					'family' => 'sans-serif',
					'link'   => 'https://use.typekit.net/zfc0lca.css',
					'styles' => ''
				),
				array(
					'name'   => 'soleil',
					'family' => 'sans-serif',
					'link'   => 'https://use.typekit.net/far2eiv.css',
					'styles' => ''
				),
				// Google font
				array(
					'name'   => 'Lora',
					'family' => 'sans-serif',
					'link'   => '',
					'styles' => 'ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700',     // Parameter 'style' used only for the Google fonts
				),
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		medeus_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags.
		// Default value of 'font-family' may be specified as reference to the array $load_fonts (see above)
		// or as comma-separated string.
		// In the second case (if 'font-family' is specified manually as comma-separated string):
		//    1) Font name with spaces in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
		//    2) If font-family inherit a value from the 'Main text' - specify 'inherit' as a value
		// example:
		// Correct:   'font-family' => basekit_get_load_fonts_family_string( $load_fonts[0] )
		// Correct:   'font-family' => 'Roboto,sans-serif'
		// Correct:   'font-family' => '"PT Serif",sans-serif'
		// Incorrect: 'font-family' => 'Roboto,sans-serif'
		// Incorrect: 'font-family' => 'PT Serif,sans-serif'

		$font_description = esc_html__( 'Font settings for the %s of the site. To ensure that the elements scale properly on mobile devices, please use only the following units: "rem", "em" or "ex"', 'medeus' );

		medeus_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'medeus' ),
					'description'     => sprintf( $font_description, esc_html__( 'main text', 'medeus' ) ),
					'font-family'     => 'museo-sans,sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.62em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.1px',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.57em',
				),
				'post'    => array(
					'title'           => esc_html__( 'Article text', 'medeus' ),
					'description'     => sprintf( $font_description, esc_html__( 'article text', 'medeus' ) ),
					'font-family'     => '',			// Example: '"PR Serif",serif',
					'font-size'       => '',			// Example: '1.286rem',
					'font-weight'     => '',			// Example: '400',
					'font-style'      => '',			// Example: 'normal',
					'line-height'     => '',			// Example: '1.75em',
					'text-decoration' => '',			// Example: 'none',
					'text-transform'  => '',			// Example: 'none',
					'letter-spacing'  => '',			// Example: '',
					'margin-top'      => '',			// Example: '0em',
					'margin-bottom'   => '',			// Example: '1.4em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'medeus' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H1', 'medeus' ) ),
					'font-family'     => 'soleil,sans-serif',
					'font-size'       => '3.167em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.05em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-1.8px',
					'margin-top'      => '1.04em',
					'margin-bottom'   => '0.46em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'medeus' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H2', 'medeus' ) ),
					'font-family'     => 'soleil,sans-serif',
					'font-size'       => '2.611em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.021em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.02em',
					'margin-top'      => '0.67em',
					'margin-bottom'   => '0.56em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'medeus' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H3', 'medeus' ) ),
					'font-family'     => 'soleil,sans-serif',
					'font-size'       => '1.944em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.086em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.94em',
					'margin-bottom'   => '0.72em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'medeus' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H4', 'medeus' ) ),
					'font-family'     => 'soleil,sans-serif',
					'font-size'       => '1.556em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.214em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.03em',
					'margin-top'      => '1.15em',
					'margin-bottom'   => '0.83em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'medeus' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H5', 'medeus' ) ),
					'font-family'     => 'soleil,sans-serif',
					'font-size'       => '1.333em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.417em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.3em',
					'margin-bottom'   => '0.84em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'medeus' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H6', 'medeus' ) ),
					'font-family'     => 'soleil,sans-serif',
					'font-size'       => '1.056em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.474em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-0.02em',
					'margin-top'      => '1.75em',
					'margin-bottom'   => '1.1em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'medeus' ),
					'description'     => sprintf( $font_description, esc_html__( 'text of the logo', 'medeus' ) ),
					'font-family'     => 'soleil,sans-serif',
					'font-size'       => '1.7em',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'medeus' ),
					'description'     => sprintf( $font_description, esc_html__( 'buttons', 'medeus' ) ),
					'font-family'     => 'soleil,sans-serif',
					'font-size'       => '16px',
					'font-weight'     => '600',
					'font-style'      => 'normal',
					'line-height'     => '20px',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'medeus' ),
					'description'     => sprintf( $font_description, esc_html__( 'input fields, dropdowns and textareas', 'medeus' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '16px',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',     // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.1px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'medeus' ),
					'description'     => sprintf( $font_description, esc_html__( 'post meta (author, categories, publish date, counters, share, etc.)', 'medeus' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '13px',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'medeus' ),
					'description'     => sprintf( $font_description, esc_html__( 'main menu items', 'medeus' ) ),
					'font-family'     => 'soleil,sans-serif',
					'font-size'       => '16px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'medeus' ),
					'description'     => sprintf( $font_description, esc_html__( 'dropdown menu items', 'medeus' ) ),
					'font-family'     => 'museo-sans,sans-serif',
					'font-size'       => '15px',
					'font-weight'     => '300',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				)
			)
		);

		// Font presets
		medeus_storage_set(
			'font_presets', array(
				'karla' => array(
								'title'  => esc_html__( 'Karla', 'medeus' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Dancing Script',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
													// Google font
													array(
														'name'   => 'Sansita Swashed',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Dancing Script",fantasy',
														'font-size'       => '1.25rem',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
														'font-size'       => '4em',
													),
													'h2'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h3'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h4'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h5'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h6'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'logo'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'button'  => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'submenu' => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
												),
							),
				'roboto' => array(
								'title'  => esc_html__( 'Roboto', 'medeus' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Noto Sans JP',
														'family' => 'serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
													// Google font
													array(
														'name'   => 'Merriweather',
														'family' => 'sans-serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Noto Sans JP",serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
												),
							),
				'garamond' => array(
								'title'  => esc_html__( 'Garamond', 'medeus' ),
								'load_fonts' => array(
													// Adobe font
													array(
														'name'   => 'Europe',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
													// Adobe font
													array(
														'name'   => 'Sofia Pro',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Sofia Pro",sans-serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Europe,sans-serif',
													),
												),
							),
			)
		);
	}
}


//--------------------------------------------
// COLOR SCHEMES
//--------------------------------------------
if ( ! function_exists( 'medeus_skin_setup_schemes' ) ) {
	add_action( 'after_setup_theme', 'medeus_skin_setup_schemes', 1 );
	function medeus_skin_setup_schemes() {

		// Theme colors for customizer
		// Attention! Inner scheme must be last in the array below
		medeus_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'medeus' ),
					'description' => esc_html__( 'Colors of the main content area', 'medeus' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'medeus' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'medeus' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'medeus' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'medeus' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'medeus' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'medeus' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'medeus' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'medeus' ),
				),
			)
		);

		medeus_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'medeus' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'medeus' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'medeus' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'medeus' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'medeus' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'medeus' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'medeus' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'medeus' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'medeus' ),
					'description' => esc_html__( 'Color of the text inside this block', 'medeus' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'medeus' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'medeus' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'medeus' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'medeus' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'medeus' ),
					'description' => esc_html__( 'Color of the links inside this block', 'medeus' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'medeus' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'medeus' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Accent 2', 'medeus' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'medeus' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Accent 2 hover', 'medeus' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'medeus' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Accent 3', 'medeus' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'medeus' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Accent 3 hover', 'medeus' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'medeus' ),
				),
			)
		);

		// Default values for each color scheme
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'medeus' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F4F3F8', //ok dem
					'bd_color'         => '#C7CED3', //ok dem

					// Text and links colors
					'text'             => '#728194', //ok dem
					'text_light'       => '#9DA9B5', //ok dem
					'text_dark'        => '#111542', //ok dem
					'text_link'        => '#F9313B', //ok dem
					'text_hover'       => '#BB252C', //ok dem
					'text_link2'       => '#1D3CE2', //ok dem
					'text_hover2'      => '#162DAA', //ok dem
					'text_link3'       => '#47BFF3', //ok dem
					'text_hover3'      => '#358FB6', //ok dem

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#ffffff', //ok
					'alter_bg_hover'   => '#ECEBF0', //ok dem
					'alter_bd_color'   => '#C7CED3', //ok dem
					'alter_bd_hover'   => '#EFF0F4', //ok
					'alter_text'       => '#728194', //ok dem
					'alter_light'      => '#9DA9B5', //ok dem
					'alter_dark'       => '#111542', //ok dem
					'alter_link'       => '#F9313B', //ok dem
					'alter_hover'      => '#BB252C', //ok dem
					'alter_link2'      => '#1D3CE2', //ok dem
					'alter_hover2'     => '#162DAA', //ok dem
					'alter_link3'      => '#47BFF3', //ok dem
					'alter_hover3'     => '#358FB6', //ok dem

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#181D4E', //ok dem
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#D6DDE4', //ok dem
					'extra_light'      => '#9DA9B5', // dem
					'extra_dark'       => '#FCFCFC', // dem
					'extra_link'       => '#F9313B', //ok dem
					'extra_hover'      => '#ffffff', //ok
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok
					'input_bg_hover'   => 'transparent', //ok
					'input_bd_color'   => '#E3E0DC', //ok DT
					'input_bd_hover'   => '#111542', //ok dem
					'input_text'       => '#9DA9B5', //ok dem
					'input_light'      => '#9DA9B5', //ok dem
					'input_dark'       => '#111542', //ok dem

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#111542', //ok dem
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#ffffff', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'medeus' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#1B215A', //ok dem
					'bd_color'         => '#252B78', //ok dem

					// Text and links colors
					'text'             => '#D6DDE4', //ok dem
					'text_light'       => '#9EABB8', //ok dem
					'text_dark'        => '#F4F3F8', //ok dem
					'text_link'        => '#F9313B', //ok dem
					'text_hover'       => '#BB252C', //ok dem
					'text_link2'       => '#1D3CE2', //ok dem
					'text_hover2'      => '#162DAA', //ok dem
					'text_link3'       => '#47BFF3', //ok dem
					'text_hover3'      => '#358FB6', //ok dem

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#181D4E', //ok dem
					'alter_bg_hover'   => '#1B215A', //ok dem
					'alter_bd_color'   => '#252B78', //ok dem
					'alter_bd_hover'   => '#2B318A', //ok dem
					'alter_text'       => '#9EABB8', //ok dem
					'alter_light'      => '#9EABB8', //ok dem
					'alter_dark'       => '#F4F3F8', //ok dem
					'alter_link'       => '#F9313B', //ok dem
					'alter_hover'      => '#BB252C', //ok dem
					'alter_link2'      => '#1D3CE2', //ok dem
					'alter_hover2'     => '#162DAA', //ok dem
					'alter_link3'      => '#47BFF3', //ok dem
					'alter_hover3'     => '#358FB6', //ok dem

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#181D4E', //dem
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#9EABB8', //dem
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#F9313B', //dem
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#transparent', //ok
					'input_bg_hover'   => '#transparent', //ok
					'input_bd_color'   => '#252B78', //ok dem
					'input_bd_hover'   => '#252B78', //ok dem
					'input_text'       => '#D2D3D5', //ok
					'input_light'      => '#D2D3D5', //ok
					'input_dark'       => '#ffffff',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#F9F9F9', //ok
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#111542', //ok dem
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#0C0F26', //ok dem

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'light'
			'light' => array(
				'title'    => esc_html__( 'Light', 'medeus' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#ffffff', //ok - GO
					'bd_color'         => '#C7CED3', //ok dem

					// Text and links colors
					'text'             => '#728194', //ok dem
					'text_light'       => '#9DA9B5', //ok dem
					'text_dark'        => '#111542', //ok dem
					'text_link'        => '#F9313B', //ok dem
					'text_hover'       => '#BB252C', //ok dem
					'text_link2'       => '#1D3CE2', //ok dem
					'text_hover2'      => '#162DAA', //ok dem
					'text_link3'       => '#47BFF3', //ok dem
					'text_hover3'      => '#358FB6', //ok dem

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F4F3F8', //ok - dem
					'alter_bg_hover'   => '#ffffff', //ok - GO
					'alter_bd_color'   => '#E3E0DC', //ok DT
					'alter_bd_hover'   => '#DCDCDC', //ok
					'alter_text'       => '#728194', //ok dem
					'alter_light'      => '#9DA9B5', //ok dem
					'alter_dark'       => '#111542', //ok dem
					'alter_link'       => '#F9313B', //ok dem
					'alter_hover'      => '#BB252C', //ok dem
					'alter_link2'      => '#1D3CE2', //ok dem
					'alter_hover2'     => '#162DAA', //ok dem
					'alter_link3'      => '#47BFF3', //ok dem
					'alter_hover3'     => '#358FB6', //ok dem

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#181D4E', //ok dem
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#D6DDE4', //dem
					'extra_light'      => '#9DA9B5', //dem
					'extra_dark'       => '#ffffff', // ok
					'extra_link'       => '#F9313B', //ok dem
					'extra_hover'      => '#ffffff', //ok
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok
					'input_bg_hover'   => 'transparent', //ok
					'input_bd_color'   => '#E3E0DC', //ok DT
					'input_bd_hover'   => '#111542', //ok dem
					'input_text'       => '#9DA9B5', //ok dem
					'input_light'      => '#9DA9B5', //ok dem
					'input_dark'       => '#111542', //ok dem

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#111542', //ok dem
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#ffffff', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dermatology_default'
			'dermatology_default' => array(
				'title'    => esc_html__( 'Default(Dermatology)', 'medeus' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F0F2F4', //ok dem +
					'bd_color'         => '#C7CED3', //ok dem

					// Text and links colors
					'text'             => '#292A2C', //ok dem +
					'text_light'       => '#B2B2B2', //ok dem +
					'text_dark'        => '#000000', //ok dem +
					'text_link'        => '#F13156', //ok dem +
					'text_hover'       => '#B92642', //ok dem +
					'text_link2'       => '#FCB247', //ok dem +
					'text_hover2'      => '#C28937', //ok dem +
					'text_link3'       => '#47BFF3', //ok dem +
					'text_hover3'      => '#3793BB', //ok dem +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#ffffff', //ok
					'alter_bg_hover'   => '#ECEBF0', //ok dem
					'alter_bd_color'   => '#C7CED3', //ok dem
					'alter_bd_hover'   => '#EFF0F4', //ok
					'alter_text'       => '#292A2C', //ok dem +
					'alter_light'      => '#B2B2B2', //ok dem +
					'alter_dark'       => '#000000', //ok dem +
					'alter_link'       => '#F13156', //ok dem +
					'alter_hover'      => '#B92642', //ok dem +
					'alter_link2'      => '#FCB247', //ok dem +
					'alter_hover2'     => '#C28937', //ok dem +
					'alter_link3'      => '#47BFF3', //ok dem +
					'alter_hover3'     => '#3793BB', //ok dem +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#444444', //ok dem +
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#323641', // +
					'extra_bd_hover'   => '#40444E', // +
					'extra_text'       => '#E5E5E5', //ok dem +
					'extra_light'      => '#B2B2B2', // dem +
					'extra_dark'       => '#FCFCFC', // dem +
					'extra_link'       => '#F13156', //ok dem +
					'extra_hover'      => '#ffffff', //ok
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok
					'input_bg_hover'   => 'transparent', //ok
					'input_bd_color'   => '#E3E0DC', //ok DT
					'input_bd_hover'   => '#000000', //ok dem +
					'input_text'       => '#B2B2B2', //ok dem +
					'input_light'      => '#B2B2B2', //ok dem +
					'input_dark'       => '#000000', //ok dem +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#000000', //ok dem +
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#ffffff', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dermatology_dark'
			'dermatology_dark'    => array(
				'title'    => esc_html__( 'Dark(Dermatology)', 'medeus' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#151619', //ok dem +
					'bd_color'         => '#323641', //ok dem +

					// Text and links colors
					'text'             => '#E5E5E5', //ok dem +
					'text_light'       => '#9EABB8', //ok dem
					'text_dark'        => '#F0F2F4', //ok dem +
					'text_link'        => '#F13156', //ok dem +
					'text_hover'       => '#B92642', //ok dem +
					'text_link2'       => '#FCB247', //ok dem +
					'text_hover2'      => '#C28937', //ok dem +
					'text_link3'       => '#47BFF3', //ok dem +
					'text_hover3'      => '#3793BB', //ok dem +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#444444', //ok dem +
					'alter_bg_hover'   => '#828282', //ok dem +
					'alter_bd_color'   => '#323641', //ok dem +
					'alter_bd_hover'   => '#40444E', //ok dem +
					'alter_text'       => '#E5E5E5', //ok dem +
					'alter_light'      => '#9EABB8', //ok dem
					'alter_dark'       => '#F0F2F4', //ok dem +
					'alter_link'       => '#F13156', //ok dem +
					'alter_hover'      => '#B92642', //ok dem +
					'alter_link2'      => '#FCB247', //ok dem +
					'alter_hover2'     => '#C28937', //ok dem +
					'alter_link3'      => '#47BFF3', //ok dem +
					'alter_hover3'     => '#3793BB', //ok dem +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#444444', //dem +
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#D2D3D5', //dem +
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#F13156', //dem +
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#transparent', //ok
					'input_bg_hover'   => '#transparent', //ok
					'input_bd_color'   => '#252B78', //ok dem
					'input_bd_hover'   => '#252B78', //ok dem
					'input_text'       => '#444444', //ok +
					'input_light'      => '#444444', //ok +
					'input_dark'       => '#ffffff',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#F9F9F9', //ok
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#000000', //ok dem +
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#0C0F26', //ok dem

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dermatology_light'
			'dermatology_light' => array( 
				'title'    => esc_html__( 'Light(Dermatology)', 'medeus' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#ffffff', //ok - GO
					'bd_color'         => '#C7CED3', //ok dem

					// Text and links colors
					'text'             => '#292A2C', //ok dem +
					'text_light'       => '#B2B2B2', //ok dem +
					'text_dark'        => '#000000', //ok dem +
					'text_link'        => '#F13156', //ok dem +
					'text_hover'       => '#B92642', //ok dem +
					'text_link2'       => '#FCB247', //ok dem +
					'text_hover2'      => '#C28937', //ok dem +
					'text_link3'       => '#47BFF3', //ok dem +
					'text_hover3'      => '#3793BB', //ok dem +

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F0F2F4', //ok - dem +
					'alter_bg_hover'   => '#ffffff', //ok - GO
					'alter_bd_color'   => '#E3E0DC', //ok DT
					'alter_bd_hover'   => '#DCDCDC', //ok
					'alter_text'       => '#292A2C', //ok dem +
					'alter_light'      => '#B2B2B2', //ok dem +
					'alter_dark'       => '#000000', //ok dem +
					'alter_link'       => '#F13156', //ok dem +
					'alter_hover'      => '#B92642', //ok dem +
					'alter_link2'      => '#FCB247', //ok dem +
					'alter_hover2'     => '#C28937', //ok dem +
					'alter_link3'      => '#47BFF3', //ok dem +
					'alter_hover3'     => '#3793BB', //ok dem +

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#444444', //ok dem +
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#323641', // +
					'extra_bd_hover'   => '#40444E', // +
					'extra_text'       => '#E5E5E5', //dem +
					'extra_light'      => '#B2B2B2', //dem +
					'extra_dark'       => '#ffffff', // ok
					'extra_link'       => '#F13156', //ok dem +
					'extra_hover'      => '#ffffff', //ok
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok
					'input_bg_hover'   => 'transparent', //ok
					'input_bd_color'   => '#E3E0DC', //ok DT
					'input_bd_hover'   => '#000000', //ok dem +
					'input_text'       => '#B2B2B2', //ok dem +
					'input_light'      => '#B2B2B2', //ok dem +
					'input_dark'       => '#000000', //ok dem +

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#000000', //ok dem +
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#ffffff', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'psychologist_default'
			'psychologist_default' => array(
				'title'    => esc_html__( 'Default(Psychologist)', 'medeus' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#FEF6EF', //ok dem //
					'bd_color'         => '#DAD6D4', //ok dem //

					// Text and links colors
					'text'             => '#80665A', //ok dem //
					'text_light'       => '#B28F7F', //ok dem //
					'text_dark'        => '#482216', //ok dem //
					'text_link'        => '#F2B08E', //ok dem //
					'text_hover'       => '#C79074', //ok dem //
					'text_link2'       => '#44ABB9', //ok dem //
					'text_hover2'      => '#388C98', //ok dem //
					'text_link3'       => '#4F91CE', //ok dem //
					'text_hover3'      => '#4177A9', //ok dem //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#ffffff', //ok
					'alter_bg_hover'   => '#ECEBF0', //ok dem
					'alter_bd_color'   => '#DAD6D4', //ok dem //
					'alter_bd_hover'   => '#EFF0F4', //ok
					'alter_text'       => '#80665A', //ok dem //
					'alter_light'      => '#B28F7F', //ok dem //
					'alter_dark'       => '#482216', //ok dem //
					'alter_link'       => '#F2B08E', //ok dem //
					'alter_hover'      => '#C79074', //ok dem //
					'alter_link2'      => '#44ABB9', //ok dem //
					'alter_hover2'     => '#388C98', //ok dem //
					'alter_link3'      => '#4F91CE', //ok dem //
					'alter_hover3'     => '#4177A9', //ok dem //

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1F0501', //ok dem //
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#503428', // //
					'extra_bd_hover'   => '#33170B', // //
					'extra_text'       => '#E8CDBF', //ok dem //
					'extra_light'      => '#B28F7F', // dem //
					'extra_dark'       => '#FEF6EF', // dem //
					'extra_link'       => '#F2B08E', //ok dem //
					'extra_hover'      => '#ffffff', //ok
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok
					'input_bg_hover'   => 'transparent', //ok
					'input_bd_color'   => '#E3E0DC', //ok DT
					'input_bd_hover'   => '#482216', //ok dem //
					'input_text'       => '#B28F7F', //ok dem //
					'input_light'      => '#B28F7F', //ok dem //
					'input_dark'       => '#482216', //ok dem //

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#482216', //ok dem //
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#ffffff', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'psychologist_dark'
			'psychologist_dark'    => array(
				'title'    => esc_html__( 'Dark(Psychologist)', 'medeus' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#281004', //ok dem //
					'bd_color'         => '#503428', //ok dem //

					// Text and links colors
					'text'             => '#E8CDBF', //ok dem //
					'text_light'       => '#F3E0D5', //ok dem //
					'text_dark'        => '#FEF6EF', //ok dem //
					'text_link'        => '#F2B08E', //ok dem //
					'text_hover'       => '#C79074', //ok dem //
					'text_link2'       => '#44ABB9', //ok dem //
					'text_hover2'      => '#388C98', //ok dem //
					'text_link3'       => '#4F91CE', //ok dem //
					'text_hover3'      => '#4177A9', //ok dem //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#1F0501', //ok dem //
					'alter_bg_hover'   => '#1A0000', //ok dem //
					'alter_bd_color'   => '#503428', //ok dem //
					'alter_bd_hover'   => '#33170B', //ok dem //
					'alter_text'       => '#E8CDBF', //ok dem //
					'alter_light'      => '#9EABB8', //ok dem
					'alter_dark'       => '#FEF6EF', //ok dem //
					'alter_link'       => '#F2B08E', //ok dem //
					'alter_hover'      => '#C79074', //ok dem //
					'alter_link2'      => '#44ABB9', //ok dem //
					'alter_hover2'     => '#388C98', //ok dem //
					'alter_link3'      => '#4F91CE', //ok dem //
					'alter_hover3'     => '#4177A9', //ok dem //

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1F0501', //dem //
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#E8CDBF', //dem //
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#F2B08E', //dem //
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#transparent', //ok
					'input_bg_hover'   => '#transparent', //ok
					'input_bd_color'   => '#252B78', //ok dem
					'input_bd_hover'   => '#252B78', //ok dem
					'input_text'       => '#444444', //ok +
					'input_light'      => '#444444', //ok +
					'input_dark'       => '#ffffff',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#F9F9F9', //ok
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#482216', //ok dem //
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#0C0F26', //ok dem

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'psychologist_light'
			'psychologist_light' => array( 
				'title'    => esc_html__( 'Light(Psychologist)', 'medeus' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#ffffff', //ok - GO
					'bd_color'         => '#DAD6D4', //ok dem //

					// Text and links colors
					'text'             => '#80665A', //ok dem //
					'text_light'       => '#B28F7F', //ok dem //
					'text_dark'        => '#482216', //ok dem //
					'text_link'        => '#F2B08E', //ok dem //
					'text_hover'       => '#C79074', //ok dem //
					'text_link2'       => '#44ABB9', //ok dem //
					'text_hover2'      => '#388C98', //ok dem //
					'text_link3'       => '#4F91CE', //ok dem //
					'text_hover3'      => '#4177A9', //ok dem //

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FEF6EF', //ok - dem //
					'alter_bg_hover'   => '#ffffff', //ok - GO
					'alter_bd_color'   => '#E3E0DC', //ok DT
					'alter_bd_hover'   => '#DCDCDC', //ok
					'alter_text'       => '#80665A', //ok dem //
					'alter_light'      => '#B28F7F', //ok dem //
					'alter_dark'       => '#482216', //ok dem //
					'alter_link'       => '#F2B08E', //ok dem //
					'alter_hover'      => '#C79074', //ok dem //
					'alter_link2'      => '#44ABB9', //ok dem //
					'alter_hover2'     => '#388C98', //ok dem //
					'alter_link3'      => '#4F91CE', //ok dem //
					'alter_hover3'     => '#4177A9', //ok dem //

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#1F0501', //ok dem //
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#503428', // //
					'extra_bd_hover'   => '#33170B', // //
					'extra_text'       => '#E8CDBF', //dem //
					'extra_light'      => '#B28F7F', //dem //
					'extra_dark'       => '#FEF6EF', // ok //
					'extra_link'       => '#F2B08E', //ok dem //
					'extra_hover'      => '#ffffff', //ok
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok
					'input_bg_hover'   => 'transparent', //ok
					'input_bd_color'   => '#E3E0DC', //ok DT
					'input_bd_hover'   => '#482216', //ok dem //
					'input_text'       => '#B28F7F', //ok dem //
					'input_light'      => '#B28F7F', //ok dem //
					'input_dark'       => '#482216', //ok dem //

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#482216', //ok dem //
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#ffffff', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'surgery_default'
			'surgery_default' => array(
				'title'    => esc_html__( 'Default(Surgery)', 'medeus' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F9F7F5', //ok dem $
					'bd_color'         => '#EEEAE7', //ok dem $

					// Text and links colors
					'text'             => '#8F8781', //ok dem $
					'text_light'       => '#92CCE0', //ok dem $
					'text_dark'        => '#282828', //ok dem $
					'text_link'        => '#F3848B', //ok dem $
					'text_hover'       => '#DA777D', //ok dem $
					'text_link2'       => '#61C2E2', //ok dem $
					'text_hover2'      => '#57AECB', //ok dem $
					'text_link3'       => '#016F90', //ok dem $
					'text_hover3'      => '#016481', //ok dem $

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#ffffff', //ok
					'alter_bg_hover'   => '#ECEBF0', //ok dem
					'alter_bd_color'   => '#EEEAE7', //ok dem $
					'alter_bd_hover'   => '#EFF0F4', //ok
					'alter_text'       => '#8F8781', //ok dem $
					'alter_light'      => '#92CCE0', //ok dem $
					'alter_dark'       => '#282828', //ok dem $
					'alter_link'       => '#F3848B', //ok dem $
					'alter_hover'      => '#DA777D', //ok dem $
					'alter_link2'      => '#61C2E2', //ok dem $
					'alter_hover2'     => '#57AECB', //ok dem $
					'alter_link3'      => '#016F90', //ok dem $
					'alter_hover3'     => '#016481', //ok dem $

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#000000', //ok dem $
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#323641', // $
					'extra_bd_hover'   => '#53535C', // $
					'extra_text'       => '#E0DDDC', //ok dem $
					'extra_light'      => '#92CCE0', // dem $
					'extra_dark'       => '#FCFCFC', // dem $
					'extra_link'       => '#F3848B', //ok dem $
					'extra_hover'      => '#ffffff', //ok
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok
					'input_bg_hover'   => 'transparent', //ok
					'input_bd_color'   => '#E3E0DC', //ok DT
					'input_bd_hover'   => '#282828', //ok dem $
					'input_text'       => '#92CCE0', //ok dem $
					'input_light'      => '#92CCE0', //ok dem $
					'input_dark'       => '#282828', //ok dem $

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#282828', //ok dem $
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#ffffff', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'surgery_dark'
			'surgery_dark'    => array(
				'title'    => esc_html__( 'Dark(Surgery)', 'medeus' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#171717', //ok dem $
					'bd_color'         => '#323641', //ok dem $

					// Text and links colors
					'text'             => '#E0DDDC', //ok dem $
					'text_light'       => '#B6B1AD', //ok dem $
					'text_dark'        => '#F9F7F5', //ok dem $
					'text_link'        => '#F3848B', //ok dem $
					'text_hover'       => '#DA777D', //ok dem $
					'text_link2'       => '#61C2E2', //ok dem $
					'text_hover2'      => '#57AECB', //ok dem $
					'text_link3'       => '#016F90', //ok dem $
					'text_hover3'      => '#016481', //ok dem $

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#000000', //ok dem $
					'alter_bg_hover'   => '#333333', //ok dem $
					'alter_bd_color'   => '#323641', //ok dem $
					'alter_bd_hover'   => '#40444E', //ok dem +
					'alter_text'       => '#E0DDDC', //ok dem $
					'alter_light'      => '#B6B1AD', //ok dem $
					'alter_dark'       => '#F9F7F5', //ok dem $
					'alter_link'       => '#F3848B', //ok dem $
					'alter_hover'      => '#DA777D', //ok dem $
					'alter_link2'      => '#61C2E2', //ok dem $
					'alter_hover2'     => '#57AECB', //ok dem $
					'alter_link3'      => '#016F90', //ok dem $
					'alter_hover3'     => '#016481', //ok dem $

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#000000', //dem $
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#E0DDDC', //dem $
					'extra_light'      => '#afafaf',
					'extra_dark'       => '#ffffff',
					'extra_link'       => '#F3848B', //dem $
					'extra_hover'      => '#ffffff',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#transparent', //ok
					'input_bg_hover'   => '#transparent', //ok
					'input_bd_color'   => '#252B78', //ok dem
					'input_bd_hover'   => '#252B78', //ok dem
					'input_text'       => '#444444', //ok +
					'input_light'      => '#444444', //ok +
					'input_dark'       => '#ffffff',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#F9F9F9', //ok
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#282828', //ok dem $
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#0C0F26', //ok dem

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'surgery_light'
			'surgery_light' => array( 
				'title'    => esc_html__( 'Light(Surgery)', 'medeus' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#ffffff', //ok - GO
					'bd_color'         => '#EEEAE7', //ok dem $

					// Text and links colors
					'text'             => '#8F8781', //ok dem $
					'text_light'       => '#92CCE0', //ok dem $
					'text_dark'        => '#282828', //ok dem $
					'text_link'        => '#F3848B', //ok dem $
					'text_hover'       => '#DA777D', //ok dem $
					'text_link2'       => '#61C2E2', //ok dem $
					'text_hover2'      => '#57AECB', //ok dem $
					'text_link3'       => '#016F90', //ok dem $
					'text_hover3'      => '#016481', //ok dem $

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#F9F7F5', //ok - dem $
					'alter_bg_hover'   => '#ffffff', //ok - GO
					'alter_bd_color'   => '#E3E0DC', //ok DT
					'alter_bd_hover'   => '#DCDCDC', //ok
					'alter_text'       => '#8F8781', //ok dem $
					'alter_light'      => '#92CCE0', //ok dem $
					'alter_dark'       => '#282828', //ok dem $
					'alter_link'       => '#F3848B', //ok dem $
					'alter_hover'      => '#DA777D', //ok dem $
					'alter_link2'      => '#61C2E2', //ok dem $
					'alter_hover2'     => '#57AECB', //ok dem $
					'alter_link3'      => '#016F90', //ok dem $
					'alter_hover3'     => '#016481', //ok dem $

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#000000', //ok dem $
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#323641', // $
					'extra_bd_hover'   => '#53535C', // $
					'extra_text'       => '#E0DDDC', //dem $
					'extra_light'      => '#92CCE0', //dem $
					'extra_dark'       => '#ffffff', // ok
					'extra_link'       => '#F3848B', //ok dem $
					'extra_hover'      => '#ffffff', //ok
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent', //ok
					'input_bg_hover'   => 'transparent', //ok
					'input_bd_color'   => '#E3E0DC', //ok DT
					'input_bd_hover'   => '#282828', //ok dem $
					'input_text'       => '#92CCE0', //ok dem $
					'input_light'      => '#92CCE0', //ok dem $
					'input_dark'       => '#282828', //ok dem $

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#282828', //ok dem $
					'inverse_link'     => '#ffffff', //ok
					'inverse_hover'    => '#ffffff', //ok

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),
		);
		medeus_storage_set( 'schemes', $schemes );
		medeus_storage_set( 'schemes_original', $schemes );

		// Add names of additional colors
		//---> For example:
		//---> medeus_storage_set_array( 'scheme_color_names', 'new_color1', array(
		//---> 	'title'       => __( 'New color 1', 'medeus' ),
		//---> 	'description' => __( 'Description of the new color 1', 'medeus' ),
		//---> ) );


		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		medeus_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
                'alter_dark_015'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.15,
                ),
                'alter_dark_02'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.2,
                ),
                'alter_dark_05'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.5,
                ),
                'alter_dark_08'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.8,
                ),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
                'text_dark_003'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.03,
                ),
                'text_dark_005'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.05,
                ),
                'text_dark_008'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.08,
                ),
				'text_dark_015'      => array(
					'color' => 'text_dark',
					'alpha' => 0.15,
				),
				'text_dark_02'      => array(
					'color' => 'text_dark',
					'alpha' => 0.2,
				),
                'text_dark_03'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.3,
                ),
                'text_dark_05'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.5,
                ),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
                'text_dark_08'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.8,
                ),
                'text_link_007'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.07,
                ),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
                'text_link_03'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.3,
                ),
				'text_link_04'      => array(
					'color' => 'text_link',
					'alpha' => 0.4,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
				'text_link2_08'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.8,
                ),
                'text_link2_007'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.07,
                ),
				'text_link2_02'      => array(
					'color' => 'text_link2',
					'alpha' => 0.2,
				),
                'text_link2_03'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.3,
                ),
				'text_link2_05'      => array(
					'color' => 'text_link2',
					'alpha' => 0.5,
				),
                'text_link3_007'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.07,
                ),
				'text_link3_02'      => array(
					'color' => 'text_link3',
					'alpha' => 0.2,
				),
                'text_link3_03'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.3,
                ),
                'inverse_text_03'      => array(
                    'color' => 'inverse_text',
                    'alpha' => 0.3,
                ),
                'inverse_link_08'      => array(
                    'color' => 'inverse_link',
                    'alpha' => 0.8,
                ),
                'inverse_hover_08'      => array(
                    'color' => 'inverse_hover',
                    'alpha' => 0.8,
                ),
				'text_dark_blend'   => array(
					'color'      => 'text_dark',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		medeus_storage_set(
			'schemes_simple', array(
				'text_link'        => array(),
				'text_hover'       => array(),
				'text_link2'       => array(),
				'text_hover2'      => array(),
				'text_link3'       => array(),
				'text_hover3'      => array(),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
			)
		);

		// Parameters to set order of schemes in the css
		medeus_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// Color presets
		medeus_storage_set(
			'color_presets', array(
				'autumn' => array(
								'title'  => esc_html__( 'Autumn', 'medeus' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	),
												'dark' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	)
												)
							),
				'green' => array(
								'title'  => esc_html__( 'Natural Green', 'medeus' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	),
												'dark' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	)
												)
							),
			)
		);
	}
}

// Enqueue clone specific style
if ( ! function_exists( 'medeus_clone_frontend_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'medeus_clone_frontend_scripts', 2150 );
	function medeus_clone_frontend_scripts() {
		$medeus_url = medeus_get_file_url( medeus_skins_get_current_skin_dir() . 'extra-styles.css' );
		if ( '' != $medeus_url ) {
			wp_enqueue_style( 'medeus-extra-styles-' . esc_attr( medeus_skins_get_current_skin_name() ), $medeus_url, array(), null );
		}
	}
}
// Custom styles
$medeus_clone_style_path = medeus_get_file_dir( medeus_skins_get_current_skin_dir() . 'extra-style.php' );
if ( ! empty( $medeus_clone_style_path ) ) {
	require_once $medeus_clone_style_path;
}

// Activation methods
if ( ! function_exists( 'medeus_clone_skin_filter_activation_methods' ) ) {
    add_filter( 'trx_addons_filter_activation_methods', 'medeus_clone_skin_filter_activation_methods', 10, 1 );
    function medeus_clone_skin_filter_activation_methods( $args ) {
        $args['elements_key'] = true;
        return $args;
    }
}
// Activation methods
if ( ! function_exists( 'medeus_skin_filter_activation_methods' ) ) {
    add_filter( 'trx_addons_filter_activation_methods', 'medeus_skin_filter_activation_methods', 10, 1 );
    function medeus_skin_filter_activation_methods( $args ) {
        $args['elements_key'] = true;
        return $args;
    }
}
