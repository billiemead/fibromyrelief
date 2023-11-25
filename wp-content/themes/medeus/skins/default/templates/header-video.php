<?php
/**
 * The template to display the background video in the header
 *
 * @package MEDEUS
 * @since MEDEUS 1.0.14
 */
$medeus_header_video = medeus_get_header_video();
$medeus_embed_video  = '';
if ( ! empty( $medeus_header_video ) && ! medeus_is_from_uploads( $medeus_header_video ) ) {
	if ( medeus_is_youtube_url( $medeus_header_video ) && preg_match( '/[=\/]([^=\/]*)$/', $medeus_header_video, $matches ) && ! empty( $matches[1] ) ) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr( $matches[1] ); ?>"></div>
		<?php
	} else {
		?>
		<div id="background_video"><?php medeus_show_layout( medeus_get_embed_video( $medeus_header_video ) ); ?></div>
		<?php
	}
}
