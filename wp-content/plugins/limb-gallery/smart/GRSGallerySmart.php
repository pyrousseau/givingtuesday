<?php
/**
 * The Gallery RS
 * Grs Gallery Smart
 * 1.0.0
 */

class GRSGallerySmart {

	/**
	 * Class constructor
	 *
	 * @param   string  $task
	 */
	public function __construct( $task = 'grs' ) {
		if ( method_exists( $this, $task ) ) {
			$this->{$task}();
		}
	}

	// Activate
	public function activate() {
		$this->checkVersion();
		$this->activateDeactivatePlan();
	}

	/**
	 * Checks activated plan (free or pro) and activates the opposite
	 */
	private function activateDeactivatePlan() {
		// Here we need to create unique
		// Deactivate other active version
		$plugin_base_name              = LIMB_Gallery::$pluginBaseName;
		$plugin_dir_path               = LIMB_Gallery::$pluginDir;
		$free_plugin_base_name         = strpos( $plugin_base_name, '-paid' ) === false ? $plugin_base_name : str_replace( basename( $plugin_dir_path ) . '-paid', basename( $plugin_dir_path ), $plugin_base_name );
		$premium_plugin_base_name      = strpos( $plugin_base_name, '-paid' ) !== false ? $plugin_base_name : str_replace( basename( $plugin_dir_path ), basename( $plugin_dir_path ) . '-paid', $plugin_base_name );
		$is_premium_version_activation = current_filter() !== 'activate_' . $free_plugin_base_name;
		// This logic is relevant only to plugins since both the free and premium versions of a plugin can be active at the same time.
		// 1. If running in the activation of the FREE module, get the basename of the PREMIUM.
		// 2. If running in the activation of the PREMIUM module, get the basename of the FREE.
		$other_version_basename = ( $is_premium_version_activation ? $free_plugin_base_name : $premium_plugin_base_name );
		/**
		 * If the other module version is active, deactivate it.
		 *
		 * is_plugin_active() checks if the plugin is active on the site or the network level and
		 * deactivate_plugins() deactivates the plugin whether it's activated on the site or network level.
		 *
		 */
		if ( is_plugin_active( $other_version_basename ) ) {
			deactivate_plugins( $other_version_basename );
		}
	}

	/**
	 * Fast update check fastUpdateCheck
	 */
	public function fastUpdateCheck() {
		$existVersion = get_option( LIMB_Gallery::$vOptName, false );
		if ( $existVersion ) {
			if ( version_compare( LIMB_Gallery::$currentVersion, $existVersion ) == 1 ) {
				if ( $this->doUpdates() ) {
					$this->storeStatus( 'success', __( 'Successfully update', 'limb-gallery' ) );
					LIMB_Gallery::$version = LIMB_Gallery::$currentVersion;
				} else {
					$this->storeStatus( 'error', __( 'Problems with update', 'limb-gallery' ) );
				}
			}
		}
	}

	/**
	 * Templates check
	 */
	public function templatesCheck() {
		if ( empty( glob( GRS_PLG_DIR . "/css/grsTemplate[0-9].css" ) ) ) {
			require_once( GRS_PLG_DIR . '/database/GRSGalleryInsert.php' );
			$obj = new GRSGalleryInsert();
			$obj->generateThemesCss_3_1();
		}
	}

	// Uninstall
	public function uninstall() {
		require_once( GRS_PLG_DIR . '/database/GRSGalleryUninstall.php' );
		$obj    = new GRSGalleryUninstall();
		$result = $obj->uninstall();
		if ( $result !== false ) {
			$this->storeStatus( 'error', __( 'Plugin uninstalled', 'limb-gallery' ) );
		}

		return $result;
	}

	/**
	 * Check plugin version
	 */
	public function checkVersion() {
		/*
		  * Get current version,
		  * get exists version,
		  * compare versions,
		  * check for tables, check for updates, check for inserts.
		*/
		$existVersion = get_option( LIMB_Gallery::$vOptName, false );
		if ( $existVersion ) {
			switch ( version_compare( LIMB_Gallery::$currentVersion, $existVersion ) ) {
				case - 1:
					$this->storeStatus( 'error', __( 'Trying to update old version, Please uninstall current then install your version', 'limb-gallery' ) );
					break;
				case 0: // do nothing
					if ( $this->checkTables() ) {
						if ( $this->insertData() ) {
							$this->storeStatus( 'success', __( 'Successfully activate', 'limb-gallery' ) );
						} else {
							$this->storeStatus( 'error', __( 'Some rows dropped and can\'t be inserted', 'limb-gallery' ) );
						}
					} else {
						$this->storeStatus( 'error', __( 'Some tables dropped, or can\'t be created', 'limb-gallery' ) );
					}
					break;
				case 1:
					if ( $this->checkTables() ) {
						if ( $this->doUpdates() ) {
							$this->storeStatus( 'success', __( 'Successfully update', 'limb-gallery' ) );
						} else {
							$this->storeStatus( 'error', __( 'Problems with update', 'limb-gallery' ) );
						}
					} else {
						$this->storeStatus( 'error', __( 'Some tables not exists and can\'t created', 'limb-gallery' ) );
					}
					break;
				default:
					$this->storeStatus( 'error', __( 'Unknown version', 'limb-gallery' ) );
					break;
			}
		} else {
			// First time so lets set activation status option, insert data 
			if ( $this->checkTables() ) {
				if ( $this->insertData() ) {
					$add = add_option( LIMB_Gallery::$vOptName, LIMB_Gallery::$currentVersion );
					$this->storeStatus( 'success', __( 'Plugin successfully activate', 'limb-gallery' ) );
				} else {
					$this->storeStatus( 'error', __( 'Data has not been inserted', 'limb-gallery' ) );
				}
			} else {
				$this->storeStatus( 'error', __( 'Some tables have not been created', 'limb-gallery' ) );
			}
		}
	}

	// Do updates
	public function doUpdates() {
		require_once( GRS_PLG_DIR . '/database/GRSGalleryUpdate.php' );
		$obj = new GRSGalleryUpdate();

		return $obj->update();
	}

	// CHeck tables
	public function checkTables() {
		global $wpdb;
		$ok    = true;
		$query = "SELECT COUNT(*) as `grsTc` 
			      FROM `information_schema`.`tables`
				  WHERE
				  `TABLE_SCHEMA` = '" . DB_NAME . "' AND 
				  `TABLE_NAME` IN ('" . $wpdb->prefix . "limb_gallery_galleries',
								   '" . $wpdb->prefix . "limb_gallery_galleriescontent', 
								   '" . $wpdb->prefix . "limb_gallery_albums',
								   '" . $wpdb->prefix . "limb_gallery_albumscontent',
								   '" . $wpdb->prefix . "limb_gallery_comments',
								   '" . $wpdb->prefix . "limb_gallery_settings',
								   '" . $wpdb->prefix . "limb_gallery_themes')";
		$c     = $wpdb->get_var( $query );
		if ( $c < 7 ) {
			require_once( GRS_PLG_DIR . '/database/GRSGalleryCreate.php' );
			$obj = new GRSGalleryCreate();
			$ok  = $obj->create();
		}

		return $ok;
	}

	// Insert data
	public function insertData() {
		require_once( GRS_PLG_DIR . '/database/GRSGalleryInsert.php' );
		$obj = new GRSGalleryInsert();

		return $obj->insert();
	}

	// Message
	public function storeStatus( $mood, $message, $saveInDb = false ) {
		$statusObj          = new stdClass();
		$statusObj->date    = date( 'Y-m-d-H:i:s', time() );
		$statusObj->mood    = $mood;
		$statusObj->content = $message;
		if ( get_option( LIMB_Gallery::$aCsOptName ) ) {
			update_option( LIMB_Gallery::$aCsOptName, json_encode( $statusObj ) );
		} else {
			add_option( LIMB_Gallery::$aCsOptName, json_encode( $statusObj ) );
		}
	}
}