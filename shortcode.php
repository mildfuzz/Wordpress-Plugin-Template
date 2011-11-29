<?php
include 'sendmail.php';

add_shortcode( 'mf_contacts', 'fetch_contact_form');
$message = false;

function fetch_contact_form(){
	global $mf_plugin, $message;
	$contacts = $mf_plugin->fetch_table($mf_plugin->table_names[0]);
	if(count($contacts)<1) return;
	if($_POST['contact_form'] == 1){
		$sent = process_mail();
		if($sent) : ?><div class="mail_message success">Message Sent</div><?php else: ?><div class="mail_message error">Sorry, message sending failed.</div><?php endif; ?>
		
			
	<?php }  ?>
	
	<?php if ($message) { ?><div class="mail_message error"><?php echo $message; ?></div><?php } ?>
	
	<form class="mail" method="post" action="<?php echo mf::thisPage(); ?>">
		<input type="hidden" name="contact_form" value="1" />
		<label for="name">Name</label><input id="name" type="text" name="name" />
		<label for="email">Email*</label><input id="email" type="text" name="email" />
		<label for="question">Question</label><select id="question" name="question">
			<?php foreach($contacts as $contact) :?>
			<option value="<?php echo $contact->email; ?>"><?php echo $contact->section; ?></option>
			<?php endforeach; ?>
		</select>
		<label for="body">Message*</label>
		<textarea id="body" name="body"></textarea>
		<input type="submit" value="Send Message" />
	</form>
	<?php
	
}

function process_mail(){
	global $message;
	$post = mf::clean($_POST);
	fb::warn($post);
	if($post['email'] == "" || $post['body'] == "") {
		$message = "Email and Message are required fields.";
		return false;
	}
	
	return smtpmailer($post['question'], $post['email'], ($post['name'] ? $post['name'] : ""), "Website Feedback", $post['body']);
	
}

?>