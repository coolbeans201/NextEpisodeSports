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
	
	if ($sport == 'Baseball')
	{
		if($playertype == 'Team')
		{
			$query = "SELECT DISTINCT year FROM BaseballTeams ORDER BY year";
		}
		if($playertype == 'Pitcher')
		{
			$query = "SELECT DISTINCT year FROM BaseballPitching ORDER BY year";
		}
		if($playertype == 'Position Player Batting')
		{
			$query = "SELECT DISTINCT year FROM BasebalBatting ORDER BY year";
		}
		if($playertype == 'Position Player Fielding')
		{
			$query = "SELECT DISTINCT year FROM BaseballFielding ORDER BY year";
		}
		if($playertype == 'Manager')
		{
			$query = "SELECT DISTINCT year FROM BaseballManagers ORDER BY year";
		}
	}
	
	else if ($sport == 'Basketball')
	{
		if($playertype == 'Team')
		{
			$query = "SELECT DISTINCT year FROM BasketballTeams ORDER BY year";
		}
		if($playertype == 'Coach')
		{
			$query = "SELECT DISTINCT year FROM BasketballCoaches ORDER BY year";
		}
		if($playertype == 'Player')
		{
			$query = "SELECT DISTINCT year FROM BasketballPlayers ORDER BY year";
		}
	}
	
	else if ($sport == 'Hockey')
	{
		if($playertype == 'Team')
		{
			$query = "SELECT DISTINCT year FROM HockeyTeams ORDER BY year";
		}
		if($playertype == 'Coach')
		{
			$query = "SELECT DISTINCT year FROM HockeyCoaches ORDER BY year";
		}
		if($playertype == 'Position Player')
		{
			$query = "SELECT DISTINCT year FROM HockeyScoring ORDER BY year";
		}
		if($playertype == 'Goalie')
		{
			$query = "SELECT DISTINCT year FROM HockeyGoalies ORDER BY year";
		}	
	}
	
	
	$statement = oci_parse($connection, $query);
	$statement2 = oci_parse($connection, $query);	
	oci_execute($statement);
	oci_execute($statement2);
	
	

	echo "Select beginning year: ";
	echo '<select name="begYear" id = "year1">';
	echo '<option value = "-1">Select:</option>';
	
	
	while($row=oci_fetch_assoc($statement)) {
			echo '<option value="' . $row['YEAR'] . '">' . $row['YEAR'] .'</option>';
	}
	
	
	echo "</select> \n";
	echo "Select end year: ";	
	echo '<select name="endYear" id = "year2">';
	echo '<option value = "-1">Select:</option>';
	while($row=oci_fetch_assoc($statement2)) {
		echo '<option value="' . $row['YEAR'] . '">' . $row['YEAR'] .'</option>';
	}
	
	echo "</select> \n";
	//
	// VERY important to close Oracle Database Connections and free statements!
	//
	oci_free_statement($statement);
	oci_free_statement($statement2);
	oci_close($connection);
?>


