<?php
class WIWWIWB_User {
    public $control_shortcode;
    function __construct() {
        include_once (WIW_DIR_CONTROL.'shortcode.php');
        $this->control_shortcode = new WIWWIWB_Shortcode();
        
        //add the [wiwwiwb] shortcode support
        $this->createShortcode('wiwwiwb','wiw_show_map');
    }

    //Declare Shortcodes
    function createShortcode($name, $function) {
        add_shortcode($name, array($this->control_shortcode,$function));     
    }   
}
?>