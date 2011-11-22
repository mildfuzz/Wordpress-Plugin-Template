<?php
/*
Plugin Name: Plugin Template
Plugin URI: http://mildfuzz.com
Description: A template to start plugins
Version: 0.1
Author: John Farrow
Author URI: http://mildfuzz.com
License: GPL2
*/


/*  Copyright 2011  John Farrow  (email : john@mildfuzz.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$pluginTables = array(
		'tables' => array(
					"contacts" => array(
							'email' => 'text NOT NULL',
							'label' => 'text NOT NULL' 
						)
					)
				);
register_activation_hook(__FILE__,'install_plugin');
//register_deactivation_hook(__FILE__,'app_switcher_uninstall');
	
function install_plugin(){
	
	//install_tables();
	

	
}


function install_tables(){
	global $pluginTables;
	$installTables = new PluginTables($pluginTables);
	
}



class PluginTables extends PluginUtilities
{
   protected $tables;

   	function __construct(){
		$args = func_get_args();
		$this->parse_args($args[0]);
		
		if(array_key_exists('tables',$args[0]))	$this->install_tables(); 
	}
	
	function parse_args($args){
		foreach($args as $k=>$v){
			$this->$k = $v;
		}
	  }
	
	
	function install_tables(){
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		fb::log($this->tables,'tables');
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
}

class PluginUtilities{
	function parse_args($args){
		
		foreach($args as $k=>$v){
			$this->$k = $v;
		}
	  }
}

include 'pages.php';


?>