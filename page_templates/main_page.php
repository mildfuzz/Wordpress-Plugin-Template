<?php
global $mf_plugin, $wpdb;
$edit_contact = false;
if(isset($_GET['action'])){
	if($_GET['action'] == 'delete') delete_contact($_GET['id']);
	if($_GET['action'] == 'edit') $edit_contact = $_GET['id'];
} else {
	
	if($_POST['edit'] == "1"){
		edit_contact();
	} else {
		$mf_plugin->fetch_post('add_contact');
	}
}

$contacts = $mf_plugin->fetch_table($mf_plugin->table_names[0]);

function edit_contact(){
	global $mf_plugin, $wpdb;
	$details = $_POST;
	unset($details['edit']);
	
	$wpdb->update($mf_plugin->table_names[0],$details,array('id' => $_POST['id']));
	mf::wpLog($_POST['name']." edited");
}

function add_contact(){
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

function delete_contact($id){
	global $wpdb, $mf_plugin;
	$table = $mf_plugin->table_names[0];
	$wpdb->query("
		DELETE FROM $table 
		WHERE id = $id");
	header("Location: ".mf::removeQueryElements(array('action','id')));
}

?>
<?php if(!$edit_contact) : ?>
<h3>Add New Contact</h3>
<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	
	<label for="name">Name</label><input id="name" type="text" name="name" />
	<label for="email">Email</label><input id="email" type="text" name="email" />
	<label for="section">Section</label><input id="section" type="text" name="section" />
	
	<input class='button-primary' type="submit" value="Add Contact" />
</form>
<?php else: ?>
	
	<?php $edit = $wpdb->get_results("SELECT * FROM ".$mf_plugin->table_names[0]." WHERE id = $edit_contact"); ?>
	<h3>Edit  "<?php echo $edit[0]->name; ?>"</h3>
	<form style="display: inline;" method="post" action="<?php echo mf::removeQueryElements(array('action','id')); ?>">
		<input type="hidden" name="edit" value="1">
		<input type="hidden" name="id" value="<?php echo $edit[0]->id; ?>">
		<label for="name">Name</label><input id="name" type="text" name="name" value="<?php echo $edit[0]->name; ?>"/>
		<label for="email">Email</label><input id="email" type="text" name="email" value="<?php echo $edit[0]->email; ?>"/>
		<label for="section">Section</label><input id="section" type="text" name="section" value="<?php echo $edit[0]->section; ?>"/>

		<input class='button-primary' type="submit" value="Save" />
	</form>
	<form style="display: inline;" method="post" action="<?php echo mf::removeQueryElements(array('action','id')); ?>">
		<input class='button-primary' type="submit" value="Cancel" />
	</form>	
<?php endif;?>
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
$edit = array('action' => 'edit', 'id'=>$contact->id);
?>
<tr>
<td><?php echo $contact->name; ?></td>
<td><?php echo $contact->email; ?></td>
<td><?php echo $contact->section; ?></td>
<td><a href="<?php echo mf::urlQuery($edit); ?>">Edit</a>/<a href="<?php echo mf::urlQuery($delete); ?>">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>
