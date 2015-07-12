/**
 * @package Where I Was, Where I Will Be
 * @version 1.0
 */

/**
 *
 * JS Scripts
 *
 */
//Upload Fleet pic from Wordpress Media
function upload_media (e, media, img, img_class) {
    var custom_uploader;

    e.preventDefault();
    
    //If the uploader object has already been created, reopen the dialog
    if (custom_uploader) {
            custom_uploader.open();
            return;
    }
    
    //Extend the wp.media object
    custom_uploader = wp.media.frames.file_frame = wp.media({
            title: wiw_vars.wiw_choose_image,
            button: {
                    text: wiw_vars.wiw_choose_image
            },
            multiple: false
    });
    
    //When a file is selected, grab the URL and set it as the text field's value
    custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery(media).val(attachment.url);
            jQuery(img).html('<img src="' + attachment.url + '" class="' + img_class + '" />');
    });
    
    //Open the uploader dialog
    custom_uploader.open();
}

//Insert a Loading gif
function loadingDiv(div, img) {
    jQuery(div).html('<div class="w100p"><strong><img src="' + img + 'ajax-loader.gif" /> ' + wiw_vars.wiw_loading + '...</strong></div>');
}


//Replace Flag if img doesn't exist
function imgError(image) {
    image.onerror = "";
    image.src = wiw_vars.wiw_dir_images+"flags/none.png";
    return true;
}

//Find Location on TextArea (Used in Edit/New Local)
(function ($, undefined) {
    $.fn.getCursorPosition = function () {
        var el = $(this).get(0);
        var pos = 0;
        if ('selectionStart' in el) {
            pos = el.selectionStart;
        } else if ('selection' in document) {
            el.focus();
            var Sel = document.selection.createRange();
            var SelLength = document.selection.createRange().text.length;
            Sel.moveStart('character', -el.value.length);
            pos = Sel.text.length - SelLength;
        }
        return pos;
    }
})(jQuery);


function return_replaceable_text(wiw_textarea, wiw_select) {
    var position = jQuery("#"+wiw_textarea).getCursorPosition()
    var content = jQuery("#"+wiw_textarea).val();
    
    var text_to_add = jQuery("#"+wiw_select).val();
    
    if (text_to_add == '%image%') text_to_add = '<img src="' + text_to_add + '" />';
    else if (text_to_add == '%url%') text_to_add = '<a href="' + text_to_add + '">Link</a>';
    
    var newContent = content.substr(0, position) + text_to_add + content.substr(position);
    
    jQuery("#"+wiw_textarea).val(newContent);
}


/**
*
*    TYPE MANAGE SCRIPTS
*
*/

//Edit Type
function btn_edit_type(id) {
    var old_name = jQuery("#wiw_type_name_hidden"+id).val();
    var name = '<input id="type_name' + id + '" name="type_name' + id + '" value="' + old_name + '" class="w100p wiw_input_text"/>';
    jQuery("#wiw_type_name" + id).html(name);
    jQuery("input[name='type_custom_pin" + id + "']").css('display','block');
    jQuery("input[name='type_text" + id + "']").css('display','block');
    jQuery("#wiw_type_text" + id).css('display','block');
    jQuery("#action" + id).css('display','none');
    jQuery("#action_delete" + id).css('display','none');
    jQuery("#action_edit" + id).css('display','block');
}

function btn_edit_cancel_type(id) {
    var old_name = jQuery("#wiw_type_name_hidden"+id).val();
    var old_pin = jQuery("#wiw_type_pin_hidden"+id).val();
    jQuery("#wiw_type_name" + id).html(old_name);
    jQuery("#type_pin_preview" + id).html('<img src="' + old_pin + '" class="wiw_admin_pin">');
    jQuery("#action" + id).css('display','block');
    jQuery("#wiw_type_text" + id).css('display','none');
    jQuery("#action_edit" + id).css('display','none');
    jQuery("#action_delete" + id).css('display','none');
    jQuery("input[name='type_custom_pin" + id + "']").css('display','none');
}


function btn_delete_type(id) {
    jQuery("#action" + id).css('display','none');
    jQuery("#action_delete" + id).css('display','block');
    jQuery("#action_edit" + id).css('display','none');
}

function btn_delete_cancel_type(id) {
    jQuery("#action" + id).css('display','block');
    jQuery("#action_edit" + id).css('display','none');
    jQuery("#action_delete" + id).css('display','none');
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

function btn_delete_local(id) {
    jQuery("#action" + id).css('display','none');
    jQuery("#action_delete" + id).css('display','block');
}

function btn_delete_cancel_local(id) {
    jQuery("#action" + id).css('display','block');
    jQuery("#action_delete" + id).css('display','none');
}
/**
*
*    END LOCAL MANAGE SCRIPTS
*
*/

