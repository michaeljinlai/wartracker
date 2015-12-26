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
		    INSERT INTO member ( 
		        clan_id, 
		        name
		    ) VALUES ( 
		        :clan_id, 
		        :name
		    ) 
		"; 

		$query_params = array(
			':clan_id' => $clan_id,
			':name' => $_POST['name']
		);

        try {
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) {  
            die("Failed to run query: " . $ex->getMessage()); 
        }

        header('Location: member');
        die();
	}

	$query = "SELECT clan_id, name FROM member WHERE clan_id = :clan_id";
	$query_params = array(':clan_id'=>$clan_id);
	$stmt = $db->prepare($query);
	$stmt->execute($query_params);
	$row = $stmt->fetchAll();
	foreach ($row as $wut) {
		echo 'Clan ID: '.$wut['clan_id']; 
		echo '<br>';
		echo 'Clan Member Name: '.$wut['name'];
		echo '<br>';
	}
?>

<form action="member" method="post">
	<input type="text" name="name"></input>
	<input type="submit"></input>
</form>



<?php require($_SERVER['DOCUMENT_ROOT']."/wartracker/templatestop.php"); ?>





