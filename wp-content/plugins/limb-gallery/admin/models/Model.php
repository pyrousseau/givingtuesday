<?php
/**
 * LIMB gallery
 * Admin model
 */

class GRSAdminModel {
	// vars
	public $version;
	/**
	 * @var Freemius
	 */
	public $lg_fs;

	/**
	 * @param   string    $version
	 * @param   Freemius  $lg_fs
	 */
	public function __construct( $version, $lg_fs ) {
		$this->version = $version;
		$this->lg_fs   = $lg_fs;
	}

	// method declaration
	public function check_action() {
	}

	public function getGrsGalleries() {
		global $wpdb;

		return $wpdb->get_results( "SELECT `id`, `title` FROM `" . $wpdb->prefix . "limb_gallery_galleries`" );
	}

	public function getGrsAlbums() {
		global $wpdb;

		return $wpdb->get_results( "SELECT `id`, `title` FROM `" . $wpdb->prefix . "limb_gallery_albums`" );
	}

	public function getGrsThemes() {
		global $wpdb;

		return $wpdb->get_results( "SELECT `id`, `name`, `default` FROM `" . $wpdb->prefix . "limb_gallery_themes`" );
	}

	public function addDotes( $str ) {
		return strlen( $str ) > 15 ? substr( $str, 0, 15 ) . "..." : $str;
	}

	public function getViewConf( $conf ) {
		$viewConf = array();
		foreach ( $conf as $key => $value ) {
			$viewConf[ $key ]                = array();
			$viewConf[ $key ]['mode']        = $value ? '' : 'disabled';
			$viewConf[ $key ]['class']       = $value ? 'enabled' : 'disabled';
			$viewConf[ $key ]['checked_yes'] = $value ? 'checked' : '';
			$viewConf[ $key ]['checked_no']  = $value ? '' : 'checked';
		}

		return $viewConf;
	}

	public function getOrderbies() {
		return array(
			'order'       => __( 'Custom Order', 'limb-gallery' ),
			'createDate'  => __( 'Date', 'limb-gallery' ),
			'id'          => __( 'Id', 'limb-gallery' ),
			'title'       => __( 'Title', 'limb-gallery' ),
			'description' => __( 'Description', 'limb-gallery' ),
			'type'        => __( 'Type', 'limb-gallery' ),
		);
	}

	public function getOrderbiesForAlb() {
		return array(
			'date'        => __( 'Date', 'limb-gallery' ),
			'contentId'   => __( 'Id', 'limb-gallery' ),
			'title'       => __( 'Title', 'limb-gallery' ),
			'description' => __( 'Description', 'limb-gallery' ),
			'contentType' => __( 'Type', 'limb-gallery' ),
		);
	}

	public function getClickActions() {
		return array(
			'openLightbox' => __( 'Open lightbox', 'limb-gallery' ),
			'openLink'     => __( 'Open link', 'limb-gallery' ),
			'doNothing'    => __( 'Do nothing', 'limb-gallery' ),
		);
	}

	public function getOpenLinkTargets() {
		return array(
			'_top'    => __( 'Same tab', 'limb-gallery' ),
			'_blank'  => __( 'New tab', 'limb-gallery' ),
			'_self'   => __( 'Same frame', 'limb-gallery' ),
			'_parent' => __( 'Parent frame', 'limb-gallery' ),
		);
	}

	public function getShortCode( $id ) {
		global $wpdb;
		try {
			$paramsStr = $wpdb->get_var( $wpdb->prepare( "SELECT `params` FROM `" . $wpdb->prefix . "limb_gallery_shortcodes` WHERE `id`=%d", $id ) );
			//TODO check params validness
			// Bring to normal keys from lowercase saved data
			$params       = (array) json_decode( $paramsStr );
			$newParamsArr = [];
			foreach ( $params as $key => $param ) {
				if ( isset( GRSAdminController::$attributesKeysMapping[ $key ] ) ) {
					$newParamsArr[ GRSAdminController::$attributesKeysMapping[ $key ] ] = $param;
				} else {
					$newParamsArr[ $key ] = $param;
				}
			}
			if ( ! empty( $newParamsArr ) ) {
				return json_encode( $newParamsArr );
			} else {
				return '';
			}
		}
		catch ( \Exception $e ) {
			// log error
			return '';
		}
	}

	public function getEffects() {
		$effects = GRS_PLG_DIR . '/frontend/views/grsEffects.json';
		if ( file_exists( $effects ) ) {
			$effectsJson = file_get_contents( $effects );

			return @json_decode( $effectsJson, true );
		} else {
			return @json_decode( '{"noEffect":{"label":"No effect","effects":{"no":{"title":"No","plan":[null,"free","personal","pro","elite"]}},"doEffect":"grsNoEffect"},"noCutting":{"label":"No cutting","effects":{"fade":{"selected":1,"in":"grsFadeIn grsAnDur inAnimationEnd","out":"grsFadeOut grsAnDur outAnimationEnd","title":"Fade","plan":[null,"free","personal","pro","elite"]}},"doEffect":"grsNoCuting"}}',
				true );
		}
	}
} 