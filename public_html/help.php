<!DOCTYPE html>
<html lang="en">
<title>Restaurant Admin</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">	
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<body>

<?php

include 'r_header.php';
$msg = "";
use PHPMailer\PHPMailer\PHPMailer;

    require_once 'phpmailer/Exception.php';
    require_once 'phpmailer/PHPMailer.php';
    require_once 'phpmailer/SMTP.php';

    $mail = new PHPMailer(true);
    $alert ='';

if (isset($_POST['submitted'])) {
	$msg = "Your message has been submitted successfully!";

if(isset($_POST['submitted'])){
    $title = $_POST['title'];
    $desc = $_POST['desc'];

    try{
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'jowyn2002@gmail.com'; // Gmail address which you want to use as SMTP server
      $mail->Password = 'pohonjjfspoeqlwo'; // Gmail address Password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = '587';

      $mail->setFrom('jowyn2002@gmail.com'); // Gmail address which you used as SMTP server
      $mail->addAddress('jowyn2002@gmail.com'); // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)

      $mail->isHTML(true);
      $mail->Subject = 'Message Received';
      $mail->Body = '<h3>Title: ' .$title. '<br>Description: ' .$desc. '</h3>';

      $mail->send();
      $alert = '<div class="alert-success">
                  <span>Message Sent! Thank you for contacting us.</span>
              </div>';
  }
  catch (Exception $e){
      $alert = '<div class="alert-error">
                  <span>'.$e->getMessage().'</span>
              </div>';
  }
    }


}

?>

<!-- !PAGE CONTENT! -->
<div class="w3-main col-sm-10 mx-auto">

<!-- Contact -->
    <h1 class="w3-xxxlarge" style="margin-top:15px"><b>Contact us Now</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
	<?php echo '<b>' .$msg . '</b>'; ?>
	<br/><br/>
    <p>Facing problems with our system? Drop us an email after filling the form below.</p>
    <form action="help.php" method="post">
      <div class="w3-section">
        <label>Title</label>
        <input class="w3-input w3-border" type="text" name="title" required>
      </div>
	  
      <div class="w3-section">
        <label>Description</label><br>
        <textarea rows="5" cols="100" name="desc" required></textarea>
      </div>
	  
	  <input type="submit" class="btn" style="background-color: #b5c1e6;" value="Submit">
	<input type="hidden" name="submitted" value="true">

    </form>  
  </div>
  
</body>
</html>