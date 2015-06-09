<?php
//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )  exit();

global $wpdb;

//Remove table Locals
$wpdb->query( 'DROP TABLE '.WIW_TABLE_PREFIX.'locals');

//Remove table Type
$wpdb->query( 'DROP TABLE '.WIW_TABLE_PREFIX.'type');
?>