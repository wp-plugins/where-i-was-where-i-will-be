(function() {
   tinymce.create('tinymce.plugins.recentposts', {
      init : function(ed, url) {
         ed.addButton('wiwwiwb', {
            title : 'Where I Was, Where I Will Be',
            image : url+'/../images/icon-16x16.png',
            onclick : function() {
               wiw_open_form();
            }
         });
      },
      createControl : function(n, cm) {
         return null;
      },
      getInfo : function() {
         return {
            longname : "Where I Was, Where I Will Be",
            author : 'Mauro Baptista',
            authorurl : 'http://www.carnou.com',
            infourl : 'http://www.carnou.com',
            version : '1.0'
         };
      }
   });
   tinymce.PluginManager.add('wiwwiwb', tinymce.plugins.recentposts);
})();

function wiw_open_form() {
    jQuery('body').css('overflow','hidden');
    jQuery("#wiwwiwb_select").css('display','block');
    var top = (jQuery(window).height() / 2) - (jQuery('#wiwwiwb_insert').height() / 2); //Vertically Centralized
    jQuery('#wiwwiwb_insert').css('top',top + 'px');
}

function wiw_close_form () {
    jQuery('body').css('overflow','initial');
    jQuery("#wiwwiwb_select").css('display','none');
}

function wiw_insert_form() {
    var start_date = jQuery("#start_date").val();
    
    var show_no_arrival = jQuery("#show_no_arrival").is(":checked");
    show_no_arrival = (show_no_arrival && !start_date.length) ? " show_no_arrival=\"true\"" : "";
    
    start_date = (start_date.length) ? " start_date=\"" + start_date + "\"" : "";
    
    var end_date = jQuery("#end_date").val();
    end_date = (end_date.length) ? " end_date=\"" + end_date + "\"" : "";

    var only_until_today = jQuery("#only_until_today").is(":checked");
    only_until_today = only_until_today ? " only_until_today=\"true\"" : "";
        
    if (only_until_today) end_date = '';

    var cluster = jQuery("#cluster").is(":checked");
    cluster = cluster ? " cluster=\"true\"" : "";

    var use_type_text = jQuery("#use_type_text").is(":checked");
    use_type_text = use_type_text ? " use_type_text=\"true\"" : "";
    
    var type = jQuery("#type").val();
    type = (type.length) ? " type=\"" + type + "\"" : "";
    
    var local = jQuery("#local").val();
    local = (local.length) ? " local=\"" + local + "\"" : "";

    if (local.length) type = '';
        
    var style = jQuery("#class").val();
    style = (style.length) ? " class=\"" + style + "\"" : "";
    
    var map_id = jQuery("#map_id").val();
    map_id = (map_id.length) ? " map_id=\"" + map_id + "\"" : "";
    
    
    //Define Google MAPS Attributes
    var zoom_control = jQuery('#zoom_control').val();
    if (zoom_control != 'DISABLED') {
        var zoom_position = " zoom_position=\""+ jQuery('#zoom_position').val() + "\"";
        zoom_control = " zoom_control=\""+ zoom_control + "\"" + zoom_position;
    } else {zoom_control = "";}
    
    var control_style = jQuery('#control_style').val();
    if (control_style != 'DISABLED') {
        var control_position = " control_position=\""+ jQuery('#control_position').val() + "\"";
        control_style = " control_style=\""+ control_style + "\"" + control_position;
    } else {control_style = '';}
    
    var pan_control = jQuery('#pan_control').val();
    if (pan_control != 'DISABLED') {
        var pan_position = " pan_position=\""+ jQuery('#pan_position').val() + "\"";
        pan_control = " pan_control=\"ENABLED\"" + pan_position;
    } else {pan_control = '';}
    
    var scale_control = jQuery('#scale_control').val();
    if (scale_control != 'DISABLED') {scale_control = " scale_control=\"ENABLED\"";}
    else {scale_control = '';}
    
    var streetview_control = jQuery('#streetview_control').val();
    if (streetview_control != 'DISABLED') {
        var streetview_position = " streetview_position=\""+ jQuery('#streetview_position').val() + "\"";
        streetview_control = " streetview_control=\"ENABLED\"" + streetview_position;
    } else {streetview_control = '';}
    
    var center_button = jQuery('#center_button').val();
    if (center_button != 'ENABLED') {
        center_button = " center_button=\"DISABLED\"";
    } else {
        var center_button_position = jQuery('#center_button_position').val();
        if (center_button_position != 'BOTTOM_CENTER') {
            center_button_position = " center_button_position=\""+ center_button_position + "\"";
        } else {center_button_position = '';}
        center_button = center_button_position;
    }
    
    var zoom = jQuery('#zoom').val();
    if (zoom != 'AUTO') {
        var force_zoom = jQuery("#force_zoom").is(":checked");
        force_zoom = (force_zoom) ? " force_zoom=\"true\"" : "";
        
        zoom = " zoom=\"" + zoom + "\"" + force_zoom;
    } else {zoom = '';}
    
    var map_type = jQuery('#map_type').val();
    if (map_type != 'ROADMAP') {
        map_type = " map_type=\"" + map_type + "\"" ;
    } else {map_type = '';}    
    
    var width = jQuery("#width").val();
    width = (width.length) ? " width=\"" + width + "\"" : "";
    
    var height = jQuery("#height").val();
    height = (height.length) ? " height=\"" + height + "\"" : "";
    
    var scroll = jQuery("#scroll").is(":checked");
    scroll = (!scroll) ? " scroll=\"false\"" : "";
    
    var show_coord = jQuery("#show_coord").val();
    show_coord = (show_coord.length) ? " show_coord=\"" + show_coord + "\"" : "";
    
    var google_maps_att = width + height + map_type + zoom + zoom_control + control_style  + pan_control + scale_control + streetview_control;
 
    window.send_to_editor("[wiwwiwb"+ center_button + start_date + end_date + only_until_today + type + local + style + map_id + google_maps_att + show_no_arrival + cluster + scroll + show_coord + use_type_text + "]");
    
    wiw_close_form ();
}

