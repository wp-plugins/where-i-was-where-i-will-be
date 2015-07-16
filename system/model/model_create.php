<?php
class WIWWIWB_Model_Create {
    
    private $table_prefix;
    private $db;
	private $charset_collate;
    function __construct() {
        require_once(ABSPATH.'wp-admin/includes/upgrade.php');
        require_once(dirname(__FILE__).'/../include/include_admin.php');
        $this->table_prefix = WIW_TABLE_PREFIX ;
        $this->db = $wpdb;
		$this->charset_collate = $this->db->get_charset_collate();
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
                                        PRIMARY KEY(id)
				) {$this->charset_collate};";
		dbDelta($sql);
		
		if (!$this->run_query("SELECT title FROM {$table_name}")) { //Include fields in older version
			$sql_update = "ALTER TABLE {$table_name} ADD title VARCHAR(256) NULL AFTER id;";
			$this->run_query($sql_update);
		}
    }
    
    function activate_create_type_table () {
		$table_name = $this->table_prefix . "type";
		$charset_collate = $this->db->get_charset_collate();
		$sql = "CREATE TABLE IF NOT EXISTS {$table_name} (id INT NOT NULL AUTO_INCREMENT  PRIMARY KEY,
										name VARCHAR(256) NOT NULL,
										pin VARCHAR(1024) NOT NULL
				) {$this->charset_collate};";
		dbDelta($sql);
        $this->populate_type();
		
		
		if (!$this->run_query("SELECT text FROM {$table_name}")) { //Include fields in older version
			$sql_update = "ALTER TABLE {$table_name} ADD text VARCHAR(256) NULL AFTER pin;";
			$this->run_query($sql_update);
		}
    }
    
    function drop_table($table) { 
		$table_name = $this->table_prefix . $table;
		$sql = "DROP TABLE {$table_name};";
		//$this->run_query($sql);
    }
    
    function populate_type() {
        //Insert Undefined
        return $this->db->query('INSERT IGNORE INTO '.$this->table_prefix.'type (id, name, pin) VALUES (1, "'.__('Undefined',WIW_TRANSLATE).'", "'.WIW_DIR_IMAGES.'pin/red-dot.png");');
    }
	
	function run_query($sql) {
		return $this->db->query($sql);
	}
/******************************************/
//  END ACTIVATE - CREATE TABLES
/******************************************/
}
?>