<?php
/**
 * LIMB gallery
 * Admin controller
 */

class GRSAdminController {
	/**
	 * @var Freemius
	 */
	public $lg_fs;

	/**
	 * @param   Freemius  $lg_fs
	 */
	public function __construct( $lg_fs ) {
		$this->lg_fs = $lg_fs;
	}

	public function display( $view ) {
		require_once( GRS_PLG_DIR . '/admin/models/Model.php' );
		$fileName  = 'View' . ucfirst( strtolower( $view ) );
		$className = 'GRSView' . ucfirst( strtolower( $view ) );
		require_once( GRS_PLG_DIR . '/admin/views/' . $fileName . '.php' );
		$model = new GRSAdminModel( LIMB_Gallery::$version, $this->lg_fs );
		$view  = new $className( $model );
		$view->display();
	}

	// shortcode filter
	public function filter( $atts ) {
		$forallArr = $this->forall();
		$atts      = shortcode_atts( $forallArr, $atts, 'GRS' );

		return $atts;
	}

	public function forall() {
		return array(
			'id'        => 0,
			'timestamp' => 0
		);
	}

	public static $attributesKeysMapping
		= [
			'contwidth'         => 'contWidth',
			'imagesperpage'     => 'imagesPerpage',
			'orderby'           => 'orderBy',
			'clickaction'       => 'clickAction',
			'openlinktarget'    => 'openLinkTarget',
			'mainview'          => 'mainView',
			'masmostype'        => 'masMostype',
			'galview'           => 'galView',
			'galmasmostype'     => 'galMasMostype',
			'galwidth'          => 'galWidth',
			'galheight'         => 'galHeight',
			'galcontwidth'      => 'galContWidth',
			'galtitle'          => 'galTitle',
			'galorderby'        => 'galOrderBy',
			'galordering'       => 'galOrdering',
			'galclickaction'    => 'galClickAction',
			'galopenlinktarget' => 'galOpenLinkTarget',
			'lightboxwidth'     => 'lightboxWidth',
			'lightboxheight'    => 'lightboxHeight',
			'lightboxfilmstrip' => 'lightboxFilmstrip',
			'lightboxcomment'   => 'lightboxComment',
			'lightboxcontbutts' => 'lightboxContButts',
			'lightboxfullw'     => 'lightboxFullW',
			'lightboxfbutt'     => 'lightboxFButt',
			'lightboxgbutt'     => 'lightboxGButt',
			'lightboxtbutt'     => 'lightboxTButt',
			'lightboxpbutt'     => 'lightboxPButt',
			'lightboxtbbutt'    => 'lightboxTbButt',
			'lightboxlibutt'    => 'lightboxLiButt',
			'lightboxreddbutt'  => 'lightboxReddButt',
			'lightboxfsbutt'    => 'lightboxFsButt',
			'lightboxap'        => 'lightboxAP',
			'lightboxapin'      => 'lightboxAPin',
			'lightboximinf'     => 'lightboxImInf',
			'lightboxswipe'     => 'lightboxSwipe',
			'lightboximcn'      => 'lightboxImCn',
			'lightboxeffect'    => 'lightboxEffect'
		];
} 