<?php
class WIWWIWB_Ajax {

    public $model_info;
    public $control_manage;
    public $control_util;
    public $control_form;
	function __construct() {
        global $wpdb;
        if (!defined('WIW_TABLE_PREFIX')) define('WIW_TABLE_PREFIX', $wpdb->prefix.'wiw_');
    
        include_once (WIW_DIR_MODEL.'info.php');
        $this->model_info = new WIWWIWB_Model_Info();
        
        include_once (WIW_DIR_CONTROL.'manage.php');
        $this->control_manage = new WIWWIWB_Manage();
        
        include_once (WIW_DIR_CONTROL.'util.php');
        $this->control_util = new WIWWIWB_Util();
		
		include_once (WIW_DIR_CONTROL.'form.php');
        $this->control_form = new WIWWIWB_Form();
    }
    
    function wiw_result_show_types () {
    
        if (!isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'wiw_nonce')) die('Permissions check failed!');
    ?>
		<div id="wiw_get_standard_text" style="display: none;"><?php echo get_option('wiw_standard_text'); ?></div>
        <table class="wiw_table">
            <tr valign="middle" class="wiw_row_title">
                <th class="w50 text-center"><?php _e('Id',WIW_TRANSLATE);?></th>
                <th class="text-left"><?php _e('Name',WIW_TRANSLATE);?></th>
                <th class="w100 text-center"><?php _e('Pin',WIW_TRANSLATE);?></th>
                <th class="w200 text-center"><?php _e('Action',WIW_TRANSLATE);?></th>
            </tr>
            <?php
                $all_types = $this->model_info->get_all_types();
                $i = 0;
                foreach ($all_types as $type) {
                    if ($type->id != 1) {
                        $i++;
            ?>
                        <tr valign="middle" class="wiw_row_<?php echo ($i % 2); ?>" id="wiw_main_row_<?php echo $type->id; ?>">
                            <td class="text-center" ><?php echo $type->id; ?></td>
                            <td class="text-left">
                                <div id="wiw_type_name<?php echo $type->id; ?>"><?php echo $type->name; ?></div>
                                <input type="hidden" id="wiw_type_name_hidden<?php echo $type->id; ?>" value="<?php echo $type->name; ?>">
								<div id="wiw_type_text<?php echo $type->id; ?>" style="display: none;" class="w100p">
									<table class="form-table">
										<tr valign="top">
											<th scope="row" class="w200 text-left">
												<div class="w100p"><span class="wiw_label"><?php _e('Text',WIW_TRANSLATE);?>:</span></div>
												<div class="w100p margintop10"><?php echo $this->control_form->insert_replaceable_text('replaceable_text'.$type->id, $type->id, 'w100p', 'w100p replaceable_btn') ; ?></div>
												<div class="w100p margintop10"><input type="button" class="w100p button load_standard_text" id="<?php echo $type->id; ?>" value="<?php _e('Load Standard Text',WIW_TRANSLATE); ?>" /></div>
											</th>
											<td colspan="3"><textarea class="wiw_textarea" name="type_text<?php echo $type->id; ?>" id="type_text<?php echo $type->id; ?>"><?php echo $type->text; ?></textarea></td>
										</tr>
									</table>
								</div>
                            </td>
                            <td class="text-center">
                                <div id="type_pin_preview<?php echo $type->id; ?>" class="type_pin_preview text-center w100p">
                                    <img src="<?php echo $type->pin; ?>" class="wiw_admin_pin">
                                </div>
                                <input id="<?php echo $type->id; ?>" name="type_custom_pin<?php echo $type->id; ?>" class="button custom_pin" type="button" value="<?php _e('Upload Custom Pin',WIW_TRANSLATE);?>" style="display:none;" />
                                <input type="hidden" id="type_pin<?php echo $type->id; ?>" name="type_pin" value="<?php echo $type->pin; ?>"/>
                                <input type="hidden" id="wiw_type_pin_hidden<?php echo $type->id; ?>" value="<?php echo $type->pin; ?>">
                            </td>
                            <td class="text-center" id="wiw_type_action<?php echo $type->id; ?>">
                                <div id="action<?php echo $type->id; ?>">
                                    <input id="<?php echo $type->id; ?>" class="button wiw_btn_edit" type="button" value="<?php _e('Edit',WIW_TRANSLATE);?>" />
                                    <input id="<?php echo $type->id; ?>" class="button wiw_btn_delete" type="button" value="<?php _e('Delete',WIW_TRANSLATE);?>" />
                                </div>
                                <div id="action_edit<?php echo $type->id; ?>" style="display: none;">
                                    <?php _e('Action',WIW_TRANSLATE);?>: <?php _e('Edit',WIW_TRANSLATE);?><BR>
                                    <input id="<?php echo $type->id; ?>" class="button wiw_btn_edit_confirm" type="button" value="<?php _e('Confirm',WIW_TRANSLATE);?>" />
                                    <input id="<?php echo $type->id; ?>" class="button wiw_btn_edit_cancel" type="button" value="<?php _e('Cancel',WIW_TRANSLATE);?>" />
                                </div>
                                <div id="action_delete<?php echo $type->id; ?>" style="display: none;">
                                    <?php _e('Action',WIW_TRANSLATE);?>: <?php _e('Delete',WIW_TRANSLATE);?><BR>
                                    <input id="<?php echo $type->id; ?>" class="button wiw_btn_delete_confirm" type="button" value="<?php _e('Confirm',WIW_TRANSLATE);?>" />
                                    <input id="<?php echo $type->id; ?>" class="button wiw_btn_delete_cancel" type="button" value="<?php _e('Cancel',WIW_TRANSLATE);?>" />
                                </div>
                            </td>
                        </tr>
                        <tr id="wiw_row_ajax_<?php echo ($type->id); ?>"  class="wiw_row_<?php echo ($i % 2); ?>" style="display: none;" >
                            <td colspan="4" ><div id="show_ajax<?php echo ($type->id); ?>"></div></td>
                        </tr>
            <?php
                    }
                }
            ?>
        </table>
        <script>
        //Edit
            //Manage Pin upload
            jQuery('.wiw_btn_edit').click(function() {
                var id = jQuery(this).attr('id');
                btn_edit_type(id);
            });
            //Cancel Edit
            jQuery('.wiw_btn_edit_cancel').click (function () {
                var id = jQuery(this).attr('id');
                btn_edit_cancel_type(id);
            });
            //Manage Pin upload
            jQuery('.custom_pin').click(function(e) {
                var id = jQuery(this).attr('id');
                upload_media (e, '#type_pin'+id,'#type_pin_preview'+id,'type_pin_preview');
            });
        //Delete
            jQuery('.wiw_btn_delete').click(function() {
                var id = jQuery(this).attr('id');
                btn_delete_type(id);
            });
            //Cancel Delete
            jQuery('.wiw_btn_delete_cancel').click (function () {
                var id = jQuery(this).attr('id');
                btn_delete_cancel_type(id);
            });
            //Confirm Edit
            jQuery('.wiw_btn_edit_confirm').click (function () {
                var id = jQuery(this).attr('id');
                ajax_edit_type('#show_ajax' + id, id);
            });
            //Confirm Delete
            jQuery('.wiw_btn_delete_confirm').click (function () {
                var id = jQuery(this).attr('id');
                ajax_delete_type('#show_ajax' + id, id);
            });
			jQuery(".replaceable_btn").click(function () {
				var id = jQuery(this).attr('id');
				return_replaceable_text('type_text' + id, 'replaceable_text' + id);
			});
			
			jQuery(".load_standard_text").click(function () {
				var id = jQuery(this).attr('id');
				jQuery('#type_text' + id).val(jQuery('#wiw_get_standard_text').html());
			});
        </script>        
    <?php
        die();
    }
    
    function wiw_action($action, $div, $msg) {

        if ($action === false) {
    ?>
                <div id="<?php echo $div; ?>" class="wiw_success"><?php echo $msg; ?>!</div>
                
    <?php
        } else {
    ?>
        <div id="<?php echo $div; ?>" class="wiw_fail"><?php echo $action; ?></div> 
    <?php
        }
    ?>
        <script>
                jQuery("#<?php echo $div; ?>").delay(3000).fadeOut(500);
        </script>
    <?php    
    }

    function wiw_result_add_type () {
        if (!isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'wiw_nonce')) die('Permissions check failed!');
        $insert = $this->control_manage->add_type($_POST);
        $this->wiw_action($insert, 'div_add', __('Type successfully included!', WIW_TRANSLATE));
        die();
    }
    
    function wiw_result_edit_type () {
        if (!isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'wiw_nonce')) die('Permissions check failed!');
        $edit = $this->control_manage->edit_type($_POST);
        $this->wiw_action($edit, 'div_edit', __('Type successfully changed!', WIW_TRANSLATE));
        die();
    }
    
    function wiw_result_delete_type () {
        if (!isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'wiw_nonce')) die('Permissions check failed!');
        $delete = $this->control_manage->delete_type($_POST['id']);
        $this->wiw_action($delete, 'div_delete', __('Type successfully deleted!', WIW_TRANSLATE));
        die();
    }
    
    function wiw_result_more_info_local () {
        $local = $this->model_info->get_local($_POST['id']);
        $local = $local[0];
        
        if (!empty($local->image)) {
            $image = '<img src="'.$local->image.'" class="image_preview" onError="imgError(this)">';
        } else {
            $image = __('NO IMAGE',WIW_TRANSLATE);
        }
        
        $arrival = $departure = '';
        if ($this->control_util->verify_date_db($local->arrival)) {
            $arrival = __('Arrival',WIW_TRANSLATE).': '.$this->control_util->change_date_to_show($local->arrival);
            if ($this->control_util->verify_date_db($local->departure)) {
                $departure =  __('Departure',WIW_TRANSLATE).': '.$this->control_util->change_date_to_show($local->departure);
            }
        }
        
        if (!empty($local->text)) {
            $text = __('Text',WIW_TRANSLATE).': '.$local->text;
        }  
    ?>
        <div class="w100p">
            <table class="wiw_table">
                <tr>
                    <td rowspan="3" class="w200 text-center"><?php echo $image; ?></td>
                    <td class="text-left"><?php _e('Latitude',WIW_TRANSLATE); ?>: <?php echo $local->latitude; ?></td>
                    <td class="text-left"><?php _e('Longitude',WIW_TRANSLATE); ?>: <?php echo $local->longitude; ?></td>
                </tr>
                <?php if (!empty($arrival)) { ?>
                    <tr>
                        <td class="text-left"><?php echo $arrival; ?></td>
                        <td class="text-left"><?php echo $departure; ?></td>
                    </tr>
                <?php } ?>
                <?php if (!empty($text)) { ?>
                <tr>
                    <td colspan="2" class="text-left"><?php echo $text; ?></td>
                </tr>
                <?php } ?>
                </table>
        </div>
    <?php
        die();
    }
    
    function wiw_result_add_local() {
        if (!isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'wiw_nonce')) die('Permissions check failed!');
        $add = $this->control_manage->add_local($_POST);
        $this->wiw_action($add, 'div_add', __('Local successfully included!', WIW_TRANSLATE));
        die();
    }
    
    function wiw_result_edit_local() {
        if (!isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'wiw_nonce')) die('Permissions check failed!');
        $edit = $this->control_manage->edit_local($_POST);
        $this->wiw_action($edit, 'div_edit', __('Local successfully  changed!', WIW_TRANSLATE));
        die();
    }
    
    function wiw_result_delete_local() {
        if (!isset($_POST['nonce']) && !wp_verify_nonce($_POST['nonce'], 'wiw_nonce')) die('Permissions check failed!');
        $delete = $this->control_manage->delete_local($_POST['id']);
        $this->wiw_action($delete, 'div_delete', __('Local successfully  deleted!', WIW_TRANSLATE));
        die();
    }       
}
?>