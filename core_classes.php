<?php
class PluginTables extends PluginUtilities
{
    public $tables;
	public $table_names;
	
   	function __construct(){
		$args = func_get_args();
		
		$this->parse_args($args[0]);
		
		
		if($this->tables){
			$this->assign_table_names();
		}
		
		
	}
	
	function assign_table_names(){
		//set array of all table names in full
		global $wpdb;
		foreach($this->tables as $table_name => $fields){
			$this->table_names[] = $wpdb->prefix . $table_name;
		}
	}
	
	function parse_args($args){
		foreach($args as $k=>$v){
			$this->$k = $v;
		}
	  }
	
	
	function activate(){
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		if(!is_array($this->tables)) wp_die('table argument for AdminDatabase must be an array');
		
		$sql = array();
		foreach($this->tables as $table_name => $fields){
			$table_name = $wpdb->prefix . $table_name;
			if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name){
				//create table
				$sql[$table_name] =  "CREATE TABLE $table_name (id mediumint(9) NOT NULL AUTO_INCREMENT,";
					//create fields
					if(!is_array($fields)) wp_die("$table_name has no fields");
					foreach ($fields as $k => $sql_command){
						$sql[$table_name] .= $k." ".$sql_command.",";
					}
				$sql[$table_name] .= "UNIQUE KEY id (id));";
				dbDelta($sql[$table_name]);
			} 
		}
	}
	
	function deactivate(){
		global $wpdb;
	
		if(!is_array($this->tables)) wp_die('table argument for AdminDatabase must be an array');
		foreach($this->tables as $table_name => $fields){
			$table_name = $wpdb->prefix . $table_name;
			
				$wpdb->query("DROP TABLE $table_name;");
			
		}
	}
	
	
}

class PluginUtilities{
	function parse_args($args){
		
		foreach($args as $k=>$v){
			$this->$k = $v;
		}
	  }
	
	function slugger($string){
		return str_replace(" ","_",strtolower($string));
	}
	
	//fetch table row
	function fetch_table($table_name, $where = false){
		global $wpdb;
		$wpdb->get_results("SELECT * FROM $table_name ".($where ? $where : "").";");
	}
	
	//only processes call back if the page has POST set
	function fetch_post($callback){
		if(!isset($_POST) || count($_POST) < 1){
			return false;
		} else {
			call_user_func($callback);
		}
	}
	
	
}
?>