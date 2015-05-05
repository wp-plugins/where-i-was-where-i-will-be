<?php
class WIWWIWB_Util {
	function __construct() {}
    
    function show($value) { //Used to Debug variables
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
    }
    
    function verify_date($date) {
        $d = explode('/',$date);
        if (count($d) != 3) return false;
        return checkdate($d[0], $d[1], $d[2]);
    }

    function verify_date_db($date) {
        $d = explode('-',$date);
        if (count($d) != 3) return false;
        return (($d[0] + $d[1] + $d[2]) > 0)?true:false;
    }
	
	function change_date_to_db($date) {
        $d = explode('/',$date);
        if (count($d) != 3) return false;
        return $d[2].'-'.$d[0].'-'.$d[1];
	}
    
    function change_date_to_show($date) {
        $d = explode('-',$date);
        if (count($d) != 3) return false;
        return $d[1].'/'.$d[2].'/'.$d[0];    
    }
    
    function get_today() {
        return date('Y-m-d');
    }
    
    function make_single_line($text) {
        if (empty($text)) return false;
        $lines = explode("\n", $text);
        $new_line = '';
        foreach ($lines as $line) {$new_line .= $line;} 
        return $new_line;
    }
    
    
}
?>