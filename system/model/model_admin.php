<?php
class WIWWIWB_Model_Admin {

    public $db;
    public $control_util;
    function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        
        include_once (WIW_DIR_CONTROL.'util.php');
        $this->control_util = new WIWWIWB_Util(); 
    }
    
/**
*
*    TYPE MANAGE SCRIPTS
*
*/    
    
    function check_if_type_exist($type_id) {
        $query = $this->db->query( 'SELECT id FROM '.WIW_TABLE_PREFIX.'type WHERE id = "'.$type_id.'"', OBJECT );
        return $query;
    }
    
    function add_type($info) {
        return $this->db->query('INSERT INTO '.WIW_TABLE_PREFIX.'type (id,name,pin,text) 
                                VALUES (NULL,"'.$info['type_name'].'","'.$info['type_pin'].'","'.$info['type_text'].'")');
    }
    
    function edit_type($info) {
        if ($info['type_id'] != 1) {  //Don't allow to change the first row
            return $this->db->query('UPDATE '.WIW_TABLE_PREFIX.'type SET name = "'.$info['type_name'].'",pin = "'.$info['type_pin'].'",text = "'.$info['type_text'].'" WHERE id = "'.$info['type_id'].'"');
        } else return false;
    }
    
    function delete_type($id) {
    
        if ($id != 1) { //Don't allow to change the first row
            //Check if deleted type is equal Standard Type
            if ($id == get_option('wiw_standard_type')) {
                $standard_type = 1; //If yes, define Standard Type as 1
                update_option('wiw_standard_type', $standard_type); //Update Option
            } else {$standard_type = get_option('wiw_standard_type');}
            
            $this->db->query('UPDATE '.WIW_TABLE_PREFIX.'locals SET type = "'.$standard_type.'"
                                WHERE type = "'.$id.'"');
            return $delete = $this->db->delete(WIW_TABLE_PREFIX.'type', array('id' => $id));
        } else return false;
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
    function add_local($info) {
        $arrival = (is_null($info['local_arrival']))?NULL:$this->control_util->change_date_to_db($info['local_arrival']);
        $departure = (is_null($info['local_departure']))?NULL:$this->control_util->change_date_to_db($info['local_departure']);  
    
        $query = $this->db->query('INSERT INTO '.WIW_TABLE_PREFIX.'locals (id, title, city, country, flag, latitude, longitude, url, image, text, type, arrival, departure) VALUES (NULL,"'.$info['local_title'].'","'.$info['local_city'].'","'.$info['local_country'].'","'.$info['local_flag'].'","'.$info['local_latitude'].'","'.$info['local_longitude'].'","'.$info['local_url'].'","'.$info['local_image'].'","'.$info['local_text'].'","'.$info['local_type'].'","'.$arrival.'","'.$departure.'");');
        
        return $query;
    }
    
    function edit_local($info) {
        $arrival = (is_null($info['local_arrival']))?NULL:$this->control_util->change_date_to_db($info['local_arrival']);
        $departure = (is_null($info['local_departure']))?NULL:$this->control_util->change_date_to_db($info['local_departure']);  
        return $this->db->query('UPDATE '.WIW_TABLE_PREFIX.'locals SET city = "'.$info['local_city'].'",
                                                                        title = "'.$info['local_title'].'",
                                                                        country = "'.$info['local_country'].'",
                                                                        flag = "'.$info['local_flag'].'",
                                                                        latitude = "'.$info['local_latitude'].'",
                                                                        longitude = "'.$info['local_longitude'].'",
                                                                        url = "'.$info['local_url'].'",
                                                                        image = "'.$info['local_image'].'",
                                                                        text = "'.$info['local_text'].'",
                                                                        type = "'.$info['local_type'].'",
                                                                        arrival = "'.$arrival.'",
                                                                        departure = "'.$departure.'"
                                WHERE id = "'.$info['local_id'].'"');
    }    
    
    function delete_local($id) {
        return $delete = $this->db->delete(WIW_TABLE_PREFIX.'locals', array('id' => $id));
    }    
    
    
/**
*
*    END LOCAL MANAGE SCRIPTS
*
*/

}
?>