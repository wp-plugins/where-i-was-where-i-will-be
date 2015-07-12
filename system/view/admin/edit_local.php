<?php include_once(WIW_DIR_INCLUDE.'admin.php'); ?>
<?php wp_enqueue_media(); //Enqueue Media to use WP Default Media Manager ?>
<div class="wiw_wrap wrap">
	<div id="wiw_edit_local">
        <h2>
            <?php echo esc_html(get_admin_page_title()); ?>
            <a href="?page=wiw_new_local"class="add-new-h2"><?php _e('Add New Local',WIW_TRANSLATE); ?></a>
            <a href="?page=wiwwiwb"class="add-new-h2"><?php _e('Manage Locals',WIW_TRANSLATE); ?></a>
        </h2>
        <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $local = $model_info->get_local($id);
                $local = $local[0];
            } else {
                _e('Please select a Local on page <strong>Manage Locals</strong>',WIW_TRANSLATE);
                echo '</div></div>';
                return;
            }
        ?>
        <div id="edit_ajax"></div>
        <table class="wiw_table">
            <tr valign="top">
                <th scope="row" class="w200 text-left"><span class="wiw_label"><?php _e('Get Info from Google',WIW_TRANSLATE); ?>:</span></th>
                <td><input type="text" id="get_info" name="get_info" value=""  class="w100p wiw_input_text" onFocus="auto_complete('get_info',0,0);"/></td>
                <td class="w50 text-right"><input id="btn_get_info" class="button" type="button" value="<?php _e('Get',WIW_TRANSLATE);?>" onclick="show_map('','show_map', 0, 0);"/></td>
            </tr>
        </table>
        <div id="show_map"></div>
        <HR>
        <table class="wiw_table">
            <tr valign="top">
                <th scope="row" class="w200 text-left"><span class="wiw_label"><?php _e('Title',WIW_TRANSLATE); ?>:</span></th>
                <td colspan="3"><input type="text" id="title" name="title" value="<?php echo $local->title; ?>" value=""  class="w100p wiw_input_text"/></td>
            </tr>
            <tr valign="top">
                <th scope="row" class="w200 text-left"><span class="wiw_label"><?php _e('City',WIW_TRANSLATE); ?>:</span></th>
                <td colspan="3"><input type="text" id="city" name="city" value="<?php echo $local->city; ?>"  class="w100p wiw_input_text"/></td>
            </tr>
            <tr valign="top">
                <th scope="row" class="w200 text-left"><span class="wiw_label"><?php _e('Country',WIW_TRANSLATE); ?>:</span></th>
                <td><input type="text" id="country" name="country" value="<?php echo $local->country; ?>"  class="w100p wiw_input_text"/></td>
                <th scope="row" class="w200 text-left"><span class="wiw_label"><?php _e('Flag',WIW_TRANSLATE); ?> <small>(<?php _e('Use ISO3166-1 alpha-2',WIW_TRANSLATE); ?>)</small>:</span></th>
                <td><div class="w50p pull-left"><input type="text" id="flag" name="flag" value="<?php echo $local->flag; ?>" class="w100p wiw_input_text"/></div><div id="show_flag" class="w50p pull-right text-center wiw_flag"><?php echo (is_null($local->flag) || empty($local->flag))?'':'<img src="'.WIW_DIR_IMAGES.'flags/'.$local->flag.'.png"  onError="imgError(this)" class="flag_preview"> ';  ?></div></td>                
            </tr>
            <tr valign="top">
                <th scope="row" class="w200 text-left"><span class="wiw_label"><?php _e('Latitude',WIW_TRANSLATE); ?>:</span></th>
                <td><input type="text" id="latitude" name="latitude" value="<?php echo $local->latitude; ?>"  class="w100p wiw_input_text"/></td>
                <th scope="row" class="w200 text-left"><span class="wiw_label"><?php _e('Longitude',WIW_TRANSLATE); ?>:</span></th>
                <td><input type="text" id="longitude" name="longitude" value="<?php echo $local->longitude; ?>"  class="w100p wiw_input_text"/></td>                
            </tr>
            <?php
                $arrival = $departure = '';
                if ($control_util->verify_date_db($local->arrival)) {
                    $arrival = $control_util->change_date_to_show($local->arrival);
                    if ($control_util->verify_date_db($local->departure)) {
                        $departure =  $control_util->change_date_to_show($local->departure);
                    }
                }
            ?>
            <tr valign="top">
                <th scope="row" class="w200 text-left"><span class="wiw_label"><?php _e('Arrival',WIW_TRANSLATE); ?>:</span></th>
                <td><input type="text" id="arrival" name="arrival" value="<?php echo $arrival; ?>"  class="w100p wiw_input_text"/></td>
                <th scope="row" class="w200 text-left"><span class="wiw_label"><?php _e('Departure',WIW_TRANSLATE); ?>:</span></th>
                <td><input type="text" id="departure" name="departure" value="<?php echo $departure; ?>"  class="w100p wiw_input_text"/></td>                
            </tr>
            <tr valign="top">
                <th scope="row" class="w200 text-left"><span class="wiw_label"><?php _e('Url',WIW_TRANSLATE); ?>:</span></th>
                <td colspan="3"><input type="text" id="url" name="url" value="<?php echo $local->url; ?>"  class="w100p wiw_input_text"/></td>           
            </tr>
            <tr valign="top">
                <th scope="row" class="w200 text-left"><span class="wiw_label"><?php _e('Image',WIW_TRANSLATE); ?>:</span></th>
                <td colspan="2"><input type="text" id="image" name="image" value="<?php echo $local->image; ?>"  class="w100p wiw_input_text"/></td>
                <td class="text-left"><input id="upload_image" class="button" type="button" value="<?php _e('Upload Image',WIW_TRANSLATE);?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row" class="w200 text-left"><span class="wiw_label"><?php _e('Preview Image',WIW_TRANSLATE);?>:</span></th>
                <td colspan="3"><div id="image_preview" class="image_preview"><?php echo (!empty($local->image))?'<img src="'.$local->image.'" class="image_preview" onError="imgError(this)">':__('NO IMAGE',WIW_TRANSLATE); ?></div></td>
            </tr>
            <tr valign="top">
                <th scope="row" class="w200 text-left">
                    <div class="w100p"><span class="wiw_label"><?php _e('Text',WIW_TRANSLATE);?>:</span></div>
                    <div class="w100p margintop10"><?php echo $control_form->insert_replaceable_text('replaceable_text', 'replaceable_btn', $class = 'w100p', 'w100p') ; ?></div>
                    <div class="w100p margintop10"><input type="button" class="w100p button" id="load_standard_text" value="<?php _e('Load Standard Text',WIW_TRANSLATE); ?>" /></div>
                </th>
                <td colspan="3"><textarea class="wiw_textarea" name="text" id="text"><?php echo $local->text; ?></textarea></td>
            </tr>            
            <tr valign="top">
                <th scope="row" class="w200 text-left"><span class="wiw_label"><?php _e('Type',WIW_TRANSLATE); ?>:</span></th>
                <td colspan="3">
                    <?php echo $control_form->create_select_types('type','wiw_select_types',$model_info->get_all_types(),$local->type); ?>
                    
                </td>
            </tr>
            <tr valign="top">
                <td colspan="4"><p class="submit"><input type="button" name="local_edit_submit" id="local_edit_submit" class="button button-primary" value="<?php _e('Edit Local',WIW_TRANSLATE);?>"></p></td>
            </tr>
        </table>
    </div>
</div>
<div id="wiw_get_standard_text" style="display: none;"><?php echo get_option('wiw_standard_text'); ?></div>
<script>
jQuery(document).ready(function () {
    //Manage Image upload
    jQuery('#upload_image').click(function(e) {
        upload_media (e, '#image','#image_preview','image_preview');
    });
    
    //Insert Date Pick
    jQuery(function() {
        jQuery("#arrival").datepicker();
        jQuery("#departure").datepicker();
    });
    
    //Show Flag
    jQuery("#flag").change(function () {
        show_flag('show_flag', jQuery(this).val(), 'flag_preview');
    });
    
    //Submit
    jQuery("#local_edit_submit").click(function () {
        jQuery("html, body").animate({ scrollTop : 0}, "slow");
        ajax_edit_local('#edit_ajax', '<?php echo $id; ?>');
    });

    jQuery("#replaceable_btn").click(function () {
        return_replaceable_text('text', 'replaceable_text');
    });
    
    jQuery("#load_standard_text").click(function () {
        jQuery("#text").val(jQuery('#wiw_get_standard_text').html());
    });
});
</script>
