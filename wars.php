<?php require($_SERVER['DOCUMENT_ROOT']."/wartracker/templatestart.php"); ?>

<?php 
	$query = "SELECT id FROM clan WHERE user_id = :user_id";
	$query_params = array(':user_id' => $_SESSION['user']['id']);
	$stmt = $db->prepare($query);
	$stmt->execute($query_params);
	$row = $stmt->fetch();
	$clan_id = $row['id'];

	if (!empty($_POST)) {
		$query = " 
		    INSERT INTO war ( 
		        clan_id, 
		        enemy_clan,
		        size,
		        comments
		    ) VALUES ( 
		        :clan_id, 
		        :enemy_clan,
		        :size,
		        :comments
		    )
		"; 

		$query_params = array(
			':clan_id' => $clan_id,
			':enemy_clan' => $_POST['enemy_clan'],
			':size' => $_POST['size'],
			':comments' => $_POST['comments']
		);

        try {
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) {  
            die("Failed to run query: " . $ex->getMessage()); 
        }

        header('Location: wars');
        die();
	}

	$query = "SELECT clan_id, enemy_clan, size, comments FROM war WHERE clan_id = :clan_id";
	$query_params = array(':clan_id'=>$clan_id);
	$stmt = $db->prepare($query);
	$stmt->execute($query_params);
	$row = $stmt->fetchAll();
	foreach ($row as $war) {
		echo 'Clan ID: '.$war['clan_id']; 
		echo '<br>';
		echo 'Clan Enemy Clan: '.$war['enemy_clan'];
		echo '<br>';
		echo 'Size: '.$war['size'];
		echo '<br>';
		echo 'Comments: '.$war['comments'];
		echo '<br>';
	}
?>

<form action="wars" method="post">
	Enemy Clan<input type="text" name="enemy_clan"></input>
	Size<input type="text" name="size"></input>
	Comments<input type="text" name="comments"></input>
	<input type="submit"></input>
</form>

<?php require($_SERVER['DOCUMENT_ROOT']."/wartracker/templatestop.php"); ?>





