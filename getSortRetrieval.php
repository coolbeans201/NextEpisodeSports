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
				$query = "SELECT a.firstname, a.lastname, a.year, a.". $stats .", rownum as rank
						  from
						  (SELECT DISTINCT ". $stats .", year, firstname, lastname
						  FROM baseballmanagers NATURAL JOIN baseballmaster
						  ORDER BY ".$stats." DESC) a
						  WHERE rownum <= '". $range ."' ";
					  }
			else if ($playertype == 'Pitcher'){
				$query = "SELECT a.firstname, a.lastname, a.year, a.". $stats .", rownum AS rank
						  FROM
						  (SELECT DISTINCT bp.". $stats .", year, bm.firstname, bm.lastname
						  FROM baseballpitching bp, baseballmaster bm
						  WHERE bp.pitcherid = bm.playerid AND bp.".$stats." IS NOT NULL
						  ORDER BY bp.".$stats." DESC) a
						  WHERE rownum <= '". $range ."' ";
					  }
			else if ($playertype == 'Position Player Batting'){
				$query = "SELECT firstname, lastname, year, ". $stats .", rownum AS rank
						  FROM
						  (SELECT DISTINCT bb.". $stats .", bb.year, bm.firstname, bm.lastname
						  FROM baseballbatting bb, baseballmaster bm
						  WHERE bb.playerid = bm.playerid AND bb.".$stats." IS NOT NULL
						  ORDER BY ".$stats." DESC) a
						  WHERE rownum <= '". $range ."' ";
					  }
			else if ($playertype == 'Position Player Fielding'){
				$query = "SELECT firstname, lastname, year, ". $stats .", rownum AS rank 
						  FROM
						  (SELECT DISTINCT bf.". $stats .", bf.year, bm.firstname, bm.lastname
						  FROM baseballfielding bf, baseballmaster bm
						  WHERE bf.playerid = bm.playerid AND bf.".$stats." IS NOT NULL
						  ORDER BY ".$stats." DESC) a
						  WHERE rownum <= '". $range ."' ";
					  }
			else if ($playertype == 'Team'){
				$query = "SELECT name, year, ". $stats .", rownum AS rank
						  FROM
						  (SELECT DISTINCT ". $stats .", year, name
						  FROM baseballteams
						  WHERE ".$stats." IS NOT NULL
						  ORDER BY ".$stats." DESC)
						  WHERE rownum <= '". $range ."' ";
					  }
	}
	
	else if ($sport == 'Basketball')
	{
		if ($playertype == 'Coach'){
			$query = "SELECT firstname, lastname, year, ". $stats .", rownum AS rank
						  FROM
						  (SELECT DISTINCT ". $stats .", bc.year, firstname, lastname
						  FROM basketballcoaches bc, basketballmaster bm
						  WHERE bc.coachid = bm.id
						  ORDER BY ".$stats." DESC)
						  WHERE rownum <= '". $range ."' ";
		}
		if ($playertype == 'Player'){
			$query = "SELECT firstname, lastname, year, ". $stats .", rownum AS rank
						  FROM
						  (SELECT DISTINCT ". $stats .", bp.year, firstname, lastname
						  FROM basketballplayers bp, basketballmaster bm
						  WHERE bp.playerid = bm.id AND ".$stats." IS NOT NULL
						  ORDER BY ".$stats." DESC)
						  WHERE rownum <= '". $range ."' ";
		}
		if ($playertype == 'Team'){
			$query =  "SELECT name, year, ". $stats .", rownum AS rank
						FROM
						(SELECT DISTINCT ". $stats .", year, name
						FROM basketballteams
						WHERE ".$stats." IS NOT NULL
						ORDER BY ".$stats." DESC)
						WHERE rownum <= '". $range ."' ";
		}
	}
	
	else if ($sport == 'Hockey')
	{
		if ($playertype == 'Coach'){
			$query = "SELECT firstname, lastname, year, ". $stats .", rownum AS rank 
						  FROM
						  (SELECT DISTINCT ". $stats .", year, firstname, lastname
						  FROM hockeycoaches NATURAL JOIN hockeymaster
						  WHERE ".$stats." IS NOT NULL
						  ORDER BY ".$stats." DESC)
						  WHERE rownum <= '". $range ."' ";
		}
		if ($playertype == 'Goalie'){
			$query = "SELECT firstname, lastname, year, ". $stats .", rownum AS rank 
						  FROM
						  (SELECT DISTINCT ". $stats .", hg.year, firstname, lastname
						  FROM hockeygoalies hg, hockeygoaliesshootout hgs, hockeymaster hm
						  WHERE hg.goalieid = hm.playerid AND hgs.goalieid = hm.playerid AND ".$stats." IS NOT NULL
						  ORDER BY ".$stats." DESC)
						  WHERE rownum <= '". $range ."' ";
		}
		if ($playertype == 'Position Player'){
			$query = "SELECT firstname, lastname, year, ". $stats .", rownum AS rank
						  FROM
						  (SELECT DISTINCT ". $stats .", hs.year, firstname, lastname
						  FROM hockeyscoring hs, hockeyscoringshootout hss, hockeymaster hm
						  WHERE hs.playerid = hm.playerid AND hss.playerid = hm.playerid AND ".$stats." IS NOT NULL
						  ORDER BY ".$stats." DESC)
						  WHERE rownum <= '". $range ."' ";
		}
		if ($playertype == 'Team'){
			$query = "SELECT name, year, ". $stats .", rownum AS rank
						FROM
						(SELECT DISTINCT ". $stats .", year, name
						FROM hockeyteams
						WHERE ".$stats." IS NOT NULL
						ORDER BY ".$stats." DESC)
						WHERE rownum <= '". $range ."' ";
		}
	}
	
	//$stats = "'$stats'";
	$statement = oci_parse($connection, $query);
	oci_execute($statement);
	echo '<font size = "4"><b>Result</b></font><br>';
	echo "<table border='1'>\n";
	if($playertype == 'Team')
	{
		echo '<tr>';
		echo '<th>Name</th>';
		echo '<th>Year</th>';
		echo '<th>Number</th>';
		echo '<th>Rank</th>';
		echo '</tr>';
	}
	else
	{
		echo '<tr>';
		echo '<th>First Name</th>';
		echo '<th>Last Name</th>';
		echo '<th>Year</th>';
		echo '<th>Number</th>';
		echo '<th>Rank</th>';
		echo '</tr>';
	}
	while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		echo "<tr>\n";
		foreach ($row as $item) 
		{
			echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
		}
		echo "</tr>\n";
	}
	echo "</table><br>";
	
	//
	// VERY important to close Oracle Database Connections and free statements!
	//
	oci_free_statement($statement);
	oci_close($connection);
?>
