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
			$querystats = "select distinct year, team, league, division, rank, games, homegames, win, loss, winpercent, 
					 ROUND(((winpercent - (select avg(winpercent) from baseballteams))/(select stddev(winpercent) from baseballteams)),3) zScore,
					 runs, atbats, hits, battingaverage, 
					 ROUND(((battingaverage - (select avg(battingaverage) from baseballteams))/(select stddev(battingaverage) from baseballteams)),3) zScore2,
					 doubles, triples, homeruns, slugging,
					 ROUND(((slugging - (select avg(slugging) from baseballteams))/(select stddev(slugging) from baseballteams)),3) zScore3,
					 walks, strikeouts, stolenbases, caughtstealing, hitbypitches, sacflies, onbasepercent,
					 ROUND(((onbasepercent - (select avg(onbasepercent) from baseballteams))/(select stddev(onbasepercent) from baseballteams)),3) zScore4,
					 runsallowed, earnedruns, era,
					 ROUND(((era - (select avg(era) from baseballteams))/(select stddev(era) from baseballteams)),3) zScore5,
					 completegames, shutouts, saves, outs, hitsallowed, homerunsallowed, walksallowed, strikeoutsallowed, errors, whip,
					 h9, hr9, bb9, so9, doubleplays, fieldingpercent,
					 ROUND(((fieldingpercent - (select avg(fieldingpercent) from baseballteams))/(select stddev(fieldingpercent) from baseballteams)),3) zScore6
					 from baseballteams
					 where name = '" . $playerid . "'
					 order by year";
			$querycareerstats = "select  SUM(games) / (COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(homegames) / (COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(win) / (COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(loss) / (COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), ROUND((SUM(win)/(SUM(win) + SUM(loss))),3) winPercent, ROUND(AVG(A.zScore), 3),
								SUM(runs)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(atbats)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(hits)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), ROUND((SUM(hits)/SUM(atbats)),3), ROUND(AVG(B.zScore),3),
								SUM(doubles)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(triples)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(homeruns)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), ROUND(((SUM(doubles) * 2 + SUM(triples) * 3 + SUM(homeruns) * 4 + (SUM(hits)-SUM(homeRuns)-SUM(triples)-SUM(doubles)))/SUM(atbats)),3), ROUND(AVG(C.zScore),3),
								SUM(walks)/ (COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(strikeouts)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(stolenbases)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(caughtstealing)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(hitbypitches)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(sacflies)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)),
								SUM(runsallowed)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(earnedruns)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)),
								SUM(completegames)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)),SUM(shutouts)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)),SUM(saves)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(outs)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)),
								SUM(hitsallowed)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(homerunsallowed)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(walksallowed)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(errors)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year)), SUM(doubleplays)/(COUNT(distinct year) * COUNT(distinct year) * COUNT(distinct year))
								from (SELECT ROUND((WINPERCENT - (SELECT AVG(WINPERCENT) FROM BASEBALLTEAMS)) / 
									 (SELECT STDDEV(WINPERCENT) FROM BASEBALLTEAMS), 3) 
									 zScore FROM BASEBALLTEAMS WHERE name = '" . $playerid . "')A,
									 (SELECT ROUND((battingAverage - (SELECT AVG(battingAverage) FROM BASEBALLTEAMS)) / 
									 (SELECT STDDEV(battingAverage) FROM BASEBALLTEAMS), 3) 
									 zScore FROM BASEBALLTEAMS WHERE name = '" . $playerid . "')B,
									 (SELECT ROUND((slugging - (SELECT AVG(slugging) FROM BASEBALLTEAMS)) / 
									 (SELECT STDDEV(slugging) FROM BASEBALLTEAMS), 3) 
									 zScore FROM BASEBALLTEAMS WHERE name = '" . $playerid . "')C,
									 BaseballTeams
								where name = '" . $playerid . "'";
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
	if($playertype != 'Team')
	{
		oci_execute($statementbio);	
		while($row=oci_fetch_assoc($statementbio)) {
			if($sport == 'Baseball')
			{
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
			else if($sport == 'Basketball')
			{
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
			else if($sport == 'Hockey')
			{
				if($playertype == 'Coach')
				{
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
	}
	else
	{
		echo '<fontsize = "4"><b>Team Regular Season Stats</b></font><br>';
	}
	$statementstats = oci_parse($connection, $querystats);
	oci_execute($statementstats);
	
	echo "<table border='1'>\n";
		if($sport == 'Baseball')
		{
			if($playertype == 'Manager')
			{
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
			if($playertype == 'Pitcher' || $playertype == 'Position Player')
			{
				
			}
			if($playertype == 'Team')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Division</th>';
				echo '<th>Rank</th>';
				echo '<th>Games</th>';
				echo '<th>Home Games</th>';
				echo '<th>Wins</th>';
				echo '<th>Losses</th>';
				echo '<th>Win Percent</th>';
				echo '<th>Win Percent z-Score</th>';
				echo '<th>Runs</th>';
				echo '<th>At-bats</th>';
				echo '<th>Hits</th>';
				echo '<th>Batting Average</th>';
				echo '<th>Batting Average z-Score</th>';
				echo '<th>Doubles</th>';
				echo '<th>Triples</th>';
				echo '<th>Home Runs</th>';
				echo '<th>Slugging</th>';
				echo '<th>Slugging z-Score</th>';
				echo '<th>Walks</th>';
				echo '<th>Struck Out</th>';
				echo '<th>Stolen Bases</th>';
				echo '<th>Caught Stealing</th>';
				echo '<th>Hit By Pitches</th>';
				echo '<th>Sac Flies</th>';
				echo '<th>OBP</th>';
				echo '<th>OBP z-Score</th>';
				echo '<th>Runs Allowed</th>';
				echo '<th>Earned Runs</th>';
				echo '<th>ERA</th>';
				echo '<th>ERA z-Score</th>';
				echo '<th>Complete Games</th>';
				echo '<th>Shutouts</th>';
				echo '<th>Saves</th>';
				echo '<th>Outs</th>';
				echo '<th>Hits Allowed</th>';
				echo '<th>Home Runs Allowed</th>';
				echo '<th>Walks Allowed</th>';
				echo '<th>Strikeouts</th>';
				echo '<th>Errors</th>';
				echo '<th>WHIP</th>';
				echo '<th>H9</th>';
				echo '<th>HR9</th>';
				echo '<th>BB9</th>';
				echo '<th>SO9</th>';
				echo '<th>Double Plays</th>';
				echo '<th>Fielding Percent</th>';
				echo '<th>Fielding Percent z-Score</th>';
				echo '</tr>';
			}
		}
		else if($sport == 'Basketball')
		{
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
		else if($sport == 'Hockey')
		{
			if($playertype == 'Coach')
			{
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
			if($playertype == 'Goalie' || $playertype == 'Position Player')
			{
				
			}
		}
	while ($row = oci_fetch_array($statementstats, OCI_ASSOC+OCI_RETURN_NULLS)) 
	{
		echo "<tr>\n";
		foreach ($row as $item) 
		{
			echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
		}
		echo "</tr>\n";
	}
	echo "</table><br>";


	$statementcareerstats = oci_parse($connection, $querycareerstats);
	oci_execute($statementcareerstats);
	if($sport == 'Baseball')
	{
		if($playertype == 'Manager')
		{
			echo '<font size = "4"><b>Manager Career Stats</b></font><br>';
		}
		if($playertype == 'Pitcher' || $playertype == 'Position Player')
		{
				
		}
		if ($playertype == 'Team')
		{
			echo '<font size = "4"><b>Team Career Regular Season Stats</b></font><br>';
		}
	}
	else if($sport == 'Basketball'){
		if($playertype == 'Coach')
		{
				echo '<font size = "4"><b>Coach Career Regular Season Stats</b></font><br>';
		}
	}
	else if($sport == 'Hockey')
	{
		if($playertype == 'Coach')
		{
			echo '<font size = "4"><b>Coach Career Regular Season Stats</b></font><br>';
		}
		if($playertype == 'Goalie' || $playertype == 'Position Player')
		{
				
		}
	}
	echo "<table border='1'>\n";
		if($sport == 'Baseball')
		{
			if($playertype == 'Manager')
			{
				echo '<tr>';
				echo '<th>Total Wins</th>';
				echo '<th>Total Losses</th>';
				echo '<th>Average Win Percent</th>';
				echo '<th>Average Win Percent z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Pitcher' || $playertype == 'Position Player')
			{
				
			}
			if($playertype == 'Team')
			{
				echo '<tr>';
				echo '<th>Total Games</th>';
				echo '<th>Total Home Games</th>';
				echo '<th>Total Wins</th>';
				echo '<th>Total Losses</th>';
				echo '<th>Average Win Percent</th>';
				echo '<th>Average Win Percent z-Score</th>';
				echo '<th>Total Runs</th>';
				echo '<th>Total At-bats</th>';
				echo '<th>Total Hits</th>';
				echo '<th>Average Batting Average</th>';
				echo '<th>Average Batting Average z-Score</th>';
				echo '<th>Total Doubles</th>';
				echo '<th>Total Triples</th>';
				echo '<th>Total Home Runs</th>';
				echo '<th>Average Slugging</th>';
				echo '<th>Average Slugging z-Score</th>';
				echo '<th>Total Walks</th>';
				echo '<th>Total Struck Out</th>';
				echo '<th>Total Stolen Bases</th>';
				echo '<th>Total Caught Stealing</th>';
				echo '<th>Total Hit By Pitches</th>';
				echo '<th>Total Sac Flies</th>';
				echo '<th>Total Runs Allowed</th>';
				echo '<th>Total Earned Runs</th>';
				echo '<th>Total Complete Games</th>';
				echo '<th>Total Shutouts</th>';
				echo '<th>Total Saves</th>';
				echo '<th>Total Outs</th>';
				echo '<th>Total Hits Allowed</th>';
				echo '<th>Total Home Runs Allowed</th>';
				echo '<th>Total Walks Allowed</th>';
				echo '<th>Total Errors</th>';
				echo '<th>Total Double Plays</th>';
				echo '</tr>';
			}
		}
		else if($sport == 'Basketball')
		{
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
		else if($sport == 'Hockey')
		{
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
