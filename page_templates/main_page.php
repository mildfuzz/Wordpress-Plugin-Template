<?php 
global $mf_plugin;
$mf_plugin->fetch_post('process_contacts');

function process_contacts(){
	global $mf_plugin, $mf_message;
	foreach($_POST as $k=>$v){
		if(!$v){
			showMessage($k." is a required field", true);
		} 
	}
}
?>
<h3 class="update">Add New Contact</h3>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	
	<label for="name">Name</label><input id="name" type="text" name="name" />
	<label for="email">Email</label><input id="email" type="text" name="email" />
	<label for="section">Section</label><input id="section" type="text" name="section" />
	
	<input class='button-primary' type="submit" value="Add Contact" />
</form>