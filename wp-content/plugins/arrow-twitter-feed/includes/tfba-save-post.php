<?php
add_action( 'save_post', 'tfba_save_form' );

function tfba_save_form( $post_id ) {

	$post_type = get_post_type($post_id);
// If this isn't a 'sfba_subscribe_form' post, don't update it.
	if ( "tfba_twitter_feed" != $post_type ) {
		return;
	}

// Stop WP from clearing custom fields on autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
		return;
	}

// Prevent quick edit from clearing custom fields
	if (defined('DOING_AJAX') && DOING_AJAX){
		return;
	}
// - Update the post's metadata.
	if ( isset( $_POST['tfba_private_access_token'] ) ) {
		update_post_meta( $post_id, '_tfba_private_access_token', sanitize_text_field( $_POST['tfba_private_access_token'] ) );
	}
	if ( isset( $_POST['tfba_shortcode_value'] ) ) {
		update_post_meta( $post_id, '_tfba_shortcode_value', sanitize_text_field( $_POST['tfba_shortcode_value'] ) );
	}
	if ( isset( $_POST['tfba_theme_selection'] ) ) {
		update_post_meta( $post_id, '_tfba_theme_selection', sanitize_text_field( $_POST['tfba_theme_selection'] ) );
	}
	if ( isset( $_POST['tfba_feed_post_size'] ) ) {
		update_post_meta( $post_id, '_tfba_feed_post_size', sanitize_text_field( $_POST['tfba_feed_post_size'] ) );
	}
	if ( isset( $_POST['tfba_limit_post_characters'] ) ) {
		update_post_meta( $post_id, '_tfba_limit_post_characters', sanitize_text_field( $_POST['tfba_limit_post_characters'] ) );
	}
	if ( isset( $_POST['tfba_column_count'] ) ) {
		update_post_meta( $post_id, '_tfba_column_count', sanitize_text_field( $_POST['tfba_column_count'] ) );
	}
	if ( isset( $_POST['tfba_thumbnail_size'] ) ) {
		update_post_meta( $post_id, '_tfba_thumbnail_size', sanitize_text_field( $_POST['tfba_thumbnail_size'] ) );
	}
	if ( isset( $_POST['tfba_feed_style'] ) ) {
		update_post_meta( $post_id, '_tfba_feed_style', sanitize_text_field( $_POST['tfba_feed_style'] ) );
	}
	if ( isset( $_POST['tfba_show_photos_from'] ) ) {
		update_post_meta( $post_id, '_tfba_show_photos_from', sanitize_text_field( $_POST['tfba_show_photos_from'] ) );
	}
	if ( isset( $_POST['tfba_user_id'] ) ) {
		update_post_meta( $post_id, '_tfba_user_id', sanitize_text_field( $_POST['tfba_user_id'] ) );
	}
	if ( isset( $_POST['tfba_hashtag'] ) ) {
		update_post_meta( $post_id, '_tfba_hashtag', sanitize_text_field( $_POST['tfba_hashtag'] ) );
	}
	if ( isset( $_POST['tfba_location'] ) ) {
		update_post_meta( $post_id, '_tfba_location', sanitize_text_field( $_POST['tfba_location'] ) );
	}
	if ( isset( $_POST['tfba_container_width'] ) ) {
		update_post_meta( $post_id, '_tfba_container_width', sanitize_text_field( $_POST['tfba_container_width'] ) );
	}
	if ( isset( $_POST['tfba_number_of_photos'] ) ) {
		update_post_meta( $post_id, '_tfba_number_of_photos', sanitize_text_field( $_POST['tfba_number_of_photos'] ) );
	}
	if ( isset( $_REQUEST['tfba_show_photos_only'] ) ) {
		update_post_meta($post_id, '_tfba_show_photos_only', TRUE);
	} else {
		update_post_meta($post_id, '_tfba_show_photos_only', FALSE);
	}
	if ( isset( $_REQUEST['tfba_date_posted'] ) ) {
		update_post_meta($post_id, '_tfba_date_posted', TRUE);
	} else {
		update_post_meta($post_id, '_tfba_date_posted', FALSE);
	}
	if ( isset( $_REQUEST['tfba_read_more'] ) ) {
		update_post_meta($post_id, '_tfba_read_more', TRUE);
	} else {
		update_post_meta($post_id, '_tfba_read_more', FALSE);
	}
	if ( isset( $_REQUEST['tfba_profile_picture'] ) ) {
		update_post_meta($post_id, '_tfba_profile_picture', TRUE);
	} else {
		update_post_meta($post_id, '_tfba_profile_picture', FALSE);
	}
	if ( isset( $_REQUEST['tfba_caption_text'] ) ) {
		update_post_meta($post_id, '_tfba_caption_text', TRUE);
	} else {
		update_post_meta($post_id, '_tfba_caption_text', FALSE);
	}
	if ( isset( $_REQUEST['tfba_link_photos_to_instagram'] ) ) {
		update_post_meta($post_id, '_tfba_link_photos_to_instagram', TRUE);
	} else {
		update_post_meta($post_id, '_tfba_link_photos_to_instagram', FALSE);
	}



	if ( isset( $_POST['tfba_social_card_width'] ) ) {
		update_post_meta( $post_id, '_tfba_social_card_width', sanitize_text_field( $_POST['tfba_social_card_width'] ) );
	}

	if ( isset( $_POST['tfba_social_card_background_color'] ) ) {
		update_post_meta( $post_id, '_tfba_social_card_background_color', sanitize_text_field( $_POST['tfba_social_card_background_color'] ) );
	}

	if ( isset( $_POST['tfba_heading_font_size'] ) ) {
		update_post_meta( $post_id, '_tfba_heading_font_size', sanitize_text_field( $_POST['tfba_heading_font_size'] ) );
	}

	if ( isset( $_POST['tfba_caption_font_size'] ) ) {
		update_post_meta( $post_id, '_tfba_caption_font_size', sanitize_text_field( $_POST['tfba_caption_font_size'] ) );
	}

	if ( isset( $_POST['tfba_social_card_heading_color'] ) ) {
		update_post_meta( $post_id, '_tfba_social_card_heading_color', sanitize_text_field( $_POST['tfba_social_card_heading_color'] ) );
	}

	if ( isset( $_POST['tfba_social_card_content_color'] ) ) {
		update_post_meta( $post_id, '_tfba_social_card_content_color', sanitize_text_field( $_POST['tfba_social_card_content_color'] ) );
	}

	if ( isset( $_POST['tfba_social_card_date_color'] ) ) {
		update_post_meta( $post_id, '_tfba_social_card_date_color', sanitize_text_field( $_POST['tfba_social_card_date_color'] ) );
	}
if ( isset( $_POST['tfba_feed_profile_style'] ) ) {
		update_post_meta( $post_id, '_tfba_feed_profile_style', sanitize_text_field( $_POST['tfba_feed_profile_style'] ) );
	}
	if ( isset( $_REQUEST['tfba_hide_media'] ) ) {
		update_post_meta($post_id, '_tfba_hide_media', TRUE);
	} else {
		update_post_meta($post_id, '_tfba_hide_media', FALSE);
	}


	
}