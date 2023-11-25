<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'medeus_cf7_get_css' ) ) {
	add_filter( 'medeus_filter_get_css', 'medeus_cf7_get_css', 10, 2 );
	function medeus_cf7_get_css( $css, $args ) {
		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS

			.sc_icons_plain .sc_icons_item .sc_icons_item_more_link {
				{$fonts['p_font-family']}
			}

			/* Title */
			h1.sc_item_title { {$fonts['h1_line-height']} }
			h2.sc_item_title { {$fonts['h2_line-height']} }
			h3.sc_item_title { {$fonts['h3_line-height']} }
			h4.sc_item_title { {$fonts['h4_line-height']} }
			h5.sc_item_title { {$fonts['h5_line-height']} }
			h6.sc_item_title { {$fonts['h6_line-height']} }

CSS;
		}

		return $css;
	}
}
