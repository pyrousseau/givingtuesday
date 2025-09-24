<?php

/**
 * LIMB gallery
 * Ajax
 */
class GRSGalleryAjax {

	/**
	 * @var mixed|string|void
	 */
	public $action;

	/**
	 * @var Freemius
	 */
	public $lg_fs;

	/**
	 * @var array
	 */
	public $actions = array(
		"getUploderItems"        => 'GRSAdminActions',
		"delItemsFromUploader"   => 'GRSAdminActions',
		"renameItemInUploader"   => 'GRSAdminActions',
		"addImageToUploader"     => 'GRSAdminActions',
		"addFolderInUploader"    => 'GRSAdminActions',
		"copyItemInUploader"     => 'GRSAdminActions',
		"getGalleryItems"        => 'GRSAdminActions',
		"getGalleryTItems"       => 'GRSAdminActions',
		"embedMedia"             => 'GRSAdminActions',
		"saveOrder"              => 'GRSAdminActions',
		"insert"                 => 'GRSAdminActions',
		"update"                 => 'GRSAdminActions',
		"delete"                 => 'GRSAdminActions',
		"addImages"              => 'GRSAdminActions',
		"addImagesFromWP"        => 'GRSAdminActions',
		"addPwAIm"               => 'GRSAdminActions',
		"addGPvIm"               => 'GRSAdminActions',
		"deleteImage"            => 'GRSAdminActions',
		"deleteImages"           => 'GRSAdminActions',
		"removeComments"         => 'GRSAdminActions',
		"getAlbumItems"          => 'GRSAdminActions',
		"addContentForAlbum"     => 'GRSAdminActions',
		"deleteContentFromAlbum" => 'GRSAdminActions',
		"addUpdateAlbum"         => 'GRSAdminActions',
		"deleteAlbum"            => 'GRSAdminActions',
		"saveSettings"           => 'GRSAdminActions',
		"getSettings"            => 'GRSAdminActions',
		"uninstall"              => 'GRSAdminActions',
		"setDefault"             => 'GRSAdminActions',
		"getThemeItems"          => 'GRSAdminActions',
		"addTheme"               => 'GRSAdminActions',
		"updateTheme"            => 'GRSAdminActions',
		"deleteTheme"            => 'GRSAdminActions',
		"saveThemeToFile"        => 'GRSAdminActions',
		"getGalleryData"         => 'GRSGetFrontendData',
		"getAlbumData"           => 'GRSGetFrontendData',
		"getPopupData"           => 'GRSGetFrontendData',
		"showComments"           => 'GRSComment',
		"comment"                => 'GRSComment',
		"reloadCaptcha"          => 'GRSCaptcha',
		"captcha"                => 'GRSCaptcha',
		"share"                  => 'GRSShare',
		"shortcode"              => 'GRSAdminActions',
		"addEditShortCode"       => 'GRSAdminActions',
		"getSettingsForF"        => 'GRSGetFrontendData',
	);

	/**
	 * GRSGalleryAjax constructor.
	 * 
	 * @param Freemius $lg_fs
	 */
	public function __construct($lg_fs) {
		$this->lg_fs = $lg_fs;
		if ( isset( $_POST['grsAction'] ) ) {
			$this->action = sanitize_text_field($_POST['grsAction']);
		} elseif ( isset( $_GET['grsAction'] ) ) {
			$this->action = sanitize_text_field($_GET['grsAction']);
		} else {
			$this->action = __( 'It isn\'t grs action', 'limb-gallery' );
		}
	}

	/**
	 *
	 */
	public function grsCheckAction() {
		$this->checkStatus();
		if ( array_key_exists( $this->action, $this->actions ) ) {
			// Implement wp_ajax_nopriv_{action} check manually
			if($this->actions[ $this->action ] === 'GRSAdminActions' && !is_user_logged_in()) {
				wp_die(0);
			}
			require_once( GRS_PLG_DIR . '/ajax/' . $this->actions[ $this->action ] . '.php' );
			$obj = new $this->actions[$this->action]( $this );
		} else {
			$this->result( 'error', __( 'Unknown action.', 'limb-gallery' ) );
		}
	}

	// Verify nonce
	public function verifyNonce() {
		if ( ! check_ajax_referer( 'grs-ajax-nonce', 'grsAjaxNonce', false ) ) {
			$this->result( 'error', __( 'Your nonce is not verified', 'limb-gallery' ) );
		}
	}

	// Print result
	public function result( $result, $message = 'message', $num = false ) {
		print_r( json_encode( array( $result => $message ) ) );
		wp_die();
	}

	// DataTables errors
	private function checkStatus() {
		$statusJs = get_option( LIMB_Gallery::$aCsOptName, false );
		$status   = json_decode( $statusJs );
		if ( $status->mood == 'error' ) {
			$this->result( 'error', $status->content . ', ' . __( 'try to reactivate plugin.', 'limb-gallery' ) );
		} else {
			return true;
		}
	}
}