<?php
    require_once (dirname(__FILE__).'/../config.php');

    if (isset($_POST['WIW_HEADER'])) {require_once($_POST['WIW_HEADER'].'/wp-blog-header.php' );}
    
    global $wpdb;
    if (!defined('WIW_TABLE_PREFIX')) define('WIW_TABLE_PREFIX', $wpdb->prefix.'wiw_');
    
    //Call Classes
    include_once (WIW_DIR_CONTROL.'util.php');
    $control_util = new WIWWIWB_Util();
    
    include_once (WIW_DIR_MODEL.'info.php');
    $model_info = new WIWWIWB_Model_Info();
    
    include_once (WIW_DIR_CONTROL.'shortcode.php');
    $control_shortcode = new WIWWIWB_Shortcode();

?>