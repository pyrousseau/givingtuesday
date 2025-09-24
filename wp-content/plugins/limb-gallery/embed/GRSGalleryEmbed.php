<?php
/**
 * LIMB gallery
 * Embed media
 */

class GRSGalleryEmbed extends GRSGalleryAjax {
	// Private variables
	private $provider;
	private $url;
	private $gallery;
	private $parsedUrl = array();
	private $allowSchemes = array(
		'http',
		'https',
	);
	private $allowHosts = array(
		'youtube'   => array(
			'www.youtube.com'
		),
		'instagram' => array(
			'www.instagram.com',
			'www.instagr.am',
		),
		'vimeo'     => array(
			'vimeo.com',
			'player.vimeo.com',
		),
		'flickr'    => array(
			'www.flic.kr',
			'www.flickr.com',
		),
	);
	private $APIendpoints = array(
		'youtube'   => array(
			'oembed' => 'https://www.youtube.com/oembed?format=json&url=',
			'embed'  => 'https://www.youtube.com/embed/{shortcode}?feature=oembed'
		),
		'instagram' => array(
			'oembed' => 'http://api.instagram.com/oembed?url=',
			'media'  => 'https://api.instagram.com/v1/media/{media_id}?access_token=',
		),
		'vimeo'     => array(
			// 'https://vimeo.com/api/oembed.{format}',
			'oembed' => 'https://vimeo.com/api/oembed.json?url=',
			'player' => 'https://player.vimeo.com/video/{video_id}',
		),
		'flickr'    => array(
			'oembed' => 'http://www.flickr.com/services/oembed?format=json&url='
		),
	);
	private $params = array(
		'titleAllowLen' => 512
	);

	// Costructor
	public function __construct() {
		$this->setRequestVars();
	}

	private function setRequestVars() {
		$this->provider = isset( $_POST['provider'] ) ? sanitize_text_field( $_POST['provider'] ) : '';
		$this->url      = isset( $_POST['url'] ) ? esc_url( $_POST['url'] ) : '';
		$this->gallery  = isset( $_POST['gallery'] ) ? (int) sanitize_text_field( $_POST['gallery'] ) : 0;
		// if they are empty send error (it can be done in client side too.)
	}

	public function checkProvider() {
		if ( method_exists( $this, $this->provider ) ) {
			$this->getEmbed();
		} else {
			$this->result( 'error', __( 'Unknown provider', 'limb-gallery' ) );
		}
	}

	private function getEmbed() {
		$this->parse_url();
		$this->checkUrlSchemeForProvider();
		$this->remoteGET();
	}

	private function remoteGET() {
		$APIurl   = $this->APIendpoints[ $this->provider ]['oembed'] . urlencode( $this->url );
		$response = wp_remote_get( $APIurl );

		$bodyobj = $this->getBody( $response );
		$this->{$this->provider}( $bodyobj );
	}

	private function getBody( $response ) {
		$body        = $response['body'];
		$responseArr = $response['response'];
		$bodyObj     = json_decode( $body );
		if ( is_null( $bodyObj ) ) {
			$this->result( 'error', $body );
		}

		return $bodyObj;
	}

	private function checkUrlSchemeForProvider() {
		if ( ! in_array( $this->parsedUrl['scheme'], $this->allowSchemes ) ) {
			$this->result( 'error', __( 'Invalid scheme ', 'limb-gallery' ) . $this->parsedUrl['scheme'] );
		}
		if ( ! in_array( $this->parsedUrl['host'], $this->allowHosts[ $this->provider ] ) ) {
			$this->result( 'error', __( 'Invalid host ', 'limb-gallery' ) . $this->parsedUrl['host'] . __( ' for ',
					'limb-gallery' ) . $this->provider . __( ' provider', 'limb-gallery' ) );
		}
	}

	private function parse_url() {
		$urlArr                    = parse_url( $this->url );
		$this->parsedUrl['scheme'] = array_key_exists( 'scheme', $urlArr ) ? $urlArr['scheme'] : false;
		$this->parsedUrl['host']   = array_key_exists( 'host', $urlArr ) ? $urlArr['host'] : false;
		$this->parsedUrl['path']   = array_key_exists( 'path', $urlArr ) ? $urlArr['path'] : false;
		$this->parsedUrl['query']  = array_key_exists( 'query', $urlArr ) ? $urlArr['query'] : false;
	}

	private function youtube( $bodyObj ) {
		$title  = $bodyObj->title;
		$width  = $bodyObj->thumbnail_width;
		$height = $bodyObj->thumbnail_height;
		// $width = $bodyObj->width;
		// $height = $bodyObj->height;
		$thumb_url = $bodyObj->thumbnail_url;
		parse_str( $this->parsedUrl['query'], $qArr );
		$url = str_replace( '{shortcode}', $qArr['v'], $this->APIendpoints[ $this->provider ]['embed'] );
		$this->saveContent( 'youtube', 'link', $url, $thumb_url, '', $title, '', $width, $height );
	}

	private function flickr( $bodyObj ) {
		$title = $bodyObj->title;
		$type  = $bodyObj->type;
		if ( $type == 'video' ) {
			$this->result( 'error', __( 'Only image urls allowed for flickr provider', 'limb-gallery' ) );
		}
		// $description = $bodyObj->description;
		$width      = $bodyObj->width;
		$height     = $bodyObj->height;
		$url        = $bodyObj->url;
		$path_parts = pathinfo( $bodyObj->thumbnail_url );
		$size       = substr( $path_parts['filename'], - 2, 2 );
		if ( strpos( $size, "_" ) !== false ) {
			$thumbFilename = substr( $path_parts['filename'], 0, - 2 );
			$thumb_url     = $path_parts['dirname'] . "/" . $thumbFilename . "." . $path_parts['extension'];
		} else {
			$thumb_url = $bodyObj->thumbnail_url;
		}
		$this->saveContent( 'flickr', 'image', $url, $thumb_url, '', $title, '', $width, $height );
	}

	private function vimeo( $bodyObj ) {
		$title       = $bodyObj->title;
		$description = $bodyObj->description;
		$width       = $bodyObj->thumbnail_width;
		$height      = $bodyObj->thumbnail_height;
		$thumb_url   = $bodyObj->thumbnail_url;
		$video_id    = $bodyObj->video_id;

		$url = str_replace( '{video_id}', $video_id, $this->APIendpoints[ $this->provider ]['player'] );
		$this->saveContent( 'vimeo', 'link', $url, $thumb_url, '', $title, $description, $width, $height );
	}

	private function instagram( $bodyObj ) {

		$response = wp_remote_get( $this->url );
		$code     = $response['response']['code'];
		if ( $code != 200 ) {
			$this->result( 'error', __( 'Error something went wrong', 'limb-gallery' ) );
		}
		$videoUrl = null;
		// If video
		$doc = new DOMDocument();
		$doc->loadHTML( $response['body'] );
		$metas = $doc->getElementsByTagName( 'meta' );
		foreach ( $metas as $meta ) {
			if ( method_exists( $meta,
					'hasAttribute' ) && $meta->hasAttribute( 'property' ) && $meta->getAttribute( 'property' ) === 'og:video' ) {
				$videoUrl = $meta->getAttribute( 'content' );
				break;
			}
		}

		$title = $bodyObj->title;
		$type  = is_null( $videoUrl ) ? 'image' : 'video';

		$thumb_url = $bodyObj->thumbnail_url;
		$url       = is_null( $videoUrl ) ? $thumb_url : $videoUrl;
		$width     = $bodyObj->thumbnail_width;
		$height    = $bodyObj->thumbnail_height;

		$this->saveContent( 'instagram', $type, $url, $thumb_url, '', $title, '', $width, $height );
	}

	private function saveContent(
		$embed,
		$type,
		$path,
		$thumb_url,
		$name = '',
		$title,
		$description = '',
		$width,
		$height
	) {
		global $wpdb;
		// $wpdb->show_errors();
		$date = date_create( null );
		date_timezone_set( $date, timezone_open( 'UTC' ) );
		$createDate  = date_format( $date, "Y-m-d H:i:s" );
		$titleLen    = strlen( $title );
		$title       = $titleLen > $this->params['titleAllowLen'] ? substr( $title, 0,
			- ( $titleLen - $this->params['titleAllowLen'] ) ) : $title;
		$order       = $wpdb->get_var( $wpdb->prepare( "SELECT MIN(`order`) FROM `" . $wpdb->prefix . "limb_gallery_galleriescontent` WHERE `galId`=%d",
			$this->gallery ) );
		$order       = $order == null ? 0 : $order - 1;
		$content_row = array(
			'galId'        => $this->gallery,
			'name'         => $name,
			'title'        => $title,
			'description'  => $description,
			'path'         => $path,
			'link'         => $this->url,
			'order'        => $order,
			'type'         => $type,
			'embed'        => $embed,
			'thumb_url'    => $thumb_url,
			'width'        => $width,
			'height'       => $height,
			'publish'      => 1,
			'createDate'   => $createDate,
			'lastmodified' => $createDate
		);
		$success     = $wpdb->insert( $wpdb->prefix . 'limb_gallery_galleriescontent',
			$content_row,
			array(
				'%d',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%d',
				'%s',
				'%s',
				'%s',
				'%d',
				'%d',
				'%d',
				'%s',
				'%s',
			)
		);
		// $wpdb->print_error();
		if ( $success !== false ) {
			$content_row['id'] = $wpdb->insert_id;
			$this->result( 'success', $content_row );
		} else {
			$this->result( 'error', __( 'Problem with save', 'limb-gallery' ) );
		}
	}
}

?>