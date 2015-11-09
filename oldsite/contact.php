<?php
/*
Template Name: Contact
*/
$cp_question = "1+1 = ?";
$cp_answer = "2";
?>
<?php get_header();?>
	<div id="content">
    <?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<div class="post">
				<?php
					//validate email adress
					function is_valid_email($email)
					{
  						return (eregi ("^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}$", $email));
					}
					function is_valid_user($answer)
					{
						global $cp_answer;
						if ($answer == $cp_answer) { return true; } else { return false;}
					}
					//clean up text
					function clean($text)
					{
						return stripslashes($text);
					}
					//encode special chars (in name and subject)
					function encodeMailHeader ($string, $charset = 'UTF-8')
					{
    					return sprintf ('=?%s?B?%s?=', strtoupper ($charset),base64_encode ($string));
					}

					$cp_name    = (!empty($_POST['cp_name']))    ? $_POST['cp_name']    : "";
					$cp_email   = (!empty($_POST['cp_email']))   ? $_POST['cp_email']   : "";
					$cp_url     = (!empty($_POST['cp_url']))     ? $_POST['cp_url']     : "";
					$cp_ans     = (!empty($_POST['cp_ans']))     ? $_POST['cp_ans']     : "";
					$cp_message = (!empty($_POST['cp_message'])) ? $_POST['cp_message'] : "";
					$cp_message = clean($cp_message);
					$error_msg = "";
					$send = 0;
					if (!empty($_POST['submit'])) {			
						$send = 1;
						if (empty($cp_name) || empty($cp_email) || empty($cp_message) || empty($cp_ans)) {
							$error_msg.= "<p style='color:#a00'><strong>Please fill in all required fields.</strong></p>\n";
							$send = 0;							
						}						
						if (!is_valid_email($cp_email)) {
							$error_msg.= "<p style='color:#a00'><strong>Your email adress failed to validate.</strong></p>\n";
							$send = 0;
						}	
						if (!is_valid_user($cp_ans)) {
							$error_msg.= "<p style='color:#a00'><strong>Incorrect Answer to the AntiSpam Question.</strong></p>\n";
							$send = 0;
						}									
					}
					if (!$send) { ?>
						<h2 class="post-title"><?php the_title(); ?></h2>
						<div class="post-content">
							<?php the_content("Continue Reading &#187;");
							?>
							<p class="info">* - Required Fields</p>
							<?php echo $error_msg;?>
							<form method="post" action="<?php echo "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" id="contactform">
              
								<fieldset>
                  					<strong>Name</strong>*<br/>
									<input type="text" class="textbox" id="cp_name" name="cp_name" value="<?php echo $cp_name ;?>" /><br/><br/>
									<strong>Email</strong>*<br/>
									<input type="text" class="textbox" id="cp_email" name="cp_email" value="<?php echo $cp_email ;?>" /><br/><br/>
									<strong>Website</strong><br/>
									<input type="text" class="textbox" id="cp_url" name="cp_url" value="<?php echo $cp_url ;?>" /><br/><br/>
									<strong>AntiSpam Challenge:<?php echo $cp_question; ?> </strong>*<br/>
									<input type="text" class="textbox" id="cp_ans" name="cp_ans" value="<?php echo $cp_ans ;?>" /><p class="info">[Just to prove you are not a spammer]</p><br/>
									<strong>Message</strong>*<br/>				
									<textarea id="cp_message" name="cp_message" rows="10" cols="100%"><?php echo $cp_message ;?></textarea><br/>
									<input type="submit" id="submit" name="submit" value="Send Message" />		
								</fieldset>
							</form>
						</div>
					<?php
					} else {
						$displayName_array	= explode(" ",$cp_name);
						$displayName = htmlentities(utf8_decode($displayName_array[0]));
			
						$header  = "MIME-Version: 1.0\n";
						$header .= "Content-Type: text/plain; charset=\"utf-8\"\n";
						$header .= "From:" . encodeMailHeader($cp_name) . "<" . $cp_email . ">\n";
						$email_subject	= "[" . get_settings('blogname') . "] " . encodeMailHeader($cp_name);
						$email_text		= "From......: " . $cp_name . "\n" .
							  "Email.....: " . $cp_email . "\n" .
							  "Url.......: " . $cp_url . "\n\n" .
							  $cp_message;

						if (@mail(get_settings('admin_email'), $email_subject, $email_text, $header)) {
							echo "<h2>Hey " . $displayName . ",</h2><p>thanks for your message! I'll get back to you as soon as possible.</p>";
						}
					}
					?>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
  <?php get_sidebar();?>
  <?php get_footer();?>