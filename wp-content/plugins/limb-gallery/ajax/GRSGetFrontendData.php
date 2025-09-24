<?php
/**
 * LIMB gallery
 * Ajax
 */

class GRSGetFrontendData {

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

	public function getGalleryData() {
		global $wpdb;
		$id           = isset( $_POST['id'] ) ? (int) esc_sql( $_POST['id'] ) : 0;
		$theme        = isset( $_POST['theme'] ) ? (int) esc_sql( $_POST['theme'] ) : 0;
		$start        = isset( $_POST['start'] ) ? (int) esc_sql( $_POST['start'] ) : 0;
		$count        = isset( $_POST['count'] ) ? (int) esc_sql( $_POST['count'] ) : 0;
		$orderBy      = isset( $_POST['orderBy'] ) && $_POST['orderBy'] != '' ? "`" . sanitize_sql_orderby( $_POST['orderBy'] ) . "`" : "`createDate`";
		$ordering     = isset( $_POST['ordering'] ) && $_POST['ordering'] != '' ? esc_sql( $_POST['ordering'] ) : "ASC";
		$firstRequest = isset( $_POST['firstRequest'] ) ? (bool) esc_sql( $_POST['firstRequest'] ) : false;
		$view         = isset( $_POST['view'] ) ? strtolower( esc_sql( $_POST['view'] ) ) : '';
		$data         = new stdclass();
		$start        *= $count;
		$queryG       = $wpdb->prepare( "SELECT `id` FROM " . $wpdb->prefix . "limb_gallery_galleries WHERE `id`=%d",
			$id );
		$gallId       = $wpdb->get_var( $queryG );

		if ( $gallId != null ) {
			$query             = $wpdb->prepare( "SELECT * FROM " . $wpdb->prefix . "limb_gallery_galleriescontent WHERE `publish`=1 AND `galId`=%d ORDER BY " . $orderBy . " " . $ordering . " LIMIT " . $start . "," . $count,
				$id );
			$grsGallerieImages = $wpdb->get_results( $query );
			if ( $firstRequest ) {
				$data->theme      = $this->getThemeParams( $view, $theme );
				$data->count      = $this->getImgsCount( $id );
				$data->gallExists = true;
			}
			$data->images = $grsGallerieImages;
		} else {
			$data->count           = 0;
			$data->gallExists      = false;
			$data->images          = array();
			$data->theme           = new stdClass();
			$data->theme->$view    = '{}';
			$data->theme->lightbox = '{}';
		}
		print_r( json_encode( $data ) );
		die();
	}

	public function getAlbumData() {
		global $wpdb;
		$id           = isset( $_POST['id'] ) ? (int) esc_sql( $_POST['id'] ) : 0;
		$theme        = isset( $_POST['theme'] ) ? (int) esc_sql( $_POST['theme'] ) : 0;
		$start        = isset( $_POST['start'] ) ? (int) esc_sql( $_POST['start'] ) : 0;
		$count        = isset( $_POST['count'] ) ? (int) esc_sql( $_POST['count'] ) : 0;
		$orderBy      = isset( $_POST['orderBy'] ) && $_POST['orderBy'] != '' ? "`" . sanitize_sql_orderby( $_POST['orderBy'] ) . "`" : "`createDate`";
		$ordering     = isset( $_POST['ordering'] ) && $_POST['ordering'] != '' ? esc_sql( $_POST['ordering'] ) : "ASC";
		$firstRequest = isset( $_POST['firstRequest'] ) ? (bool) esc_sql( $_POST['firstRequest'] ) : false;
		$view         = isset( $_POST['view'] ) ? strtolower( esc_sql( $_POST['view'] ) ) : '';
		$data         = new stdclass();
		$start        *= $count;
		$queryA       = $wpdb->prepare( "SELECT `id` FROM " . $wpdb->prefix . "limb_gallery_albums WHERE id='%d'",
			$id );
		$albId        = $wpdb->get_var( $queryA );
		if ( $albId != null ) {
			$query = $wpdb->prepare( "(SELECT `" . $wpdb->prefix . "limb_gallery_albumscontent`.`id`,
				`" . $wpdb->prefix . "limb_gallery_albumscontent`.`albId`,
				`" . $wpdb->prefix . "limb_gallery_albumscontent`.`contentId`,
				`" . $wpdb->prefix . "limb_gallery_albumscontent`.`type` as `contentType`,
				`" . $wpdb->prefix . "limb_gallery_albums`.`title`,
				`" . $wpdb->prefix . "limb_gallery_albums`.`description`,
				`" . $wpdb->prefix . "limb_gallery_albums`.`createDate` as date,
				`" . $wpdb->prefix . "limb_gallery_albums`.`prevImgName` as name,
				`" . $wpdb->prefix . "limb_gallery_albums`.`prevImgPath` as path, 
				`" . $wpdb->prefix . "limb_gallery_albums`.`prevImgType` as type,
				`" . $wpdb->prefix . "limb_gallery_albums`.`prevImgWidth` as width, 
				`" . $wpdb->prefix . "limb_gallery_albums`.`prevImgHeight` as height FROM `" . $wpdb->prefix . "limb_gallery_albumscontent` INNER JOIN `" . $wpdb->prefix . "limb_gallery_albums` ON ( `" . $wpdb->prefix . "limb_gallery_albumscontent`.`contentId` = `" . $wpdb->prefix . "limb_gallery_albums`.`id` AND `" . $wpdb->prefix . "limb_gallery_albumscontent`.`type` = 'alb'  AND `" . $wpdb->prefix . "limb_gallery_albumscontent`.`albId` = %d)) 
										UNION ALL
										(SELECT `" . $wpdb->prefix . "limb_gallery_albumscontent`.`id`,
				`" . $wpdb->prefix . "limb_gallery_albumscontent`.`albId`,
				`" . $wpdb->prefix . "limb_gallery_albumscontent`.`contentId`,
				`" . $wpdb->prefix . "limb_gallery_albumscontent`.`type` as `contentType`,
				`" . $wpdb->prefix . "limb_gallery_galleries`.`title`,
				`" . $wpdb->prefix . "limb_gallery_galleries`.`description`,
				`" . $wpdb->prefix . "limb_gallery_galleries`.`createDate` as date,
				`" . $wpdb->prefix . "limb_gallery_galleries`.`prevImgName` as name,
				`" . $wpdb->prefix . "limb_gallery_galleries`.`prevImgPath` as path, 
				`" . $wpdb->prefix . "limb_gallery_galleries`.`prevImgType` as type,
				`" . $wpdb->prefix . "limb_gallery_galleries`.`prevImgWidth`  as width, 
				`" . $wpdb->prefix . "limb_gallery_galleries`.`prevImgHeight` as height FROM `" . $wpdb->prefix . "limb_gallery_albumscontent` INNER JOIN `" . $wpdb->prefix . "limb_gallery_galleries` ON ( `" . $wpdb->prefix . "limb_gallery_albumscontent`.`contentId` = `" . $wpdb->prefix . "limb_gallery_galleries`.`id` AND `" . $wpdb->prefix . "limb_gallery_albumscontent`.`type` = 'gal'  AND `" . $wpdb->prefix . "limb_gallery_albumscontent`.`albId` = %d)) ORDER BY " . $orderBy . " " . $ordering . "
				LIMIT " . $start . "," . $count, $id, $id );
			if ( $firstRequest ) {
				$data->theme     = $this->getThemeParams( $view, $theme );
				$data->count     = $this->getContentCount( $id );
				$data->albExists = true;
			}
			$grsAlbumContent = $wpdb->get_results( $query );
			$data->content   = $grsAlbumContent;
		} else {
			$data->count     = 0;
			$data->albExists = false;
			$data->content   = array();
		}
		print_r( json_encode( $data ) );
		die();
	}

	public function getPopupData() {
		global $wpdb;
		$id       = isset( $_POST['id'] ) ? (int) esc_sql($_POST['id']) : 0;
		$perPage  = isset( $_POST['perPage'] ) ? (int) esc_sql($_POST['perPage']) : 0;
		$offsets  = isset( $_POST['offsets'] ) ? esc_sql($_POST['offsets']) : array();
		$query    = "";
		$orderBy  = isset( $_POST['orderBy'] ) && $_POST['orderBy'] != '' ? "`" . sanitize_sql_orderby( $_POST['orderBy'] ) . "`" : "`createDate`";
		$ordering = isset( $_POST['ordering'] ) && $_POST['ordering'] != '' ? esc_sql( $_POST['ordering'] ) : "DESC";
		if ( is_array( $offsets ) ) {
			foreach ( $offsets as $key => $offset ) {
				$start = $offset['from'] * $perPage;
				if ( is_array( $offset ) ) {
					$query .= "(SELECT * FROM `" . $wpdb->prefix . "limb_gallery_galleriescontent` WHERE `galId`=$id ORDER BY $orderBy $ordering LIMIT " . $start . "," . $offset['count'] . ")";
					if ( $key == ( count( $offsets ) - 1 ) ) {
						continue;
					} else {
						$query .= " UNION ALL ";
					}
				}
			}
		}
		$data = $wpdb->get_results( $query );
		if ( is_array( $data ) ) {
			$this->ajaxClass->result( 'success', $data );
		} else {
			$this->ajaxClass->result( 'error', 'Something went wrong.' );
		}
	}

	public function getThemeParams( $view, $theme ) {
		global $wpdb;
		$views = array( 'thumbnail', 'masonry', 'mosaic', 'album', 'film', 'carousel3d' );
		if ( ! in_array( $view, $views ) ) {
			return null;
		}
		$q         = "SELECT `" . $view . "`, `lightbox` FROM " . $wpdb->prefix . "limb_gallery_themes";
		$query     = $wpdb->prepare( $q . " WHERE `id`=%d ORDER BY `id` ASC ", $theme );
		$themeData = $wpdb->get_row( $query );
		if ( $theme == 0 || $themeData == null ) {
			// Get default theme
			$query     = $q . " WHERE `default`=1 ORDER BY `id` ASC ";
			$themeData = $wpdb->get_row( $query );
		}

		return $themeData;
	}

	public function getImgsCount( $id ) {
		global $wpdb;
		$query        = $wpdb->prepare( "SELECT COUNT(*) FROM `" . $wpdb->prefix . "limb_gallery_galleriescontent` WHERE `publish`=1 AND `galId`=%d",
			$id );
		$grsImgsCount = $wpdb->get_var( $query );

		return $grsImgsCount;
	}

	public function getContentCount( $id ) {
		global $wpdb;
		$query        = $wpdb->prepare( "SELECT COUNT(*) FROM `" . $wpdb->prefix . "limb_gallery_albumscontent` WHERE `albId`=%d",
			$id );
		$grsContCount = $wpdb->get_var( $query );

		return $grsContCount;
	}

	// Settings
	private function getSettingsForF() {
		global $wpdb;
		$grsSettings = $wpdb->get_row( "SELECT * FROM `" . $wpdb->prefix . "limb_gallery_settings` WHERE `default`=1" );
		$this->ajaxClass->result( 'success', $grsSettings, true );
	}
}