<?php
global $mf_plugin;
$mf_plugin->fetch_post('process_contacts');
$contacts = $mf_plugin->fetch_table($mf_plugin->table_names[0]);

function process_contacts(){
	global $mf_plugin, $mf_message, $wpdb;
	$contactsTable = $mf_plugin->table_names[0];
	

	foreach($_POST as $k=>$v){
		if(!$v){
			mf::wpLog($k." is a required field", true);
			$failed = true;
		} 
		
		
		
		
	}
	$email = $_POST['email'];
	$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $contactsTable WHERE email = '$email';" ));
	
	if($count > 0){
		mf::wpLog("email already in use", true);
		$failed = true;
	} 
	if($failed) return false;
	
	
	$wpdb->insert($contactsTable,$_POST);
	mf::wpLog($_POST['name']." added to contacts");
	
	
	
	
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
<table class="widefat">
	<thead>
		<th>Name</th>
		<th>eMail</th>
		<th>Section</th>
		<th>Action</th>
	</thead>
<?php foreach($contacts as $contact): 
$delete = array('action' => 'delete', 'id'=>$contact->id);
$edit = array('action' => 'edit', 'ID'=>$contact->id);
?>
<tr>
<td><?php echo $contact->name; ?></td>
<td><?php echo $contact->email; ?></td>
<td><?php echo $contact->section; ?></td>
<td><a href="<?php echo mf::urlQuery($edit); ?>">Edit</a>/<a href="<?php echo mf::urlQuery($delete); ?>">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>
