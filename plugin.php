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

    This code set is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

   
*/
//load core classes
include 'core_classes.php';

global $mf_plugin;
$pluginTables = array(
		'tables' => array(
					"contacts" => array(
							'email' => 'text NOT NULL',
							'name'	=> 'text NOT NULL',
							'section' => 'text NOT NULL'
						)
					)
				);
				
$mf_plugin = new PluginTables($pluginTables);
		
register_activation_hook(__FILE__,'mf_activate_plugin');
register_deactivation_hook(__FILE__,'mf_deactivate_plugin');
	
function mf_activate_plugin(){
	global $mf_plugin;
	$mf_plugin->activate();
}
function mf_deactivate_plugin(){
	global $mf_plugin;
	
	$mf_plugin->deactivate();
}




//after install
include 'pages.php';
include 'utilities.php';
include 'shortcode.php';


?>