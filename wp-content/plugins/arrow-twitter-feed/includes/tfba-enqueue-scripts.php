<?php
add_action( 'wp_enqueue_scripts', 'tfba_enqueue_styles', 10);
add_action( 'admin_enqueue_scripts', 'tfba_admin_enqueue_styles', 10);

function tfba_enqueue_styles() {
	
		wp_enqueue_script('jquery');
		
		wp_register_script( 'tfba_jquery', plugin_dir_url( __FILE__ ) . '../bower_components/jquery/dist/jquery.min.js', array( 'jquery' ) );
		wp_register_script( 'tfba_codebird', plugin_dir_url( __FILE__ ) . '../bower_components/codebird-js/codebird.js', array( 'jquery' ) );
		wp_register_script( 'tfba_doT', plugin_dir_url( __FILE__ ) . '../bower_components/doT/doT.min.js', array( 'jquery' ) );
		wp_register_script( 'tfba_moment', plugin_dir_url( __FILE__ ) . '../bower_components/moment/min/moment.min.js', array( 'jquery' ) );
		wp_register_script( 'tfba_socialfeed', plugin_dir_url( __FILE__ ) . '../js/jquery.socialfeed.js', array( 'jquery' ) );
		wp_register_style( 'tfba_socialfeed_style', plugin_dir_url( __FILE__ )  . '../css/jquery.socialfeed.css', false, '1.0.0' );

		wp_enqueue_style( 'tfba_jquery');
		wp_enqueue_style( 'tfba_socialfeed_style');
		wp_enqueue_style( 'tfba_fontawesome_style');
   		wp_enqueue_script( 'tfba_codebird');
   		wp_enqueue_script( 'tfba_doT');
   		wp_enqueue_script( 'tfba_moment');
   		wp_enqueue_script( 'tfba_socialfeed');

}


function tfba_admin_enqueue_styles() {
	
		wp_enqueue_script('jquery');
		wp_register_script( 'tfba_script', plugin_dir_url( __FILE__ ) . '../js/tfba-script.js', array( 'jquery' ) );
		wp_enqueue_script( 'tfba_script');
		wp_enqueue_style( 'wp-color-picker' );
    	wp_enqueue_script( 'wp-color-picker-script',  plugin_dir_url(__FILE__) .'../js/colorpicker.js', array( 'wp-color-picker' ), false, true );
		
}