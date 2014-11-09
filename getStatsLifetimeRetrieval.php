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
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, baseballmanagers.managerid
									from baseballmanagers
									where baseballmanagers.year <= ". $begYear ." and baseballmanagers.year >= ".$endYear."
									group by baseballmanagers.managerid)";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, baseballmanagers.managerid
									from baseballmanagers
									where baseballmanagers.year >= ". $begYear ." and baseballmanagers.year <= ".$endYear."
									group by baseballmanagers.managerid) ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, baseballmanagers.managerid
									from baseballmanagers
									where baseballmanagers.year <= ". $begYear ." and baseballmanagers.year >= ".$endYear."
									group by baseballmanagers.managerid)";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, baseballmanagers.managerid
									from baseballmanagers
									where baseballmanagers.year >= ". $begYear ." and baseballmanagers.year <= ".$endYear."
									group by baseballmanagers.managerid)";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballmanagers.managerid, sum(baseballmanagers.".$stats.") total1
									from baseballmanagers
									where baseballmanagers.year <= ".$begYear." and baseballmanagers.year >= ".$endYear."
									group by baseballmanagers.managerid
									having sum(baseballmanagers.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, baseballmanagers.managerid
																						from baseballmanagers
																						where baseballmanagers.year <= ".$begYear." and baseballmanagers.year >= ".$endYear."
																						group by baseballmanagers.managerid)
																				))b, baseballmanagers, baseballmaster
							where b.managerid = baseballmanagers.managerid and baseballmanagers.managerid = baseballmaster.managerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballmanagers.managerid, sum(baseballmanagers.".$stats.") total1
									from baseballmanagers
									where baseballmanagers.year >= ".$begYear." and baseballmanagers.year <= ".$endYear."
									group by baseballmanagers.managerid
									having sum(baseballmanagers.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, baseballmanagers.managerid
																						from baseballmanagers
																						where baseballmanagers.year >= ".$begYear." and baseballmanagers.year <= ".$endYear."
																						group by baseballmanagers.managerid)
																				))b, baseballmanagers, baseballmaster
							where b.managerid = baseballmanagers.managerid and baseballmanagers.managerid = baseballmaster.managerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballmanagers.managerid, sum(baseballmanagers.".$stats.") total1
									from baseballmanagers
									where baseballmanagers.year <= ".$begYear." and baseballmanagers.year >= ".$endYear."
									group by baseballmanagers.managerid
									having sum(baseballmanagers.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, baseballmanagers.managerid
																						from baseballmanagers
																						where baseballmanagers.year <= ".$begYear." and baseballmanagers.year >= ".$endYear."
																						group by baseballmanagers.managerid)
																				))b, baseballmanagers, baseballmaster
							where b.managerid = baseballmanagers.managerid and baseballmanagers.managerid = baseballmaster.managerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballmanagers.managerid, sum(baseballmanagers.".$stats.") total1
									from baseballmanagers
									where baseballmanagers.year >= ".$begYear." and baseballmanagers.year <= ".$endYear."
									group by baseballmanagers.managerid
									having sum(baseballmanagers.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, baseballmanagers.managerid
																						from baseballmanagers
																						where baseballmanagers.year >= ".$begYear." and baseballmanagers.year <= ".$endYear."
																						group by baseballmanagers.managerid)
																				))b, baseballmanagers, baseballmaster
							where b.managerid = baseballmanagers.managerid and baseballmanagers.managerid = baseballmaster.managerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
		}
		else if ($playertype == 'Pitcher')
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, baseballpitching.pitcherid
									from baseballpitching
									where baseballpitching.year <= ". $begYear ." and baseballpitching.year >= ".$endYear."
									group by baseballpitching.pitcherid)";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, baseballpitching.pitcherid
									from baseballpitching
									where baseballpitching.year >= ". $begYear ." and baseballpitching.year <= ".$endYear."
									group by baseballpitching.pitcherid) ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, baseballpitching.pitcherid
									from baseballpitching
									where baseballpitching.year <= ". $begYear ." and baseballpitching.year >= ".$endYear."
									group by baseballpitching.pitcherid)";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, baseballpitching.pitcherid
									from baseballpitching
									where baseballpitching.year >= ". $begYear ." and baseballpitching.year <= ".$endYear."
									group by baseballpitching.pitcherid)";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballpitching.pitcherid, sum(baseballpitching.".$stats.") total1
									from baseballpitching
									where baseballpitching.year <= ".$begYear." and baseballpitching.year >= ".$endYear."
									group by baseballpitching.pitcherid
									having sum(baseballpitching.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, baseballpitching.pitcherid
																						from baseballpitching
																						where baseballpitching.year <= ".$begYear." and baseballpitching.year >= ".$endYear."
																						group by baseballpitching.pitcherid)
																				))b, baseballpitching, baseballmaster
							where b.pitcherid = baseballpitching.pitcherid and baseballpitching.pitcherid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballpitching.pitcherid, sum(baseballpitching.".$stats.") total1
									from baseballpitching
									where baseballpitching.year >= ".$begYear." and baseballpitching.year <= ".$endYear."
									group by baseballpitching.pitcherid
									having sum(baseballpitching.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, baseballpitching.pitcherid
																						from baseballpitching
																						where baseballpitching.year >= ".$begYear." and baseballpitching.year <= ".$endYear."
																						group by baseballpitching.pitcherid)
																				))b, baseballpitching, baseballmaster
							where b.pitcherid = baseballpitching.pitcherid and baseballpitching.pitcherid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballpitching.pitcherid, sum(baseballpitching.".$stats.") total1
									from baseballpitching
									where baseballpitching.year <= ".$begYear." and baseballpitching.year >= ".$endYear."
									group by baseballpitching.pitcherid
									having sum(baseballpitching.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, baseballpitching.pitcherid
																						from baseballpitching
																						where baseballpitching.year <= ".$begYear." and baseballpitching.year >= ".$endYear."
																						group by baseballpitching.pitcherid)
																				))b, baseballpitching, baseballmaster
							where b.pitcherid = baseballpitching.pitcherid and baseballpitching.pitcherid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballpitching.pitcherid, sum(baseballpitching.".$stats.") total1
									from baseballpitching
									where baseballpitching.year >= ".$begYear." and baseballpitching.year <= ".$endYear."
									group by baseballpitching.pitcherid
									having sum(baseballpitching.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, baseballpitching.pitcherid
																						from baseballpitching
																						where baseballpitching.year >= ".$begYear." and baseballpitching.year <= ".$endYear."
																						group by baseballpitching.pitcherid)
																				))b, baseballpitching, baseballmaster
							where b.pitcherid = baseballpitching.pitcherid and baseballpitching.pitcherid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
		}
		else if ($playertype == 'Position Player Batting')
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, baseballbatting.playerid
									from baseballbatting
									where baseballbatting.year <= ". $begYear ." and baseballbatting.year >= ".$endYear."
									group by baseballbatting.playerid)";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, baseballbatting.playerid
									from baseballbatting
									where baseballbatting.year >= ". $begYear ." and baseballbatting.year <= ".$endYear."
									group by baseballbatting.playerid) ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, baseballbatting.playerid
									from baseballbatting
									where baseballbatting.year <= ". $begYear ." and baseballbatting.year >= ".$endYear."
									group by baseballbatting.playerid)";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, baseballbatting.playerid
									from baseballbatting
									where baseballbatting.year >= ". $begYear ." and baseballbatting.year <= ".$endYear."
									group by baseballbatting.playerid)";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballbatting.playerid, sum(baseballbatting.".$stats.") total1
									from baseballbatting
									where baseballbatting.year <= ".$begYear." and baseballbatting.year >= ".$endYear."
									group by baseballbatting.playerid
									having sum(baseballbatting.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, baseballbatting.playerid
																						from baseballbatting
																						where baseballbatting.year <= ".$begYear." and baseballbatting.year >= ".$endYear."
																						group by baseballbatting.playerid)
																				))b, baseballbatting, baseballmaster
							where b.playerid = baseballbatting.playerid and baseballbatting.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballbatting.playerid, sum(baseballbatting.".$stats.") total1
									from baseballbatting
									where baseballbatting.year >= ".$begYear." and baseballbatting.year <= ".$endYear."
									group by baseballbatting.playerid
									having sum(baseballbatting.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, baseballbatting.playerid
																						from baseballbatting
																						where baseballbatting.year >= ".$begYear." and baseballbatting.year <= ".$endYear."
																						group by baseballbatting.playerid)
																				))b, baseballbatting, baseballmaster
							where b.playerid = baseballbatting.playerid and baseballbatting.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballbatting.playerid, sum(baseballbatting.".$stats.") total1
									from baseballbatting
									where baseballbatting.year <= ".$begYear." and baseballbatting.year >= ".$endYear."
									group by baseballbatting.playerid
									having sum(baseballbatting.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, baseballbatting.playerid
																						from baseballbatting
																						where baseballbatting.year <= ".$begYear." and baseballbatting.year >= ".$endYear."
																						group by baseballbatting.playerid)
																				))b, baseballbatting, baseballmaster
							where b.playerid = baseballbatting.playerid and baseballbatting.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballbatting.playerid, sum(baseballbatting.".$stats.") total1
									from baseballbatting
									where baseballbatting.year >= ".$begYear." and baseballbatting.year <= ".$endYear."
									group by baseballbatting.playerid
									having sum(baseballbatting.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, baseballbatting.playerid
																						from baseballbatting
																						where baseballbatting.year >= ".$begYear." and baseballbatting.year <= ".$endYear."
																						group by baseballbatting.playerid)
																				))b, baseballbatting, baseballmaster
							where b.playerid = baseballbatting.playerid and baseballbatting.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
		}
		else if ($playertype == 'Position Player Fielding')
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, baseballfielding.playerid
									from baseballfielding
									where baseballfielding.year <= ". $begYear ." and baseballfielding.year >= ".$endYear."
									group by baseballfielding.playerid)";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, baseballfielding.playerid
									from baseballfielding
									where baseballfielding.year >= ". $begYear ." and baseballfielding.year <= ".$endYear."
									group by baseballfielding.playerid) ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, baseballfielding.playerid
									from baseballfielding
									where baseballfielding.year <= ". $begYear ." and baseballfielding.year >= ".$endYear."
									group by baseballfielding.playerid)";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, baseballfielding.playerid
									from baseballfielding
									where baseballfielding.year >= ". $begYear ." and baseballfielding.year <= ".$endYear."
									group by baseballfielding.playerid)";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballfielding.playerid, sum(baseballfielding.".$stats.") total1
									from baseballfielding
									where baseballfielding.year <= ".$begYear." and baseballfielding.year >= ".$endYear."
									group by baseballfielding.playerid
									having sum(baseballfielding.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, baseballfielding.playerid
																						from baseballfielding
																						where baseballfielding.year <= ".$begYear." and baseballfielding.year >= ".$endYear."
																						group by baseballfielding.playerid)
																				))b, baseballfielding, baseballmaster
							where b.playerid = baseballfielding.playerid and baseballfielding.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballfielding.playerid, sum(baseballfielding.".$stats.") total1
									from baseballfielding
									where baseballfielding.year >= ".$begYear." and baseballfielding.year <= ".$endYear."
									group by baseballfielding.playerid
									having sum(baseballfielding.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, baseballfielding.playerid
																						from baseballfielding
																						where baseballfielding.year >= ".$begYear." and baseballfielding.year <= ".$endYear."
																						group by baseballfielding.playerid)
																				))b, baseballfielding, baseballmaster
							where b.playerid = baseballfielding.playerid and baseballfielding.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballfielding.playerid, sum(baseballfielding.".$stats.") total1
									from baseballfielding
									where baseballfielding.year <= ".$begYear." and baseballfielding.year >= ".$endYear."
									group by baseballfielding.playerid
									having sum(baseballfielding.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, baseballfielding.playerid
																						from baseballfielding
																						where baseballfielding.year <= ".$begYear." and baseballfielding.year >= ".$endYear."
																						group by baseballfielding.playerid)
																				))b, baseballfielding, baseballmaster
							where b.playerid = baseballfielding.playerid and baseballfielding.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct baseballmaster.firstname, baseballmaster.lastname, b.total1
							  from (select baseballfielding.playerid, sum(baseballfielding.".$stats.") total1
									from baseballfielding
									where baseballfielding.year >= ".$begYear." and baseballfielding.year <= ".$endYear."
									group by baseballfielding.playerid
									having sum(baseballfielding.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, baseballfielding.playerid
																						from baseballfielding
																						where baseballfielding.year >= ".$begYear." and baseballfielding.year <= ".$endYear."
																						group by baseballfielding.playerid)
																				))b, baseballfielding, baseballmaster
							where b.playerid = baseballfielding.playerid and baseballfielding.playerid = baseballmaster.playerid and baseballmaster.firstname is not null and baseballmaster.lastname is not null";
				}
			}
		}
		else
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, baseballteams.name
									from baseballteams
									where baseballteams.year <= ". $begYear ." and baseballteams.year >= ".$endYear."
									group by baseballteams.name)";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, baseballteams.name
									from baseballteams
									where baseballteams.year >= ". $begYear ." and baseballteams.year <= ".$endYear."
									group by baseballteams.name) ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, baseballteams.name
									from baseballteams
									where baseballteams.year <= ". $begYear ." and baseballteams.year >= ".$endYear."
									group by baseballteams.name)";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, baseballteams.name
									from baseballteams
									where baseballteams.year >= ". $begYear ." and baseballteams.year <= ".$endYear."
									group by baseballteams.name)";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = 
							  "(select baseballteams.name, sum(baseballteams.".$stats.") total1
									from baseballteams
									where baseballteams.year <= ".$begYear." and baseballteams.year >= ".$endYear."
									group by baseballteams.name
									having sum(baseballteams.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, baseballteams.name
																						from baseballteams
																						where baseballteams.year <= ".$begYear." and baseballteams.year >= ".$endYear."
																						group by baseballteams.name)
																				))";
				}
				else
				{
					$query = "(select baseballteams.name, sum(baseballteams.".$stats.") total1
									from baseballteams
									where baseballteams.year >= ".$begYear." and baseballteams.year <= ".$endYear."
									group by baseballteams.name
									having sum(baseballteams.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, baseballteams.name
																						from baseballteams
																						where baseballteams.year >= ".$begYear." and baseballteams.year <= ".$endYear."
																						group by baseballteams.name)
																				))";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "(select baseballteams.name, sum(baseballteams.".$stats.") total1
									from baseballteams
									where baseballteams.year <= ".$begYear." and baseballteams.year >= ".$endYear."
									group by baseballteams.name
									having sum(baseballteams.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, baseballteams.name
																						from baseballteams
																						where baseballteams.year <= ".$begYear." and baseballteams.year >= ".$endYear."
																						group by baseballteams.name)
																				))";
				}
				else
				{
					$query = "(select baseballteams.name, sum(baseballteams.".$stats.") total1
									from baseballteams
									where baseballteams.year >= ".$begYear." and baseballteams.year <= ".$endYear."
									group by baseballteams.name
									having sum(baseballteams.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, baseballteams.name
																						from baseballteams
																						where baseballteams.year >= ".$begYear." and baseballteams.year <= ".$endYear."
																						group by baseballteams.name)
																				))";
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
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, basketballcoaches.coachid
									from basketballcoaches
									where basketballcoaches.year <= ". $begYear ." and basketballcoaches.year >= ".$endYear."
									group by basketballcoaches.coachid)";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, basketballcoaches.coachid
									from basketballcoaches
									where basketballcoaches.year >= ". $begYear ." and basketballcoaches.year <= ".$endYear."
									group by basketballcoaches.coachid) ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, basketballcoaches.coachid
									from basketballcoaches
									where basketballcoaches.year <= ". $begYear ." and basketballcoaches.year >= ".$endYear."
									group by basketballcoaches.coachid)";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, basketballcoaches.coachid
									from basketballcoaches
									where basketballcoaches.year >= ". $begYear ." and basketballcoaches.year <= ".$endYear."
									group by basketballcoaches.coachid)";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, b.total1
							  from (select basketballcoaches.coachid, sum(basketballcoaches.".$stats.") total1
									from basketballcoaches
									where basketballcoaches.year <= ".$begYear." and basketballcoaches.year >= ".$endYear."
									group by basketballcoaches.coachid
									having sum(basketballcoaches.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, basketballcoaches.coachid
																						from basketballcoaches
																						where basketballcoaches.year <= ".$begYear." and basketballcoaches.year >= ".$endYear."
																						group by basketballcoaches.coachid)
																				))b, basketballcoaches, basketballmaster
							where b.coachid = basketballcoaches.coachid and basketballcoaches.coachid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, b.total1
							  from (select basketballcoaches.coachid, sum(basketballcoaches.".$stats.") total1
									from basketballcoaches
									where basketballcoaches.year >= ".$begYear." and basketballcoaches.year <= ".$endYear."
									group by basketballcoaches.coachid
									having sum(basketballcoaches.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, basketballcoaches.coachid
																						from basketballcoaches
																						where basketballcoaches.year >= ".$begYear." and basketballcoaches.year <= ".$endYear."
																						group by basketballcoaches.coachid)
																				))b, basketballcoaches, basketballmaster
							where b.coachid = basketballcoaches.coachid and basketballcoaches.coachid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, b.total1
							  from (select basketballcoaches.coachid, sum(basketballcoaches.".$stats.") total1
									from basketballcoaches
									where basketballcoaches.year <= ".$begYear." and basketballcoaches.year >= ".$endYear."
									group by basketballcoaches.coachid
									having sum(basketballcoaches.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, basketballcoaches.coachid
																						from basketballcoaches
																						where basketballcoaches.year <= ".$begYear." and basketballcoaches.year >= ".$endYear."
																						group by basketballcoaches.coachid)
																				))b, basketballcoaches, basketballmaster
							where b.coachid = basketballcoaches.coachid and basketballcoaches.coachid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, b.total1
							  from (select basketballcoaches.coachid, sum(basketballcoaches.".$stats.") total1
									from basketballcoaches
									where basketballcoaches.year >= ".$begYear." and basketballcoaches.year <= ".$endYear."
									group by basketballcoaches.coachid
									having sum(basketballcoaches.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, basketballcoaches.coachid
																						from basketballcoaches
																						where basketballcoaches.year >= ".$begYear." and basketballcoaches.year <= ".$endYear."
																						group by basketballcoaches.coachid)
																				))b, basketballcoaches, basketballmaster
							where b.coachid = basketballcoaches.coachid and basketballcoaches.coachid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
			}
		}
		else if($playertype == 'Player')
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, basketballplayers.playerid
									from basketballplayers
									where basketballplayers.year <= ". $begYear ." and basketballplayers.year >= ".$endYear."
									group by basketballplayers.playerid)";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, basketballplayers.playerid
									from basketballplayers
									where basketballplayers.year >= ". $begYear ." and basketballplayers.year <= ".$endYear."
									group by basketballplayers.playerid) ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, basketballplayers.playerid
									from basketballplayers
									where basketballplayers.year <= ". $begYear ." and basketballplayers.year >= ".$endYear."
									group by basketballplayers.playerid)";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, basketballplayers.playerid
									from basketballplayers
									where basketballplayers.year >= ". $begYear ." and basketballplayers.year <= ".$endYear."
									group by basketballplayers.playerid)";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, b.total1
							  from (select basketballplayers.playerid, sum(basketballplayers.".$stats.") total1
									from basketballplayers
									where basketballplayers.year <= ".$begYear." and basketballplayers.year >= ".$endYear."
									group by basketballplayers.playerid
									having sum(basketballplayers.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, basketballplayers.playerid
																						from basketballplayers
																						where basketballplayers.year <= ".$begYear." and basketballplayers.year >= ".$endYear."
																						group by basketballplayers.playerid)
																				))b, basketballplayers, basketballmaster
							where b.playerid = basketballplayers.playerid and basketballplayers.playerid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, b.total1
							  from (select basketballplayers.playerid, sum(basketballplayers.".$stats.") total1
									from basketballplayers
									where basketballplayers.year >= ".$begYear." and basketballplayers.year <= ".$endYear."
									group by basketballplayers.playerid
									having sum(basketballplayers.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, basketballplayers.playerid
																						from basketballplayers
																						where basketballplayers.year >= ".$begYear." and basketballplayers.year <= ".$endYear."
																						group by basketballplayers.playerid)
																				))b, basketballplayers, basketballmaster
							where b.playerid = basketballplayers.playerid and basketballplayers.playerid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, b.total1
							  from (select basketballplayers.playerid, sum(basketballplayers.".$stats.") total1
									from basketballplayers
									where basketballplayers.year <= ".$begYear." and basketballplayers.year >= ".$endYear."
									group by basketballplayers.playerid
									having sum(basketballplayers.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, basketballplayers.playerid
																						from basketballplayers
																						where basketballplayers.year <= ".$begYear." and basketballplayers.year >= ".$endYear."
																						group by basketballplayers.playerid)
																				))b, basketballplayers, basketballmaster
							where b.playerid = basketballplayers.playerid and basketballplayers.playerid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
				else
				{
					$query = "select distinct basketballmaster.firstname, basketballmaster.lastname, b.total1
							  from (select basketballplayers.playerid, sum(basketballplayers.".$stats.") total1
									from basketballplayers
									where basketballplayers.year >= ".$begYear." and basketballplayers.year <= ".$endYear."
									group by basketballplayers.playerid
									having sum(basketballplayers.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, basketballplayers.playerid
																						from basketballplayers
																						where basketballplayers.year >= ".$begYear." and basketballplayers.year <= ".$endYear."
																						group by basketballplayers.playerid)
																				))b, basketballplayers, basketballmaster
							where b.playerid = basketballplayers.playerid and basketballplayers.playerid = basketballmaster.id and basketballmaster.firstname is not null and basketballmaster.lastname is not null";
				}
			}
		}
		else
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, basketballteams.name
									from basketballteams
									where basketballteams.year <= ". $begYear ." and basketballteams.year >= ".$endYear."
									group by basketballteams.name)";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, basketballteams.name
									from basketballteams
									where basketballteams.year >= ". $begYear ." and basketballteams.year <= ".$endYear."
									group by basketballteams.name) ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, basketballteams.name
									from basketballteams
									where basketballteams.year <= ". $begYear ." and basketballteams.year >= ".$endYear."
									group by basketballteams.name)";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, basketballteams.name
									from basketballteams
									where basketballteams.year >= ". $begYear ." and basketballteams.year <= ".$endYear."
									group by basketballteams.name)";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = 
							  "(select basketballteams.name, sum(basketballteams.".$stats.") total1
									from basketballteams
									where basketballteams.year <= ".$begYear." and basketballteams.year >= ".$endYear."
									group by basketballteams.name
									having sum(basketballteams.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, basketballteams.name
																						from basketballteams
																						where basketballteams.year <= ".$begYear." and basketballteams.year >= ".$endYear."
																						group by basketballteams.name)
																				))";
				}
				else
				{
					$query = "(select basketballteams.name, sum(basketballteams.".$stats.") total1
									from basketballteams
									where basketballteams.year >= ".$begYear." and basketballteams.year <= ".$endYear."
									group by basketballteams.name
									having sum(basketballteams.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, basketballteams.name
																						from basketballteams
																						where basketballteams.year >= ".$begYear." and basketballteams.year <= ".$endYear."
																						group by basketballteams.name)
																				))";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "(select basketballteams.name, sum(basketballteams.".$stats.") total1
									from basketballteams
									where basketballteams.year <= ".$begYear." and basketballteams.year >= ".$endYear."
									group by basketballteams.name
									having sum(basketballteams.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, basketballteams.name
																						from basketballteams
																						where basketballteams.year <= ".$begYear." and basketballteams.year >= ".$endYear."
																						group by basketballteams.name)
																				))";
				}
				else
				{
					$query = "(select basketballteams.name, sum(basketballteams.".$stats.") total1
									from basketballteams
									where basketballteams.year >= ".$begYear." and basketballteams.year <= ".$endYear."
									group by basketballteams.name
									having sum(basketballteams.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, basketballteams.name
																						from basketballteams
																						where basketballteams.year >= ".$begYear." and basketballteams.year <= ".$endYear."
																						group by basketballteams.name)
																				))";
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
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, hockeycoaches.coachid
									from hockeycoaches
									where hockeycoaches.year <= ". $begYear ." and hockeycoaches.year >= ".$endYear."
									group by hockeycoaches.coachid)";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, hockeycoaches.coachid
									from hockeycoaches
									where hockeycoaches.year >= ". $begYear ." and hockeycoaches.year <= ".$endYear."
									group by hockeycoaches.coachid) ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, hockeycoaches.coachid
									from hockeycoaches
									where hockeycoaches.year <= ". $begYear ." and hockeycoaches.year >= ".$endYear."
									group by hockeycoaches.coachid)";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, hockeycoaches.coachid
									from hockeycoaches
									where hockeycoaches.year >= ". $begYear ." and hockeycoaches.year <= ".$endYear."
									group by hockeycoaches.coachid)";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, b.total1
							  from (select hockeycoaches.coachid, sum(hockeycoaches.".$stats.") total1
									from hockeycoaches
									where hockeycoaches.year <= ".$begYear." and hockeycoaches.year >= ".$endYear."
									group by hockeycoaches.coachid
									having sum(hockeycoaches.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, hockeycoaches.coachid
																						from hockeycoaches
																						where hockeycoaches.year <= ".$begYear." and hockeycoaches.year >= ".$endYear."
																						group by hockeycoaches.coachid)
																				))b, hockeycoaches, hockeymaster
							where b.coachid = hockeycoaches.coachid and hockeycoaches.coachid = hockeymaster.coachid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
				else
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, b.total1
							  from (select hockeycoaches.coachid, sum(hockeycoaches.".$stats.") total1
									from hockeycoaches
									where hockeycoaches.year >= ".$begYear." and hockeycoaches.year <= ".$endYear."
									group by hockeycoaches.coachid
									having sum(hockeycoaches.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, hockeycoaches.coachid
																						from hockeycoaches
																						where hockeycoaches.year >= ".$begYear." and hockeycoaches.year <= ".$endYear."
																						group by hockeycoaches.coachid)
																				))b, hockeycoaches, hockeymaster
							where b.coachid = hockeycoaches.coachid and hockeycoaches.coachid = hockeymaster.coachid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, b.total1
							  from (select hockeycoaches.coachid, sum(hockeycoaches.".$stats.") total1
									from hockeycoaches
									where hockeycoaches.year <= ".$begYear." and hockeycoaches.year >= ".$endYear."
									group by hockeycoaches.coachid
									having sum(hockeycoaches.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, hockeycoaches.coachid
																						from hockeycoaches
																						where hockeycoaches.year <= ".$begYear." and hockeycoaches.year >= ".$endYear."
																						group by hockeycoaches.coachid)
																				))b, hockeycoaches, hockeymaster
							where b.coachid = hockeycoaches.coachid and hockeycoaches.coachid = hockeymaster.coachid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
				else
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, b.total1
							  from (select hockeycoaches.coachid, sum(hockeycoaches.".$stats.") total1
									from hockeycoaches
									where hockeycoaches.year >= ".$begYear." and hockeycoaches.year <= ".$endYear."
									group by hockeycoaches.coachid
									having sum(hockeycoaches.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, hockeycoaches.coachid
																						from hockeycoaches
																						where hockeycoaches.year >= ".$begYear." and hockeycoaches.year <= ".$endYear."
																						group by hockeycoaches.coachid)
																				))b, hockeycoaches, hockeymaster
							where b.coachid = hockeycoaches.coachid and hockeycoaches.coachid = hockeymaster.coachid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
			}
		}
		else if ($playertype == 'Goalie')
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, hockeygoalies.goalieid
									from hockeygoalies
									where hockeygoalies.year <= ". $begYear ." and hockeygoalies.year >= ".$endYear."
									group by hockeygoalies.goalieid)";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, hockeygoalies.goalieid
									from hockeygoalies
									where hockeygoalies.year >= ". $begYear ." and hockeygoalies.year <= ".$endYear."
									group by hockeygoalies.goalieid) ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, hockeygoalies.goalieid
									from hockeygoalies
									where hockeygoalies.year <= ". $begYear ." and hockeygoalies.year >= ".$endYear."
									group by hockeygoalies.goalieid)";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, hockeygoalies.goalieid
									from hockeygoalies
									where hockeygoalies.year >= ". $begYear ." and hockeygoalies.year <= ".$endYear."
									group by hockeygoalies.goalieid)";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, b.total1
							  from (select hockeygoalies.goalieid, sum(hockeygoalies.".$stats.") total1
									from hockeygoalies
									where hockeygoalies.year <= ".$begYear." and hockeygoalies.year >= ".$endYear."
									group by hockeygoalies.goalieid
									having sum(hockeygoalies.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, hockeygoalies.goalieid
																						from hockeygoalies
																						where hockeygoalies.year <= ".$begYear." and hockeygoalies.year >= ".$endYear."
																						group by hockeygoalies.goalieid)
																				))b, hockeygoalies, hockeymaster
							where b.goalieid = hockeygoalies.goalieid and hockeygoalies.goalieid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
				else
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, b.total1
							  from (select hockeygoalies.goalieid, sum(hockeygoalies.".$stats.") total1
									from hockeygoalies
									where hockeygoalies.year >= ".$begYear." and hockeygoalies.year <= ".$endYear."
									group by hockeygoalies.goalieid
									having sum(hockeygoalies.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, hockeygoalies.goalieid
																						from hockeygoalies
																						where hockeygoalies.year >= ".$begYear." and hockeygoalies.year <= ".$endYear."
																						group by hockeygoalies.goalieid)
																				))b, hockeygoalies, hockeymaster
							where b.goalieid = hockeygoalies.goalieid and hockeygoalies.goalieid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, b.total1
							  from (select hockeygoalies.goalieid, sum(hockeygoalies.".$stats.") total1
									from hockeygoalies
									where hockeygoalies.year <= ".$begYear." and hockeygoalies.year >= ".$endYear."
									group by hockeygoalies.goalieid
									having sum(hockeygoalies.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, hockeygoalies.goalieid
																						from hockeygoalies
																						where hockeygoalies.year <= ".$begYear." and hockeygoalies.year >= ".$endYear."
																						group by hockeygoalies.goalieid)
																				))b, hockeygoalies, hockeymaster
							where b.goalieid = hockeygoalies.goalieid and hockeygoalies.goalieid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
				else
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, b.total1
							  from (select hockeygoalies.goalieid, sum(hockeygoalies.".$stats.") total1
									from hockeygoalies
									where hockeygoalies.year >= ".$begYear." and hockeygoalies.year <= ".$endYear."
									group by hockeygoalies.goalieid
									having sum(hockeygoalies.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, hockeygoalies.goalieid
																						from hockeygoalies
																						where hockeygoalies.year >= ".$begYear." and hockeygoalies.year <= ".$endYear."
																						group by hockeygoalies.goalieid)
																				))b, hockeygoalies, hockeymaster
							where b.goalieid = hockeygoalies.goalieid and hockeygoalies.goalieid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
			}
		}
		else if($playertype == 'Position Player')
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, hockeyscoring.playerid
									from hockeyscoring
									where hockeyscoring.year <= ". $begYear ." and hockeyscoring.year >= ".$endYear."
									group by hockeyscoring.playerid)";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, hockeyscoring.playerid
									from hockeyscoring
									where hockeyscoring.year >= ". $begYear ." and hockeyscoring.year <= ".$endYear."
									group by hockeyscoring.playerid) ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, hockeyscoring.playerid
									from hockeyscoring
									where hockeyscoring.year <= ". $begYear ." and hockeyscoring.year >= ".$endYear."
									group by hockeyscoring.playerid)";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, hockeyscoring.playerid
									from hockeyscoring
									where hockeyscoring.year >= ". $begYear ." and hockeyscoring.year <= ".$endYear."
									group by hockeyscoring.playerid)";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, b.total1
							  from (select hockeyscoring.playerid, sum(hockeyscoring.".$stats.") total1
									from hockeyscoring
									where hockeyscoring.year <= ".$begYear." and hockeyscoring.year >= ".$endYear."
									group by hockeyscoring.playerid
									having sum(hockeyscoring.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, hockeyscoring.playerid
																						from hockeyscoring
																						where hockeyscoring.year <= ".$begYear." and hockeyscoring.year >= ".$endYear."
																						group by hockeyscoring.playerid)
																				))b, hockeyscoring, hockeymaster
							where b.playerid = hockeyscoring.playerid and hockeyscoring.playerid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
				else
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, b.total1
							  from (select hockeyscoring.playerid, sum(hockeyscoring.".$stats.") total1
									from hockeyscoring
									where hockeyscoring.year >= ".$begYear." and hockeyscoring.year <= ".$endYear."
									group by hockeyscoring.playerid
									having sum(hockeyscoring.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, hockeyscoring.playerid
																						from hockeyscoring
																						where hockeyscoring.year >= ".$begYear." and hockeyscoring.year <= ".$endYear."
																						group by hockeyscoring.playerid)
																				))b, hockeyscoring, hockeymaster
							where b.playerid = hockeyscoring.playerid and hockeyscoring.playerid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, b.total1
							  from (select hockeyscoring.playerid, sum(hockeyscoring.".$stats.") total1
									from hockeyscoring
									where hockeyscoring.year <= ".$begYear." and hockeyscoring.year >= ".$endYear."
									group by hockeyscoring.playerid
									having sum(hockeyscoring.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, hockeyscoring.playerid
																						from hockeyscoring
																						where hockeyscoring.year <= ".$begYear." and hockeyscoring.year >= ".$endYear."
																						group by hockeyscoring.playerid)
																				))b, hockeyscoring, hockeymaster
							where b.playerid = hockeyscoring.playerid and hockeyscoring.playerid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
				else
				{
					$query = "select distinct hockeymaster.firstname, hockeymaster.lastname, b.total1
							  from (select hockeyscoring.playerid, sum(hockeyscoring.".$stats.") total1
									from hockeyscoring
									where hockeyscoring.year >= ".$begYear." and hockeyscoring.year <= ".$endYear."
									group by hockeyscoring.playerid
									having sum(hockeyscoring.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, hockeyscoring.playerid
																						from hockeyscoring
																						where hockeyscoring.year >= ".$begYear." and hockeyscoring.year <= ".$endYear."
																						group by hockeyscoring.playerid)
																				))b, hockeyscoring, hockeymaster
							where b.playerid = hockeyscoring.playerid and hockeyscoring.playerid = hockeymaster.playerid and hockeymaster.firstname is not null and hockeymaster.lastname is not null";
				}
			}
		}
		else
		{
			if($operation == 'average')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, hockeyteams.name
									from hockeyteams
									where hockeyteams.year <= ". $begYear ." and hockeyteams.year >= ".$endYear."
									group by hockeyteams.name)";
				}
				else
				{
					$query = "SELECT  ROUND((AVG(total)),3)
						      FROM (select sum(".$stats.") total, hockeyteams.name
									from hockeyteams
									where hockeyteams.year >= ". $begYear ." and hockeyteams.year <= ".$endYear."
									group by hockeyteams.name) ";
				}
			}
			else if ($operation == 'standardDeviation')
			{
				if($begYear > $endYear)
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, hockeyteams.name
									from hockeyteams
									where hockeyteams.year <= ". $begYear ." and hockeyteams.year >= ".$endYear."
									group by hockeyteams.name)";
				}
				else
				{
					$query = "SELECT  ROUND((STDDEV(total)),3)
						      FROM (select sum(".$stats.") total, hockeyteams.name
									from hockeyteams
									where hockeyteams.year >= ". $begYear ." and hockeyteams.year <= ".$endYear."
									group by hockeyteams.name)";
				}
			}
			else if ($operation == 'min')
			{
				if($begYear > $endYear)
				{
					$query = 
							  "(select hockeyteams.name, sum(hockeyteams.".$stats.") total1
									from hockeyteams
									where hockeyteams.year <= ".$begYear." and hockeyteams.year >= ".$endYear."
									group by hockeyteams.name
									having sum(hockeyteams.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, hockeyteams.name
																						from hockeyteams
																						where hockeyteams.year <= ".$begYear." and hockeyteams.year >= ".$endYear."
																						group by hockeyteams.name)
																				))";
				}
				else
				{
					$query = "(select hockeyteams.name, sum(hockeyteams.".$stats.") total1
									from hockeyteams
									where hockeyteams.year >= ".$begYear." and hockeyteams.year <= ".$endYear."
									group by hockeyteams.name
									having sum(hockeyteams.".$stats.") = (SELECT  MIN(total) maximum
																				FROM (select sum(".$stats.") total, hockeyteams.name
																						from hockeyteams
																						where hockeyteams.year >= ".$begYear." and hockeyteams.year <= ".$endYear."
																						group by hockeyteams.name)
																				))";
				}
			}
			else
			{
				if($begYear > $endYear)
				{
					$query = "(select hockeyteams.name, sum(hockeyteams.".$stats.") total1
									from hockeyteams
									where hockeyteams.year <= ".$begYear." and hockeyteams.year >= ".$endYear."
									group by hockeyteams.name
									having sum(hockeyteams.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, hockeyteams.name
																						from hockeyteams
																						where hockeyteams.year <= ".$begYear." and hockeyteams.year >= ".$endYear."
																						group by hockeyteams.name)
																				))";
				}
				else
				{
					$query = "(select hockeyteams.name, sum(hockeyteams.".$stats.") total1
									from hockeyteams
									where hockeyteams.year >= ".$begYear." and hockeyteams.year <= ".$endYear."
									group by hockeyteams.name
									having sum(hockeyteams.".$stats.") = (SELECT  MAX(total) maximum
																				FROM (select sum(".$stats.") total, hockeyteams.name
																						from hockeyteams
																						where hockeyteams.year >= ".$begYear." and hockeyteams.year <= ".$endYear."
																						group by hockeyteams.name)
																				))";
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
			echo '<th>Number</th>';
			echo '</tr>';
		}
		else
		{
			echo '<tr>';
			echo '<th>First Name</th>';
			echo '<th>Last Name</th>';
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
