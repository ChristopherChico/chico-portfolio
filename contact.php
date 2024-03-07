<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$EMAIL = "";

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && isset($_SESSION['EMAIL'])) {
    $EMAIL = $_SESSION['EMAIL'];
    $userLoggedIn = true;
	$userEmail = $_SESSION['EMAIL'];
	
} else {
    $userLoggedIn = false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $userLoggedIn == "true") {
    $subject = $_POST["subject"];
    $message = $_POST["message"];
	$userEmail = $_SESSION['EMAIL'];

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'formalchico@gmail.com';
        $mail->Password   = 'jddvkdkjsffvyqgr';
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom('formalchico@gmail.com');
        $mail->addAddress($userEmail); 

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "This is a message by $userEmail <br>The Message:<br> $message";

        // Send email
        $mail->send();

        // Display success message
        echo "<div class='alert alert-success'>Your Message Was Successfully Sent!</div>";
        echo '<script>
              setTimeout(function(){
                  $(".alert").fadeOut();
                  }, 2000);
            </script>';
    } catch (Exception $e) {
        // Display error message
        echo "<div class='alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
        echo '<script>
              setTimeout(function(){
                  $(".alert").fadeOut();
                  }, 2000);
            </script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Information</title>
	<link rel="icon" type="image/x-icon" href="/Images/contact.png">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.3/components/contacts/contact-1/assets/css/contact-1.css"/>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="CSS/contactstyle.css" rel="stylesheet"/> 
	<link href="CSS/button.css" rel="stylesheet"/>
	<link href="CSS/Style.css" rel="stylesheet" />

    <style>

body {
      font-family: Arial, sans-serif !important;
      padding: 10px !important;
      background-color: #9AD0C2;
      color: #333;
}

.alert {
	background-color: white;
	color: black;
    border: 0ch;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 50px;
    left: 50%;
    transform: translateX(-50%);
}

h1 {
   font-family: 'Bebas', sans-serif !important;
   color: black;
   font-size: 80px !important;
   display: inline-block;
   margin-left: 60px;
}


h2 {
  font-family: 'Bebas', sans-serif;
  line-height: 1;
  color: white;
  text-align: left;
  font-size: 50px;
}

h6 {
  font-family: 'Bebas', sans-serif;
  line-height: 1;
  color: white;
  text-align: center;
  font-size: 30px;
  margin-top: 80px;
  margin-bottom: 30px;
}

h3 {
	color: white;
}

#h3c {
	font-family: 'Bebas', sans-serif;
	font-size: 40px;

}
      
    </style>
</head>
<body>
  <header>

    <h1>My Contact</h1>
    
    <button style="color: gold" id="nav" onclick="goBack()">Home</button>

    <button id="nav" onclick="skillFunction()">Skills</button>

    <button id="nav" onclick="aboutFunction()">About Me</button>

    <button id="nav" onclick="getRandomQuote()">Free Quote</button>
 
</header>

  <section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center" style="margin-top: -100px;">
				<div class="col-lg-10 col-md-12">
					<div class="wrapper">
						<div class="row no-gutters">
							<div class="col-md-7 d-flex align-items-stretch">
								<div class="contact-wrap w-100 p-md-5 p-" style="background-color: #ECF4D6;"> 
									<h3 class="mb-4" id="h3c" style="color: black;">Feedback On Me Website</h3>
									<div id="form-message-warning" class="mb-4"></div> 
				      		<div id="form-message-success" class="mb-4">
				            Your message was sent, thank you!
				      		</div> 
									<form method="POST" id="contactForm" name="contactForm">
									<div class="form-group">
                        				<label for="userEmail">Your Email Address:</label>
                        				<input type="text" class="form-control" id="userEmail" value="<?php echo isset($userEmail) ? $userEmail : ''; ?>" placeholder="Not Login Yet" readonly>
                    				</div>
            
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<textarea name="message" class="form-control" id="message" cols="30" rows="7" placeholder="Message"></textarea>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<input type="submit" value="Send Message" class="btn" id="submit">
													<div class="submitting"></div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="col-md-5 d-flex align-items-stretch">
								<div class="info-wrap w-100 p-lg-5 p-4"  id="side-panel">
									<h3 class="mb-4 mt-md-4" id="h3c">Contact Me</h3>
				        	<div class="dbox w-100 d-flex align-items-start">
				        		<div class="align-items-center justify-content-center">
				        		</div>
				        		<div class="text pl-3">
					          </div>
				          </div>
				        	<div class="dbox w-100 d-flex align-items-center">
				        		<div class="icon d-flex align-items-center justify-content-center">
				        			<span class="fa fa-phone"></span>
				        		</div>
				        		<div class="text pl-3">
					            <p><span>Phone:</span> <a href="tel://1234567920">09937909553</a></p>
					          </div>
				          </div>
						  
				        	<div class="dbox w-100 d-flex align-items-center">
				        		<div class="icon d-flex align-items-center justify-content-center">
				        			<span class="fa fa-paper-plane"></span>
				        		</div>
				        		<div class="text pl-3">
					            <p><span>Email:</span> <a href="mailto:formalchico@gmail.com">formalchico@gmail.com</a></p>
					          </div>
				          </div>
						  <div>
					            <h6>	--Login/Register To Send A-- Message</h6>
							<button class="button-38" role="button" style="margin-left: 22px;" onclick="location.href='login.php'">Login</button>
							<button class="button-38" role="button" onclick="location.href='register.php'">Register</button>
							<button class="button-38" role="button" onclick="location.href='logout.php'">Log Out</button>
						  </div>
				          </div>
			          </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


    
<script src="JS/javascript.js"></script>
<script src="js/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>
</html>