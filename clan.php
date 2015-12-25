<?php require($_SERVER['DOCUMENT_ROOT']."/wartracker/templatestart.php"); ?>

<?php 
	preg_match("/[^\/]+$/", $_SERVER['REQUEST_URI'], $matches);
	$last_word = $matches[0]; // test 
	echo $last_word;
?>

<?php require($_SERVER['DOCUMENT_ROOT']."/wartracker/templatestop.php"); ?>





