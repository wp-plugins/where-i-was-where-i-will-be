<?php
    require_once (dirname(__FILE__).'/../config.php');
    
    global $wpdb;
    if (!defined('WIW_TABLE_PREFIX')) define('WIW_TABLE_PREFIX', $wpdb->prefix.'wiw_');
    
    //Call Classes
    include_once (WIW_DIR_CONTROL.'util.php');
    $control_util = new WIWWIWB_Util();
    
    include_once (WIW_DIR_MODEL.'admin.php');
    $model_admin = new WIWWIWB_Model_Admin();
    
    include_once (WIW_DIR_MODEL.'info.php');
    $model_info = new WIWWIWB_Model_Info();

    include_once (WIW_DIR_CONTROL.'form.php');
    $control_form = new WIWWIWB_Form();
    
    include_once (WIW_DIR_CONTROL.'manage.php');
    $control_manage = new WIWWIWB_Manage();
    

?>