<?php require($_SERVER['DOCUMENT_ROOT']."/clashofclans/Elements/usebootstrap2.3.2.php");?>
<?php echo '
<body>
	<div class="container">
		<div class="span10 offset1">
			<div class="row">
			<h3>Reset Password</h3>
			</div>
			<form class="form-horizontal" action="reset.php" method="POST">
				<div class="control-group">
					<label class="control-label">Email</label>
					<div class="controls">
						<input type="text" name="email" placeholder="Please enter your account email">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Password</label>
					<div class="controls">
						<input type="password" name="password" placeholder="Password">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Confirm Password</label>
					<div class="controls">
						<input type="password" name="confirmpassword" placeholder="Confirm Password">
					</div>
				</div>
				<input type="hidden" name="q" value="';
				if (isset($_GET["q"])) {
					echo $_GET["q"];
				}
					echo '" />
				<div class="form-actions">
					<button type="submit" name="ResetPasswordForm" class="btn btn-success">Reset Password</button>
				</div>
			</form>
		</div>
	</div>
</body>';

?>

