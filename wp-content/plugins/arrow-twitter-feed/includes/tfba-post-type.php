<?php

add_action( 'init', 'tfba_subscribe_form_function' );
add_action('admin_menu', 'tfba_custom_menu_pages');
add_action('admin_menu', 'tfba_custom_plugins_pages');
add_action('admin_menu', 'tfba_rate_us_pages');

function tfba_subscribe_form_function() {
    $labels = array(
        'name'               => _x( 'Twitter Feeds', 'post type general name' ),
        'singular_name'      => _x( 'Twitter Feed', 'post type singular name' ),
        'menu_name'          => _x( 'Arrow Twitter Feed', 'admin menu' ),
        'name_admin_bar'     => _x( 'Twitter Feed', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', 'Form' ),
        'add_new_item'       => __( 'Add New Twitter Feed' ),
        'new_item'           => __( 'New Twitter Feed' ),
        'edit_item'          => __( 'Edit Twitter Feed' ),
        'view_item'          => __( 'View Twitter Feed' ),
        'all_items'          => __( 'All Twitter Feeds' ),
        'search_items'       => __( 'Search Twitter Feeds' ),
        'parent_item_colon'  => __( 'Parent Twitter Feeds:' ),
        'not_found'          => __( 'No Feed Forms found.' ),
        'not_found_in_trash' => __( 'No Feed Forms found in Trash.' )
        );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Add responsive twitter feed into your post, page & widgets' ),
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'rewrite'            => array( 'slug' => 'arrow_twitter_feed' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'menu_icon'		 => 'dashicons-twitter',
        'supports'           => array( 'title' , 'custom_fields')
        );

    register_post_type( 'tfba_twitter_feed', $args );
}


function tfba_rate_us_pages() {

add_submenu_page(
    'edit.php?post_type=tfba_twitter_feed',
    'Rate us',
    'Rate us',
    'manage_options',
    'tfba_rate_us_plugins',
    'tfba_rate_us_page' );

}


function tfba_rate_us_page(){
    include_once( 'tfba-rate-us.php' );
}


function tfba_custom_plugins_pages() {

add_submenu_page(
    'edit.php?post_type=tfba_twitter_feed',
    'Our Plugins',
    'Our Plugins',
    'manage_options',
    'tfba_our_plugins',
    'tfba_plugins_page' );

}


function tfba_plugins_page(){
    include_once( 'tfba-our-plugins.php' );
}



function tfba_custom_menu_pages() {

add_submenu_page(
    'edit.php?post_type=tfba_twitter_feed',
    'Support',
    'Support',
    'manage_options',
    'tfba_form_support',
    'tfba_support_page' );

}


function tfba_support_page(){
    include_once( 'tfba-support-page.php' );
}

function tfba_settings_after_title() {

    $scr = get_current_screen();
    
    if( $scr-> post_type !== 'tfba_twitter_feed' )
        return;

    include_once( 'tfba-settings-page.php' );
}

add_action( 'edit_form_after_title', 'tfba_settings_after_title' );
/*function admin_redirects() {
    global $pagenow;

    if($pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'tfba_twitter_feed' ){
        if (isset($_GET['access_token'])) {
            
        wp_redirect(admin_url('/edit.php?post_type=tfba_twitter_feed&page=tfba_settings&access_token='.$_GET["access_token"], 'http'));
        exit;
    }
}
}

add_action('admin_init', 'admin_redirects');
*/
/*    if (isset($_GET['access_token'])) {
$url = urlencode(admin_url('edit.php?post_type=tfba_twitter_feed&page=tfba_settings&access_token').$_GET["access_token"]) ;
wp_redirect( $url ); exit;
}
*/

add_action('load-post-new.php', 'tfba_limit_cpt' );

function tfba_limit_cpt()
{
global $typenow;

if( 'tfba_twitter_feed' !== $typenow )
return;

$total = get_posts( array( 
'post_type' => 'tfba_twitter_feed', 
'numberposts' => -1, 
'post_status' => 'publish,future,draft' 
));

if( $total && count( $total ) >= 3 )
wp_die(
'<p style="text-align:center;font-weight:bold;">Sorry, Creation of maximum number of Twitter Feeds reached, Please <a href="https://www.arrowplugins.com/twitter-feed" target="_blank">Buy Premium Version</a> to create more Twitter Feeds With Awesome Features</p>', 
'Maximum reached',  
array( 
'response' => 500, 
'back_link' => true 
)
);  
}