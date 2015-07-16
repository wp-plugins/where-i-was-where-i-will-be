/**
 * @package Where I Was, Where I Will Be
 * @version 1.0
 */

/**
*
*    TYPE MANAGE SCRIPTS
*
*/

//Delete Type


//Add Type
function ajax_show_types(div) {
    loadingDiv(div, wiw_vars.wiw_dir_images);
    data = {
        action: 'wiw_show_types',
        nonce: wiw_vars.wiw_nonce
    };
    
    jQuery.post(ajaxurl, data, function (response) {
        jQuery(div).html(response);
    });
    
    return false;
}

//Add Type
function ajax_add_type(div) {
    loadingDiv(div, wiw_vars.wiw_dir_images);
    data = {
        action: 'wiw_add_type',
        nonce: wiw_vars.wiw_nonce,
        type_name: jQuery("#type_new_name").val(),
        type_text: jQuery("#type_new_text").val(),
        type_pin: jQuery("#type_new_pin").val()
    }
    jQuery.post(ajaxurl, data, function (response) {
        new_name = jQuery("#type_new_name").val();
        new_pin = jQuery("#type_new_pin").val();
        if (new_name.length > 3 && new_pin.length > 3) {
            ajax_show_types('#show_types_ajax');
            jQuery("#type_new_name").val('');
            jQuery("#type_new_text").val('');
        }
        jQuery(div).html(response);
    });
    return false;
}

function ajax_edit_type(div, id) {
    loadingDiv(div, wiw_vars.wiw_dir_images);
    jQuery("#wiw_row_ajax_"+ id).css("display","table-row");
    data = {
        action: 'wiw_edit_type',
        nonce: wiw_vars.wiw_nonce,
        type_id: id,
        type_name: jQuery("#type_name" + id).val(),
        type_text: jQuery("#type_text" + id).val(),
        type_pin: jQuery("#type_pin" + id).val()
    };
    
    jQuery.post(ajaxurl, data, function (response) {
        jQuery(div).html(response);
        var new_name = jQuery("#type_name" + id).val();
        var new_pin = jQuery("#type_pin" + id).val();
        var old_name = jQuery("#wiw_type_name_hidden"+id).val();
        var old_pin = jQuery("#wiw_type_pin_hidden"+id).val();
        if (new_name.length > 3 && new_pin.length > 3) {
            name = new_name;
            pin = new_pin;
            jQuery("#action" + id).css('display','block');
            jQuery("#action_edit" + id).css('display','none');
            jQuery("input[name='type_custom_pin" + id + "']").css('display','none');
            jQuery("#type_pin_preview" + id).html('<img src="' + pin + '" class="wiw_admin_pin">');
            jQuery("#wiw_type_name_hidden"+id).val(name);
            jQuery("#wiw_type_pin_hidden"+id).val(pin);
            jQuery("#wiw_type_name" + id).html(name);
        } else {
            name = old_name;
            pin = old_pin;
        }
        jQuery("#wiw_type_name_hidden"+id).val(name);
        jQuery("#wiw_type_pin_hidden"+id).val(pin);
        
        jQuery("#wiw_row_ajax_" + id).delay(3000).fadeOut(500);
    });	
}


function ajax_delete_type(div, id) {
    loadingDiv(div, wiw_vars.wiw_dir_images);
    jQuery("#wiw_row_ajax_"+ id).css("display","table-row");
    data = {
        action: 'wiw_delete_type',
        nonce: wiw_vars.wiw_nonce,
        id: id
    };
    jQuery.post(ajaxurl, data, function (response) {
        jQuery("#wiw_main_row_"+id).delay(1000).fadeOut(500);
        jQuery("#wiw_row_ajax_" + id).delay(2000).fadeOut(500);
        jQuery(div).html(response);
    });	
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

//Local More Info
function ajax_more_info_local(div, id) {
    loadingDiv(div, wiw_vars.wiw_dir_images);
    jQuery("#wiw_row_ajax_"+ id).css("display","table-row");
    data = {
        action: 'wiw_more_info_local',
        nonce: wiw_vars.wiw_nonce,
        id: id
    }
    jQuery.post(ajaxurl, data, function (response) {
        jQuery(div).html(response);
    });	
}

//Add Local
function ajax_add_local(div) {
    loadingDiv(div, wiw_vars.wiw_dir_images);
    data = {
        action: 'wiw_add_local',
        nonce: wiw_vars.wiw_nonce,
        local_city: jQuery("#city").val(),
        local_title: jQuery("#title").val(),
        local_country: jQuery("#country").val(),
        local_flag: jQuery("#flag").val(),
        local_latitude: jQuery("#latitude").val(),
        local_longitude: jQuery("#longitude").val(),
        local_url: jQuery("#url").val(),
        local_image: jQuery("#image").val(),
        local_text: jQuery("#text").val(),
        local_type: jQuery("#type").val(),
        local_arrival: jQuery("#arrival").val(),
        local_departure: jQuery("#departure").val()
        }
    jQuery.post(ajaxurl, data, function (response) {
        jQuery(div).html(response);
    });	
}

//Edit Local
function ajax_edit_local(div, id) {
    loadingDiv(div, wiw_vars.wiw_dir_images);
    data = {
        action: 'wiw_edit_local',
        nonce: wiw_vars.wiw_nonce,
        local_id: id,
        local_city: jQuery("#city").val(),
        local_title: jQuery("#title").val(),
        local_country: jQuery("#country").val(),
        local_flag: jQuery("#flag").val(),
        local_latitude: jQuery("#latitude").val(),
        local_longitude: jQuery("#longitude").val(),
        local_url: jQuery("#url").val(),
        local_image: jQuery("#image").val(),
        local_text: jQuery("#text").val(),
        local_type: jQuery("#type").val(),
        local_arrival: jQuery("#arrival").val(),
        local_departure: jQuery("#departure").val()
        }
    jQuery.post(ajaxurl, data, function (response) {
        jQuery(div).html(response);
    });		
}

//Delete Type
function ajax_delete_local(div, id) {
    loadingDiv(div, wiw_vars.wiw_dir_images);
    jQuery("#wiw_row_ajax_"+ id).css("display","table-row");
    data = {
        action: 'wiw_delete_local',
        nonce: wiw_vars.wiw_nonce,
        id: id
        }
    jQuery.post(ajaxurl, data, function (response) {
        jQuery("#wiw_main_row_"+id).delay(1000).fadeOut(500);
        jQuery("#wiw_row_ajax_" + id).delay(2000).fadeOut(500);
        jQuery(div).html(response);
    });	
}

/**
*
*    END LOCAL MANAGE SCRIPTS
*
*/
