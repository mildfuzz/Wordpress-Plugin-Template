Wordpress Plugin Template
-------------------------

Set of classes for rapidly setting up extra admin pages, sub pages and tables to create a wordpress plugin.

Usage
-----

Tables--

Set up tables by altering the following property in plugin.php

$pluginTables = array(
		'tables' => array(
					"contacts" => array(
							'email' => 'text NOT NULL',
							'label' => 'text NOT NULL' 
						)
					)
				);
				
$pluginTables must be an array containing one value with the key 'tables'.
Within that is an array of tables, the key serving as the table name
Within that is a key of fields for each table.

Pages--

in pages.php, all the important vars are in the function install pages

function install_pages(){
	$pages = array(
			'page_title' => 'Plugin Template',
			'menu_title' => 'Plugin Template',
			'menu_slug' => 'plugin_template',
			'include' => 'page_templates/main_page.php',
	);
	
	
	$pluginPage = new PluginPage($pages);
	$pluginSubPage = new PluginSubPage($pluginPage, 'Sub Page 1',"page_templates/subpage1.php");
	$pluginSubPage2 = new PluginSubPage($pluginPage, 'Sub Page 2',"page_templates/subpage2.php");
	
}

- menu_slug must not contain spaces.
- newPluginSubPage must have three arguments, first in an instance of the parent page, the second is the title of the sub page and lastly the includes reference.

- includes is a reference to a php file. Rather than loading callback functions, this set up allows to to use includes, much more like a template scheme.