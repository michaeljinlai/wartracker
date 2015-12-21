<?php require($_SERVER['DOCUMENT_ROOT']."/clashofclans/Elements/usebootstrap2.3.2.php"); ?>

<!-- <form action="change.php" method="POST">
E-mail Address: <input type="text" name="email" size="20" /> <input type="submit" name="ForgotPassword" value=" Request Reset " />
</form> -->

<body>
    <div class="container">
        <div class="span10 offset1">
            <div class="row">
                <h3>Forgot Password</h3>
            </div>
            <form class="form-horizontal" action="change.php" method="post"> 
                
                <!-- Email -->                
                <label class="control-label">Email</label>
                <div class="controls">
                    <input name="email" type="text" placeholder="Email">
                </div>
                
                <div class="form-actions">
                    <button type="submit" name="ForgotPassword" class="btn btn-success">Request Reset</button>
                </div>
            </form>
        </div>
    </div>
</body>