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
	$playerid2 = $_GET['playerid2'];

	if ($sport == 'Baseball')
	{
		if ($playertype == 'Manager'){
			$query = "SELECT *
					FROM baseballmanagers
					WHERE managerid IS NOT NULL AND managerid = '" . $playerid . "'";
			
			$query2 = "SELECT *
					FROM baseballmanagers
					WHERE managerid IS NOT NULL AND managerid = '" . $playerid2 . "'";
		}
		if ($playertype == 'Pitcher'){
			$query = "SELECT *
			      FROM basebballpitching
				  WHERE pitcherid IS NOT NULL AND pitcherid = '" . $playerid . "'";
			$query2 = "SELECT *
			      FROM basebballpitching
				  WHERE pitcherid IS NOT NULL AND pitcherid = '" . $playerid2 . "'";
		}
		if ($playertype == 'Position Player'){
			$query = "SELECT *
				 FROM baseballpatting NATURAL JOIN baseballfielding
				 WHERE playerid IS NOT NULL AND playerid = '" . $playerid . "'";
			$query2 = "SELECT *
				 FROM baseballpatting NATURAL JOIN baseballfielding
				 WHERE playerid IS NOT NULL AND playerid = '" . $playerid2 . "'";	 
		}
		if ($playertype == 'Team'){
			$query = "SELECT *
				  FROM BaseballTeams 
				  WHERE name = '" . $playerid1 . "'";
			$query = "SELECT *
				  FROM BaseballTeams 
				  WHERE name = '" . $playerid2 . "'";	  
		}
	}
	
	else if ($sport == 'Basketball')
	{
		if ($playertype == 'Coach'){
			$query = "SELECT *
					FROM basketballcoaches
					WHERE coachid IS NOT NULL AND coachid = '" . $playerid . "'";	 
			$query2 = "SELECT *
					FROM basketballcoaches
					WHERE coachid IS NOT NULL AND coachid = '" . $playerid2 . "'";			
		}
		if ($playertype == 'Player'){
			$query = "SELECT *
					FROM basketballteams
					WHERE playerid IS NOT NULL AND playerid = '" . $playerid . "'";	 
			$query2 = "SELECT *
					FROM basketballteams
					WHERE playerid IS NOT NULL AND playerid = '" . $playerid2 . "'";	   
		}
		if ($playertype == 'Team'){
			$query = "SELECT *
					FROM basketballplayers
					WHERE name = '" . $playerid . "'";	 
			$query2 = "SELECT *
					FROM basketballplayers
					WHERE name = '" . $playerid2 . "'";	 
		}
	}
	else if ($sport == 'Hockey')
	{
		if ($playertype == 'Coach'){
			$query = "SELECT *
			  FROM hockeycoaches
			  WHERE coachid IS NOT NULL AND coachid = '" . $playerid . "'";
			$query2 = "SELECT *
			  FROM hockeycoaches
			  WHERE coachid IS NOT NULL AND coachid = '" . $playerid2 . "'";  
		}
		if ($playertype == 'Goalie'){
			$query = "SELECT *
			  FROM hockeygoalies
			  WHERE goalieid IS NOT NULL AND goalieid = '" . $playerid . "'";
			$query2 = "SELECT *
			  FROM hockeygoalies
			  WHERE goalieid IS NOT NULL AND goalieid = '" . $playerid2 . "'"; 
		}
		if ($playertype == 'Position Player'){
			$query = "SELECT *
			  FROM hockeyscoring
			  WHERE playerid IS NOT NULL AND playerid = '" . $playerid . "'";
			$query2 = "SELECT *
			  FROM hockeyscoring
			  WHERE playerid IS NOT NULL AND playerid = '" . $playerid2 . "'";   
		}
		if ($playertype == 'Team'){
			$query = "SELECT *
					FROM hockeyteams
					WHERE name = '" . $playerid . "'";	 
			$query2 = "SELECT *
					FROM hockeyteams
					WHERE name = '" . $playerid2 . "'"; 
		}
	}

	
	$statement = oci_parse($connection, $query);
	oci_execute($statement);
	
	while($row=oci_fetch_assoc($statement)) {
		
	}
	
	$statement2 = oci_parse($connection, $query2);
	oci_execute($statement2);

	while($row=oci_fetch_assoc($statement2)) {
		
	}
	
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
	oci_free_statement($statement);
	oci_free_statement($statement2);
	oci_close($connection);
?>
