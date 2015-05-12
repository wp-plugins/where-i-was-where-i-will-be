<?php
/*
Plugin Name: Where I Was, Where I Will Be
Plugin URI: http://wordpress.org/plugins/where-i-was-where-i-will-be/
Description: A Plugin that use Google Maps to show where you was and where you will be! Seriously! :)
Author: Mauro Baptista
Version: 1.0.5
Author URI: http://carnou.com/
License: GPL2

Flags: https://github.com/hjnilsson/country-flags
Marker Clusterer Library: https://github.com/googlemaps/js-marker-clusterer
*/
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}
if (!defined('ABSPATH')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	die();
}

define('WIW_DIR_IMAGES',   plugins_url('assets/images/', __FILE__));
define('WIW_DIR_CSS',      plugins_url('assets/css/', __FILE__));
define('WIW_DIR_JS',       plugins_url('assets/js/', __FILE__));
define('WIW_AJAX_VIEW_ADMIN',plugins_url('system/view/admin/ajax/', __FILE__));
include_once (dirname(__FILE__).'/system/config.php');

function wiw_styles() {
    //Register Basic Style Sheet
    wp_register_style('wiw_basic_style', WIW_DIR_CSS.'style.css');
    wp_enqueue_style('wiw_basic_style');
    
    //Register Style only used in Admin
    if (is_admin()) {
        wp_register_style('wiw_datepicker_style', WIW_DIR_CSS.'jquery-ui.min.css');
        wp_enqueue_style('wiw_datepicker_style');
    }
}

function wiw_scripts() {
    //Register Basic Scripts
    wp_register_script('wiw_basic_script', WIW_DIR_JS.'script.js');
    wp_enqueue_script('wiw_basic_script');
    
    //Register Map Scripts
    wp_register_script( 'wiw_map_script', WIW_DIR_JS.'map.js',array('jquery-ui-datepicker'));
    wp_enqueue_script('wiw_map_script'); 

    //Register Google Maps Api
    if (get_option('wiw_load_google_api') !== 'on') {
        wp_register_script( 'wiw_google_script','https://maps.googleapis.com/maps/api/js?key='.get_option('wiw_google_api').'&sensor=false&language='.get_option('WPLANG').'&libraries=places,geometry,drawing'); //Google API
        wp_enqueue_script('wiw_google_script');
    }    
    
    //Register Ajax (Only for Admin)
    if (is_admin()) {
        wp_register_script( 'wiw_ajax_script',WIW_DIR_JS.'call_ajax.js'); //Google API
        wp_enqueue_script('wiw_ajax_script');
        wp_localize_script('wiw_ajax_script', 'wiw_vars', array(
                                                        'wiw_nonce' => wp_create_nonce('wiw_nonce'),
                                                        'wiw_dir_images' => WIW_DIR_IMAGES,
                                                        'wiw_choose_image' => __('Choose Image', WIW_TRANSLATE),
                                                        'wiw_loading' => __('Loading', WIW_TRANSLATE),
                                                        'wiw_google_maps_error' => __('Geocode was not successful for the following reason',WIW_TRANSLATE)
                                                        ));
    } else {
		//Register Marker Clusterer (Only for User)
		wp_register_script( 'wiw_cluster_script',WIW_DIR_JS.'markerclusterer.min.js'); //Marker Clusterer (for Google API)
		wp_enqueue_script('wiw_cluster_script');
	}
}

//Includes
if (is_admin()) {
    //Add Scripts and Styles to Admin View
    add_action ('admin_enqueue_scripts', 'wiw_styles');
    add_action ('admin_enqueue_scripts', 'wiw_scripts');
    
    // Call Admin Functions and Screens
	include_once (WIW_DIR_CONTROL.'admin.php');
    $wiwwiwb_admin = new WIWWIWB_Admin();

    //Activate and Deactivate Plugin
    register_activation_hook(__FILE__, array($wiwwiwb_admin,'wiw_activate'));
    register_deactivation_hook(__FILE__, array($wiwwiwb_admin,'wiw_deactivate'));
    
} else {
    //Add Scripts and Styles to User View
    add_action ('wp_enqueue_scripts', 'wiw_styles');
    add_action ('wp_enqueue_scripts', 'wiw_scripts');
    
	// Call User Functions and Screens
	include_once (WIW_DIR_CONTROL.'user.php');
    $wiwwiwb_user = new WIWWIWB_User();
}
?>