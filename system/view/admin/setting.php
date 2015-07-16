<?php include_once(WIW_DIR_INCLUDE.'admin.php'); ?>
<div class="wiw_wrap wrap">
	<?php settings_errors(); ?>
	<div id="wiw_settings">
        <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
        <form method="post" action="options.php">
            <?php settings_fields('wiw_settings');?>
            <?php do_settings_sections('wiw_settings');?>
            <table class="wiw_table">
                <tr valign="top">
                    <th scope="row" class="w200 text-left"><span class="wiw_label"><?php _e('Google API',WIW_TRANSLATE); ?>:</span></th>
                    <td colspan="3"><input type="text" name="wiw_google_api" value="<?php echo get_option('wiw_google_api'); ?>"  class="w100p wiw_input_text"/></td>
                </tr>
                <tr valign="top">
                    <th scope="row" class="w200 text-left"><span class="wiw_label"><?php _e('Standard Type',WIW_TRANSLATE); ?>:</span></th>
                    <td colspan="3">
                        <?php echo $control_form->create_select_types('wiw_standard_type','wiw_select_types',$model_info->get_all_types(),get_option('wiw_standard_type')); ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row" class="w200 text-left">
                        <div class="w100p"><span class="wiw_label"><?php _e('Standard Text',WIW_TRANSLATE); ?>:</span></div>
                        <div class="w100p margintop10"><?php echo $control_form->insert_replaceable_text('replaceable_text', 'replaceable_btn', $class = 'w100p', 'w100p') ; ?></div>
                    </th>
                    <td colspan="3">
                        <textarea name='wiw_standard_text'  id='wiw_standard_text' class="wiw_textarea"><?php echo get_option('wiw_standard_text'); ?></textarea>
                    </td>
                </tr>
            </table>
            <div class="w100p pull-left">
                <span class="wiw_label wiw_advanced"><span class="wiw_advanced_icon">+</span> <?php _e('Advanced Options',WIW_TRANSLATE); ?></span><br>
                <div id="wiw_advanced_div"class="w100p pull-left" style="display:none;">
                    <table class="wiw_table">
                        <?php (get_option('wiw_load_google_api'))?$checked='checked':$checked=''; ?>
                        <tr valign="top">
                            <td colspan="4">
                                <input type="checkbox" name="wiw_load_google_api" <?php echo $checked; ?>> <?php _e('DO NOT load Google Api from this plugin!', WIW_TRANSLATE) ; ?> <small>(<?php _e('Only mark it if you know what you are doing!', WIW_TRANSLATE);?>)</small>
                            </td>
                        </tr>
                        <?php (get_option('wiw_drop_table'))?$checked='checked':$checked=''; ?>
                        <tr valign="top">
                            <td colspan="4">
                                <input type="checkbox" name="wiw_drop_table" <?php echo $checked; ?>> <?php _e('Delete Locals and Types when deactivate WIWWIWB plugin!', WIW_TRANSLATE) ; ?> <small>(<?php _e('It will also reset all settings!', WIW_TRANSLATE) ; ?>)</small>
                            </td>
                        </tr>                
                    </table>
                </div>
            </div>
			<div class="w100p pull-left">
				<div class="wiw_fail"><?php _e('',WIW_TRANSLATE); ?>
				<?php _e('If you have any issue or idea to improve this plugin, please contact me',WIW_TRANSLATE); ?>:<BR>
				<?php _e('E-mail',WIW_TRANSLATE); ?>: <a href="mailto:wiwwiwb@carnou.com" target="_blank">wiwwiwb@carnou.com</a> <?php _e('or',WIW_TRANSLATE); ?> <?php _e('WP Forum',WIW_TRANSLATE); ?>: <a href="https://wordpress.org/support/plugin/where-i-was-where-i-will-be" target="_blank">https://wordpress.org/support/plugin/where-i-was-where-i-will-be</a> (<?php _e('better',WIW_TRANSLATE); ?>)<BR>
<BR>
<?php _e('Also, if you could rate this plugin, I\'d appreciate',WIW_TRANSLATE); ?>: <a href="https://wordpress.org/support/view/plugin-reviews/where-i-was-where-i-will-be">https://wordpress.org/support/view/plugin-reviews/where-i-was-where-i-will-be</a>
				</div>
			</div>
            <div class="wiw_space20"></div>
            <div class="wiw_space20"></div>
            <?php submit_button(); ?>
        </form>
    </div>
</div>
<script>
    jQuery("#replaceable_btn").click(function () {
        return_replaceable_text('wiw_standard_text', 'replaceable_text');
    });
    
    //Show Google Map Options
    jQuery(".wiw_advanced").click(function () {
        var status = jQuery(".wiw_advanced_icon").html();
        
        if (status == '-') {
            jQuery("#wiw_advanced_div").fadeOut('slow');
            jQuery(".wiw_advanced_icon").html('+');
        } else {
            jQuery("#wiw_advanced_div").fadeIn('fast');
            jQuery(".wiw_advanced_icon").html('-');
        }
    }); 
    
</script>