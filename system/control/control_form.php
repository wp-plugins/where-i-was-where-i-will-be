<?php
class WIWWIWB_Form {
	function __construct() {}
	
	function create_select_types($name, $class, $all_types, $value = NULL) {
        $class = (!empty($class))?"class='{$class}'":'';
		$output = "<select name='{$name}' id='{$name}' {$class}>".PHP_EOL;
        foreach ($all_types as $type) {
            $selected = ($value == $type->id)?'selected':'';
            $output .= "<option value='{$type->id}' {$selected}>{$type->name}</option>".PHP_EOL;
        }
        $output .= '</select>';
        return $output;
        
    }
    
    function create_select($name, $class, $options, $value = "NULL") {
        $class = (!empty($class))?"class='{$class}'":'';
		$output = "<select name='{$name}' id='{$name}' {$class}>".PHP_EOL;
        foreach ($options as $option) {
            $selected = (strtoupper($value) == strtoupper($option))?'selected':'';
            $output .= "<option value='{$option}' {$selected}>{$option}</option>".PHP_EOL;
        }
        $output .= '</select>';
        return $output;    
    }
    
    function insert_replaceable_text($name, $button, $class = '', $class_btn = '') {
        $values = array(array('id',__('Id',WIW_TRANSLATE)),
                       array('title',__('Title',WIW_TRANSLATE)),
                       array('city',__('City',WIW_TRANSLATE)),
                       array('country',__('Country',WIW_TRANSLATE)),
                       array('flag',__('Flag',WIW_TRANSLATE)),
                       array('latitude',__('Latitude',WIW_TRANSLATE)),
                       array('longitude',__('Longitude',WIW_TRANSLATE)),
                       array('arrival',__('Arrival',WIW_TRANSLATE)),
                       array('departure',__('Departure',WIW_TRANSLATE)),
                       array('days',__('Days',WIW_TRANSLATE)),
                       array('nights',__('Nigths',WIW_TRANSLATE)),
                       array('url',__('Url',WIW_TRANSLATE)),
                       array('image',__('Image',WIW_TRANSLATE)));
        $output = '';
        $output .= '<select id="'.$name.'" name="'.$name.'" class="'.$class.'">';
        foreach ($values as $value) {
                $output .=  "<option value='%{$value[0]}%'>{$value[1]}</option>".PHP_EOL;
        }
        $output .= '</select>'.PHP_EOL;
        $output .= '<input type="button" id="'.$button.'" class="'.$class_btn.' button" value="'.__('Insert', WIW_TRANSLATE).'"</div>'.PHP_EOL;
        
        return $output;
    }
}
?>