<?php 

	$url = 'index.php'; 

	if (!empty($_GET['url'])) {
		$url = $_GET['url'];
	}

?>

<head>
    <meta charset="utf-8" http-equiv="refresh" content="3;url='<?php echo $url; ?>'">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<br>

<div class="container">
    <div class="alert <?php echo 'alert-'.$_GET['class']; ?>">
        <strong><?php echo ucfirst($_GET['class']); ?>!</strong> <?php echo $_GET['message']; ?>
    </div>
</div>