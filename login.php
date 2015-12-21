<?php 

    // First we execute our common code to connection to the database and start the session 
    require($_SERVER['DOCUMENT_ROOT']."/clashofclans/database.php"); 

    $test = $_SERVER['DOCUMENT_ROOT']."/clashofclans/";
     
    // This variable will be used to re-display the user's username to them in the 
    // login form if they fail to enter the correct password.  It is initialized here 
    // to an empty value, which will be shown if the user has not submitted the form. 
    $submitted_username = ''; 
     
    // This if statement checks to determine whether the login form has been submitted 
    // If it has, then the login code is run, otherwise the form is displayed 
    if(!empty($_POST)) { 

        // keep track of incorrect username and password
        $error = null;

        // This query retreives the user's information from the database using 
        // their username. 
        $query = " 
            SELECT 
                id, 
                username, 
                password, 
                salt,
                privilege, 
                email 
            FROM users 
            WHERE 
                username = :username 
        "; 
         
        // The parameter values 
        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
         
        try { 
            // Execute the query against the database 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // This variable tells us whether the user has successfully logged in or not. 
        // We initialize it to false, assuming they have not. 
        // If we determine that they have entered the right details, then we switch it to true. 
        $login_ok = false; 
         
        // Retrieve the user data from the database.  If $row is false, then the username 
        // they entered is not registered. 
        $row = $stmt->fetch(); 
        if($row) { 
            // Using the password submitted by the user and the salt stored in the database, 
            // we now check to see whether the passwords match by hashing the submitted password 
            // and comparing it to the hashed version already stored in the database. 
            $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
            for($round = 0; $round < 65536; $round++) { 
                $check_password = hash('sha256', $check_password . $row['salt']); 
            } 
             
            if($check_password === $row['password']) { 
                // If they do, then we flip this to true 
                $login_ok = true; 
            } 
        } 
         
        // If the user logged in successfully, then we send them to the private members-only page 
        // Otherwise, we display a login failed message and show the login form again 
        if($login_ok) { 
            // Here I am preparing to store the $row array into the $_SESSION by 
            // removing the salt and password values from it.  Although $_SESSION is 
            // stored on the server-side, there is no reason to store sensitive values 
            // in it unless you have to.  Thus, it is best practice to remove these 
            // sensitive values first. 
            unset($row['salt']); 
            unset($row['password']); 
             
            // This stores the user's data into the session at the index 'user'. 
            // We will check this index on the private members-only page to determine whether 
            // or not the user is logged in.  We can also use it to retrieve 
            // the user's details. 
            $_SESSION['user'] = $row; 
            
            if($_SESSION['user']['privilege'] === 'administrator') {
	            // Redirect the user if they are an administrator.  <-- need to add field to users table for administrator 
	            header("Location: ./"); 
	            die("Redirecting to: index.php"); 
            }
            else {
	            // Redirect the user if they are a normal user. 
	            header("Location: ./"); 
	            die("Redirecting to: index.php"); 
            }
        } 
        else { 
            // Tell the user they failed 
            //print("Login Failed."); 
            $error = "Incorrect Username/Password";
             
            // Show them their username again so all they have to do is enter a new 
            // password.  The use of htmlentities prevents XSS attacks.  You should 
            // always use htmlentities on user submitted values before displaying them 
            // to any users (including the user that submitted them).  For more information: 
            // http://en.wikipedia.org/wiki/XSS_attack 
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8'); 
        } 
    } 
     
?> 

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap css -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">

    <title>Login</title>
</head>

<body>

<div class="container">

    <form class="form-signin" action="login.php" method="post">

        <!-- Sign in heading -->
        <h2 class="form-signin-heading">Login</h2>

        <!-- Username -->
        <label for="inputUsername" class="sr-only">Username</label>
        <!-- Show error message upon wrong user details -->
        <?php 
            if (!empty($error)) {
                echo $error;
            }
        ?>
        <input name="username" type="text" id="inputUsername" class="form-control" value="<?php echo $submitted_username; ?>" placeholder="Username" autofocus>

        <!-- Password -->
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" value="">

        <!-- Container for 'Sign Up' and 'Forgot Password' -->
        <!-- Hidden because the buttons below are better -->
        <div class="login-help hide">

            <!-- Sign Up -->
            <label>
                <a href="register">Sign Up</a>
            </label>

            <!-- Forgot Password (with inline style to make it float right) -->
            <label style="float:right;">
                <a href="forgot_password">Forgot Password</a>
            </label>

        </div>

        <!-- Sign in button -->
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <div class="btn-group btn-block btn-group-justified">
        <a class="btn btn-info" href="register">Register</a>
        <a class="btn btn-info" href="forgot_password">Forgot Password</a>
        </div>

        <div class="login-back">
            <label>
                <a href="./">Back</a>
            </label>    
        </div>

    </form>


</div> <!-- /container -->

</body>

<!-- Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-70397779-1', 'auto');
  ga('send', 'pageview');

</script>