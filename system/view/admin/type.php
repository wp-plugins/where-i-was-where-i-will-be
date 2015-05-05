<?php wp_enqueue_media(); //Enqueue Media to use WP Default Media Manager ?>
<div class="wiw_wrap wrap">
	<div id="wiw_new_type">
        <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
        <div id="show_types_ajax"></div>
	</div>
    <HR>
	<div id="wiw_new_type">
        <h2><?php _e('Add New Type'); ?></h2>
        <div id="show_ajax_add"></div>
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><span class="wiw_label"><?php _e('Name',WIW_TRANSLATE);?>:</span></th>
                <td colspan="3"><input id="type_new_name" name="type_new_name" value="" class="w100p wiw_input_text"/></td>
            </tr>
            <tr valign="top">
                <th scope="row"><span class="wiw_label"><?php _e('Choose Pin',WIW_TRANSLATE);?>:</span></th>
                <td colspan="3">
                <?php
                    $pins = array('blue-dot', 'green-dot', 'ltblue-dot', 'orange-dot', 'purple-dot', 'red-dot', 'yellow-dot');
                    
                    foreach ($pins as $pin) {
                ?>
                    <div style="width:auto; float:left;">
                        <img src="<?php echo WIW_DIR_IMAGES.'pin/'.$pin; ?>.png" id="<?php echo $pin; ?>" class="standard-pin"/>
                    </div>
                <?php  
                    }
                ?>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><span class="wiw_label"><?php _e('Pin',WIW_TRANSLATE);?>:</span></th>
                <td colspan="3"><input  id="type_new_pin" name="type_new_pin" value="" class="w100p wiw_input_text"/> </td>
            </tr>
            <tr valign="top">
                <th scope="row"><span class="wiw_label"><?php _e('Custom Pin',WIW_TRANSLATE);?>:</span></th>
                <td><input id="type_new_custom_pin" class="button" type="button" value="<?php _e('Upload Custom Pin',WIW_TRANSLATE);?>" /></td>
                <td colspan="2"><div id="type_new_pin_preview" class="type_new_pin_preview"></div></td>
            </tr>
            <tr valign="top">
                <td colspan="4">
                    <?php _e('Where download pin?', WIW_TRANSLATE); ?>
                    <ul>
                        <li><a href="https://sites.google.com/site/gmapsdevelopment/" target="_blank">GMaps Development</a></li>
                        <li><a href="http://mapicons.nicolasmollet.com/" target="_blank">Map Icons Collection</a></li>
                    </ul>
                </td>
            </tr>
            
            
            
            <tr valign="top">
                <td colspan="4"><p class="submit"><input type="button" name="type_new_submit" id="type_new_submit" class="button button-primary" value="<?php _e('Insert New Pin',WIW_TRANSLATE);?>"></p></td>
            </tr>
        </table>
	</div>
</div>
<script>
jQuery(document).ready(function () {

//Show Types
    ajax_show_types('#show_types_ajax');

//Add
    //Manage Pin upload
    jQuery('#type_new_custom_pin').click(function(e) {
        upload_media (e, '#type_new_pin','#type_new_pin_preview','type_new_pin_preview');
    });
    
    //Add Type	
    jQuery("#type_new_submit").click(function () {
        ajax_add_type('#show_ajax_add');
    });
    
    jQuery('.standard-pin').click(function () {
        var pin = jQuery(this).attr('id');
        jQuery('#type_new_pin').val('<?php echo WIW_DIR_IMAGES.'pin/'; ?>' + pin + '.png');
    });
});
</script>