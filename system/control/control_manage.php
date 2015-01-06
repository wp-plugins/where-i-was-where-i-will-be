<?php
class WIWWIWB_Manage {
    
    public $model_admin;
    public $control_util;
	function __construct() {
        include_once (WIW_DIR_MODEL.'admin.php');
        $this->model_admin = new WIWWIWB_Model_Admin();
        include_once (WIW_DIR_CONTROL.'util.php');
        $this->control_util = new WIWWIWB_Util(); 
    }
    
/**
*
*    TYPE MANAGE SCRIPTS
*
*/
    
    function check_type_info($info) {
		$erro = '';
		
		if (strlen($info['type_name']) <= 3) $erro .= sprintf(__('[%s] must have more than 3 character',WIW_TRANSLATE).'<BR>',__('Name',WIW_TRANSLATE));
		if (strlen($info['type_pin']) <= 3) $erro .= sprintf(__('[%s] must have more than 3 character',WIW_TRANSLATE).'<BR>',__('Pin',WIW_TRANSLATE));
		if (empty($erro)) {return false;}
		else {return $erro;}
    }
	
	function add_type($info) {
        $check = $this->check_type_info($info);
        
        if ($check === false) {
            $insert = $this->model_admin->add_type($info);
            if ($insert) return false;
            else $check = __('Error saving new Type!',WIW_TRANSLATE);
            return false;
        } else {return $check;}
	}
    
	function edit_type($info) {
        $check = $this->check_type_info($info);
        
        if ($check === false) {
            $edit = $this->model_admin->edit_type($info);
            if ($edit) return false;
            else $check = __('Error editing Type!',WIW_TRANSLATE);
            return false;
        } else {return $check;}
	}
    
	function delete_type($id) {
        $delete = $this->model_admin->delete_type($id);
        if ($delete) return false;
        else $check = __('Error deleting Type!',WIW_TRANSLATE);
        return false;
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

    function check_local_info($info) {
		$erro = '';
        
        if (empty($info['local_country'])) $erro .= sprintf(__('[%s] is required',WIW_TRANSLATE).'<BR>',__('Country',WIW_TRANSLATE));
		if (!empty($info['local_flag']))
            if (strlen($info['local_flag']) != 2)
                $erro .= sprintf(__('[%s] must be 2 characters',WIW_TRANSLATE).'<BR>',__('Flag'));
        if (!is_numeric($info['local_latitude'])) $erro .= sprintf(__('[%s] must be a number',WIW_TRANSLATE).'<BR>',__('Latitude',WIW_TRANSLATE));
        if (!is_numeric($info['local_longitude'])) $erro .= sprintf(__('[%s] must be a number',WIW_TRANSLATE).'<BR>',__('Longitude',WIW_TRANSLATE));
        if (!empty($info['local_arrival'])) {
            if (!$this->control_util->verify_date($info['local_arrival']))
                $erro .= sprintf(__('[%s] must be a valid date',WIW_TRANSLATE).'<BR>',__('Arrival',WIW_TRANSLATE));
        }
        if (!empty($info['local_departure'])) {
            if (!$this->control_util->verify_date($info['local_departure']))
                $erro .= sprintf(__('[%s] must be a valid date',WIW_TRANSLATE).'<BR>',__('Departure',WIW_TRANSLATE));
            if (empty($info['local_arrival'])) $erro .= sprintf(__('[%s] must be set',WIW_TRANSLATE).'<BR>',__('Arrival',WIW_TRANSLATE));
        }
        
        
        if (!$this->model_admin->check_if_type_exist($info['local_type'])) $erro .= sprintf(__('[%s] invalid',WIW_TRANSLATE).'<BR>',__('Type',WIW_TRANSLATE));
        
        if (empty($erro)) {return false;}
		else {return $erro;}
    }
	
	function add_local($info) {
        $check = $this->check_local_info($info);
        
        if ($check === false) {
            $insert = $this->model_admin->add_local($info);
            if ($insert) return false;
            else $check = __('Error saving new Local!',WIW_TRANSLATE);
            return false;
        } else {return $check;}
	}
    
	function edit_local($info) {
        $check = $this->check_local_info($info);
        
        if ($check === false) {
            $edit = $this->model_admin->edit_local($info);
            if ($edit) return false;
            else $check = __('Error editing Local!',WIW_TRANSLATE);
            return false;
        } else {return $check;}
	}    
    
	function delete_local($id) {
        $delete = $this->model_admin->delete_local($id);
        if ($delete) return false;
        else $check = __('Error deleting Local!',WIW_TRANSLATE);
        return false;
	}    

/**
*
*    END LOCAL MANAGE SCRIPTS
*
*/


}
?>