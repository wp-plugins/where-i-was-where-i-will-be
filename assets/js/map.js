//Show Map by Address

function show_map(id, div, lat, lng) {
    var geocoder;
    var map;
    geocoder = new google.maps.Geocoder();
    get_info = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(lat, lng);
    var mapOptions = {
        zoom: 12,
        center: latlng
    }
    map = new google.maps.Map(document.getElementById(div), mapOptions);
    jQuery('#' + div).addClass('wiw_map_local');
    code_address(map, id, geocoder, get_info);
}  

//Get info from Address
function code_address(map, id, geocoder, get_info) {
    var address = document.getElementById('get_info' + id).value;
    var error_msg = wiw_vars.wiw_google_maps_error;
    geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location,
                draggable:true,
            });
            google.maps.event.addListener(marker,'dragend', function(event) {
                show_marker_info(id, marker, get_info, error_msg);
            });
            show_marker_info(id, marker, get_info, error_msg);
            
        } else {
            alert(error_msg + ': ' + status);
        }
    });
}

function show_flag(div, flag, style) {
    jQuery('#'+div).html('<img src="'+wiw_vars.wiw_dir_images+'/flags/' + flag + '.png" class="' + style + '" onerror="imgError(this);">');
}

//Show info on Form
function show_marker_info(id, marker, get_info, error_msg) {
    var lat = marker.position.A;
    var lng = marker.position.F;
    var latlng = new google.maps.LatLng(lat, lng);
    get_info.geocode({'latLng': latlng}, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var found_city = 0;
            var found_country = 0;
            for (var i = 0; i < results[0].address_components.length; i++) {
                for (var n = 0;n < results[0].address_components[i].types.length; n++) {
                    if ((results[0].address_components[i].types[n] == "locality") && (found_city == 0)){
                        var city = results[0].address_components[i];
                        found_city = 1;
                    }
                    if ((results[0].address_components[i].types[n] == "country") && (found_country == 0)) {
                        var country = results[0].address_components[i];
                        found_country = 1;
                    }
                    if ((found_city == 1) && (found_country == 1)) {
                        break;
                    }
                }
            }
            jQuery('#latitude' + id).val(lat);
            jQuery('#longitude' + id).val(lng);
            if (city !== undefined) jQuery('#city' + id).val(city.long_name);
            else jQuery('#city' + id).val('');
            if (country !== undefined) {
                jQuery('#country' + id).val(country.long_name);
                jQuery('#flag' + id).val(country.short_name.toLowerCase());
                show_flag('show_flag' + id, country.short_name.toLowerCase(), 'flag_preview');
            } else {
                jQuery('#country' + id).val('');
                jQuery('#flag' + id).val('');
            }
        } else {
            alert(error_msg + ': ' + status);
        }
    });
}

//Auto Complete
function auto_complete(input_id, lat, lng) {
    var complete;
    var bounds = new google.maps.LatLngBounds(new google.maps.LatLng(lat, lng),new google.maps.LatLng(lat, lng));
    complete = new google.maps.places.Autocomplete((document.getElementById(input_id)),{ types: ['geocode'] });
    complete.setBounds(bounds);
}