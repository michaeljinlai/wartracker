<?php

require($_SERVER['DOCUMENT_ROOT']."/clashofclans/database.php");
    
// Was the form submitted?
if (isset($_POST["ResetPasswordForm"])) {
	// Gather the post data
	$email = $_POST["email"];
	$dbpassword = $_POST["password"];
	$confirmpassword = $_POST["confirmpassword"];
	$hash = $_POST["q"];

	// Use the same salt from the forgot_password.php file
	$resetsalt = "498#2D83B631%3800EBD!801600D*7E3CC13";

	// Generate the reset key
	$resetkey = hash('sha512', $resetsalt.$email);

	// Does the new reset key match the old one?
	if ($resetkey == $hash) {
		if ($dbpassword == $confirmpassword)
		{
			$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
			$password = hash('sha256', $_POST['password'] . $salt);
            for($round = 0; $round < 65536; $round++) 
            { 
                $password = hash('sha256', $password . $salt); 
            } 

			// Update the user's password
				$query = $db->prepare('UPDATE users SET password = :password, salt = :salt WHERE email = :email');
				$query->bindParam(':password', $password);
				$query->bindParam(':salt', $salt);
				$query->bindParam(':email', $email);
				$query->execute();
				$db = null;
			echo "Your password has been successfully reset.";
		}
		else
			echo "Your passwords do not match.";
	}
	else {
		echo "Your password reset key is invalid.";
	}
}

?>

