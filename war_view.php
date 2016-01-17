<?php
	
	require($_SERVER['DOCUMENT_ROOT']."/wartracker/database.php");

	$war_id = NULL;

	if (!empty($_GET['id'])) {
		$war_id = $_GET['id'];
	}

	require($_SERVER['DOCUMENT_ROOT']."/wartracker/templatestart.php");

	$query = "SELECT id, clan_id, enemy_clan, size, comments FROM war WHERE id = :war_id";

	$query_params = array(':war_id' => $war_id);
	$stmt = $db->prepare($query);
	$stmt->execute($query_params);
	$row = $stmt->fetch();
	echo $row['clan_id'];
	echo '<br>';
	echo $row['enemy_clan'];
	echo '<br>';
	echo $row['size'];
	echo '<br>';
	echo $row['comments'];
	echo '<br>';
	echo '<br>';
?>

<?php require($_SERVER['DOCUMENT_ROOT']."/wartracker/templatestop.php"); ?>





