<!-- Deler av php kode er lånt fra denne nettsiden:http://www.dreamweavertutorial.co.uk/dreamweaver/video/contact-form-php-validation.htm-->

<?php

// Set email variables
$email_to = 'sorlandsstudenten@gmail.com';
$email_subject = 'Form submission';
// Set required fields
$required_fields = array('fullname','email','comment');
// set error messages
$error_messages = array(
	'fullname' => 'Please enter a Name to proceed.',
	'email' => 'Please enter a valid Email Address to continue.',
	'comment' => 'Please enter your Message to continue.'
);
// Set form status
$form_complete = FALSE;
// configure validation array
$validation = array();
// check form submittal
if(!empty($_POST)) {
	// Sanitise POST array
	foreach($_POST as $key => $value) $_POST[$key] = remove_email_injection(trim($value));
	// Loop into required fields and make sure they match our needs
	foreach($required_fields as $field) {		
		// the field has been submitted?
		if(!array_key_exists($field, $_POST)) array_push($validation, $field);
		// check there is information in the field?
		if($_POST[$field] == '') array_push($validation, $field);
		// validate the email address supplied
		if($field == 'email') if(!validate_email_address($_POST[$field])) array_push($validation, $field);
	}
	// basic validation result
	if(count($validation) == 0) {
		// Prepare our content string
		$email_content = 'Ny kommentar: ' . "\n\n";
		// simple email content
		foreach($_POST as $key => $value) {
			if($key != 'submit') $email_content .= $key . ': ' . $value . "\n";
		}
		// if validation passed ok then send the email
		mail($email_to, $email_subject, $email_content);
		// Update form switch
		$form_complete = TRUE;
	}
}
function validate_email_address($email = FALSE) {
	return (preg_match('/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i', $email))? TRUE : FALSE;
}
function remove_email_injection($field = FALSE) {
   return (str_ireplace(array("\r", "\n", "%0a", "%0d", "Content-Type:", "bcc:","to:","cc:"), '', $field));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Sørlandsstudenten: Kontakt</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/component.css" />
	<script src="js/modernizr.custom.js"></script>	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/mootools/1.3.0/mootools-yui-compressed.js"></script>	
    <script type="text/javascript" src="js/validation.js"></script>
	<script type="text/javascript">
    
    var nameError = '<?php echo $error_messages['fullname']; ?>';
	var emailError = '<?php echo $error_messages['email']; ?>';
	var commentError = '<?php echo $error_messages['comment']; ?>';

    function MM_preloadImages() { //v3.0
    var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

    </script>
    
</head>
<body>
	<section class="banner">
		<div class="topbanner">
    	<a href="http://sorlandsstudenten.net/"><img src="images/logo.png" alt="TEAM AWESOME"></a>
		</div>
		<div class="information">
			<h1>Sørlandsstudenten</h1>
			<p>- For studenter, av studenter</p>
		</div>
	</section>
    
	<header class="mainheader">
		<nav>
			<ul>
				<li><a href="index.html">Hjem</a></li>
				<li><a href="events.html">Events</a></li>
				<li><a href="galleri.html">Galleri</a></li>
				<li class="active"><a href="kontakt.php">Kontakt</a></li>
                <li><a href="om-oss.html">Om oss</a></li>
			</ul>
		</nav>
	</header>

	<div class="maincontent">
		<div class="content">
			<div class="content-left">	
				<article class="leftcontent">
					<header>
						<h2>Spørsmål?</h2>
						<p> Ta kontakt med oss via facebook, twitter eller mail hvis det er noe dere lurer på.</p>
						<ul>
						  <li> UiA, Kristiansand 4686 Norge</li>
						  <li> Telefon: +47 951 62 760</li>
						  <li> E-post: sorlandsstudenten@gmail.com</li>
					  	</ul>
						<p><br>
					  	</p>
					</header>
					</content>
				</article>

			<div class="content-right" onfocus="MM_preloadImages('images/x.png')">
				<article class="rightcontentmail">
					<header>
						<h2>Kontakt oss via mail</h2>
					</header>
                    <div class="understrekkontakt"></div>

                    <div id="form">
                    <?php if($form_complete === FALSE): ?>
                    <form action="kontakt.php" method="post" id="comments_form">
                    
                    <div class="row">
                    <div class="label">Ditt navn</div>
                    <div class="input">

                    <input type="text" id="fullname" class="detail" name="fullname" value="<?php echo isset($_POST['fullname'])? $_POST['fullname'] : ''; ?>" /><?php if(in_array('fullname', $validation)): ?><span class="error"><?php echo $error_messages['fullname']; ?></span><?php endif; ?>
                    </div>
                    </div>

                    <div class="row">
                    <div class="label">Din e-post</div>
                    <div class="input">
                    <input type="text" id="email" class="detail" name="email" value="<?php echo isset($_POST['email'])? $_POST['email'] : ''; ?>" /><?php if(in_array('email', $validation)): ?><span class="error"><?php echo $error_messages['email']; ?></span><?php endif; ?>

                    </div>
                    <div class="context">Slapp av, vi vil ikke publisere meldingen!</div>
                    </div>

                    <div class="row">
                    <div class="label">Skriv her</div>
                    <div class="input">
                    <textarea id="comment" name="comment" class="mess"><?php echo isset($_POST['comment'])? $_POST['comment'] : ''; ?></textarea><?php if(in_array('comment', $validation)): ?><span class="error"><?php echo $error_messages['comment']; ?></span><?php endif; ?>

                    </div>
                    </div>
                    <div class="submit">
                    <input type="submit" id="submit" name="submit" value="Send" />
						</div>

                        </form>
                        <?php else: ?>
                        <p>Takk for din melding!</p>
                        <?php endif; ?>
                        </div>
                        </div>
                        </div>
					</div>
				</div>
			</div>
		</div>

		<div class="maincontent map">
        <iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.no/maps?f=q&amp;source=s_q&amp;hl=no&amp;geocode=&amp;q=University+of+Agder,+Gimlemoen,+Kristiansand&amp;aq=0&amp;oq=uni&amp;sll=58.163369,8.003476&amp;sspn=0.005031,0.016512&amp;ie=UTF8&amp;hq=&amp;hnear=Gimlemoen,+4630,+Kristiansand,+Vest-Agder&amp;ll=58.163518,8.003849&amp;spn=0.005031,0.016512&amp;t=m&amp;z=14&amp;output=embed"></iframe>

		</div>
	</div>
	<footer class="mainfooter">
		<p>Copyright &copy; 2013 <a href="https://www.facebook.com/sorlandsstudenten">Team Awesome</a></p>
	</footer>

</body>
</html>