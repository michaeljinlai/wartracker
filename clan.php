<?php require($_SERVER['DOCUMENT_ROOT']."/wartracker/templatestart.php"); ?>

<?php 
	if (!empty($_POST)) {
		$query = "
			UPDATE
				clan
			SET
				clan_name = :clan_name,
				clan_tag = :clan_tag
			WHERE
				user_id = :user_id
		";

		$query_params = array(
			':clan_name' => $_POST['clan_name'],
			':clan_tag' => $_POST['clan_tag'],
			':user_id' => $_SESSION['user']['id']
		);

        try {
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) {  
            die("Failed to run query: " . $ex->getMessage()); 
        }

        header('Location: clan');
        die();
	}
?>

<form action="clan" method="post">
	<input type="text" name="clan_name"></input>
	<input type="text" name="clan_tag"></input>
	<input type="submit"></input>
</form>

<?php require($_SERVER['DOCUMENT_ROOT']."/wartracker/templatestop.php"); ?>





