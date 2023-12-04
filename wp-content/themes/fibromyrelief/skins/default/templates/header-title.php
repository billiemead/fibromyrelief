<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package MEDEUS
 * @since MEDEUS 1.0
 */

// Page (category, tag, archive, author) title

if ( medeus_need_page_title() ) {
	medeus_sc_layouts_showed( 'title', true );
	medeus_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								medeus_show_post_meta(
									apply_filters(
										'medeus_filter_post_meta_args', array(
											'components' => join( ',', medeus_array_get_keys_by_value( medeus_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', medeus_array_get_keys_by_value( medeus_get_theme_option( 'counters' ) ) ),
											'seo'        => medeus_is_on( medeus_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$medeus_blog_title           = medeus_get_blog_title();
							$medeus_blog_title_text      = '';
							$medeus_blog_title_class     = '';
							$medeus_blog_title_link      = '';
							$medeus_blog_title_link_text = '';
							if ( is_array( $medeus_blog_title ) ) {
								$medeus_blog_title_text      = $medeus_blog_title['text'];
								$medeus_blog_title_class     = ! empty( $medeus_blog_title['class'] ) ? ' ' . $medeus_blog_title['class'] : '';
								$medeus_blog_title_link      = ! empty( $medeus_blog_title['link'] ) ? $medeus_blog_title['link'] : '';
								$medeus_blog_title_link_text = ! empty( $medeus_blog_title['link_text'] ) ? $medeus_blog_title['link_text'] : '';
							} else {
								$medeus_blog_title_text = $medeus_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $medeus_blog_title_class ); ?>">
								<?php
								$medeus_top_icon = medeus_get_term_image_small();
								if ( ! empty( $medeus_top_icon ) ) {
									$medeus_attr = medeus_getimagesize( $medeus_top_icon );
									?>
									<img src="<?php echo esc_url( $medeus_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'medeus' ); ?>"
										<?php
										if ( ! empty( $medeus_attr[3] ) ) {
											medeus_show_layout( $medeus_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $medeus_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $medeus_blog_title_link ) && ! empty( $medeus_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $medeus_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $medeus_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'medeus_action_breadcrumbs' );
						$medeus_breadcrumbs = ob_get_contents();
						ob_end_clean();
						medeus_show_layout( $medeus_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
