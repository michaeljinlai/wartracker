<?php 

    // First we execute our common code to connection to the database and start the session 
    require($_SERVER['DOCUMENT_ROOT']."/clashofclans/database.php"); 
     
    // This if statement checks to determine whether the registration form has been submitted 
    // If it has, then the registration code is run, otherwise the form is displayed 
    if(!empty($_POST)) {   

        // Google ReCaptcha
        // https://www.google.com/recaptcha/admin#site/319847548?setup
        // Honestly I have no idea what this code really does, but it's what makes Google's recaptcha function work
        $secret = "6Ld8fBATAAAAAIWPaXH74AjV0YC7nn60qHB4eCwZ";
        $ip = $_SERVER['REMOTE_ADDR'];
        $captcha = $_POST['g-recaptcha-response'];
        $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip$ip");
        $arr = json_decode($rsp, TRUE);

        $captchasuccess = false;

        if ($arr['success']) {
            $captchasuccess = true;
        }
        // END GOOGLE RECAPTCHA

        // keep track validation errors
        $usernameError = null;
        $emailError = null;
        $passwordError = null;
        $confirmPasswordError = null;

        // keep track post values
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        $valid = true;

        // Ensure that the user has entered a non-empty username 
        if(empty($_POST['username'])) { 
            // Note that die() is generally a terrible way of handling user errors 
            // like this.  It is much better to display the error with the form 
            // and allow the user to correct their mistake.  However, that is an 
            // exercise for you to implement yourself. 
            //die("Please enter a username."); 

            $usernameError = 'Please enter a username';
            $valid = false;
        }

        // Ensure that the password is at least 6 characters long 
        if(strlen($_POST['password']) < 6) { 
            $passwordError = 'Password needs to be at least 6 characters';
            $confirmPasswordError = 'Password needs to be at least 6 characters';
            $valid = false;
        }        
         
        // Ensure that the user has entered a non-empty password 
        if(empty($_POST['password'])) { 
            //die("Please enter a password."); 

            $passwordError = 'Please enter a password';
            $valid = false;
        } 

        // Ensure that the user has captcha 
        if($captchasuccess == false) { 
            $captchaError = 'Please verify the captcha';
            $valid = false;
        } 

        // Ensure that the user has entered a non-empty confirm password 
        if(empty($_POST['confirmPassword'])) { 
            $confirmPasswordError = 'Please enter a confirm password';
            $valid = false;
        } 

        // Ensure that the fields password and confirm password mathes
        if(!($_POST["password"] == $_POST["confirmPassword"])) { 
            $confirmPasswordError = 'Passwords do not match';
            $passwordError = 'Passwords do not match';
            $valid = false;
        } 
         
        // Make sure the user entered a valid E-Mail address 
        // filter_var is a useful PHP function for validating form input, see: 
        // http://us.php.net/manual/en/function.filter-var.php 
        // http://us.php.net/manual/en/filter.filters.php 
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) { 
            //die("Invalid E-Mail Address"); 

            $emailError = 'Please enter a valid email address';
            $valid = false;
        } 
         
        // We will use this SQL query to see whether the username entered by the 
        // user is already in use.  A SELECT query is used to retrieve data from the database. 
        // :username is a special token, we will substitute a real value in its place when 
        // we execute the query. 
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                username = :username 
        "; 
         
        // This contains the definitions for any special tokens that we place in 
        // our SQL query.  In this case, we are defining a value for the token 
        // :username.  It is possible to insert $_POST['username'] directly into 
        // your $query string; however doing so is very insecure and opens your 
        // code up to SQL injection exploits.  Using tokens prevents this. 
        // For more information on SQL injections, see Wikipedia: 
        // http://en.wikipedia.org/wiki/SQL_Injection 
        $query_params = array( 
            ':username' => $_POST['username'] 
        ); 
         
        try { 
            // These two statements run the query against your database table. 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        // The fetch() method returns an array representing the "next" row from 
        // the selected results, or false if there are no more rows to fetch. 
        $row = $stmt->fetch(); 
         
        // If a row was returned, then we know a matching username was found in 
        // the database already and we should not allow the user to continue. 
        if($row) { 
            //die("This username is already in use"); 

            $usernameError = 'This username is already in use';
            $valid = false;
        } 
         
        // Now we perform the same type of check for the email address, in order 
        // to ensure that it is unique. 
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                email = :email 
        "; 
         
        $query_params = array( 
            ':email' => $_POST['email'] 
        ); 
         
        try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) { 
            //die("This email address is already registered"); 
            $emailError = 'This email address is already registered';
            $valid = false;
        } 
         
        if($valid && $captchasuccess) {

            // An INSERT query is used to add new rows to a database table. 
            // Again, we are using special tokens (technically called parameters) to 
            // protect against SQL injection attacks. 
            $query = " 
                INSERT INTO users ( 
                    username, 
                    password, 
                    salt, 
                    email 
                ) VALUES ( 
                    :username, 
                    :password, 
                    :salt, 
                    :email 
                ) 
            "; 
             
            // A salt is randomly generated here to protect again brute force attacks 
            // and rainbow table attacks.  The following statement generates a hex 
            // representation of an 8 byte salt.  Representing this in hex provides 
            // no additional security, but makes it easier for humans to read. 
            // For more information: 
            // http://en.wikipedia.org/wiki/Salt_%28cryptography%29 
            // http://en.wikipedia.org/wiki/Brute-force_attack 
            // http://en.wikipedia.org/wiki/Rainbow_table 
            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
             
            // This hashes the password with the salt so that it can be stored securely 
            // in your database.  The output of this next statement is a 64 byte hex 
            // string representing the 32 byte sha256 hash of the password.  The original 
            // password cannot be recovered from the hash.  For more information: 
            // http://en.wikipedia.org/wiki/Cryptographic_hash_function 
            $password = hash('sha256', $_POST['password'] . $salt); 
             
            // Next we hash the hash value 65536 more times.  The purpose of this is to 
            // protect against brute force attacks.  Now an attacker must compute the hash 65537 
            // times for each guess they make against a password, whereas if the password 
            // were hashed only once the attacker would have been able to make 65537 different  
            // guesses in the same amount of time instead of only one. 
            for($round = 0; $round < 65536; $round++) { 
                $password = hash('sha256', $password . $salt); 
            } 
             
            // Here we prepare our tokens for insertion into the SQL query.  We do not 
            // store the original password; only the hashed version of it.  We do store 
            // the salt (in its plaintext form; this is not a security risk). 
            $query_params = array( 
                ':username' => $_POST['username'], 
                ':password' => $password, 
                ':salt' => $salt, 
                ':email' => $_POST['email'] 
            ); 
             
            try { 
                // Execute the query to create the user 
                $stmt = $db->prepare($query); 
                $result = $stmt->execute($query_params); 
            } 
            catch(PDOException $ex) { 
                // Note: On a production website, you should not output $ex->getMessage(). 
                // It may provide an attacker with helpful information about your code.  
                die("Failed to run query: " . $ex->getMessage()); 
            } 

            // This redirects the user back to the login page after they register 
            header("Location: redirect.php?class=success&message=Please wait to be redirected&url=login.php"); 
             
            // Calling die or exit after performing a redirect using the header function 
            // is critical.  The rest of your PHP script will continue to execute and 
            // will be sent to the user if you do not die or exit. 
            die(); 

        }
    } 

?> 

<?php require($_SERVER['DOCUMENT_ROOT']."/clashofclans/Elements/usebootstrap2.3.2.php"); ?>
<head>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
    <div class="container">
        <div class="span10 offset1">
            <div class="row">
                <h3>Register</h3>
            </div>
            <form id="myform" class="form-horizontal" action="register.php" method="post"> 
                <!-- Username -->
                <div class="control-group <?php echo !empty($usernameError)?'error':'';?>">
                    <label class="control-label">Username</label>
                    <div class="controls">
                        <input name="username" type="text"  placeholder="Username" value="<?php echo !empty($username)?$username:'';?>">
                        <?php if (!empty($usernameError)): ?>
                            <span class="help-inline"><?php echo $usernameError;?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Email -->
                <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                    <label class="control-label">Email</label>
                    <div class="controls">
                        <input name="email" type="text"  placeholder="Email" value="<?php echo !empty($email)?$email:'';?>">
                        <?php if (!empty($emailError)): ?>
                            <span class="help-inline"><?php echo $emailError;?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Password -->
                <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
                    <label class="control-label">Password</label>
                    <div class="controls">
                        <input name="password" type="password"  placeholder="Password" value="<?php echo !empty($password)?$password:'';?>">
                        <?php if (!empty($passwordError)): ?>
                            <span class="help-inline"><?php echo $passwordError;?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Confirm Password -->
                <div class="control-group <?php echo !empty($confirmPasswordError)?'error':'';?>">
                    <label class="control-label">Confirm Password</label>
                    <div class="controls">
                        <input name="confirmPassword" type="password"  placeholder="Confirm Password" value="<?php echo !empty($confirmPassword)?$confirmPassword:'';?>">
                        <?php if (!empty($confirmPasswordError)): ?>
                            <span class="help-inline"><?php echo $confirmPasswordError;?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="control-group <?php echo !empty($captchaError)?'error':'';?>">
                    <div class="controls">
                        <div class="g-recaptcha" data-sitekey="6Ld8fBATAAAAAA_N9OVBzUq_TFkcjQeKa1iiBjJx" data-callback="enableBtn"></div>
                        <?php if (!empty($captchaError)): ?>
                            <span class="help-inline"><?php echo $captchaError;?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-actions">
                    <button id="register" type="submit" class="btn btn-success">Register</button>
                    <a class="btn" href="login">Back</a>
                </div>
            </form>
        </div>
    </div>
</body>