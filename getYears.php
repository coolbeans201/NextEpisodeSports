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
	// Escape User Input to help prevent SQL Injection
	//$sport = mysql_real_escape_string($sport);
	
	if ($sport == 'baseball')
	{
		$query = "SELECT DISTINCT year FROM BaseballTeams ORDER BY year";
	}
	
	else if ($sport == 'basketball')
	{
		$query = "SELECT DISTINCT year FROM BasketballTeams ORDER BY year";
	}
	
	else if ($sport == 'hockey')
	{
		$query = "SELECT DISTINCT year FROM HockeyTeams ORDER BY year";																	  
	}
	
	$statement = oci_parse($connection, $query);
	$statement2 = oci_parse($connection, $query);	
	oci_execute($statement);
	oci_execute($statement2);
	echo "Select beginning year: ";
	echo '<select name="begYear">';
	echo '<option value = "-1">Select:</option>';
	while($row=oci_fetch_assoc($statement)) {
			echo '<option>' . $row['YEAR'] .'</option>';
	}
	echo "</select> \n";
	echo "Select end year: "	
	echo '<select name="endYear">';
	echo '<option value = "-1">Select:</option>';
	while($row=oci_fetch_assoc($statement2)) {
		echo '<option>' . $row['YEAR'] .'</option>';
	}
	
	echo "</select> \n";
	
	//
	// VERY important to close Oracle Database Connections and free statements!
	//
	oci_free_statement($statement);
	oci_free_statement($statement2);
	oci_close($connection);
