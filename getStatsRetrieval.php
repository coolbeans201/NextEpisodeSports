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
	$playerid = $_GET['playerid'];
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
	oci_execute($statement);
	
	echo '<textarea disabled id = "statsRetrievalTextBox" name="statsRetrievalTextBox" cols="150" rows="40">';
	while($row=oci_fetch_assoc($statement)) {
			echo $row['FIRSTNAME'] . ' ' . $row['LASTNAME'];
	}
	
	echo "</textarea> \n";
	
	//
	// VERY important to close Oracle Database Connections and free statements!
	//
	oci_free_statement($statement);
	oci_close($connection);
?>
