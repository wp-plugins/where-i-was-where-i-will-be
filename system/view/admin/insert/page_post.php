<?php include_once dirname(__FILE__).'/../../../include/include_admin.php'; ?>
<div id="wiwwiwb_select" style="display:none;">
    <div id="wiwwiwb_insert">
        <div class="wiw_wrap">
            <h2>
                <img src="<?php echo WIW_DIR_IMAGES; ?>icon-128x128.png" class="wiw_admin_pin" />
                <?php _e('Where I Was, Where I Wil Be',WIW_TRANSLATE); ?> <small><?php _e('Shortcode',WIW_TRANSLATE); ?></small>
            </h2>
            <div class="w100p">
                <div class="w50p pull-left">
                    <span class="wiw_label"><?php _e('Start Date',WIW_TRANSLATE); ?>:</span><br>
                    <input type="text" id="start_date" name="start_date" value=""  class="w100p wiw_input_text"/>
                </div>
                <div class="w50p pull-right">
                    <span class="wiw_label"><?php _e('End Date',WIW_TRANSLATE); ?>:</span><br>
                    <input type="text" id="end_date" name="end_date" value=""  class="w100p wiw_input_text"/>
                </div>
            </div>
            <div class="w100p">
                <span class="wiw_label"><input type="checkbox" id="only_until_today" name="only_until_today"> <?php _e('Show only until current date'); ?></span> <small> (<?php _e('if checked it will ignore the End Date',WIW_TRANSLATE); ?>!)</small>
            </div>
            <div class="w100p">
                <span class="wiw_label"><input type="checkbox" id="show_no_arrival" name="show_no_arrival"> <?php _e('Show places without arrival date'); ?></span>  <small> (<?php _e('if Start Date filled it will be ignored',WIW_TRANSLATE); ?>!)</small>
            </div>
            <div class="w100p">
                <span class="wiw_label"><input type="checkbox" id="cluster" name="cluster"> <?php _e('Cluster places?'); ?></span> <small> (<?php _e('Avoid too many markers in one place',WIW_TRANSLATE); ?>!)</small>
            </div>
            <div class="w100p">
                <span class="wiw_label"><input type="checkbox" id="use_type_text" name="use_type_text"> <?php _e('Use text from Type?'); ?></span> <small> (<?php _e('Default value is to show text from local.',WIW_TRANSLATE); ?>!)</small>
            </div>
            <span class="wiw_label wiw_show_types"><span class="wiw_show_types_icon">+</span> <?php _e('Choose Type',WIW_TRANSLATE); ?></span><br>
            <div id="wiw_show_types_div" style="display: none;">
                <table class="wiw_table">
                    <tr valign="middle" class="wiw_row_title">
                        <th class="w50 text-center"><input type="checkbox" id="all_types" name="all_type"></th>
                        <th class="w50 text-center"><?php _e('Id',WIW_TRANSLATE);?></th>
                        <th class="w50 text-center"><?php _e('Pin',WIW_TRANSLATE);?></th>
                        <th class="text-left"><?php _e('Name',WIW_TRANSLATE);?></th>
                    </tr>
                    <?php
                        $types = $model_info->get_all_types('ORDER BY name ASC');
                        $i = 0;
                        foreach ($types as $type) {
                    ?>
                    <tr valign="middle" class="wiw_row_<?php echo ($i % 2); ?>" id="wiw_main_row_<?php echo $type->id; ?>">
                        <td class="w50 text-center"><input type="checkbox" id="type<?php echo $type->id; ?>" name="cb_type" value="<?php echo $type->id; ?>"></td>
                        <td class="w50 text-center"><?php echo $type->id; ?></td>
                        <td class="w50 text-center"><img src="<?php echo $type->pin; ?>" class="wiw_admin_pin"></td>
                        <td class="text-left"><?php echo $type->name; ?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </div>
            <span class="wiw_label wiw_show_locals"><span class="wiw_show_locals_icon">+</span> <?php _e('Choose Local',WIW_TRANSLATE); ?></span><br>       

            <div id="wiw_show_locals_div" style="display: none;">
                <small><?php _e('If you choose one or more locals, the type you have had choosed will be ignored on the map',WIW_TRANSLATE); ?></small>
                <table class="wiw_table">
                    <tr valign="middle" class="wiw_row_title">
                        <th class="w50 text-center"><input type="checkbox" id="all_locals" name="all_locals"></th>
                        <th class="w50 text-center"><?php _e('Id',WIW_TRANSLATE);?></th>
                        <th class="text-left"><?php _e('City',WIW_TRANSLATE);?></th>
                        <th class="w50 text-center"><?php _e('Flag',WIW_TRANSLATE);?></th>
                        <th class="text-left"><?php _e('Country',WIW_TRANSLATE);?></th>
                    </tr>
                    <?php
                        $locals = $model_info->get_all_locals('ORDER BY city ASC');
                        $i = 0;
                        foreach ($locals as $local) {
                            $flag = (is_null($local->flag) || empty($local->flag))?'':'<img src="'.WIW_DIR_IMAGES.'flags/'.$local->flag.'.png"  onError="imgError(this)" class="flag_preview"> ';
                    ?>
                    <tr valign="middle" class="wiw_row_<?php echo ($i % 2); ?>" id="wiw_main_row_<?php echo $local->id; ?>">
                        <td class="w50 text-center"><input type="checkbox" id="type<?php echo $type->id; ?>" name="cb_local" value="<?php echo $local->id; ?>"></td>
                        <td class="w50 text-center"><?php echo $local->id; ?></td>
                        <td class="text-left"><?php echo $local->city; ?></td>
                        <td class="w50 text-center"><?php echo $flag; ?></td>
                        <td class="text-left"><?php echo $local->country; ?></td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>
            </div>
            <div class="w100p pull-left wiw_row_1">
                <div class="w50p pull-left">
                    <span class="wiw_label"><?php _e('Map Size [Width]',WIW_TRANSLATE); ?>:</span><br>
                    <input type="text" id="width" name="width" value=""  class="w100p wiw_input_text"/>
                </div>
                <div class="w50p pull-right">
                    <span class="wiw_label"><?php _e('Map Size [Height]',WIW_TRANSLATE); ?>:</span><br>
                    <input type="text" id="height" name="height" value=""  class="w100p wiw_input_text"/>
                </div>
                <div class="w100p pull-left wiw_row_0">
                <small> <span class="wiw_label"><?php _e('Use px or %.',WIW_TRANSLATE); ?></span> (<?php _e('If none used, will be considered as px.',WIW_TRANSLATE); ?>!)</small>
                </div>
            </div>
            <div class="w100p pull-left">
                <div class="w100p pull-left">
                    <span class="wiw_label"><?php _e('Show Coordinates',WIW_TRANSLATE); ?>:</span><br>
                    <input type="text" id="show_coord" name="show_coord" value=""  class="w100p wiw_input_text"/>
                </div>
                <div class="w100p pull-left wiw_row_0">
                <small> <span class="wiw_label"><?php _e('Options: "<strong>center</strong>" Same as lat 0 and lng 0. | "<strong>last</strong>" Set map on last local coordinate | "<strong>lat,lng</strong>" Choose your own coordinate (lat and lng must be numbers and separeted by a comma)',WIW_TRANSLATE); ?></span> (<?php _e('Do NOT include quote marks.',WIW_TRANSLATE); ?>!)</small>
                </div>
            </div>
            <div class="w100p wiw_row_1">
                <div class="w50p pull-left">
                    <span class="wiw_label"><?php _e('Class',WIW_TRANSLATE); ?>:</span><br>
                    <input type="text" id="class" name="class" value=""  class="w100p wiw_input_text"/>
                </div>
                <div class="w50p pull-right">
                    <span class="wiw_label"><?php _e('Map Id',WIW_TRANSLATE); ?>:</span><br>
                    <input type="text" id="map_id" name="map_id" value=""  class="w100p wiw_input_text"/>
                </div>
            </div>
            <div class="wiw_space10 pull-left"></div>
            <div class="w100p pull-left">
                <span class="wiw_label wiw_show_google"><span class="wiw_show_google_icon">+</span> <?php _e('Google Map Options',WIW_TRANSLATE); ?></span><br>
                <?php
                    $position = array('TOP_CENTER','TOP_LEFT','TOP_RIGHT','LEFT_TOP','RIGHT_TOP','LEFT_CENTER','RIGHT_CENTER','LEFT_BOTTOM','RIGHT_BOTTOM','BOTTOM_CENTER','BOTTOM_LEFT','BOTTOM_RIGHT');
                ?>
            <div id="wiw_show_google_div" style="display: none;">
                <div class="wiw_space10"></div>                 
                    <div class="w100p pull-left wiw_row_0">
                        <div class="w50p pull-left">
                            <span class="wiw_label"><?php _e('Zoom',WIW_TRANSLATE); ?>:</span><br>
                            <select id="zoom" name="zoom">
                                <option value="AUTO" selected><?php _e('AUTO',WIW_TRANSLATE); ?></options>
                                <?php for($i = 1; $i <= 20; $i++) { ?>
                                    <option value="<?php echo $i; ?>" ><?php echo $i; ?></options>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="w50p pull-right">
                            <span class="wiw_label"><input type="checkbox" id="force_zoom" name="force_zoom"> <?php _e('Force Zoom', WIW_TRANSLATE); ?></span> 
                        </div>
                        <div class="w100p pull-left wiw_row_0">
                        <small> <span class="wiw_label"><?php _e('If you set a number as a Zoom value, it will only work if the map has only one markers.',WIW_TRANSLATE); ?></span> (<?php _e('Checking Force Zoom, it will show all markers, but focused on the last one.',WIW_TRANSLATE); ?>!)</small>
                        </div>
                        <div class="wiw_space10"></div>
                    </div>
                    <div class="w100p pull-left wiw_row_1">
                        <div class="w50p pull-left">
                            <span class="wiw_label"><?php _e('Map Type',WIW_TRANSLATE); ?>:</span><br>
                            <select id="map_type" name="map_type">
                                <option value="HYBRID"><?php _e('Hybrid',WIW_TRANSLATE); ?></options>
                                <option value="ROADMAP" selected><?php _e('Road Map',WIW_TRANSLATE); ?></options>
                                <option value="SATELLITE"><?php _e('Satellite',WIW_TRANSLATE); ?></options>
                                <option value="TERRAIN"><?php _e('Terrain',WIW_TRANSLATE); ?></options>
                            </select>
                        </div>
                        <div class="w50p pull-right"></div>
                        <div class="wiw_space10"></div>
                    </div> 
                    <div class="w100p pull-left wiw_row_0">
                        <div class="w50p pull-left">
                            <span class="wiw_label"><?php _e('See All Markers Button',WIW_TRANSLATE); ?>:</span><br>
                            <select id="center_button" name="center_button">
                                <option value="DISABLED"><?php _e('Disabled',WIW_TRANSLATE); ?></options>
                                <option value="ENABLED" selected><?php _e('Enabled',WIW_TRANSLATE); ?></options>
                            </select>
                        </div>
                        <div class="w50p pull-right">
                            <span class="wiw_label"><?php _e('See All Markers Button Position',WIW_TRANSLATE); ?>:</span><br>
                            <?php echo $control_form->create_select('center_button_position','', $position,'BOTTOM_CENTER'); ?>
                        </div>
                        <div class="wiw_space10"></div>
                    </div>                
                    <div class="w100p pull-left wiw_row_1">
                        <div class="w50p pull-left">
                            <span class="wiw_label"><?php _e('Pan Control',WIW_TRANSLATE); ?>:</span><br>
                            <select id="pan_control" name="pan_control">
                                <option value="DISABLED"><?php _e('Disabled',WIW_TRANSLATE); ?></options>
                                <option value="ENABLED"><?php _e('Enabled',WIW_TRANSLATE); ?></options>
                            </select>
                        </div>
                        <div class="w50p pull-right">
                            <span class="wiw_label"><?php _e('Pan Position',WIW_TRANSLATE); ?>:</span><br>
                            <?php echo $control_form->create_select('pan_position','', $position,'TOP_LEFT'); ?>
                        </div>
                        <div class="wiw_space10"></div>
                    </div>
                    <div class="w100p pull-left wiw_row_0">
                        <div class="w50p pull-left">
                            <span class="wiw_label"><?php _e('Zoom Control',WIW_TRANSLATE); ?>:</span><br>
                            <select id="zoom_control" name="zoom_control">
                                <option value="DISABLED"><?php _e('Disabled',WIW_TRANSLATE); ?></options>
                                <option value="DEFAULT"><?php _e('Default',WIW_TRANSLATE); ?></options>
                                <option value="SMALL"><?php _e('Small',WIW_TRANSLATE); ?></options>
                                <option value="LARGE"><?php _e('Large',WIW_TRANSLATE); ?></options>
                            </select>
                        </div>
                        <div class="w50p pull-right">
                            <span class="wiw_label"><?php _e('Zoom Position',WIW_TRANSLATE); ?>:</span><br>
                            <?php echo $control_form->create_select('zoom_position','', $position,'TOP_LEFT'); ?>
                        </div>
                        <div class="wiw_space10"></div>
                    </div>                    
                    <div class="w100p pull-left wiw_row_1">
                        <div class="w50p pull-left">
                            <span class="wiw_label"><?php _e('Control Style',WIW_TRANSLATE); ?>:</span><br>
                            <select id="control_style" name="control_style">
                                <option value="DISABLED"><?php _e('Disabled',WIW_TRANSLATE); ?></options>
                                <option value="DEFAULT"><?php _e('Default',WIW_TRANSLATE); ?></options>
                                <option value="HORIZONTAL_BAR"><?php _e('Horizontal Bar',WIW_TRANSLATE); ?></options>
                                <option value="DROPDOWN_MENU"><?php _e('Dropdown Menu',WIW_TRANSLATE); ?></options>
                            </select>
                        </div>
                        <div class="w50p pull-right">
                            <span class="wiw_label"><?php _e('Control Position',WIW_TRANSLATE); ?>:</span><br>
                            <?php echo $control_form->create_select('control_position','', $position,'TOP_RIGHT'); ?>
                        </div>
                        <div class="wiw_space10"></div>
                    </div>
                    <div class="w100p pull-left wiw_row_0">
                        <div class="w50p pull-left">
                            <span class="wiw_label"><?php _e('Scale Control',WIW_TRANSLATE); ?>:</span><br>
                            <select id="scale_control" name="scale_control">
                                <option value="DISABLED"><?php _e('Disabled',WIW_TRANSLATE); ?></options>
                                <option value="ENABLED"><?php _e('Enabled',WIW_TRANSLATE); ?></options>
                            </select>
                        </div>
                        <div class="w50p pull-right"><span class="wiw_label"><?php _e('Scale Position',WIW_TRANSLATE); ?>:</span><BR><span class="wiw_label"><small><?php _e('Fixed to BOTTOM_RIGHT',WIW_TRANSLATE); ?></small></span></div>
                        <div class="wiw_space10"></div>
                    </div>
                    <div class="w100p pull-left wiw_row_1">
                        <div class="w50p pull-left">
                            <span class="wiw_label"><?php _e('Street View Control',WIW_TRANSLATE); ?>:</span><br>
                            <select id="streetview_control" name="streetview_control">
                                <option value="DISABLED"><?php _e('Disabled',WIW_TRANSLATE); ?></options>
                                <option value="ENABLED"><?php _e('Enabled',WIW_TRANSLATE); ?></options>
                            </select>
                        </div>
                        <div class="w50p pull-right">
                            <span class="wiw_label"><?php _e('Street View Position',WIW_TRANSLATE); ?>:</span><br>
                            <?php echo $control_form->create_select('streetview_position','', $position,'TOP_LEFT'); ?>
                        </div>
                        <div class="wiw_space10"></div>
                    </div>
                    <div class="w100p pull-left wiw_row_2">
                        <div class="w100p pull-left">
                            <span class="wiw_label"><input type="checkbox" id="scroll" name="scroll" checked> <?php _e('Wheel Scroll'); ?></span> <small> (<?php _e('If not set, when user scroll on map it will move entire page',WIW_TRANSLATE); ?>!)</small>
                        </div>
                        <div class="wiw_space10"></div>
                    </div>
                    
                    
                    
                </div>
            </div>
            <div class="wiw_space20"></div>
            <div class="pull-left w100p">
                <input type="hidden" id="local" name="local" value="" class="w100p wiw_input_text"/>
                <input type="hidden" id="type" name="type" value="" class="w100p wiw_input_text"/>
                <input type="button" class="button-primary pull-right" value="<?php _e("Insert Shortcode", WIW_TRANSLATE); ?>" onclick="wiw_insert_form();" />
                <a class="button pull-left" href="#" onclick="wiw_close_form(); return false;"><?php _e("Cancel", WIW_TRANSLATE); ?></a>

            </div>
            <div class="wiw_space20"></div>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function () {
    //Insert Date Pick
    jQuery(function() {
        jQuery("#start_date").datepicker();
        jQuery("#end_date").datepicker();
    });
    
    //Show Types
    jQuery(".wiw_show_types").click(function () {
        var status = jQuery(".wiw_show_types_icon").html();
        
        if (status == '-') {
            jQuery("#wiw_show_types_div").fadeOut('slow');
            jQuery(".wiw_show_types_icon").html('+');
        } else {
            jQuery("#wiw_show_types_div").fadeIn('fast');
            jQuery(".wiw_show_types_icon").html('-');
        }
    });
    
    //Check / uncheck all Types
    var status_type = false;
    jQuery("#all_types").click(function () {
        status_type = (status_type)?false:true;
        var text = '';
        jQuery('input[name="cb_type"]').each(function(){
            this.checked = status_type;
            if (status_type == true) {
                if (text.length == 0) text = jQuery(this).val();
                else text += ',' + jQuery(this).val();
            }
        });
        jQuery('#type').val(text);
    });
    
    //Get checkeds Type
    jQuery('input[name="cb_type"]').click(function () {
        var text = '';
        jQuery('input[name="cb_type"]').each(function(){
            if (this.checked == true) {
                if (text.length == 0) text = jQuery(this).val();
                else text += ',' + jQuery(this).val();
            }
        });
        jQuery('#type').val(text);
    });
    
    //Show Types
    jQuery(".wiw_show_locals").click(function () {
        var status = jQuery(".wiw_show_locals_icon").html();
        
        if (status == '-') {
            jQuery("#wiw_show_locals_div").fadeOut('slow');
            jQuery(".wiw_show_locals_icon").html('+');
        } else {
            jQuery("#wiw_show_locals_div").fadeIn('fast');
            jQuery(".wiw_show_locals_icon").html('-');
        }
    });    
    
    //Check / uncheck all Locals
    var status_local = false;
    jQuery("#all_locals").click(function () {
        status_local = (status_local)?false:true;
        var text = '';
        jQuery('input[name="cb_local"]').each(function(){
            this.checked = status_local;
            if (status_local == true) {
                if (text.length == 0) text = jQuery(this).val();
                else text += ',' + jQuery(this).val();
            }
        });
        jQuery('#local').val(text);
    });
    
    //Get checkeds Local
    jQuery('input[name="cb_local"]').click(function () {
        var text = '';
        jQuery('input[name="cb_local"]').each(function(){
            if (this.checked == true) {
                if (text.length == 0) text = jQuery(this).val();
                else text += ',' + jQuery(this).val();
            }
        });
        jQuery('#local').val(text);
    });
    
    
    //Show Google Map Options
    jQuery(".wiw_show_google").click(function () {
        var status = jQuery(".wiw_show_google_icon").html();
        
        if (status == '-') {
            jQuery("#wiw_show_google_div").fadeOut('slow');
            jQuery(".wiw_show_google_icon").html('+');
        } else {
            jQuery("#wiw_show_google_div").fadeIn('fast');
            jQuery(".wiw_show_google_icon").html('-');
        }
    });       
});
    
</script>