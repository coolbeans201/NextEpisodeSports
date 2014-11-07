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
			$querystats = "SELECT distinct year, team, league, games, wins, loss, winpercent, ROUND((WINPERCENT - (SELECT AVG(WINPERCENT) FROM BASEBALLMANAGERS)) / (SELECT STDDEV(WINPERCENT) FROM BASEBALLMANAGERS), 3) zScore ,rank
						FROM Baseballmanagers
						WHERE managerid = '" . $playerid . "'
						ORDER BY year";
		       $querycareerstats = "SELECT SUM(BaseballManagers.WINS) / COUNT(DISTINCT YEAR), SUM(BaseballManagers.LOSS) / COUNT(DISTINCT YEAR), ROUND((SUM(WINS) / (SUM(WINS) + SUM(LOSS))),3), ROUND(AVG(A.zScore), 3)
						 FROM (SELECT ROUND((WINPERCENT - (SELECT AVG(WINPERCENT) FROM BASEBALLMANAGERS)) / 
     						(SELECT STDDEV(WINPERCENT) FROM BASEBALLMANAGERS), 3) 
      						zScore FROM BASEBALLMANAGERS WHERE managerID = '" . $playerid . "')A, BaseballManagers
						WHERE BaseballManagers.MANAGERID = '" . $playerid . "'";
		}
		if ($playertype == 'Pitcher'){
		}
		if ($playertype == 'Position Player'){
		}
		if ($playertype == 'Team'){
		}
	}
	
	else if ($sport == 'Basketball')
	{
		if ($playertype == 'Coach'){
			$querybio = "SELECT firstName, lastName, height, weight
				      FROM BASKETBALLMASTER
				      WHERE id = '" . $playerid . "' AND id IN (SELECT DISTINCT COACHID FROM BASKETBALLCOACHES)";
			$querystats = "SELECT distinct year, team, league, wins, losses, winningpercentage, ROUND((winningpercentage - (select avg(winningpercentage) from basketballcoaches)) / (select stddev(winningpercentage) from basketballcoaches), 3) zScore
					 FROM BASKETBALLCoaches
					 WHERE coachid = '" . $playerid . "'
					 order by year";
			$querycareerstats = "SELECT SUM(WINS) / COUNT(DISTINCT YEAR), (SUM(LOSSES) / COUNT(DISTINCT YEAR)), ROUND((SUM(WINS) / (SUM(LOSSES) + SUM(WINS))), 3), ROUND(AVG(A.zScore), 3)
						FROM (SELECT ROUND((WINNINGPERCENTAGE - (SELECT AVG(WINNINGPERCENTAGE) FROM BASKETBALLCOACHES)) / 
     						(SELECT STDDEV(WINNINGPERCENTAGE) FROM BASKETBALLCOACHES), 3) 
      						zScore FROM BasketballCoaches WHERE coachID = '" . $playerid . "')A, BasketballCoaches
						WHERE BasketballCoaches.CoachID = '" . $playerid . "'";
			$querypostseasonstats = "SELECT distinct year, team, league, POSTSEASONWINS, POSTSEASONLOSSES, POSTSEASONWINNINGPERCENTAGE, ROUND((POSTSEASONWINNINGPERCENTAGE - (SELECT AVG(POSTSEASONWINNINGPERCENTAGE) FROM BASKETBALLCOACHES)) / (SELECT STDDEV(POSTSEASONWINNINGPERCENTAGE) FROM BASKETBALLCOACHES), 3) zScore
						    FROM BASKETBALLCOACHES
						    WHERE BasketballCoaches.CoachID = '" . $playerid . "' AND POSTSEASONWINNINGPERCENTAGE != -1
						    order by year";
			$querycareerpostseasonstats = "SELECT SUM(POSTSEASONWINS), SUM(POSTSEASONLOSSES), ROUND((SUM(POSTSEASONWINS) / (SUM(POSTSEASONLOSSES) + SUM(POSTSEASONWINS))), 3)
							   FROM BasketballCoaches
						          WHERE BasketballCoaches.CoachID = '" . $playerid . "'";
		}
		if ($playertype == 'Player'){
		}
		if ($playertype == 'Team'){
		}
	}
	
	else if ($sport == 'Hockey')
	{
		if ($playertype == 'Coach'){
			$querybio = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
					FROM Hockeymaster
					WHERE coachid IS NOT NULL AND coachid = '" . $playerid . "'";
			$querystats = "SELECT DISTINCT YEAR, TEAM, LEAGUE, GAMES, WIN, LOSS, TIE, POINTSPERGAME, ROUND(((POINTSPERGAME - (SELECT AVG(POINTSPERGAME) FROM HOCKEYCOACHES))/(SELECT STDDEV(POINTSPERGAME) FROM HOCKEYCOACHES)), 3) zScore
			   FROM HOCKEYCOACHES
			   WHERE COACHID = '" . $playerid . "'
			   ORDER BY YEAR";
			$querycareerstats = "SELECT SUM(WIN) / (4 * COUNT(DISTINCT YEAR)), (SUM(LOSS) / (4 * COUNT(DISTINCT YEAR))), (SUM(TIE) / (4 * COUNT(DISTINCT YEAR))), ROUND(((2 * SUM(WIN) + SUM(TIE)) / (SUM(LOSS) + SUM(WIN) + SUM(TIE))), 3), ROUND(AVG(A.zScore), 3)
					 FROM (SELECT ROUND (((POINTSPERGAME - (SELECT AVG(POINTSPERGAME) FROM HOCKEYCOACHES)) / 
					(SELECT STDDEV(POINTSPERGAME) FROM HOCKEYCOACHES)), 3) zScore FROM HockeyCoaches WHERE COACHID = '" . $playerid . "')A, HockeyCoaches
					 WHERE COACHID = '" . $playerid . "'";
			$querypostseasonstats = "SELECT distinct year, team, league, postseasongames, postseasonwin, postseasonloss, postseasontie, postseasonwinpercent						    
						 from hockeycoaches
						 WHERE COACHID = '" . $playerid . "'
						 order by year";
			$querycareerpostseasonstats = "SELECT SUM(POSTSEASONWIN) / (COUNT(DISTINCT YEAR)), (SUM(POSTSEASONLOSS) / (COUNT(DISTINCT YEAR))), (SUM(POSTSEASONTIE) / (COUNT(DISTINCT YEAR))), ROUND((SUM(POSTSEASONWIN) / (SUM(POSTSEASONLOSS) + SUM(POSTSEASONWIN))), 3)
							   FROM HockeyCoaches
							   WHERE COACHID = '" . $playerid . "'";
		}
		if ($playertype == 'Goalie'){
		}
		if ($playertype == 'Position Player'){
		}
		if ($playertype == 'Team'){
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
				echo '<b> Manager Regular Season Stats </b> </font>';
			}
			if($playertype == 'Pitcher' || $playertype == 'Position Player'){
				
			}
		}
		else if($sport == 'Basketball'){
			if($playertype = 'Coach')
			{
				echo '<font size = "4">';
				echo "<b> Biographical Information </b> <br>";
				echo 'Name: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . "<br>";
				echo 'Height: ' . $row['HEIGHT'] . " inches <br>";
				echo 'Weight: ' . $row['WEIGHT'] . " pounds <br>";
				echo '<br>';
				echo '<b> Coach Regular Season Stats </b> </font>';
			}
		}
		else if($sport == 'Hockey'){
			if($playertype == 'Coach'){
				echo '<font size = "4">';
				echo "<b> Biographical Information </b> <br>";
				echo 'Name: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . "<br>";
				echo 'Date of Birth: ' . $row['BIRTHMONTH'] . '/' . $row['BIRTHDAY'] . '/' . $row['BIRTHYEAR'] . "<br>";
				echo 'Height: ' . $row['HEIGHT'] . " inches <br>";
				echo 'Weight: ' . $row['WEIGHT'] . " pounds <br>";
				echo '<br>';
				echo '<b> Coach Regular Season Stats </b> </font>';
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
				echo '<th>Games</th>';
				echo '<th>Wins</th>';
				echo '<th>Losses</th>';
				echo '<th>Win Percent</th>';
				echo '<th>Win Percent z-Score</th>';
				echo '<th>Rank</th>';
				echo '</tr>';
			}
			if($playertype == 'Pitcher' || $playertype == 'Position Player'){
				
			}
		}
		else if($sport == 'Basketball'){
			if($playertype == 'Coach'){
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Wins</th>';
				echo '<th>Losses</th>';
				echo '<th>Win Percent</th>';
				echo '<th>Win Percent z-Score</th>';
				echo '</tr>';
			}
		}
		else if($sport == 'Hockey'){
			if($playertype == 'Coach'){
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Games</th>';
				echo '<th>Wins</th>';
				echo '<th>Losses</th>';
				echo '<th>Ties</th>';
				echo '<th>Points Per Game</th>';
				echo '<th>Points Per Game z-Score</th>';
				echo '</tr>';
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
	echo "</table><br>";


	$statementcareerstats = oci_parse($connection, $querycareerstats);
	oci_execute($statementcareerstats);
	if ($playertype == 'Team'){
		}
		else if($sport == 'Baseball'){
			if($playertype == 'Manager'){
				echo '<font size = "4"><b>Manager Career Stats</b></font><br>';
			}
			if($playertype == 'Pitcher' || $playertype == 'Position Player'){
				
			}
		}
		else if($sport == 'Basketball'){
			if($playertype == 'Coach'){
				echo '<font size = "4"><b>Coach Career Regular Season Stats</b></font><br>';
			}
		}
		else if($sport == 'Hockey'){
			if($playertype == 'Coach'){
				echo '<font size = "4"><b>Coach Career Regular Season Stats</b></font><br>';
			}
			if($playertype == 'Goalie' || $playertype == 'Position Player'){
				
			}
		}

	echo "<table border='1'>\n";
		if ($playertype == 'Team'){
		}
		else if($sport == 'Baseball'){
			if($playertype == 'Manager'){
				echo '<tr>';
				echo '<th>Total Wins</th>';
				echo '<th>Total Losses</th>';
				echo '<th>Average Win Percent</th>';
				echo '<th>Average Win Percent z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Pitcher' || $playertype == 'Position Player'){
				
			}
		}
		else if($sport == 'Basketball'){
			if($playertype == 'Coach')
			{
				echo '<tr>';
				echo '<th>Total Wins</th>';
				echo '<th>Total Losses</th>';
				echo '<th>Average Win Percent</th>';
				echo '<th>Average Win Percent z-Score</th>';
				echo '</tr>';
			}
		}
		else if($sport == 'Hockey'){
			if($playertype == 'Coach'){
				echo '<tr>';
				echo '<th>Total Wins</th>';
				echo '<th>Total Losses</th>';
				echo '<th>Total Ties</th>';
				echo '<th>Average Points Per Game</th>';
				echo '<th>Average Points Per Game z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Goalie' || $playertype == 'Position Player'){
				
			}
		}
	while ($row = oci_fetch_array($statementcareerstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
		echo "<tr>\n";
		foreach ($row as $item) {
			echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
		}
		echo "</tr>\n";
	}
	echo "</table><br>";
	if ($playertype == 'Team'){
		}
		else if($sport == 'Baseball'){
			if($playertype == 'Manager'){
				
			}
			if($playertype == 'Pitcher' || $playertype == 'Position Player'){
				
			}
		}
		else if($sport == 'Basketball'){
			if($playertype == 'Coach'){
				echo '<font size = "4"><b>Coach Postseason Stats</b></font><br>';
			}
		}
		else if($sport == 'Hockey'){
			if($playertype == 'Coach'){
				echo '<font size = "4"><b>Coach Postseason Stats</b></font><br>';
			}
			if($playertype == 'Goalie' || $playertype == 'Position Player'){
				
			}
		}
	$statementpostseasonstats = oci_parse($connection, $querypostseasonstats);
	if(($sport == 'Basketball' && $playertype == 'Coach') || ($sport == 'Hockey' && $playertype == 'Coach'))
	{
		oci_execute($statementpostseasonstats);
		echo "<table border='1'>\n";
			if ($playertype == 'Team'){
			}
			else if($sport == 'Baseball'){
			if($playertype == 'Manager'){
			}
			if($playertype == 'Pitcher' || $playertype == 'Position Player'){
				
			}
		}
		else if($sport == 'Basketball'){
			if($playertype == 'Coach')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Wins</th>';
				echo '<th>Losses</th>';
				echo '<th>Win Percent</th>';
				echo '<th>Win Percent z-Score</th>';
				echo '</tr>';
			}
		}
		else if($sport == 'Hockey'){
			if($playertype == 'Coach'){
			       echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Games</th>';
				echo '<th>Wins</th>';
				echo '<th>Losses</th>';
				echo '<th>Ties</th>';
				echo '<th>Win Percent</th>';
				echo '</tr>';
			}
			if($playertype == 'Goalie' || $playertype == 'Position Player'){
				
			}
		}
		while ($row = oci_fetch_array($statementpostseasonstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			echo "<tr>\n";
			foreach ($row as $item) {
				echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table><br>";
	}
	if ($playertype == 'Team'){
		}
		else if($sport == 'Baseball'){
			if($playertype == 'Manager'){
				
			}
			if($playertype == 'Pitcher' || $playertype == 'Position Player'){
				
			}
		}
		else if($sport == 'Basketball'){
			if($playertype == 'Coach'){
				echo '<font size = "4"><b>Coach Career Postseason Stats</b></font><br>';
			}
		}
		else if($sport == 'Hockey'){
			if($playertype == 'Coach'){
				echo '<font size = "4"><b>Coach Career Postseason Stats</b></font><br>';
			}
			if($playertype == 'Goalie' || $playertype == 'Position Player'){
				
			}
		}

	$statementcareerpostseasonstats = oci_parse($connection, $querycareerpostseasonstats);
	if(($sport == 'Basketball' && $playertype == 'Coach') || ($sport == 'Hockey' && $playertype = 'Coach'))
	{
		oci_execute($statementcareerpostseasonstats);
		echo "<table border='1'>\n";
			if ($playertype == 'Team'){
			}
			else if($sport == 'Baseball'){
			if($playertype == 'Manager'){
			}
			if($playertype == 'Pitcher' || $playertype == 'Position Player'){
				
			}
		}
		else if($sport == 'Basketball'){
			if($playertype == 'Coach')
			{
				echo '<tr>';
				echo '<th>Total Wins</th>';
				echo '<th>Total Losses</th>';
				echo '<th>Average Win Percent</th>';
				echo '</tr>';
			}
		}
		else if($sport == 'Hockey'){
			if($playertype == 'Coach'){
				echo '<tr>';
				echo '<th>Total Wins</th>';
				echo '<th>Total Losses</th>';
				echo '<th>Total Ties</th>';
				echo '<th>Average Win Percent</th>';
				echo '</tr>';	
			}
			if($playertype == 'Goalie' || $playertype == 'Position Player'){
				
			}
		}
		while ($row = oci_fetch_array($statementcareerpostseasonstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			echo "<tr>\n";
			foreach ($row as $item) {
				echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table><br>";
	}
	//
	// VERY important to close Oracle Database Connections and free statements!
	//
	oci_free_statement($statementbio);
	oci_free_statement($statementstats);
	oci_free_statement($statementcareerstats);
	oci_free_statement($statementpostseasonstats);
	oci_free_statement($statementcareerpostseasonstats);
	oci_close($connection);
?>
