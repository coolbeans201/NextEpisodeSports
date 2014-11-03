#!/usr/local/bin/php

<?php
	$connection = oci_connect($username = 'weingart',
							  $password = 'bridgeoverlord201',
							  $connection_string = '//oracle.cise.ufl.edu/orcl');
							  
							  
	if (!$connection) {
		die('Could not connect');
	}						  
	
	// Retrieve data from Query String
	$sport = $_GET['sport'];
	$playertype = $_GET['playertype'];
	
	// Escape User Input to help prevent SQL Injection
	//$sport = mysql_real_escape_string($sport);
	//$playertype = mysql_real_escape_string($playertype);
	
	if ($sport == 'Baseball')
	{
		if ($playertype == 'Manager'){
			$query = "SELECT DISTINCT firstName, lastName
			      FROM BaseballMaster
				  WHERE firstName IS NOT NULL AND lastName IS NOT NULL AND managerID IS NOT NULL AND managerID IN ((SELECT DISTINCT managerID FROM BaseballManagers))
				  ORDER BY firstName, lastName";
		}
		if ($playertype == 'Pitcher'){
			$query = "SELECT DISTINCT firstName, lastName
			      FROM BaseballMaster
				  WHERE firstName IS NOT NULL AND lastName IS NOT NULL AND playerID IS NOT NULL AND playerID IN ((SELECT DISTINCT pitcherID FROM BaseballPitching)
																												  UNION
																												(SELECT DISTINCT playerID FROM BaseballPitchingPostseason))
				  ORDER BY firstName, lastName";
		}
		if ($playertype == 'Position Player'){
			$query = "SELECT DISTINCT firstname, lastname
				 FROM BaseballMaster
				 WHERE firstname IS NOT NULL AND lastname IS NOT NULL AND playerID IS NOT NULL AND playerID IN ((SELECT DISTINCT playerID FROM BaseballFielding)
																											     UNION
																												(SELECT DISTINCT playerID FROM BaseballFieldingPostseason)
																												 UNION
																												(SELECT DISTINCT playerID FROM BaseballBatting)
																												 UNION
																												(SELECT DISTINCT playerID FROM BaseballBattingPostseason))
				 ORDER BY firstname, lastname";
		}
		if ($playertype == 'Team'){
			$query = "SELECT DISTINCT name 
				  FROM BaseballTeams 
				  ORDER BY name";
		}
	}
	
	else if ($sport == 'Basketball')
	{
		if ($playertype == 'Coach'){
			$query = "SELECT DISTINCT firstName, lastName
					FROM BasketballMaster
					WHERE firstName IS NOT NULL AND lastName IS NOT NULL AND ID IS NOT NULL AND ID IN ((SELECT DISTINCT coachID
                                                                                    FROM BasketballCoaches))
					ORDER BY firstName, lastName";
		}
		if ($playertype == 'Player'){
			$query = "SELECT DISTINCT firstName, lastName
				   FROM BasketballMaster
				   WHERE firstName IS NOT NULL AND lastName IS NOT NULL AND ID IS NOT NULL AND ID IN ((SELECT DISTINCT playerID
																									   FROM BasketballPlayers)
																									   UNION
																									  (SELECT DISTINCT player_ID
																									   FROM BasketballPlayerAllStar))
				   ORDER BY firstName, lastName";
		}
		if ($playertype == 'Team'){
			$query = "SELECT DISTINCT name
				 FROM BasketballTeams
				 ORDER BY name";
		}
	}
	
	else if ($sport == 'Hockey')
	{
		if ($playertype == 'Coach'){
			$query = "SELECT DISTINCT firstName, lastName
			  FROM HockeyMaster
			  WHERE firstName IS NOT NULL AND lastName IS NOT NULL AND coachID IS NOT NULL AND coachID IN ((SELECT DISTINCT coachID
																											FROM HockeyCoaches))
                                                                                                
			  ORDER BY firstName, lastName";
		}
		if ($playertype == 'Goalie'){
			$query = "SELECT DISTINCT firstName, lastName
			   FROM HockeyMaster
			   WHERE firstName IS NOT NULL AND lastName IS NOT NULL AND playerID IS NOT NULL AND playerID IN ((SELECT DISTINCT goalieID
																											   FROM HockeyGoalies)
																											   UNION
																											  (SELECT DISTINCT goalieID
																											   FROM HockeyGoaliesShootout))
			   ORDER BY firstName, lastName";
		}
		if ($playertype == 'Position Player'){
			$query = "SELECT DISTINCT firstName, lastName
			   FROM HockeyMaster
			   WHERE firstName IS NOT NULL AND lastName IS NOT NULL AND playerID IS NOT NULL AND playerID IN ((SELECT DISTINCT playerID
																											   FROM HockeyScoring)
																											   UNION
																											  (SELECT DISTINCT playerID
																											   FROM HockeyScoringShootout))
			   ORDER BY firstName, lastName";
		}
		if ($playertype == 'Team'){
			$query = "SELECT DISTINCT name
			 FROM HockeyTeams
			 ORDER BY name";
		}
	}
	
	
	$statement = oci_parse($connection, $query);
	$statement2 = oci_parse($connection, $query);
	
	oci_execute($statement);
	oci_execute($statement2);
	
	echo "Select name: ";
	echo '<select name="personbox1">';
	echo '<option value = "-1">Select:</option>';
	while($row=oci_fetch_assoc($statement)) {
		if ($playertype != 'Team'){
			echo '<option>' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . '</option>';
		}
		else{
			echo '<option>' . $row['NAME'] . ' ' . '</option>';
		}
	}
	
	echo "</select> \n";
	
	echo "vs.\n";
	
	echo '<select name="personbox2">';
	echo '<option value = "-1">Select:</option>';
	
	while($row=oci_fetch_assoc($statement2)) {
		if ($playertype != 'Team'){
			echo '<option>' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . '</option>';
		}
		else{
			echo '<option>' . $row['NAME'] . ' ' . '</option>';
		}
	}
	
	echo "</select> \n";
	
	//
	// VERY important to close Oracle Database Connections and free statements!
	//
	oci_free_statement($statement);
	oci_free_statement($statement2);
	oci_close($connection);
?>




