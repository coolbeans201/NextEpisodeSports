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
				  WHERE name = '" . $playerid . "'";
			$query2 = "SELECT *
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
	
	echo "Comparison:";
	echo "<br/>";
	
		$statement = oci_parse($connection, $query);	//1
		oci_execute($statement);

		if(true) {   
			echo "cocks";
			if ($playertype == 'Team'){
				echo "<table border='1'>\n";
					echo '<tr>';
						echo '<th>Name</th>';
						echo '<th>Year</th>';
						echo '<th>Team</th>';
						echo '<th>League</th>';
						echo '<th>Games Played</th>';
						echo '<th>Wins</th>';
						echo '<th>Losses</th>';
						echo '<th>Win Percent</th>';
						echo '<th>Rank</th>';
					echo '</tr>';
					while($row=oci_fetch_assoc($statement)){
						echo '<tr>';
							echo '<td>'. $row['NAME'] .'</td>';
							echo '<td>'. $row['YEAR'] .'</td>';
							echo '<td>'. $row['TEAM'] .'</td>';
							echo '<td>'. $row['LEAGUE'] .'</td>';
							echo '<td>'. $row['GAMES'] .'</td>';
							echo '<td>'. $row['WIN'] .'</td>';
							echo '<td>'. $row['LOSS'] .'</td>';
							echo '<td>'. $row['WINPERCENT'] .'</td>';
							echo '<td>'. $row['RANK'] .'</td>';
						echo '</tr>';
					}
				echo "</table>";
			}
			else if($sport == 'Baseball'){
				if($playertype == 'Manager'){
					
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
		
		
		$statement2 = oci_parse($connection, $query2); 	//2
		oci_execute($statement2);
		
		if(true) {   
			echo "cocks";
			if ($playertype == 'Team'){
				echo "<table border='1'>\n";
					echo '<tr>';
						echo '<th>Name</th>';
						echo '<th>Year</th>';
						echo '<th>Team</th>';
						echo '<th>League</th>';
						echo '<th>Games Played</th>';
						echo '<th>Wins</th>';
						echo '<th>Losses</th>';
						echo '<th>Win Percent</th>';
						echo '<th>Rank</th>';
					echo '</tr>';
					while($row=oci_fetch_assoc($statement)){
						echo '<tr>';
							echo '<td>'. $row['NAME'] .'</td>';
							echo '<td>'. $row['YEAR'] .'</td>';
							echo '<td>'. $row['TEAM'] .'</td>';
							echo '<td>'. $row['LEAGUE'] .'</td>';
							echo '<td>'. $row['GAMES'] .'</td>';
							echo '<td>'. $row['WIN'] .'</td>';
							echo '<td>'. $row['LOSS'] .'</td>';
							echo '<td>'. $row['WINPERCENT'] .'</td>';
							echo '<td>'. $row['RANK'] .'</td>';
						echo '</tr>';
					}
				echo "</table>";
			}
				echo "</table>";
			}
			else if($sport == 'Baseball'){
				if($playertype == 'Manager'){
					
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
	
	///////////////////////////////////////////////
	
	//
	// VERY important to close Oracle Database Connections and free statements!
	//
	oci_free_statement($statement);
	oci_free_statement($statement2);
	oci_close($connection);
?>
