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
	$stats = $_GET['stats'];
	$range = $_GET['range'];
	// Escape User Input to help prevent SQL Injection
	//$sport = mysql_real_escape_string($sport);
	//$playertype = mysql_real_escape_string($playertype);
	
	if ($sport == 'Baseball')
	{
			if ($playertype == 'Manager'){
				$query = "SELECT a.". $stats .", a.firstname, a.lastname, rownum AS rank
						  FROM
						  (SELECT DISTINCT ". $stats .", firstname, lastname
						  FROM baseballmanagers NATURAL JOIN baseballmaster
						  ORDER BY ".$stats." DESC) a
						  WHERE rownum <= '". $range ."' ";
					  }
			else if ($playertype == 'Pitcher'){
				$query = "SELECT rownum AS rank, a.". $stats .", a.firstname, a.lastname
						  FROM
						  (SELECT DISTINCT bp.". $stats .", bm.firstname, bm.lastname
						  FROM baseballpitching bp, baseballmaster bm
						  WHERE bp.pitcherid = bm.playerid AND bp.".$stats." IS NOT NULL
						  ORDER BY bp.".$stats." DESC) a
						  WHERE rownum <= '". $range ."' ";
					  }
			else if ($playertype == 'Position Player Batting'){
				$query = "SELECT rownum AS rank, ". $stats .", firstname, lastname
						  FROM
						  (SELECT DISTINCT bb.". $stats .", bm.firstname, bm.lastname
						  FROM baseballbatting bb, baseballmaster bm
						  WHERE bb.playerid = bm.playerid AND bb.".$stats." IS NOT NULL
						  ORDER BY ".$stats." DESC) a
						  WHERE rownum <= '". $range ."' ";
					  }
			else if ($playertype == 'Position Player Fielding'){
				$query = "SELECT rownum AS rank, ". $stats .", firstname, lastname 
						  FROM
						  (SELECT DISTINCT bf.". $stats .", bm.firstname, bm.lastname
						  FROM baseballfielding bf, baseballmaster bm
						  WHERE bf.playerid = bm.playerid AND bf.".$stats." IS NOT NULL
						  ORDER BY ".$stats." DESC) a
						  WHERE rownum <= '". $range ."' ";
					  }
			else if ($playertype == 'Team'){
				$query = "SELECT rownum AS rank, ". $stats .", name 
						  FROM
						  (SELECT DISTINCT ". $stats .", name
						  FROM baseballteams
						  WHERE ".$stats." IS NOT NULL
						  ORDER BY ".$stats." DESC)
						  WHERE rownum <= '". $range ."' ";
					  }
	}
	
	else if ($sport == 'Basketball')
	{
		if ($playertype == 'Coach'){
			$query = "SELECT rownum AS rank, ". $stats .", firstname, lastname
						  FROM
						  (SELECT DISTINCT ". $stats .", firstname, lastname
						  FROM basketballcoaches bc, basketballmaster bm
						  WHERE bc.coachid = bm.id
						  ORDER BY ".$stats." DESC)
						  WHERE rownum <= '". $range ."' ";
		}
		if ($playertype == 'Player'){
			$query = "SELECT rownum AS rank, ". $stats .", firstname, lastname
						  FROM
						  (SELECT DISTINCT ". $stats .", firstname, lastname
						  FROM basketballplayers bp, basketballmaster bm
						  WHERE bp.playerid = bm.id AND ".$stats." IS NOT NULL
						  ORDER BY ".$stats." DESC)
						  WHERE rownum <= '". $range ."' ";
		}
		if ($playertype == 'Team'){
			$query =  "SELECT rownum AS rank, ". $stats .", name 
						FROM
						(SELECT DISTINCT ". $stats .", name
						FROM basketballteams
						WHERE ".$stats." IS NOT NULL
						ORDER BY ".$stats." DESC)
						WHERE rownum <= '". $range ."' ";
		}
	}
	
	else if ($sport == 'Hockey')
	{
		if ($playertype == 'Coach'){
			$query = "SELECT rownum AS rank, ". $stats .", firstname, lastname
						  FROM
						  (SELECT DISTINCT ". $stats .", firstname, lastname
						  FROM hockeycoaches NATURAL JOIN hockeymaster
						  WHERE ".$stats." IS NOT NULL
						  ORDER BY ".$stats." DESC)
						  WHERE rownum <= '". $range ."' ";
		}
		if ($playertype == 'Goalie'){
			$query = "SELECT rownum AS rank, ". $stats .", firstname, lastname
						  FROM
						  (SELECT DISTINCT ". $stats .", firstname, lastname
						  FROM hockeygoalies hg, hockeygoaliesshootout hgs, hockeymaster hm
						  WHERE hg.goalieid = hm.playerid AND hgs.goalieid = hm.playerid AND ".$stats." IS NOT NULL
						  ORDER BY ".$stats." DESC)
						  WHERE rownum <= '". $range ."' ";
		}
		if ($playertype == 'Position Player'){
			$query = "SELECT rownum AS rank, ". $stats .", firstname, lastname
						  FROM
						  (SELECT DISTINCT ". $stats .", firstname, lastname
						  FROM hockeyscoring hs, hockeyscoringshootout hss, hockeymaster hm
						  WHERE hs.playerid = hm.playerid AND hss.playerid = hm.playerid AND ".$stats." IS NOT NULL
						  ORDER BY ".$stats." DESC)
						  WHERE rownum <= '". $range ."' ";
		}
		if ($playertype == 'Team'){
			$query = "SELECT rownum AS rank, ". $stats .", name 
						FROM
						(SELECT DISTINCT ". $stats .", name
						FROM hockeyteams
						WHERE ".$stats." IS NOT NULL
						ORDER BY ".$stats." DESC)
						WHERE rownum <= '". $range ."' ";
		}
	}
	
	//$stats = "'$stats'";
	echo $query;
	$statement = oci_parse($connection, $query);
	oci_execute($statement);
	echo '<textarea disabled id = "sortTextBox" name="sortTextBox" cols="150" rows="40">';
	while($row=oci_fetch_assoc($statement)) {
		if($playertype != 'Team')
			echo $row['RANK'] . ' ' . $row["$stats"] . ' ' . $row['FIRSTNAME'] . ' '. $row['LASTNAME'] . ' ';
		else
			echo $row['RANK'] . ' ' . $row["$stats"] . ' ' . $row['NAME']. ' ';
	}
	echo "</textarea> \n";
	
	//
	// VERY important to close Oracle Database Connections and free statements!
	//
	oci_free_statement($statement);
	oci_close($connection);
?>
