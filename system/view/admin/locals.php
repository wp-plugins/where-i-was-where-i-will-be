<?php include_once(WIW_DIR_INCLUDE.'admin.php'); ?>
<div class="wiw_wrap wrap">
	<div id="wiw_new_local">
        <h2>
            <?php echo esc_html(get_admin_page_title()); ?>
            <a href="?page=wiw_new_local"class="add-new-h2"><?php _e('Add New Local',WIW_TRANSLATE); ?></a>
        </h2>
        <table class="wiw_table">
            <tr valign="middle" class="wiw_row_title">
                <th class="w50 text-center"><?php _e('Id',WIW_TRANSLATE); ?></th>
				<th class="text-left"><?php _e('Title',WIW_TRANSLATE); ?></th>
                <th class="text-left"><?php _e('City',WIW_TRANSLATE); ?></th>
                <th class="text-left"><?php _e('Country',WIW_TRANSLATE); ?></th>
                <th class="w200 text-left"><?php _e('Type',WIW_TRANSLATE); ?></th>
                <th class="w200 text-center"><?php _e('Url',WIW_TRANSLATE); ?></th>
                <th class="w200 text-center"><?php _e('Action',WIW_TRANSLATE); ?></th>
            </tr>
            <?php
                $all_locals = $model_info->get_all_locals('ORDER BY country ASC, city ASC, title ASC ');
                $i = 0;
                foreach ($all_locals as $local) {
                    $i++;
                    
                    $country = (is_null($local->flag) || empty($local->flag))?$local->country:'<img src="'.WIW_DIR_IMAGES.'flags/'.$local->flag.'.png"  onError="imgError(this)" class="flag_preview"> '.$local->country;
                    $type = $model_info->get_type($local->type);
                    $url = (is_null($local->url) || empty($local->url))?'':'<a href="'.$local->url.'" target="_blank"><input class="button wiw_btn_more" type="button" value="'. __('See',WIW_TRANSLATE).'"></a>';
            ?>
                <tr valign="middle" class="wiw_row_<?php echo ($i % 2); ?>" id="wiw_main_row_<?php echo $local->id; ?>">
                    <td class="w50 text-center"><?php echo $local->id; ?></td>
					<td class="text-left"><?php echo $local->title; ?></td>
                    <td class="text-left"><?php echo $local->city; ?></td>
                    <td class="text-left"><?php echo $country; ?></td>
                    <td class="w200 text-left"><img src="<?php echo $type[0]->pin; ?>" class="wiw_admin_pin"> <?php echo $type[0]->name; ?></td>
                    <td class="w200 text-center"><?php echo $url; ?></td>
                    <td class="w200 text-center">
                        <div id="action<?php echo $local->id; ?>">
                            <input id="<?php echo $local->id; ?>" class="button wiw_btn_more" type="button" value="<?php _e('More Info',WIW_TRANSLATE);?>" />
                            <a href="?page=wiw_edit_local&id=<?php echo $local->id; ?>"><input id="<?php echo $local->id; ?>" class="button wiw_btn_edit" type="button" value="<?php _e('Edit',WIW_TRANSLATE);?>" /></a>
                            <input id="<?php echo $local->id; ?>" class="button wiw_btn_delete" type="button" value="<?php _e('Delete',WIW_TRANSLATE);?>" />
                        </div>
                        
                        <div id="action_delete<?php echo $local->id; ?>" style="display: none;">
                            <?php _e('Action',WIW_TRANSLATE);?>: <?php _e('Delete',WIW_TRANSLATE);?><BR>
                            <input id="<?php echo $local->id; ?>" class="button wiw_btn_delete_confirm" type="button" value="<?php _e('Confirm',WIW_TRANSLATE);?>" />
                            <input id="<?php echo $local->id; ?>" class="button wiw_btn_delete_cancel" type="button" value="<?php _e('Cancel',WIW_TRANSLATE);?>" />
                        </div>                    </td>
                </tr>
                <tr id="wiw_row_ajax_<?php echo ($local->id); ?>"  class="wiw_row_ajax wiw_row_<?php echo ($i % 2); ?>" style="display: none;" >
                    <td colspan="6" ><div id="show_ajax<?php echo ($local->id); ?>"></div></td>
                </tr>
            <?php
                }
            ?>
        </table>
    </div>
</div>
<script>
    //Show More Info
    jQuery('.wiw_btn_more').click(function() {
        var id = jQuery(this).attr('id');
        jQuery('.wiw_row_ajax').css('display','none');
        ajax_more_info_local('#show_ajax' + id, id);
    });
    
    //Delete
    jQuery('.wiw_btn_delete').click(function() {
        var id = jQuery(this).attr('id');
        btn_delete_local(id);
    });
    
    //Confirm Edit
    jQuery('.wiw_btn_delete_confirm').click (function () {
        var id = jQuery(this).attr('id');
        ajax_delete_local('#show_ajax' + id, id);
    });
    
    //Cancel Edit
    jQuery('.wiw_btn_delete_cancel').click (function () {
        var id = jQuery(this).attr('id');
        btn_delete_cancel_local(id);
    });    
</script>