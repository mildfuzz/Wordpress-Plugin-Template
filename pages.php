<?php

add_action('admin_menu','install_pages');
add_action('admin_menu','admin_js');

function admin_js(){
	//wp_enqueue_script('ui',plugins_url('\js\ui.js',__FILE__));
}

function install_pages(){
	$pages = array(
			'page_title' => 'Contacts',
			'menu_title' => 'Contacts',
			'menu_slug' => 'plugin_template',
			'include' => 'page_templates/main_page.php',
	);
	
	
	$pluginPage = new PluginPage($pages);
	//$pluginSubPage = new PluginSubPage($pluginPage, 'Sub Page 1',"page_templates/subpage1.php");
	//$pluginSubPage2 = new PluginSubPage($pluginPage, 'Sub Page 2',"page_templates/subpage2.php");
	
	
	
}
class PluginSubPage extends PluginPage
{

  protected $submenu_slug;

  function __construct($parent,$title,$include){
	$args = get_object_vars($parent);
	$this->parse_args($args);
	$this->include = $include;
	$this->menu_title = $title;
	$this->submenu_slug = $this->menu_slug . '_' . $this->slugger($this->menu_title);
	
	$this->add_page();
    }
  
  	
	
	function add_page(){
		add_submenu_page( $this->menu_slug, $this->menu_title, $this->menu_title, $this->capability, $this->submenu_slug, array($this, 'display_page'));
	}
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
	
	
	$this->add_page();
    
  }
  
  	function add_page(){
		// Creates a top level admin menu - this kicks off the 'display_page()' function to build the page
    	add_menu_page($this->page_title, $this->menu_title, $this->capability, $this->menu_slug, array($this, 'display_page'));
  	}
	
	
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
	
	static function display_sub_page($args = false)
    {
        
		var_dump($args);
      	if($arg){
			include($arg);
		} else {
			echo "Nothing to Display";
		}
	}
	
}



?>