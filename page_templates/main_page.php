<?php 
global $mf_plugin;
$mf_plugin->fetch_post('process_contacts');
$contacts = $mf_plugin->fetch_table($mf_plugin->table_names);

function process_contacts(){
	global $mf_plugin, $mf_message, $wpdb;
	$contactsTable = $mf_plugin->table_names;
	
	
	foreach($_POST as $k=>$v){
		if(!$v){
			showMessage($k." is a required field", true);
			$failed = true;
		} 
		
		
		
		
	}
	$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT('email') FROM $contactsTable;" ));
	if($count > 0){
		showMessage("email already in use", true);
		$failed = true;
	} 
	if($failed) return false;
	
	fb::log($_POST,$contactsTable);
	$wpdb->insert($contactsTable,$_POST);
	showMessage($_POST['name']." added to contacts");
	
	
	
	
}
?>
<h3>Add New Contact</h3>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	
	<label for="name">Name</label><input id="name" type="text" name="name" />
	<label for="email">Email</label><input id="email" type="text" name="email" />
	<label for="section">Section</label><input id="section" type="text" name="section" />
	
	<input class='button-primary' type="submit" value="Add Contact" />
</form>
<h3>Contacts</h3>
<table>
<?php foreach($contacts as $contact): ?>
<tr>
<td><?php echo $contact->name; ?></td>
<td><?php echo $contact->email; ?></td>
<td><?php echo $contact->section; ?></td>
</tr>
<?php endforeach; ?>
</table>
