<?php

	require($_SERVER['DOCUMENT_ROOT']."/wartracker/database.php");

	$war_id = NULL;

	if (!empty($_GET['war_id'])) {
		$war_id = $_GET['war_id'];
	}

	if (!empty($_POST)) {

		$query = " 
            UPDATE 
            	attack 
            SET 
            	damage = :damage
            WHERE 
            	attack_id = :attack_id	
        "; 
        
        $query_params = array( 
            ':damage' => $_POST['damage'],
            ':attack_id' => $_POST['attack_id']
        ); 
         
        try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) {  
            die("Failed to run query: " . $ex->getMessage()); 
        } 

	}

	require($_SERVER['DOCUMENT_ROOT']."/wartracker/templatestart.php");

	$query = "SELECT * FROM attack WHERE war_id = :war_id";

	$query_params = array(':war_id' => $war_id);
	$stmt = $db->prepare($query);
	$stmt->execute($query_params);
	$rows = $stmt->fetchAll();
	foreach ($rows as $roster) {
		echo 'War ID: '.$roster['war_id'];
		echo '<br>';
		echo 'Member ID: '.$roster['member_id'];
		echo '<br>';
		echo 'Attack Number: '.$roster['attack_number'];
		echo '<br>';
		echo 'damage: '.$roster['damage'];
		echo '<br>';
		echo '<br>';
	}
?>

<form action="" method="post">
	<?php foreach ($rows as $attack) : ?>
		Attack Number<input type="text" value="<?php echo $attack['attack_number']; ?>"></input>
	<?php endforeach; ?>	
	<input type="submit"></input>
</form>

<?php require($_SERVER['DOCUMENT_ROOT']."/wartracker/templatestop.php"); ?>





