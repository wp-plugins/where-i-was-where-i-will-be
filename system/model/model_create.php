<?php
class WIWWIWB_Model_Create {
    
    private $table_prefix;
    private $db;
    function __construct() {
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        require_once(dirname(__FILE__).'/../include/include_admin.php');
        $this->table_prefix = WIW_TABLE_PREFIX ;
        $this->db = $wpdb;
    }
    
/*****************************************************/
//  ACTIVATE - CREATE TABLES
/*****************************************************/

    function activate_create_locals_table () {		
		$table_name = $this->table_prefix . "locals";
		$sql = "CREATE TABLE IF NOT EXISTS {$table_name} (id INT NOT NULL AUTO_INCREMENT,
										city VARCHAR(256) NULL,
										country VARCHAR(256) NOT NULL,
                                        flag VARCHAR(8) NULL,
										latitude REAL NOT NULL,
										longitude REAL NOT NULL,
										arrival DATE NULL,
										departure DATE NULL,
										url VARCHAR(1024) NULL,
										image VARCHAR(1024) NULL,
										type INT NOT NULL,
										text TEXT NULL,
                                        PRIMARY KEY(id));";
		dbDelta($sql);
        
    }
    
    function activate_create_type_table () {
		$table_name = $this->table_prefix . "type";
		$sql = "CREATE TABLE IF NOT EXISTS {$table_name} (id INT NOT NULL AUTO_INCREMENT  PRIMARY KEY,
										name VARCHAR(256) NOT NULL,
										pin VARCHAR(1024) NOT NULL);";
		dbDelta($sql);
        $this->populate_type();
    }
    
    function drop_table($table) { 
		$table_name = $this->table_prefix . $table;
		$sql = "DROP TABLE {$table_name};";
		$query = $this->db->query($sql);
    }
    
    function populate_type() {
        //Insert Undefined
        return $this->db->query('INSERT INTO '.$this->table_prefix.'type (id, name, pin) VALUES (1, "'.__('Undefined',WIW_TRANSLATE).'", "'.WIW_DIR_IMAGES.'pin/red-dot.png");');
    }
/******************************************/
//  END ACTIVATE - CREATE TABLES
/******************************************/


}
?>