<?php require($_SERVER['DOCUMENT_ROOT']."/wartracker/templatestart.php"); ?>

<?php
	$valid = true;
	$war_id = NULL;
	$current_roster = array();

	if (!empty($_GET['war_id'])) {
		$war_id = $_GET['war_id'];
	}

	if (!empty($_POST)) {

		$query = " 
            SELECT 
                1 
            FROM roster 
            WHERE 
                war_id = :war_id AND member_id = :member_id 
        "; 
        
        $query_params = array( 
            ':war_id' => $war_id,
            ':member_id' => $_POST['member_id']
        ); 
         
        try { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) {  
            die("Failed to run query: " . $ex->getMessage()); 
        } 
        
        $row = $stmt->fetch(); 
        
        if($row) {
            $valid = false;
        } 

        if ($valid) {
			$query = " 
			    INSERT INTO roster (
			    	war_id,
			    	member_id
			    ) VALUES (
			        :war_id,
			        :member_id
			    )
			"; 

			$query_params = array(
				':war_id' => $war_id,
				':member_id' => $_POST['member_id']
			);

	        try {
	            $stmt = $db->prepare($query); 
	            $result = $stmt->execute($query_params); 
	        } 
	        catch(PDOException $ex) {  
	            die("Failed to run query: " . $ex->getMessage()); 
	        }

	        header('Location: http://localhost/wartracker/war/roster/'.$war_id);
	        die();
    	}
	}

	$query = "SELECT war_id, member_id FROM roster WHERE war_id = :war_id";

	$query_params = array(':war_id' => $war_id);
	$stmt = $db->prepare($query);
	$stmt->execute($query_params);
	$rows = $stmt->fetchAll();
	foreach ($rows as $roster) {
		array_push($current_roster, $roster['member_id']);
		echo 'War ID: '.$roster['war_id'];
		echo '<br>';
		echo 'Member ID: '.$roster['member_id'];
		echo '<br>';
		echo '<br>';
	}
?>

<?php 
	$query = "SELECT id FROM member";
	$stmt = $db->prepare($query);
	$stmt->execute();
	$member_id_list = $stmt->fetchAll();
?>

<form action="" method="post">
	<select name="member_id" >
		<?php foreach ($member_id_list as $member) : ?>
			<?php if (!in_array($member['id'], $current_roster)) : ?>
	    		<option value="<?php echo $member['id']; ?>"><?php echo $member['id'] ?></option>
	    	<?php endif; ?>	
	    <?php endforeach; ?>	
	</select>
	<input type="submit"></input>
</form>

<?php require($_SERVER['DOCUMENT_ROOT']."/wartracker/templatestop.php"); ?>





