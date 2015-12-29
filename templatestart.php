<?php require($_SERVER['DOCUMENT_ROOT']."/wartracker/database.php"); ?>

<?php 
    if(empty($_SESSION['user'])) 
    { 
        header("Location: login"); 
        die("Redirecting to login"); 
    } 

	function locationChecker($location) {
		preg_match("/[^\/]+$/", $_SERVER['REQUEST_URI'], $matches);
		$last_word = $matches[0];
		if ($location === $last_word) {
			echo 'active';
		}	
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="http://localhost/wartracker/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="http://localhost/wartracker/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://localhost/wartracker/css/fonts.css" rel="stylesheet">
    <link href="http://localhost/wartracker/css/custom.css" rel="stylesheet">
    <link href="http://localhost/wartracker/css/font-awesome.min.css" rel="stylesheet">
  </head>

  <body>

    <div class="col-sm-3 col-md-2 sidebar" id="sidebar-open">
      <ul class="nav nav-sidebar">
        <li class="<?php locationChecker('dashboard'); ?>"><a href="http://localhost/wartracker/dashboard">Dashboard</a></li>
        <li class="<?php locationChecker('clan'); ?>"><a href="http://localhost/wartracker/clan">Clan</a></li>
        <li class="<?php locationChecker('members'); ?>"><a href="http://localhost/wartracker/members">Members</a></li>
        <li class="<?php locationChecker('wars'); ?>"><a href="http://localhost/wartracker/wars">Wars</a></li>
        <li><a href="logout">Logout</a></li>
      </ul>
    </div>

    <div class="col-sm-3 col-md-2 sidebar hide" id="sidebar-close">
      <ul class="nav nav-sidebar">
        <li class="<?php locationChecker('dashboard'); ?>"><a href="http://localhost/wartracker/dashboard">Dashboard</a></li>
        <li class="<?php locationChecker('clan'); ?>"><a href="http://localhost/wartracker/clan">Clan</a></li>
        <li class="<?php locationChecker('members'); ?>"><a href="http://localhost/wartracker/members">Members</a></li>
        <li class="<?php locationChecker('wars'); ?>"><a href="http://localhost/wartracker/wars">Wars</a></li>
        <li><a href="logout">Logout</a></li>
      </ul>
    </div>

    <div class="container-fluid">
      <div class="row">

	    <nav class="navbar">
	      <div class="container-fluid">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="btn btn-primary hamburger-btn" id="hamburger-open">
	          	<i class="fa fa-bars"></i>
	          </a>
	          <a class="btn btn-primary hamburger-btn hide" id="hamburger-close">
	          	<i class="fa fa-bars"></i>
	          </a>
	        </div>
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="#">Dashboard</a></li>
	            <li><a href="#">Settings</a></li>
	            <li><a href="#">Profile</a></li>
	            <li><a href="#">Help</a></li>
	          </ul>
	        </div>
	      </div>
	    </nav>

	    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">