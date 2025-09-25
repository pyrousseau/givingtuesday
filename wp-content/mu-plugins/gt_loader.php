<?php
/**
 * Plugin Name: GT Loader (MU)
 */
$path = WPMU_PLUGIN_DIR . 'gt_slider.php'; // <= mets ici ton vrai chemin
if ( file_exists($path) ) {
  require_once $path;
}
