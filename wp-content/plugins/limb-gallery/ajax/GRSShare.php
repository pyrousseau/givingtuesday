<?php

/**
 * LIMB gallery
 * GRSShare
 */
class GRSShare {

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

	private function share() {
		global $wpdb;
		$imageId       = isset( $_GET['imageId'] ) ? (int) $_GET['imageId'] : '';
		$grs           = isset( $_GET['grs'] ) ? (int) $_GET['grs'] : '';
		$curUrl        = isset( $_GET['curUrl'] ) ? esc_url( $_GET['curUrl'] ) : '';
		$query         = $wpdb->prepare( 'SELECT * FROM `' . $wpdb->prefix . 'limb_gallery_galleriescontent` WHERE `id`="%d"',
			$imageId );
		$item          = $wpdb->get_row( $query );
		$socialNetwork = isset( $_GET['socialNetwork'] ) ? sanitize_text_field( $_GET['socialNetwork'] ) : '';
		if ( $item->embed == '' ) {
			$imageUrl = LIMB_Gallery::$uploadUrl . $item->path . 'medium/' . $item->name . $item->type;
			$imageDir = LIMB_Gallery::$uploadDir . $item->path . 'medium/' . $item->name . $item->type;
			list( $width, $height ) = getimagesize( $imageDir );
			$imageUrl = str_replace( ' ', '%20', $imageUrl );
			$shareUrl = add_query_arg( array(
				"action"    => "grsGalleryAjax",
				"grsAction" => "share",
				"imageId"   => $imageId,
				"grs"       => $grs,
				"curUrl"    => urlencode( $curUrl )
			), admin_url( "admin-ajax.php" ) );
		} elseif ( $item->embed == 'wp' ) {
			$imageUrl = LIMB_Gallery::$wpUploadDir['baseurl'] . '/' . $item->path . $item->name . $item->type;
			$imageDir = LIMB_Gallery::$wpUploadDir['basedir'] . '/' . $item->path . $item->name . $item->type;
			list( $width, $height ) = getimagesize( $imageDir );
			$imageUrl = str_replace( ' ', '%20', $imageUrl );
			$shareUrl = add_query_arg( array(
				"action"    => "grsGalleryAjax",
				"grsAction" => "share",
				"imageId"   => $imageId,
				"grs"       => $grs,
				"curUrl"    => urlencode( $curUrl )
			), admin_url( "admin-ajax.php" ) );
		} else {
			if ( $socialNetwork == 'facebook' ) {
				$shareUrl = $item->link;
			} else {
				if ( $item->embed == 'flickr' ) {
					$imageUrl = $item->path;

				} elseif ( $item->embed == 'instagram' ) {
					if ( $item->type == 'video' ) {
						$imageUrl = $item->thumb_url;
					} else {
						$imageUrl = $item->path;
					}
				} else {
					$imageUrl = $item->thumb_url;
				}
				$width       = $item->with;
				$height      = $item->height;
				$item->embed = '';
				$shareUrl    = '';
			}
		}
		?>
        <!DOCTYPE html>
        <html>
        <head>
            <title><?php echo $item->title; ?></title>
            <meta property="og:title" content="<?php echo esc_attr( $item->title ); ?>"/>
            <meta property="og:type" content="website"/>
            <meta property="og:url" content="<?php echo esc_url( $shareUrl ); ?>"/>
			<?php if ( $item->embed == '' || $item->embed == 'wp' ) { ?>
                <meta property="og:image" content="<?php echo esc_url( $imageUrl ); ?>"/>
                <meta property="og:image:width" content="<?php echo esc_attr( $width ); ?>"/>
                <meta property="og:image:height" content="<?php echo esc_attr( $height ); ?>"/>
			<?php } ?>
            <meta property="og:description" content="<?php echo esc_attr( $item->description ); ?>"/>
            <script>
                window.location = '<?php echo $curUrl; ?>';
            </script>
        </head>
        <body>
        </body>
        </html>
		<?php
		wp_die();
	}
}