<?php

add_action('admin_menu','install_pages');
//add_action( 'admin_menu', array( $$this, 'add_sub_menu'),11);

function install_pages(){
	$pages = array(
			'page_title' => 'Plugin Template',
			'menu_title' => 'Plugin Template',
			'menu_slug' => 'plugin_template',
			'include' => 'page_templates/plugin.php',
	);
	$pluginPage = new PluginPage($pages);
}


class PluginPage extends PluginUtilities
{

  //default arguments
  protected $capability = "manage_options";
  protected $page_title = "";
  protected $menu_title = "";
  protected $menu_slug = "";
  protected $function = "";
  protected $icon_url = NULL;
  protected $position = '';
  protected $include = "";

  function __construct(){
	
	$args = func_get_args();
	$this->parse_args($args[0]);
	
	
	$this->add_top_level_menu();
    
  }
  
  function add_top_level_menu(){
	
	    // Creates a top level admin menu - this kicks off the 'display_page()' function to build the page
        add_menu_page($this->page_title, $this->menu_title, $this->capability, $this->menu_slug, array(&$this, 'display_page'));
  }
	/*
	function add_sub_menu(){
		// Adds an additional sub menu page to the above menu - if we add this, we end up with 2 sub menu pages (the main pages is then in sub menu. But if we omit this, we have no sub menu
        // This has been left in incase we want to add an additional page here soon
        //add_submenu_page( $menu_slug, 'sub menu 1', 'sub menu 1', $this->capability, $menu_slug . '_sub_menu_page_1', $function );
	}
	*/
	

    function display_page()
    {
        if (!current_user_can($this->capability ))
        wp_die(__('You do not have sufficient permissions to access this page.'));
      	//Include PHP to build page - > Relative to script
      	if($this->include != ""){
			include($this->include);
		} else {
			echo "Nothing to Display";
		}
	}
}
?>