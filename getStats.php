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
	$operation = $_GET['operation'];
	$stats = $_GET['stats'];
	$begYear = $_GET['begYear'];
	$endYear = $_GET['endYear'];
	if($sport == 'Baseball')
	{
		if($playertype == 'Manager')
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM baseballmanagers 
						      WHERE baseballmanagers.year <= ". $begYear ." and baseballmanagers.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM baseballmanagers 
						      WHERE baseballmanagers.year >= ". $begYear ." and baseballmanagers.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM baseballmanagers 
						      WHERE baseballmanagers.year <= ". $begYear ." and baseballmanagers.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM baseballmanagers 
						      WHERE baseballmanagers.year >= ". $begYear ." and baseballmanagers.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballmanagers.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM baseballmanagers 
						                 WHERE baseballmanagers.year <= ". $begYear ." and baseballmanagers.year >= ". $endYear.")a, baseballmanagers, baseballmaster
							   where baseballmanagers.".$stats." = minimum and baseballmanagers.year <= ". $begYear ." and baseballmanagers.year >= ". $endYear." and baseballmanagers.managerid = baseballmaster.managerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballmanagers.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM baseballmanagers 
						                 WHERE baseballmanagers.year >= ". $begYear ." and baseballmanagers.year <= ". $endYear.")a, baseballmanagers, baseballmaster
							   where baseballmanagers.".$stats." = minimum and baseballmanagers.year >= ". $begYear ." and baseballmanagers.year <= ". $endYear." and baseballmanagers.managerid = baseballmaster.managerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballmanagers.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM baseballmanagers 
						                 WHERE baseballmanagers.year <= ". $begYear ." and baseballmanagers.year >= ". $endYear.")a, baseballmanagers, baseballmaster
							   where baseballmanagers.".$stats." = maximum and baseballmanagers.year <= ". $begYear ." and baseballmanagers.year >= ". $endYear." and baseballmanagers.managerid = baseballmaster.managerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballmanagers.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM baseballmanagers 
						                 WHERE baseballmanagers.year >= ". $begYear ." and baseballmanagers.year <= ". $endYear.")a, baseballmanagers, baseballmaster
							   where baseballmanagers.".$stats." = maximum and baseballmanagers.year >= ". $begYear ." and baseballmanagers.year <= ". $endYear." and baseballmanagers.managerid = baseballmaster.managerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
		}
		else if ($playertype == 'Pitcher')
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM baseballpitching 
						      WHERE baseballpitching.year <= ". $begYear ." and baseballpitching.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM baseballpitching
						      WHERE baseballpitching.year >= ". $begYear ." and baseballpitching.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM baseballpitching 
						      WHERE baseballpitching.year <= ". $begYear ." and baseballpitching.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM baseballpitching 
						      WHERE baseballpitching.year >= ". $begYear ." and baseballpitching.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballpitching.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM baseballpitching 
						                 WHERE baseballpitching.year <= ". $begYear ." and baseballpitching.year >= ". $endYear.")a, baseballpitching, baseballmaster
							   where baseballpitching.".$stats." = minimum and baseballpitching.year <= ". $begYear ." and baseballpitching.year >= ". $endYear." and baseballpitching.pitcherid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballpitching.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM baseballpitching 
						                 WHERE baseballpitching.year >= ". $begYear ." and baseballpitching.year <= ". $endYear.")a, baseballpitching, baseballmaster
							   where baseballpitching.".$stats." = minimum and baseballpitching.year >= ". $begYear ." and baseballpitching.year <= ". $endYear." and baseballpitching.pitcherid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballpitching.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM baseballpitching 
						                 WHERE baseballpitching.year <= ". $begYear ." and baseballpitching.year >= ". $endYear.")a, baseballpitching, baseballmaster
							   where baseballpitching.".$stats." = maximum and baseballpitching.year <= ". $begYear ." and baseballpitching.year >= ". $endYear." and baseballpitching.pitcherid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballpitching.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM baseballpitching 
						                 WHERE baseballpitching.year >= ". $begYear ." and baseballpitching.year <= ". $endYear.")a, baseballpitching, baseballmaster
							   where baseballpitching.".$stats." = maximum and baseballpitching.year >= ". $begYear ." and baseballpitching.year <= ". $endYear." and baseballpitching.pitcherid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
		}
		else if ($playertype == 'Position Player Batting')
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM baseballbatting 
						      WHERE baseballbatting.year <= ". $begYear ." and baseballbatting.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM baseballbatting
						      WHERE baseballbatting.year >= ". $begYear ." and baseballbatting.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM baseballbatting
						      WHERE baseballbatting.year <= ". $begYear ." and baseballbatting.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM baseballbatting 
						      WHERE baseballbatting.year >= ". $begYear ." and baseballbatting.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballbatting.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM baseballbatting 
						                 WHERE baseballbatting.year <= ". $begYear ." and baseballbatting.year >= ". $endYear.")a, baseballbatting, baseballmaster
							   where baseballbatting.".$stats." = minimum and baseballbatting.year <= ". $begYear ." and baseballbatting.year >= ". $endYear." and baseballbatting.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballbatting.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM baseballbatting 
						                 WHERE baseballbatting.year >= ". $begYear ." and baseballbatting.year <= ". $endYear.")a, baseballbatting, baseballmaster
							   where baseballbatting.".$stats." = minimum and baseballbatting.year >= ". $begYear ." and baseballbatting.year <= ". $endYear." and baseballbatting.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballbatting.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM baseballbatting
						                 WHERE baseballbatting.year <= ". $begYear ." and baseballbatting.year >= ". $endYear.")a, baseballbatting, baseballmaster
							   where baseballbatting.".$stats." = maximum and baseballbatting.year <= ". $begYear ." and baseballbatting.year >= ". $endYear." and baseballbatting.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballbatting.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM baseballbatting 
						                 WHERE baseballbatting.year >= ". $begYear ." and baseballbatting.year <= ". $endYear.")a, baseballbatting, baseballmaster
							   where baseballbatting.".$stats." = maximum and baseballbatting.year >= ". $begYear ." and baseballbatting.year <= ". $endYear." and baseballbatting.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
		}
		else if ($playertype == 'Position Player Fielding')
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM baseballfielding 
						      WHERE baseballfielding.year <= ". $begYear ." and baseballfielding.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM baseballfielding
						      WHERE baseballfielding.year >= ". $begYear ." and baseballfielding.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM baseballfielding
						      WHERE baseballfielding.year <= ". $begYear ." and baseballfielding.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM baseballfielding 
						      WHERE baseballfielding.year >= ". $begYear ." and baseballfielding.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballfielding.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM baseballfielding 
						                 WHERE baseballfielding.year <= ". $begYear ." and baseballfielding.year >= ". $endYear.")a, baseballfielding, baseballmaster
							   where baseballfielding.".$stats." = minimum and baseballfielding.year <= ". $begYear ." and baseballfielding.year >= ". $endYear." and baseballfielding.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballfielding.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM baseballfielding 
						                 WHERE baseballfielding.year >= ". $begYear ." and baseballfielding.year <= ". $endYear.")a, baseballfielding, baseballmaster
							   where baseballfielding.".$stats." = minimum and baseballfielding.year >= ". $begYear ." and baseballfielding.year <= ". $endYear." and baseballfielding.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballfielding.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM baseballfielding
						                 WHERE baseballfielding.year <= ". $begYear ." and baseballfielding.year >= ". $endYear.")a, baseballfielding, baseballmaster
							   where baseballfielding.".$stats." = maximum and baseballfielding.year <= ". $begYear ." and baseballfielding.year >= ". $endYear." and baseballfielding.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, baseballfielding.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM baseballfielding 
						                 WHERE baseballfielding.year >= ". $begYear ." and baseballfielding.year <= ". $endYear.")a, baseballfielding, baseballmaster
							   where baseballfielding.".$stats." = maximum and baseballfielding.year >= ". $begYear ." and baseballfielding.year <= ". $endYear." and baseballfielding.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
		}
		else
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM baseballteams 
						      WHERE baseballteams.year <= ". $begYear ." and baseballteams.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM baseballteams
						      WHERE baseballteams.year >= ". $begYear ." and baseballteams.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM baseballteams
						      WHERE baseballteams.year <= ". $begYear ." and baseballteams.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM baseballteams 
						      WHERE baseballteams.year >= ". $begYear ." and baseballteams.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballteams.name, baseballteams.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM baseballteams
						                 WHERE baseballteams.year <= ". $begYear ." and baseballteams.year >= ". $endYear.")a, baseballteams
							   where baseballteams.".$stats." = minimum and baseballteams.year <= ". $begYear ." and baseballteams.year >= ". $endYear."";
				}
				else
				{
					$query = "select distinct baseballteams.name, baseballteams.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM baseballteams 
						                 WHERE baseballteams.year >= ". $begYear ." and baseballteams.year <= ". $endYear.")a, baseballteams
							   where baseballteams.".$stats." = minimum and baseballteams.year >= ". $begYear ." and baseballteams.year <= ". $endYear."";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballteams.name, baseballteams.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM baseballteams
						                 WHERE baseballteams.year <= ". $begYear ." and baseballteams.year >= ". $endYear.")a, baseballteams
							   where baseballteams.".$stats." = maximum and baseballteams.year <= ". $begYear ." and baseballteams.year >= ". $endYear."";
				}
				else
				{
					$query = "select distinct baseballteams.name, baseballteams.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM baseballteams 
						                 WHERE baseballteams.year >= ". $begYear ." and baseballteams.year <= ". $endYear.")a, baseballteams
							   where baseballteams.".$stats." = maximum and baseballteams.year >= ". $begYear ." and baseballteams.year <= ". $endYear."";
				}
			}
		}
	}
	else if($sport == 'Basketball')
	{
		if($playertype == 'Coach')
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM basketballcoaches
						      WHERE basketballcoaches.year <= ". $begYear ." and basketballcoaches.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM basketballcoaches 
						      WHERE basketballcoaches.year >= ". $begYear ." and basketballcoaches.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM basketballcoaches 
						      WHERE basketballcoaches.year <= ". $begYear ." and basketballcoaches.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM basketballcoaches 
						      WHERE basketballcoaches.year >= ". $begYear ." and basketballcoaches.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, basketballcoaches.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM basketballcoaches 
						                 WHERE basketballcoaches.year <= ". $begYear ." and basketballcoaches.year >= ". $endYear.")a, basketballcoaches, basketballmaster
							   where basketballcoaches.".$stats." = minimum and basketballcoaches.year <= ". $begYear ." and basketballcoaches.year >= ". $endYear." and basketballcoaches.coachid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, basketballcoaches.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM basketballcoaches 
						                 WHERE basketballcoaches.year >= ". $begYear ." and basketballcoaches.year <= ". $endYear.")a, basketballcoaches, basketballmaster
							   where basketballcoaches.".$stats." = minimum and basketballcoaches.year >= ". $begYear ." and basketballcoaches.year <= ". $endYear." and basketballcoaches.coachid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, basketballcoaches.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM basketballcoaches 
						                 WHERE basketballcoaches.year <= ". $begYear ." and basketballcoaches.year >= ". $endYear.")a, basketballcoaches, basketballmaster
							   where basketballcoaches.".$stats." = maximum and basketballcoaches.year <= ". $begYear ." and basketballcoaches.year >= ". $endYear." and basketballcoaches.coachid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, basketballcoaches.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM basketballcoaches 
						                 WHERE basketballcoaches.year >= ". $begYear ." and basketballcoaches.year <= ". $endYear.")a, basketballcoaches, basketballmaster
							   where basketballcoaches.".$stats." = maximum and basketballcoaches.year >= ". $begYear ." and basketballcoaches.year <= ". $endYear." and basketballcoaches.coachid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
			}
		}
		else if($playertype == 'Player')
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM basketballplayers
						      WHERE basketballplayers.year <= ". $begYear ." and basketballplayers.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM basketballplayers 
						      WHERE basketballplayers.year >= ". $begYear ." and basketballplayers.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM basketballplayers 
						      WHERE basketballplayers.year <= ". $begYear ." and basketballplayers.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM basketballplayers 
						      WHERE basketballplayers.year >= ". $begYear ." and basketballplayers.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, basketballplayers.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM basketballplayers 
						                 WHERE basketballplayers.year <= ". $begYear ." and basketballplayers.year >= ". $endYear." and)a, basketballplayers, basketballmaster
							   where basketballplayers.".$stats." = minimum and basketballplayers.year <= ". $begYear ." and basketballplayers.year >= ". $endYear." and basketballplayers.playerid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, basketballplayers.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM basketballplayers 
						                 WHERE basketballplayers.year >= ". $begYear ." and basketballplayers.year <= ". $endYear.")a, basketballplayers, basketballmaster
							   where basketballplayers.".$stats." = minimum and basketballplayers.year >= ". $begYear ." and basketballplayers.year <= ". $endYear." and basketballplayers.playerid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, basketballplayers.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM basketballplayers 
						                 WHERE basketballplayers.year <= ". $begYear ." and basketballplayers.year >= ". $endYear.")a, basketballplayers, basketballmaster
							   where basketballplayers.".$stats." = maximum and basketballplayers.year <= ". $begYear ." and basketballplayers.year >= ". $endYear." and basketballplayers.playerid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, basketballplayers.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM basketballplayers 
						                 WHERE basketballplayers.year >= ". $begYear ." and basketballplayers.year <= ". $endYear.")a, basketballplayers, basketballmaster
							   where basketballplayers.".$stats." = maximum and basketballplayers.year >= ". $begYear ." and basketballplayers.year <= ". $endYear." and basketballplayers.playerid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
			}
		}
		else
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM basketballteams 
						      WHERE basketballteams.year <= ". $begYear ." and basketballteams.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM basketballteams
						      WHERE basketballteams.year >= ". $begYear ." and basketballteams.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM basketballteams
						      WHERE basketballteams.year <= ". $begYear ." and basketballteams.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM basketballteams 
						      WHERE basketballteams.year >= ". $begYear ." and basketballteams.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct basketballteams.name, basketballteams.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM basketballteams
						                 WHERE basketballteams.year <= ". $begYear ." and basketballteams.year >= ". $endYear.")a, basketballteams
							   where basketballteams.".$stats." = minimum and basketballteams.year <= ". $begYear ." and basketballteams.year >= ". $endYear."";
				}
				else
				{
					$query = "select distinct basketballteams.name, basketballteams.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM basketballteams 
						                 WHERE basketballteams.year >= ". $begYear ." and basketballteams.year <= ". $endYear.")a, basketballteams
							   where basketballteams.".$stats." = minimum and basketballteams.year >= ". $begYear ." and basketballteams.year <= ". $endYear."";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct basketballteams.name, basketballteams.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM basketballteams
						                 WHERE basketballteams.year <= ". $begYear ." and basketballteams.year >= ". $endYear.")a, basketballteams
							   where basketballteams.".$stats." = maximum and basketballteams.year <= ". $begYear ." and basketballteams.year >= ". $endYear."";
				}
				else
				{
					$query = "select distinct basketballteams.name, basketballteams.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM basketballteams 
						                 WHERE basketballteams.year >= ". $begYear ." and basketballteams.year <= ". $endYear.")a, basketballteams
							   where basketballteams.".$stats." = maximum and basketballteams.year >= ". $begYear ." and basketballteams.year <= ". $endYear."";
				}
			}
		}
	}
	else
	{
		if($playertype == 'Coach')
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM hockeycoaches 
						      WHERE hockeycoaches.year <= ". $begYear ." and hockeycoaches.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM hockeycoaches 
						      WHERE hockeycoaches.year >= ". $begYear ." and hockeycoaches.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM hockeycoaches 
						      WHERE hockeycoaches.year <= ". $begYear ." and hockeycoaches.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM hockeycoaches 
						      WHERE hockeycoaches.year >= ". $begYear ." and hockeycoaches.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, hockeycoaches.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM hockeycoaches 
						                 WHERE hockeycoaches.year <= ". $begYear ." and hockeycoaches.year >= ". $endYear.")a, hockeycoaches, hockeymaster
							   where hockeycoaches.".$stats." = minimum and hockeycoaches.year <= ". $begYear ." and hockeycoaches.year >= ". $endYear." and hockeycoaches.coachid = hockeymaster.coachid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
				else
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, hockeycoaches.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM hockeycoaches 
						                 WHERE hockeycoaches.year >= ". $begYear ." and hockeycoaches.year <= ". $endYear.")a, hockeycoaches, hockeymaster
							   where hockeycoaches.".$stats." = minimum and hockeycoaches.year >= ". $begYear ." and hockeycoaches.year <= ". $endYear." and hockeycoaches.coachid = hockeymaster.coachid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, hockeycoaches.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM hockeycoaches 
						                 WHERE hockeycoaches.year <= ". $begYear ." and hockeycoaches.year >= ". $endYear.")a, hockeycoaches, hockeymaster
							   where hockeycoaches.".$stats." = maximum and hockeycoaches.year <= ". $begYear ." and hockeycoaches.year >= ". $endYear." and hockeycoaches.coachid = hockeymaster.coachid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
				else
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, hockeycoaches.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM hockeycoaches 
						                 WHERE hockeycoaches.year >= ". $begYear ." and hockeycoaches.year <= ". $endYear.")a, hockeycoaches, hockeymaster
							   where hockeycoaches.".$stats." = maximum and hockeycoaches.year >= ". $begYear ." and hockeycoaches.year <= ". $endYear." and hockeycoaches.coachid = hockeymaster.coachid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
			}
		}
		else if ($playertype == 'Goalie')
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM hockeygoalies 
						      WHERE hockeygoalies.year <= ". $begYear ." and hockeygoalies.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM hockeygoalies
						      WHERE hockeygoalies.year >= ". $begYear ." and hockeygoalies.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM hockeygoalies 
						      WHERE hockeygoalies.year <= ". $begYear ." and hockeygoalies.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM hockeygoalies 
						      WHERE hockeygoalies.year >= ". $begYear ." and hockeygoalies.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, hockeygoalies.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM hockeygoalies 
						                 WHERE hockeygoalies.year <= ". $begYear ." and hockeygoalies.year >= ". $endYear.")a, hockeygoalies, hockeymaster
							   where hockeygoalies.".$stats." = minimum and hockeygoalies.year <= ". $begYear ." and hockeygoalies.year >= ". $endYear." and hockeygoalies.goalieid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
				else
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, hockeygoalies.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM hockeygoalies 
						                 WHERE hockeygoalies.year >= ". $begYear ." and hockeygoalies.year <= ". $endYear.")a, hockeygoalies, hockeymaster
							   where hockeygoalies.".$stats." = minimum and hockeygoalies.year >= ". $begYear ." and hockeygoalies.year <= ". $endYear." and hockeygoalies.goalieid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, hockeygoalies.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM hockeygoalies 
						                 WHERE hockeygoalies.year <= ". $begYear ." and hockeygoalies.year >= ". $endYear.")a, hockeygoalies, hockeymaster
							   where hockeygoalies.".$stats." = maximum and hockeygoalies.year <= ". $begYear ." and hockeygoalies.year >= ". $endYear." and hockeygoalies.goalieid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
				else
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, hockeygoalies.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM hockeygoalies 
						                 WHERE hockeygoalies.year >= ". $begYear ." and hockeygoalies.year <= ". $endYear.")a, hockeygoalies, hockeymaster
							   where hockeygoalies.".$stats." = maximum and hockeygoalies.year >= ". $begYear ." and hockeygoalies.year <= ". $endYear." and hockeygoalies.goalieid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
			}
		}
		else if($playertype == 'Position Player')
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM hockeyscoring 
						      WHERE hockeyscoring.year <= ". $begYear ." and hockeyscoring.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM hockeyscoring
						      WHERE hockeyscoring.year >= ". $begYear ." and hockeyscoring.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM hockeyscoring 
						      WHERE hockeyscoring.year <= ". $begYear ." and hockeyscoring.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM hockeyscoring 
						      WHERE hockeyscoring.year >= ". $begYear ." and hockeyscoring.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, hockeyscoring.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM hockeyscoring 
						                 WHERE hockeyscoring.year <= ". $begYear ." and hockeyscoring.year >= ". $endYear.")a, hockeyscoring, hockeymaster
							   where hockeyscoring.".$stats." = minimum and hockeyscoring.year <= ". $begYear ." and hockeyscoring.year >= ". $endYear." and hockeyscoring.playerid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
				else
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, hockeyscoring.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM hockeyscoring 
						                 WHERE hockeyscoring.year >= ". $begYear ." and hockeyscoring.year <= ". $endYear.")a, hockeyscoring, hockeymaster
							   where hockeyscoring.".$stats." = minimum and hockeyscoring.year >= ". $begYear ." and hockeyscoring.year <= ". $endYear." and hockeyscoring.playerid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, hockeyscoring.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM hockeyscoring 
						                 WHERE hockeyscoring.year <= ". $begYear ." and hockeyscoring.year >= ". $endYear.")a, hockeyscoring, hockeymaster
							   where hockeyscoring.".$stats." = maximum and hockeyscoring.year <= ". $begYear ." and hockeyscoring.year >= ". $endYear." and hockeyscoring.playerid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
				else
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, hockeyscoring.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM hockeyscoring 
						                 WHERE hockeyscoring.year >= ". $begYear ." and hockeyscoring.year <= ". $endYear.")a, hockeyscoring, hockeymaster
							   where hockeyscoring.".$stats." = maximum and hockeyscoring.year >= ". $begYear ." and hockeyscoring.year <= ". $endYear." and hockeyscoring.playerid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
			}
		}
		else
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM hockeyteams 
						      WHERE hockeyteams.year <= ". $begYear ." and hockeyteams.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(". $stats .")),3)
						      FROM hockeyteams
						      WHERE hockeyteams.year >= ". $begYear ." and hockeyteams.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM hockeyteams
						      WHERE hockeyteams.year <= ". $begYear ." and hockeyteams.year >= ". $endYear." ";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(". $stats .")),3)
						      FROM hockeyteams 
						      WHERE hockeyteams.year >= ". $begYear ." and hockeyteams.year <= ". $endYear." ";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct hockeyteams.name, hockeyteams.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM hockeyteams
						                 WHERE hockeyteams.year <= ". $begYear ." and hockeyteams.year >= ". $endYear.")a, hockeyteams
							   where hockeyteams.".$stats." = minimum and hockeyteams.year <= ". $begYear ." and hockeyteams.year >= ". $endYear."";
				}
				else
				{
					$query = "select distinct hockeyteams.name, hockeyteams.year, a.minimum
					          from      (SELECT  MIN(". $stats .") minimum
										 FROM hockeyteams 
						                 WHERE hockeyteams.year >= ". $begYear ." and hockeyteams.year <= ". $endYear.")a, hockeyteams
							   where hockeyteams.".$stats." = minimum and hockeyteams.year >= ". $begYear ." and hockeyteams.year <= ". $endYear."";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct hockeyteams.name, hockeyteams.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM hockeyteams
						                 WHERE hockeyteams.year <= ". $begYear ." and hockeyteams.year >= ". $endYear.")a, hockeyteams
							   where hockeyteams.".$stats." = maximum and hockeyteams.year <= ". $begYear ." and hockeyteams.year >= ". $endYear."";
				}
				else
				{
					$query = "select distinct hockeyteams.name, hockeyteams.year, a.maximum
					          from      (SELECT  MAX(". $stats .") maximum
										 FROM hockeyteams 
						                 WHERE hockeyteams.year >= ". $begYear ." and hockeyteams.year <= ". $endYear.")a, hockeyteams
							   where hockeyteams.".$stats." = maximum and hockeyteams.year >= ". $begYear ." and hockeyteams.year <= ". $endYear."";
				}
			}
		}
	}
	$statement = oci_parse($connection, $query);
	oci_execute($statement);
	echo '<font size = "4"><b>Result</b></font><br>';
	echo "<table border='1'>\n";
	if($operation == 'average')
	{
		echo '<tr>';
		echo '<th>Number</th>';
		echo '</tr>';
	}
	if($operation == 'standardDeviation')
	{
		echo '<tr>';
		echo '<th>Number</th>';
		echo '</tr>';
	}
	if($operation == 'min' || $operation == 'max')
	{
		if($playertype == 'Team')
		{
			echo '<tr>';
			echo '<th>Name</th>';
			echo '<th>Year</th>';
			echo '<th>Number</th>';
			echo '</tr>';
		}
		else
		{
			echo '<tr>';
			echo '<th>First Name</th>';
			echo '<th>Last Name</th>';
			echo '<th>Year</th>';
			echo '<th>Number</th>';
			echo '</tr>';
		}
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
	oci_free_statement($statement);
	oci_close($connection);
?>
