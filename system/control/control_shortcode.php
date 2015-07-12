<?php
class WIWWIWB_Shortcode {

    public $control_util;
    public $model_info;
	function __construct() {
        include_once (WIW_DIR_CONTROL.'util.php');
        $this->control_util = new WIWWIWB_Util();
        
        include_once (WIW_DIR_MODEL.'info.php');
        $this->model_info = new WIWWIWB_Model_Info();
    }
    
    function wiw_show_map($atts) {
        $att = shortcode_atts(array(
            'start_date' => false,
            'end_date' => false,
            'only_until_today' => false,
            'type' => false,
            'local'=> false,
            'show_no_arrival' => true,
            'class'=> false,
            'width'=> '100%',
            'height' => '400px',
            'map_id'=> false,
            'zoom' => 'AUTO',
            'force_zoom' => false,
            'map_type'=> 'ROADMAP',
            'zoom_control'=> 'DISABLED',
            'zoom_position'=> false,
            'control_style'=> 'DISABLED',
            'control_position'=> false,
            'pan_control'=> 'DISABLED',
            'pan_position'=> false,
            'scale_control'=> 'DISABLED',
            'streetview_control'=> 'DISABLED',
            'streetview_position'=> false,
            'center_button'=> 'ENABLED',
            'center_button_position' => 'BOTTOM_CENTER',
			'cluster' => false,
			'scroll' => true,
			'show_coord' => '',
			'use_type_text' => false
        ), $atts);
        
        //Attributes to Generate WHERE
        $info['start_date'] = $this->treat_date($att['start_date'],'arrival','>');
        $show_no_arrival = ($att['show_no_arrival'])?'=':'';
        $info['start_date'] = ($info['start_date'] === false)?'arrival >'.$show_no_arrival.' \'0000-00-00\'':$info['start_date'];
        $info['end_date'] = ($att['only_until_today'] !== false)?false:$this->treat_date($att['end_date'],'arrival','<');
        $info['end_date'] = ($att['only_until_today'] === false)?$info['end_date']:'arrival <= \''.$this->control_util->get_today().'\'';
        $info['locals'] = $this->explode_att($att['local']);
        $info['types'] = ($info['locals'] !== false)?false:$this->explode_att($att['type']);
        $sql_where = $this->generate_where($info);
		
        
        //Attributes to be passed to show_map.php
        $width = $this->check_dimension($att['width']);
        $height = $this->check_dimension($att['height']);
        $cluster = (($att['cluster'] === false) || ($att['cluster']) === "false")?false:true;
		$scroll = (($att['scroll'] === true) || ($att['scroll']) === "true")?true:false;
		$use_type_text = (($att['use_type_text'] === true) || ($att['use_type_text']) === "true")?true:false;
				
        $atts = array('class' => $att['class'],
                      'map_id' => $att['map_id'],
                      'zoom' => $att['zoom'],
                      'width' => $width,
                      'height' => $height,
                      'force_zoom' => $att['force_zoom'],
                      'zoom_position' => $att['zoom_position'],
                      'map_type' => $att['map_type'],
                      'control_style' => $att['control_style'],
                      'control_position' => $att['control_position'],
                      'pan_control' => $att['pan_control'],
                      'pan_position' => $att['pan_position'],
                      'scale_control' => $att['scale_control'],
                      'zoom_control' => $att['zoom_control'],
                      'streetview_control' => $att['streetview_control'],
                      'streetview_position' => $att['streetview_position'],
                      'center_button' => $att['center_button'],
                      'center_button_position' => $att['center_button_position'],
					  'cluster' => $cluster,
					  'scroll' => $scroll,
					  'show_coord' => $att['show_coord'],
					  'use_type_text' => $use_type_text);
        
        return $this->generate_map($sql_where, $atts);
    }
    
    function explode_att($att) {
        if (empty($att)) return false;
        $att = explode(',',$att);
        if (count($att) === 0) return $att;
        else return $att;
    }
    
    function treat_date($date, $field, $signal = '>') {
        if ($date !== false) {
            if ($this->control_util->verify_date($date)) {
                $date = $this->control_util->change_date_to_db($date);
                return ''.$field.' '.$signal.'= \''.$date.'\'';
            }
        }
        return false;
    }
    
    function treat_array($array, $field) {
        $sql = '';
        if (count($array) == 1) $sql = $field . ' = '.$array[0];
        else if (count($array) > 1) {
            $sql = '(';
            for ($i = 0; $i < count($array); $i++) {
                if ($i != 0) $sql .= ' OR ';
                $sql .= $field.' = '.$array[$i];
            }
            $sql .= ')';
        }
        return $sql;
    }
    
    function check_dimension($dimension) {
        
        if ((strpos($dimension, 'px') === false) && (strpos($dimension, '%') === false)) {
            if (is_numeric($dimension)) $dimension = $dimension .'px';
            else {
                $dimension = preg_replace("/[^0-9,.]/", "", $dimension).'px';
            }
        }

        return $dimension;
    }
    
    function generate_where($info) {
        $sql = '';
        if ($info['start_date'] !== false) $sql .= $info['start_date'];
        if ($info['end_date'] !== false) $sql .= ((!empty($sql))?' AND ':'').$info['end_date'];
        if ($info['locals'] !== false) $sql .= ((!empty($sql))?' AND ':'').$this->treat_array($info['locals'],'id');
        if ($info['locals'] === false)
            if ($info['types'] !== false) $sql .= ((!empty($sql))?' AND ':'').$this->treat_array($info['types'],'type');
        $sql = (!empty($sql))?' WHERE '.$sql:$sql;
        return $sql;
    }
    
    function generate_map ($where,$atts) {
        $atts['WIW_HEADER'] = ABSPATH;
        $atts['where'] = $where;
        $compliment = '';
        foreach ($atts as $i => $v) {
            $compliment .= (empty($compliment))?'?':'&';
            $compliment .= $i .'='. urlencode($v);
        }
        $url = plugins_url('where-i-was-where-i-will-be/system/view/user/show_map.php').$compliment;
        $content = wp_remote_get($url);
        return (is_array($content))?$content['body']:false;
    }
    
    function replace_text($text, $info) {
    
        $array_index = array();
        $array_value = array();
        foreach ($info as $index => $value) {
            if ($index == 'flag') {
                $value = '<img src="'.WIW_DIR_IMAGES.'flags/'.$value.'.png" style="max-width:64px!important; max-height:64px!important;"/>';
            }
            array_push($array_index,'%'.$index.'%');
            array_push($array_value,$value);
			
			//Change single quote to code (avoid conflict in js)
            array_push($array_index,'\'');
            array_push($array_value,'&#39;');
        }
    
        $new_text = str_replace($array_index, $array_value, $this->control_util->make_single_line($text));
    
        return $new_text;
    }
    
    function include_days_nigths($info) {
        if ($this->control_util->verify_date_db($info->arrival) || $this->control_util->verify_date_db($info->departure)) {
            $arrival = new DateTime($info->arrival);
            $departure = new DateTime($info->departure);

            $info->days = $departure->diff($arrival)->format("%a");
            $info->nights = $info->days--;
        } else {
            $info->days = '';
            $info->nights = '';
        }
        
        return $info;
    }
    
    function adjust_days($info) {
        if ($this->control_util->verify_date_db($info->arrival)) {
            $info->arrival = $this->control_util->change_date_to_show($info->arrival);
            $info->departure = ($this->control_util->verify_date_db($info->departure))?$this->control_util->change_date_to_show($info->departure):'';
        } else {
            $info->arrival = '';
            $info->departure = '';
        }
        return $info;
    }
}
?>