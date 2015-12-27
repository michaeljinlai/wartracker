<?php require($_SERVER['DOCUMENT_ROOT']."/wartracker/templatestart.php"); ?>

<?php
	$war_id = NULL;

	if (!empty($_GET['id'])) {
		$war_id = $_GET['id'];
	}

	if (!empty($_POST)) {
		$query = " 
		    UPDATE war
		    SET 
		        enemy_clan = :enemy_clan,
		        size = :size,
		        comments = :comments
		    WHERE id = :war_id
		"; 

		$query_params = array(
			':enemy_clan' => $_POST['enemy_clan'],
			':size' => $_POST['size'],
			':comments' => $_POST['comments'],
			':war_id' => $war_id
		);

        try {
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) {  
            die("Failed to run query: " . $ex->getMessage()); 
        }

        header('Location: http://localhost/wartracker/war/edit/'.$war_id);
        die();
	}

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

<?php if (!empty($row)) : ?>

<form action="" method="post">
	Enemy Clan<input type="text" name="enemy_clan" value="<?php echo $row['enemy_clan']; ?>"></input>
	Size<input type="text" name="size" value="<?php echo $row['size']; ?>"></input>
	Comments<input type="text" name="comments" value="<?php echo $row['comments']; ?>"></input>
	<input type="submit"></input>
</form>

<?php endif; ?>

<?php require($_SERVER['DOCUMENT_ROOT']."/wartracker/templatestop.php"); ?>





