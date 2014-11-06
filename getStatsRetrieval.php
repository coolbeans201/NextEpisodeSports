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
			$querybio = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
					FROM Baseballmaster
					WHERE managerid IS NOT NULL AND managerid = '" . $playerid . "'";
			$querystats = "SELECT year, team, league, games, wins, loss, winpercent, rank
						FROM Baseballmanagers
						WHERE managerid = '" . $playerid . "'
						ORDER BY year";
		}
		if ($playertype == 'Pitcher'){
			$querybio = "SELECT DISTINCT firstName, lastName
			      FROM BaseballMaster
				  WHERE firstName IS NOT NULL AND lastName IS NOT NULL AND playerID IS NOT NULL AND playerID IN ((SELECT DISTINCT pitcherID FROM BaseballPitching)
																												  UNION
																												(SELECT DISTINCT playerID FROM BaseballPitchingPostseason))
				  ORDER BY firstName, lastName";
		}
		if ($playertype == 'Position Player'){
			$querybio = "SELECT DISTINCT firstname, lastname
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
			$querybio = "SELECT DISTINCT name 
				  FROM BaseballTeams 
				  ORDER BY name";
		}
	}
	
	else if ($sport == 'Basketball')
	{
		if ($playertype == 'Coach'){
			$querybio = "SELECT DISTINCT firstName, lastName
					FROM BasketballMaster
					WHERE firstName IS NOT NULL AND lastName IS NOT NULL AND ID IS NOT NULL AND ID IN ((SELECT DISTINCT coachID
                                                                                    FROM BasketballCoaches))
					ORDER BY firstName, lastName";
		}
		if ($playertype == 'Player'){
			$querybio = "SELECT DISTINCT firstName, lastName
				   FROM BasketballMaster
				   WHERE firstName IS NOT NULL AND lastName IS NOT NULL AND ID IS NOT NULL AND ID IN ((SELECT DISTINCT playerID
																									   FROM BasketballPlayers)
																									   UNION
																									  (SELECT DISTINCT player_ID
																									   FROM BasketballPlayerAllStar))
				   ORDER BY firstName, lastName";
		}
		if ($playertype == 'Team'){
			$querybio = "SELECT DISTINCT name
				 FROM BasketballTeams
				 ORDER BY name";
		}
	}
	
	else if ($sport == 'Hockey')
	{
		if ($playertype == 'Coach'){
			$querybio = "SELECT DISTINCT firstName, lastName
			  FROM HockeyMaster
			  WHERE firstName IS NOT NULL AND lastName IS NOT NULL AND coachID IS NOT NULL AND coachID IN ((SELECT DISTINCT coachID
																											FROM HockeyCoaches))
                                                                                                
			  ORDER BY firstName, lastName";
		}
		if ($playertype == 'Goalie'){
			$querybio = "SELECT DISTINCT firstName, lastName
			   FROM HockeyMaster
			   WHERE firstName IS NOT NULL AND lastName IS NOT NULL AND playerID IS NOT NULL AND playerID IN ((SELECT DISTINCT goalieID
																											   FROM HockeyGoalies)
																											   UNION
																											  (SELECT DISTINCT goalieID
																											   FROM HockeyGoaliesShootout))
			   ORDER BY firstName, lastName";
		}
		if ($playertype == 'Position Player'){
			$querybio = "SELECT DISTINCT firstName, lastName
			   FROM HockeyMaster
			   WHERE firstName IS NOT NULL AND lastName IS NOT NULL AND playerID IS NOT NULL AND playerID IN ((SELECT DISTINCT playerID
																											   FROM HockeyScoring)
																											   UNION
																											  (SELECT DISTINCT playerID
																											   FROM HockeyScoringShootout))
			   ORDER BY firstName, lastName";
		}
		if ($playertype == 'Team'){
			$querybio = "SELECT DISTINCT name
			 FROM HockeyTeams
			 ORDER BY name";
		}
	}
	
	
	$statementbio = oci_parse($connection, $querybio);
	oci_execute($statementbio);
	
	while($row=oci_fetch_assoc($statementbio)) {
		if ($playertype == 'Team'){
		}
		else if($sport == 'Baseball'){
			if($playertype == 'Manager'){
				echo '<font size = "4">';
				echo "<b> Biographical Information </b> <br>";
				echo 'Name: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . "<br>";
				echo 'Date of Birth: ' . $row['BIRTHMONTH'] . '/' . $row['BIRTHDAY'] . '/' . $row['BIRTHYEAR'] . "<br>";
				echo 'Height: ' . $row['HEIGHT'] . " inches <br>";
				echo 'Weight: ' . $row['WEIGHT'] . " pounds <br>";
				echo '<br>';
				echo '<b> Statistical Information </b> </font>';
			}
			if($playertype == 'Pitcher' || $playertype == 'Position Player'){
				
			}
		}
		else if($sport == 'Basketball'){

		}
		else if($sport == 'Hockey'){
			if($playertype == 'Coach'){
				
			}
			if($playertype == 'Goalie' || $playertype == 'Position Player'){
				
			}
		}
	}
	
	$statementstats = oci_parse($connection, $querystats);
	oci_execute($statementstats);
	
	echo "<table border='1'>\n";
		if ($playertype == 'Team'){
		}
		else if($sport == 'Baseball'){
			if($playertype == 'Manager'){
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Games Played</th>';
				echo '<th>Wins</th>';
				echo '<th>Losses</th>';
				echo '<th>Win Percent</th>';
				echo '<th>Rank</th>';
				echo '</tr>';
			}
			if($playertype == 'Pitcher' || $playertype == 'Position Player'){
				
			}
		}
		else if($sport == 'Basketball'){

		}
		else if($sport == 'Hockey'){
			if($playertype == 'Coach'){
				
			}
			if($playertype == 'Goalie' || $playertype == 'Position Player'){
				
			}
		}
	while ($row = oci_fetch_array($statementstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
		echo "<tr>\n";
		foreach ($row as $item) {
			echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
		}
		echo "</tr>\n";
	}
	echo "</table>\n";

	//
	// VERY important to close Oracle Database Connections and free statements!
	//
	oci_free_statement($statementbio);
	oci_free_statement($statementstats);
	oci_close($connection);
?>
