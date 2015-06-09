<?php
    if (isset($_GET['WIW_HEADER'])) $_POST['WIW_HEADER'] = $_GET['WIW_HEADER']; else return false;
    include_once('../../include/include_user.php');
?>
<?php
    //Make $_GET['var'] in $var
    if (isset($_GET)) foreach ($_GET as $i => $v) {$$i = $v;}
    
    $map_id = (!empty($map_id))?$map_id:uniqid('map_');
    $class = (!empty($class))?' class = "'.$class.'"':'';
    $style =  'style=" width:'.$width.';height:'.$height.';"';

    //Get Locals
    $locals = $model_info->get_all_locals(stripslashes($where).' ORDER BY arrival ASC');
?>
<div id="<?php echo $map_id; ?>" <?php echo $class; ?> <?php echo $style; ?>></div>
<style type="text/css">#<?php echo $map_id; ?> img {width: auto!important; max-width: none!important;}</style>
<script type="text/javascript">
        if (markerClusterer<?php echo $map_id; ?>) {markerClusterer<?php echo $map_id; ?>.clearMarkers();}
        
      //Start Marker Clusterer
      var markerClusterer<?php echo $map_id; ?> = null;
      var map = null;
    
    // Define your locations: HTML content for the info window, latitude, longitude
    var locations = [
<?php
    foreach ($locals as $local) {
        $local = $control_shortcode->include_days_nigths($local);
        $local = $control_shortcode->adjust_days($local);
        $comma = ($local === $locals[count($locals)-1])?'':',';
        echo "['".$control_shortcode->replace_text($local->text, $local)."', {$local->latitude}, {$local->longitude}]".$comma.PHP_EOL;
    }
?>
    ];
    
    // Setup the different icons
    var icons = [   
<?php
    foreach ($locals as $local) {
        $comma = ($local === $locals[count($locals)-1])?'':',';
        $pin = $model_info->get_type($local->type);
        echo "'{$pin[0]->pin}'".$comma.PHP_EOL;
    }
    
    //Define coordinate to start map with
    if (strtolower($show_coord) == 'last') $coord = $local->latitude.','.$local->longitude;
    else if (strtolower($show_coord) == 'center') $coord = '0,0';
    else $coord = $show_coord;
?>    
    ];
    var icons_length = icons.length;

    var map = new google.maps.Map(document.getElementById('<?php echo $map_id; ?>'), {
        zoom: <?php echo ($zoom == 'AUTO')?'10':$zoom; ?>,
        center: new google.maps.LatLng(<?php echo $coord; ?>),
        mapTypeId: google.maps.MapTypeId.<?php echo $map_type; ?>,
        <?php if (!$scroll) { ?>
            scrollwheel: false,
        <?php } ?>
        <?php
            if ($control_style != 'DISABLED') {
        ?>
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.<?php echo $control_style; ?>,
            position: google.maps.ControlPosition.<?php echo $control_position; ?>
        },
        <?php } else {?>
        mapTypeControl: false,
        <?php } ?>
        <?php
            if ($pan_control == 'ENABLED') {
        ?>
        panControl: true,
        panControlOptions: {
            position: google.maps.ControlPosition.<?php echo $pan_position; ?>
        },
        <?php } else {?>
        panControl: false,
        <?php
            }
        ?>

        <?php
            if ($zoom_control != 'DISABLED') {
        ?>        
        zoomControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.<?php echo $zoom_control; ?>,
            position: google.maps.ControlPosition.<?php echo $zoom_position; ?>
        },
        <?php } else {?>
        zoomControl: false,
        <?php
            }
        ?>
        
        <?php
            if ($scale_control == 'ENABLED') {
        ?>          
        scaleControl: true,
        <?php } else {?>
        scaleControl: false,
        <?php
            }
        ?>
        
        <?php
            if ($streetview_control == 'ENABLED') {
        ?> 
        streetViewControl: true,
        streetViewControlOptions: {
            position: google.maps.ControlPosition.<?php echo $streetview_position; ?>
        }
        <?php } else {?>
        streetViewControl: false
        <?php
            }
        ?>
        
    });

    var infowindow = new google.maps.InfoWindow();

    var marker;
    var markers = new Array();
    
    var iconCounter = 0;
    
    // Add the markers and infowindows to the map
    for (var i = 0; i < locations.length; i++) {  
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            icon : icons[iconCounter]
        });
    
        markers.push(marker);
        
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                if (locations[i][0].length) {
                    infowindow.setContent(locations[i][0]);
                    infowindow.open(map, marker);
                }
            }
        }) (marker, i));
        iconCounter++;
    }
    
    <?php if ($cluster) { ?>
    markerClusterer<?php echo $map_id; ?> = new MarkerClusterer(map, markers, {
        maxZoom: <?php echo ($zoom == 'AUTO')?'10':$zoom; ?>,
        gridSize: 40
    });
    
    <?php } ?>
    <?php
        if ($center_button == 'ENABLED') {
    ?>
    var center_button_div = document.createElement('div');
    var center_button1 = new center_button(center_button_div, map);
  
    center_button_div.index = 1;
    map.controls[google.maps.ControlPosition.<?php echo $center_button_position; ?>].push(center_button_div);
    <?php
        }
    ?>
    <?php
        if ((count($locals) > 1) && ($force_zoom == false) && (empty($show_coord))) {
    ?>
        AutoCenter();
    <?php
        }
    ?>
    
    function AutoCenter() {
        //  Create a new viewpoint bound
        var bounds = new google.maps.LatLngBounds();
        //  Go through each...
        jQuery.each(markers, function (index, marker) {
            bounds.extend(marker.position);
        });
        //  Fit these bounds to the map
        map.fitBounds(bounds);
    }
    
    function center_button(controlDiv, map) {
        // Set CSS styles for the DIV containing the control
        // Setting padding to 5 px will offset the control
        // from the edge of the map.
        controlDiv.style.padding = '5px';
        
        // Set CSS for the control border.
        var controlUI = document.createElement('div');
        controlUI.style.backgroundColor = 'white';
        controlUI.style.borderStyle = 'solid';
        controlUI.style.borderWidth = '2px';
        controlUI.style.cursor = 'pointer';
        controlUI.style.textAlign = 'center';
        controlUI.title = '<?php _e('Click to set the zoom to show all markers',WIW_TRANSLATE); ?>';
        controlDiv.appendChild(controlUI);
        
        // Set CSS for the control interior.
        var controlText = document.createElement('div');
        controlText.style.fontFamily = 'Arial,sans-serif';
        controlText.style.fontSize = '12px';
        controlText.style.paddingLeft = '4px';
        controlText.style.paddingRight = '4px';
        controlText.innerHTML = '<strong><?php _e('Show All Markers',WIW_TRANSLATE); ?></strong>';
        controlUI.appendChild(controlText);
        
        // Setup the click event listeners: simply set the map to Chicago.
        google.maps.event.addDomListener(controlUI, 'click', function() {
            AutoCenter();
        });
    }
  </script>