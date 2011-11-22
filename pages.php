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
	$sub_pages = array('Sub Page 1' => "page_templates/subpage1.php",'Sub Page 2' => "page_templates/subpage2.php");
	
	$pluginPage = new PluginPage($pages);
	$pluginPage->sub_pages($sub_pages);
	
	
	
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
	
	function sub_pages($pages){
		if(!is_array($pages)) wp_die("sub_pages requires and array");
		foreach($pages as $title => $display){
			$this->add_sub_page($title,$display);
		}
		
	}
	
	private function add_sub_page($title, $display){
		add_submenu_page( $this->menu_slug, $title, $title, $this->capability, $this->menu_slug . '_' . $this->slugger($title), $this->display_page($display));
	}

    function display_page($include = false)
    {
        if(!$include) $include = $this->include;
		if (!current_user_can($this->capability ))
        wp_die(__('You do not have sufficient permissions to access this page.'));
      	//Include PHP to build page - > Relative to script
      	if($this->include != ""){
			include($include);
		} else {
			echo "Nothing to Display";
		}
	}
}
?>