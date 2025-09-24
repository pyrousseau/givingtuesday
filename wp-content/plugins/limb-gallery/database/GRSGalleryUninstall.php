<?php
/**
 * LIMB gallery
 * Grs Gallery Uninstall
 */
 
class GRSGalleryUninstall {
	// Private vars
	private $options = array(
		'deleteFolder' => false,
		'removeOptions' => true
	);

	/**
	 * Class constructor
	 */
	public function __construct() {	
	}
	
	// Uninstall
	public function uninstall() {
		return $this->drop();
	}
	
	// Drop tables
	public function drop() {
		global $wpdb;
		$query = "DROP TABLE IF EXISTS  `". $wpdb->prefix . "limb_gallery_comments`, 
										`". $wpdb->prefix . "limb_gallery_albumscontent`,
										`". $wpdb->prefix . "limb_gallery_galleriescontent`,
										`". $wpdb->prefix . "limb_gallery_settings`,
										`". $wpdb->prefix . "limb_gallery_themes`,
										`". $wpdb->prefix . "limb_gallery_galleries`,
										`". $wpdb->prefix . "limb_gallery_shortcodes`,
										`". $wpdb->prefix . "limb_gallery_albums`;";
		return ((!get_option( LIMB_Gallery::$vOptName, false ))) ? 'Plugin already uninstalled' : $wpdb->query($query) && $this->removeOptions();
	}
	// Remove options
	public function removeOptions() {
		return delete_option( LIMB_Gallery::$vOptName ) && delete_option( LIMB_Gallery::$aCsOptName );
	}
	// Delete folder
	public function deleteFolder() {
	}
}