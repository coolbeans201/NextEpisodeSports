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
			$query = "((select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLMANAGERS')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLMANAGERS' AND COLUMN_NAME != 'YEAR') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLMANAGERS' AND COLUMN_NAME != 'TEAM') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLMANAGERS' AND COLUMN_NAME != 'MANAGERID')
			          INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLMANAGERS' AND COLUMN_NAME != 'LEAGUE')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLMANAGERS' AND COLUMN_NAME != 'RANK')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLMANAGERS' AND COLUMN_NAME != 'PLAYERMANAGER'))";
		}
		if ($playertype == 'Pitcher'){
			$query = "
				   ((select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLPITCHING')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLPITCHING' AND COLUMN_NAME != 'YEAR') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLPITCHING' AND COLUMN_NAME != 'TEAM') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLPITCHING' AND COLUMN_NAME != 'PITCHERID')
			          INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLPITCHING' AND COLUMN_NAME != 'LEAGUE'))";
		}
		if ($playertype == 'Position Player Batting')
		{
			$query = "((select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLBATTING')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLBATTING' AND COLUMN_NAME != 'YEAR') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLBATTING' AND COLUMN_NAME != 'TEAM') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLBATTING' AND COLUMN_NAME != 'PLAYERID')
			          INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLBATTING' AND COLUMN_NAME != 'LEAGUE'))";	
	    }
		   
		if ($playertype == 'Position Player Fielding')
		{
			$query = "((select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLFIELDING')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLFIELDING' AND COLUMN_NAME != 'YEAR') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLFIELDING' AND COLUMN_NAME != 'TEAM') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLFIELDING' AND COLUMN_NAME != 'PLAYERID')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLFIELDING' AND COLUMN_NAME != 'LEAGUE')
				   INTERSECT
				   (SELECT COLUMN_NAME FROM ALL_TAB_COLUMNS WHERE TABLE_NAME = 'BASEBALLFIELDING' AND COLUMN_NAME != 'POSITION'))";
		}
		     
		if ($playertype == 'Team'){
			$query = "((select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLTEAMS')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLTEAMS' AND COLUMN_NAME != 'YEAR') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLTEAMS' AND COLUMN_NAME != 'TEAM') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLTEAMS' AND COLUMN_NAME != 'FRANCHISE')
			          INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLTEAMS' AND COLUMN_NAME != 'LEAGUE')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLTEAMS' AND COLUMN_NAME != 'RANK')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLTEAMS' AND COLUMN_NAME != 'NAME')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLTEAMS' AND COLUMN_NAME != 'DIVISION') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLTEAMS' AND COLUMN_NAME != 'DIVISIONWIN') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLTEAMS' AND COLUMN_NAME != 'WILDCARDWIN')
			          INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLTEAMS' AND COLUMN_NAME != 'LEAGUEWIN')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASEBALLTEAMS' AND COLUMN_NAME != 'WORLDSERIESWIN'))";
		}
	}
	
	else if ($sport == 'Basketball')
	{
		if ($playertype == 'Coach'){
			$query = "((select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLCOACHES')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLCOACHES' AND COLUMN_NAME != 'YEAR') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLCOACHES' AND COLUMN_NAME != 'TEAM') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLCOACHES' AND COLUMN_NAME != 'COACHID')
			          INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLCOACHES' AND COLUMN_NAME != 'LEAGUE'))";
		}
		if ($playertype == 'Player'){
			$query = "((select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLPLAYERS')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLPLAYERS' AND COLUMN_NAME != 'YEAR') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLPLAYERS' AND COLUMN_NAME != 'TEAM') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLPLAYERS' AND COLUMN_NAME != 'PLAYERID')
			          INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLPLAYERS' AND COLUMN_NAME != 'LEAGUE'))";
		}
		if ($playertype == 'Team'){
			$query = "((select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLTEAMS')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLTEAMS' AND COLUMN_NAME != 'YEAR') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLTEAMS' AND COLUMN_NAME != 'TEAM') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLTEAMS' AND COLUMN_NAME != 'FRANCHISE')
			          INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLTEAMS' AND COLUMN_NAME != 'LEAGUE')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLTEAMS' AND COLUMN_NAME != 'RANK')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLTEAMS' AND COLUMN_NAME != 'NAME')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLTEAMS' AND COLUMN_NAME != 'DIVISION') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLTEAMS' AND COLUMN_NAME != 'CONFERENCE') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLTEAMS' AND COLUMN_NAME != 'CONFERENCERANK')
			          INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='BASKETBALLTEAMS' AND COLUMN_NAME != 'PLAYOFF'))";
		}
	}
	
	else if ($sport == 'Hockey')
	{
		if ($playertype == 'Coach'){
			$query = "((select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYCOACHES')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYCOACHES' AND COLUMN_NAME != 'YEAR') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYCOACHES' AND COLUMN_NAME != 'TEAM') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYCOACHES' AND COLUMN_NAME != 'COACHID')
			          INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYCOACHES' AND COLUMN_NAME != 'LEAGUE'))";
		}
		if ($playertype == 'Goalie'){
			$query = 
				   "((select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYGOALIES')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYGOALIES' AND COLUMN_NAME != 'YEAR') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYGOALIES' AND COLUMN_NAME != 'TEAM') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYGOALIES' AND COLUMN_NAME != 'GOALIEID')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYGOALIES' AND COLUMN_NAME != 'LEAGUE'))";
		}
		if ($playertype == 'Position Player'){
			$query = "((select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYSCORING')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYSCORING' AND COLUMN_NAME != 'YEAR') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYSCORING' AND COLUMN_NAME != 'TEAM') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYSCORING' AND COLUMN_NAME != 'PLAYERID')
			          INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYSCORING' AND COLUMN_NAME != 'LEAGUE'))";
		}
		if ($playertype == 'Team'){
			$query = "((select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYTEAMS')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYTEAMS' AND COLUMN_NAME != 'YEAR') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYTEAMS' AND COLUMN_NAME != 'TEAM') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYTEAMS' AND COLUMN_NAME != 'FRANCHISE')
			          INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYTEAMS' AND COLUMN_NAME != 'LEAGUE')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYTEAMS' AND COLUMN_NAME != 'RANK')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYTEAMS' AND COLUMN_NAME != 'NAME')
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYTEAMS' AND COLUMN_NAME != 'DIVISION') 
				   INTERSECT
				   (select COLUMN_NAME from ALL_TAB_COLUMNS where TABLE_NAME='HOCKEYTEAMS' AND COLUMN_NAME != 'PLAYOFF')
				   INTERSECT
				   (SELECT COLUMN_NAME FROM ALL_TAB_COLUMNS WHERE TABLE_NAME = 'HOCKEYTEAMS' AND COLUMN_NAME != 'CONFERENCE'))";
		}
	}
	$statement = oci_parse($connection, $query);
	
	oci_execute($statement);
	
	echo '<font size = "4">Select statistic: </font>';
	echo '<select name="stats" id = "stats">';
	echo '<option value = "-1">Select:</option>';
	while($row=oci_fetch_assoc($statement)) {
		echo '<option value="' . $row['COLUMN_NAME'] . '">' . $row['COLUMN_NAME']. ' ' . '</option>';
	}
	echo "</select> \n";	
	//
	// VERY important to close Oracle Database Connections and free statements!
	//
	oci_free_statement($statement);
	oci_close($connection);
	//nigger
?>
