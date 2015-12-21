<?php

require($_SERVER['DOCUMENT_ROOT']."/clashofclans/database.php");

// Was the form submitted?
if (isset($_POST["ForgotPassword"])) {
	
	// Harvest submitted e-mail address
	if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		$email = $_POST["email"];
		
	}else{
		require($_SERVER['DOCUMENT_ROOT']."/clashofclans/Elements/usebootstrap2.3.2.php");
		echo   '<body>
				    <div class="container">
				        <div class="span10 offset1">
				            <div class="row">
				                <h3>Forgot Password</h3>
				            </div>
				            <form class="form-horizontal"> 
					            Entered email is invalid.  
					            <div class="form-actions">
					                <a class="btn" href="forgot_password">Try Again</a>
					            </div>
					        </form    
				        </div>
				    </div>
				</body>';
		exit;
	}

	// Check to see if a user exists with this e-mail
	$query = $db->prepare('SELECT email FROM users WHERE email = :email');
	$query->bindParam(':email', $email);
	$query->execute();
	$userExists = $query->fetch(PDO::FETCH_ASSOC);
	$db = null;
	
	if ($userExists["email"])
	{
		// Create a unique salt. This will never leave PHP unencrypted.
		$salt = "498#2D83B631%3800EBD!801600D*7E3CC13";

		// Create the unique user password reset key
		$dbpassword = hash('sha512', $salt.$userExists["email"]);

		// Create a url which we will direct them to reset their password
		$pwrurl = "clashofclans.mikelai.org/reset_password.php?q=".$dbpassword;
		
		// Mail them their key
		$mailbody = "Dear user,\n\nIf this e-mail does not apply to you please ignore it. It appears that you have requested a password reset at our website clashofclans.mikelai.org\n\nTo reset your password, please click the link below. If you cannot click it, please paste it into your web browser's address bar.\n\n" . $pwrurl . "\n\nThanks,\nThe Administration";
		mail($userExists["email"], "clashofclans.mikelai.org - Password Reset", $mailbody);
		
		require($_SERVER['DOCUMENT_ROOT']."/clashofclans/Elements/usebootstrap2.3.2.php");
		echo   '<body>
				    <div class="container">
				        <div class="span10 offset1">
				            <div class="row">
				                <h3>Forgot Password</h3>
				            </div>
				            <form class="form-horizontal"> 
					            Your password recovery key has been sent to your email.  
					            <div class="form-actions">
					                <a class="btn" href="login">Back to Login</a>
					            </div>
					        </form    
				        </div>
				    </div>
				</body>';		
	}
	else {
		require($_SERVER['DOCUMENT_ROOT']."/clashofclans/Elements/usebootstrap2.3.2.php");
		echo   '<body>
				    <div class="container">
				        <div class="span10 offset1">
				            <div class="row">
				                <h3>Forgot Password</h3>
				            </div>
				            <form class="form-horizontal"> 
					            Email does not exist.  
					            <div class="form-actions">
					                <a class="btn" href="forgot_password">Try Again</a>
					            </div>
					        </form    
				        </div>
				    </div>
				</body>';
		exit;
	}
}
?>