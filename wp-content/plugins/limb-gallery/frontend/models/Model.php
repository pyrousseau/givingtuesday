<?php
/**
 * LIMB gallery
 * Frontend
 * Model
 */

class GRSModel {

	/**
	 * @var $atts
	 */
	public $atts;
	public $theme;

	/**
	 * GRSModel constructor.
	 *
	 * @param $atts
	 *
	 * @throws Exception
	 */
	public function __construct( $atts ) {
		$this->atts = $atts;
		$this->setSomeThemeParams();
	}

	/**
	 * @throws Exception
	 */
	public function setSomeThemeParams() {
		global $wpdb;
		if ( preg_match( '/"theme":"([[:digit:]]+)"/', $this->atts, $matches ) ) {
			$lastModDate = $wpdb->get_var( $wpdb->prepare( "SELECT `lastmodified` FROM `" . $wpdb->prefix . "limb_gallery_themes` WHERE `id` = %d",
				$matches[1] ) );

			if ( $lastModDate == null ) {
				$defTheme = $wpdb->get_row( "SELECT `id`, `lastmodified` FROM `" . $wpdb->prefix . "limb_gallery_themes` WHERE `default` = 1" );
				if ( $defTheme != null ) {

					// Replace the value of the theme
					preg_replace( '/"theme":"([[:digit:]]+)"/', $defTheme->id, $this->atts, 1 );
					$this->theme = $defTheme->id;
					// Add new new field value to the JSON
					$this->atts = substr_replace( $this->atts,
						',"themeLastModDate":"' . strtotime( $defTheme->lastmodified ) . '"', - 1, 0 );
				} else {
					// Add new new field value to the JSON
					$this->theme = 0;
					$this->atts  = substr_replace( $this->atts, ',"themeLastModDate":""', - 1, 0 );
				}
			} else {
				$this->theme = $matches[1];
				// Add new new field value to the JSON
				$this->atts = substr_replace( $this->atts, ',"themeLastModDate":"' . strtotime( $lastModDate ) . '"',
					- 1, 0 );
			}
		} else {
			throw new \Exception('invalid_params_structure');
		}
	}
}