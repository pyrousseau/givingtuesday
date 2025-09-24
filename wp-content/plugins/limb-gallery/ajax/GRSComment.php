<?php
/**
 * LIMB gallery
 * Ajax
 * GRSComment
 */

class GRSComment extends GRSGalleryAjax {

	/**
	 * @var GRSGalleryAjax
	 */
	public $ajaxClass;

	/**
	 * @param GRSGalleryAjax $ajaxClass
	 */
	public function __construct( $ajaxClass ) {
		$this->ajaxClass = $ajaxClass;
		if ( method_exists( $this, $ajaxClass->action ) ) {
			$this->{$ajaxClass->action}();
		}
	}

	private function comment() {
		global $wpdb;
		// $wpdb->show_errors();
		$name        = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
		$email       = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
		$comment     = isset( $_POST['comment'] ) ? sanitize_text_field( wp_unslash( $_POST['comment'] ) ) : '';
		$imageId     = isset( $_POST['imageId'] ) ? (int) $_POST['imageId'] : 0;
		$galId       = isset( $_POST['galId'] ) ? (int) $_POST['galId'] : 0;
		$captchaCode = isset( $_POST['captchaCode'] ) ? sanitize_text_field( $_POST['captchaCode'] ) : '';
		if ( session_id() == '' ) {
			session_start([
				'read_and_close' => true,
			]);
		}
		if ( $captchaCode === $_SESSION['captcha']['code'] ) {
			if ( $name == '' ) {
				$message = __( 'Invalid name', 'limb-gallery' );
				$result  = 'error';
			} elseif ( $email == '' ) {
				$message = __( 'Invalid email address', 'limb-gallery' );
				$result  = 'error';
			} elseif ( $comment == '' ) {
				$message = __( 'Invalid comment', 'limb-gallery' );
				$result  = 'error';
			} elseif ( ! $imageId ) {
				$message = __( 'Invalid image', 'limb-gallery' );
				$result  = 'error';
			} elseif ( ! $galId ) {
				$message = __( 'Invalid gallery', 'limb-gallery' );
				$result  = 'error';
			} else {
				$grsSettings = $wpdb->get_row( "SELECT * FROM `" . $wpdb->prefix . "limb_gallery_settings` WHERE `default`=1" );
				$date        = date_create( null );
				date_timezone_set( $date, timezone_open( 'UTC' ) );
				$createDate = date_format( $date, "Y-m-d H:i:s" );
				$insert     = $wpdb->insert( $wpdb->prefix . 'limb_gallery_comments',
					array(
						'imgId'      => $imageId,
						'galId'      => $galId,
						'publish'    => 1,
						'name'       => $name,
						'email'      => $email,
						'comment'    => $comment,
						'createDate' => $createDate
					),
					array(
						'%d',
						'%d',
						'%d',
						'%s',
						'%s',
						'%s',
						'%s'
					)
				);
				if ( $insert !== false ) {
					$result             = 'success';
					$message            = new stdclass();
					$message->insert_id = $wpdb->insert_id;
					// $grsSettings = $wpdb->get_row("SELECT `timezone`, `timeformat` FROM `" . $wpdb->prefix . "grssettings` WHERE `default`=1");
					date_timezone_set( $date, timezone_open( $grsSettings->timezone ) );
					$message->createDate = date_format( $date, $grsSettings->timeformat );
				} else {
					// $wpdb->print_error();
					$message = __( 'Problem with save', 'limb-gallery' );
					$result  = 'error';
				}
			}
		} else {
			$message = __( 'Incorrect captcha code', 'limb-gallery' );
			$result  = 'error';
		}
		$this->ajaxClass->result( $result, $message );

		return;
	}

	public function showComments() {
		global $wpdb;
		$id          = ( isset( $_POST['id'] ) && $_POST['id'] != '' ) ? (int) $_POST['id'] : 0;
		$gallId      = ( isset( $_POST['gallId'] ) && $_POST['gallId'] != '' ) ? (int) $_POST['gallId'] : 0;
		$grsSettings = $wpdb->get_row( "SELECT `timezone`, `timeformat` FROM `" . $wpdb->prefix . "limb_gallery_settings` WHERE `default`=1" );
		if ( $id && $gallId ) {
			$query    = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "limb_gallery_comments WHERE `imgId`=%d AND `galId`=%d",
				$id, $gallId );
			$comments = $wpdb->get_results( $query );
			foreach ( $comments as $key => $comment ) {
				$date = date_create( $comment->createDate );
				date_timezone_set( $date, timezone_open( $grsSettings->timezone ) );
				$comment->createDate = date_format( $date, $grsSettings->timeformat );
			}
			$this->ajaxClass->result( 'success', $comments );
		} else {
			$this->ajaxClass->result( 'error', __( 'Invalid image id', 'limb-gallery' ) );
		}
	}
}