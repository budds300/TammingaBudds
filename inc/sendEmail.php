<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

include '../src/Exception.php';
include '../src/PHPMailer.php';
include '../src/SMTP.php';

// Replace this with your own email address
$siteOwnersEmail = 'tammingagivondo@gmail.com';


if($_POST) {
	
	$name = trim(stripslashes($_POST['contactName']));
	$email = trim(stripslashes($_POST['contactEmail']));
	$subject = trim(stripslashes($_POST['contactSubject']));
	$contact_message = trim(stripslashes($_POST['contactMessage']));
	$error=''; 
   // Check Name
	if (strlen($name) < 2) {
		$error = "Please enter your name.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error = "Please enter a valid email address.";
	}
	// Check Message
	if (strlen($contact_message) < 15) {
		$error = "Please enter your message. It should have at least 15 characters.";
	}
   // Subject
	if ($subject == '') { $subject = "Contact Form Submission"; }


//    Set Message
	$message = "Email from: " . $name . "<br />";
	$message .= "Email address: " . $email . "<br />";
	$message .= "Message: <br />";
	$message .= $contact_message;
	$message .= "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

   // Set From: header
   $from =  $name . " <" . $email . ">";

//    Email Headers
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
 	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$mail =new PHPMailer(true);
	$mail ->isSMTP();
	$mail->SMTPAuth=true;
	$mail->SMTPSecure = 'ssl';
	$mail->SMTPAutoTLS = false;
	$mail->Host = 'smtp.gmail.com';
	$mail->Username=$siteOwnersEmail;
	$mail->Password="hoglpbjcrqizecwu";
	$mail->SMTPKeepAlive = true; 
	$mail->Port="465";
	$mail->isHTML(true);
	$mail->SetFrom($email);
	$mail->addAddress($siteOwnersEmail);
	$mail->Subject=$subject;
	$mail->Body=$message;

	$mail->SMTPDebug;

   if ($error =="" ) {

      ini_set("sendmail_from", $siteOwnersEmail); // for windows server
	  $mail->send();
    //   $mail = mail($siteOwnersEmail, $subject, $message, $headers);

		if ($mail) { echo "OK"; }
      else { echo "Something went wrong. Please try again."; }
		
	} # end if - no validation error

	else {
// 
		$response = (isset($error['message'])) ? $error['message'] . "<br />n\n" : null;
		$response .= (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> <br /> \n" : null;
		
		echo $error;

	} # end if - there was a validation error

}

?>