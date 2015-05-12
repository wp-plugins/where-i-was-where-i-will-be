<?php
class WIWWIWB_Model_Info {

    public $db;
    function __construct() {
        global $wpdb;
        $this->db = $wpdb; 
    }
    
/**
*
*    TYPE MANAGE SCRIPTS
*
*/    
    function get_all_types($complement = '') {
        return $this->db->get_results( 'SELECT * FROM '.WIW_TABLE_PREFIX.'type '.$complement, OBJECT );
    }
    
    function get_type($type_id, $complement = '') {
        return $this->db->get_results( 'SELECT * FROM '.WIW_TABLE_PREFIX.'type WHERE id = "'.$type_id.'" '.$complement, OBJECT);
    }
    
    function check_if_type_exist($type_id) {
        $query = $this->db->query( 'SELECT id FROM '.WIW_TABLE_PREFIX.'type WHERE id = "'.$type_id.'"', OBJECT );
        return $query;
    }
    
/**
*
*    END TYPE MANAGE SCRIPTS
*
*/

/**
*
*    LOCAL MANAGE SCRIPTS
*
*/

    function get_all_locals($complement = '') {
        return $this->db->get_results( 'SELECT * FROM '.WIW_TABLE_PREFIX.'locals '.$complement, OBJECT );
    }
    
    function get_local($local_id,$complement = '') {
        return $this->db->get_results( 'SELECT * FROM '.WIW_TABLE_PREFIX.'locals WHERE id = "'.$local_id.'" '.$complement, OBJECT);
    }
    
/**
*
*    END LOCAL MANAGE SCRIPTS
*
*/

}
?>