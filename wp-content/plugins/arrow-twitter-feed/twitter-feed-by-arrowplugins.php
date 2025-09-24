<?php 
/*
Plugin Name: Arrow Custom Feed for Twitter 
Plugin URI: https://wordpress.org/plugins/arrow-twitter-feed
Description: Add Responsive Twitter Feed into your Posts, Pages & Widgets
Author: Arrow Plugins
Author URI: https://www.arrowplugins.com/twitter-feed
Version: 1.5.3
License: GplV2
Copyright: 2019 Arrow Plugins
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define( 'TFBA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );


include_once('includes/tfba-post-type.php');
include_once('includes/tfba-custom-columns.php');


include_once('includes/tfba-post-meta-boxes.php');
include_once('includes/tfba-save-post.php');


include_once('includes/tfba-shortcode.php');
include_once('includes/tfba-enqueue-scripts.php');



add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'tfba_plugin_action_links' );

function tfba_plugin_action_links( $links ) {
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'edit.php?post_type=tfba_twitter_feed') ) .'">Dashboard</a>';
   $links[] = '<a href="'. esc_url( get_admin_url(null, 'edit.php?post_type=tfba_twitter_feed&page=tfba_form_support') ) .'">Support</a>';
   return $links;
}