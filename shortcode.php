<?php
include 'sendmail.php';

add_shortcode( 'mf_contacts', 'fetch_contact_form');
$message = false;

function fetch_contact_form(){
	global $mf_plugin, $message;
	$contacts = $mf_plugin->fetch_table($mf_plugin->table_names[0]);
	
	if($_POST['mf_contact_form'] == 1){
		fb::error($_POST,'post');
		$sent = process_mail();
		if($sent) : ?><div class="mail_message success">Message Sent</div><?php else: ?><div class="mail_message error">Sorry, message sending failed.</div><?php endif; ?>
		
			
	<?php }  ?>
	
	<?php if ($message) { ?><div class="mail_message error"><?php echo $message; ?></div><?php } ?>
	
	<form class="mail" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<fieldset> 
			<legend>Your message</legend> 
		
		
		<textarea id="body" name="mf_body"></textarea>
		<?php if($contacts) : ?>
			<fieldset>
				<legend>What is your message about?</legend> 
				<?php 
			foreach($contacts as $contact) :
				$slug = mf::slugger($contact->section); ?>
				<label for="<?php echo $slug; ?>"><?php echo $contact->section; ?></label><input id="<?php echo $slug; ?>" type="radio" name="mf_question" value="<?php echo $contact->email; ?>" />
			<?php endforeach; ?>
			</fieldset>
		<?php endif ?>
		</fieldset>
		<fieldset>
			<legend>About You</legend>     
		
		
		<input type="hidden" name="mf_contact_form" value="1" />
		<label for="name">Your name</label><input id="name" type="text" name="mf_name" />
		<label for="email">Your email*</label><input id="email" type="text" name="mf_email" />
		
			
		
		
		</fieldset>  
		
		<input type="submit" value="Send Message" />
	</form>
	<?php
	
}

function process_mail(){
	global $message;
	$post = mf::clean($_POST);
	if($post['mf_question'] == "") $post['mf_question'] = get_bloginfo('admin_email');
	if($post['mf_email'] == "" || $post['mf_body'] == "") {
		$message = "Email and Message are required fields.";
		return false;
	}
	$post['mf_body'] = "Name : ".$post['mf_name']."<br />Reply Address: ".$post['mf_email']."<div style='width: 100%; border-top: 1px solid #555555; margin: 14px 0;'></div>Message: <br />".$post['mf_body'];
	return smtpmailer($post['mf_question'], $post['mf_email'], ($post['mf_name'] ? $post['mf_name'] : ""), "Website Feedback", $post['mf_body']);
	
}

?>