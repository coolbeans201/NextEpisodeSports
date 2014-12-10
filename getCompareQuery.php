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
	// Escape User Input to help prevent SQL Injection
	//$sport = mysql_real_escape_string($sport);
	//$playertype = mysql_real_escape_string($playertype);
	
	
	echo "<table align='center'>";
	
	
	echo "<tr>";
	
	echo "<td valign='top'>";
	if ($sport == 'Baseball')
	{
		if ($playertype == 'Manager'){
			$querybio = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
					FROM Baseballmaster
					WHERE managerid IS NOT NULL AND managerid = '" . $playerid . "'";
			$querystats = "SELECT distinct year, ROUND((WINPERCENT - (SELECT AVG(WINPERCENT) FROM BASEBALLMANAGERS)) / (SELECT STDDEV(WINPERCENT) FROM BASEBALLMANAGERS), 3) zScore
						FROM Baseballmanagers
						WHERE managerid = '" . $playerid . "'
						ORDER BY year";
		}
		
		if ($playertype == 'Pitcher'){
			$querybio = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
			FROM Baseballmaster
			WHERE playerid = '" . $playerid . "'";
			
			$querystats = "SELECT distinct year,
			ROUND(((bavg - (select avg(bavg) from baseballpitching))/(select stddev(bavg) from baseballpitching)),3) bavgZSCORE,
			ROUND(((era - (select avg(era) from baseballpitching))/(select stddev(era) from baseballpitching)),3) eraZSCORE
			FROM BaseballPitching
			WHERE pitcherid = '" . $playerid . "'
			ORDER BY year";
			
			
			$querypostseasonstats = "SELECT distinct year, round, 
			ROUND(((battingaverage - (select avg(battingaverage) from baseballpitchingpostseason))/(select stddev(battingaverage) from baseballpitchingpostseason)),3) bavgZSCORE,
			ROUND(((era - (select avg(era) from baseballpitchingpostseason))/(select stddev(era) from baseballpitchingpostseason)),3) eraZSCORE
			FROM BaseballPitchingPostSeason
			WHERE playerid = '" . $playerid . "'
			ORDER BY year";
			
			$querybattingstats = "select distinct year, ROUND(((battingaverage - (select avg(battingaverage) from baseballbatting))/(select stddev(battingaverage) from baseballbatting)),3) zScore,
								  ROUND(((slugging - (select avg(slugging) from baseballbatting))/(select stddev(slugging) from baseballbatting)),3) zScore2,
								  ROUND(((onbasepercent - (select avg(onbasepercent) from baseballbatting))/(select stddev(onbasepercent) from baseballbatting)),3) zScore3
								  from baseballbatting
								  where baseballbatting.playerid = '" . $playerid . "' AND slugging != -1
								  order by year";
								  
			$querypostseasonbattingstats = "select distinct year, round, ROUND(((battingaverage - (select avg(battingaverage) from baseballbattingpostseason))/(select stddev(battingaverage) from baseballbattingpostseason)),3) zScore,
								  ROUND(((slugging - (select avg(slugging) from baseballbattingpostseason))/(select stddev(slugging) from baseballbattingpostseason)),3) zScore2,
								  ROUND(((onbasepercent - (select avg(onbasepercent) from baseballbattingpostseason))/(select stddev(onbasepercent) from baseballbattingpostseason)),3) zScore3
								  from baseballbattingpostseason
								  where baseballbattingpostseason.playerid = '" . $playerid . "'  AND slugging != -1
								  order by year";
								  
			
			$queryfieldingstats = "select distinct year,
									ROUND(((fieldingpercent - (select avg(fieldingpercent) from baseballfielding))/(select stddev(fieldingpercent) from baseballfielding)),3) zScore
									from baseballfielding
									where baseballfielding.playerid = '" . $playerid . "'
									order by year";
									
			
			$querypostseasonfieldingstats = "select distinct year, round,
											ROUND(((fieldingpercent - (select avg(fieldingpercent) from baseballfieldingpostseason))/(select stddev(fieldingpercent) from baseballfieldingpostseason)),3) zScore
											from baseballfieldingpostseason
											where baseballfieldingpostseason.playerid = '" . $playerid . "' and baseballfieldingpostseason.fieldingpercent != -1
											order by year";
											
			
			
		}
		if ($playertype == 'Position Player'){
			$querybio = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
			FROM Baseballmaster
			WHERE playerid = '" . $playerid . "'";
			$querybattingstats = "select distinct year, ROUND(((battingaverage - (select avg(battingaverage) from baseballbatting))/(select stddev(battingaverage) from baseballbatting)),3) zScore,
								  ROUND(((slugging - (select avg(slugging) from baseballbatting))/(select stddev(slugging) from baseballbatting)),3) zScore2,
								  ROUND(((onbasepercent - (select avg(onbasepercent) from baseballbatting))/(select stddev(onbasepercent) from baseballbatting)),3) zScore3
								  from baseballbatting
								  where baseballbatting.playerid = '" . $playerid . "' AND slugging != -1
								  order by year";
								  
			$querypostseasonbattingstats = "select distinct year, round, ROUND(((battingaverage - (select avg(battingaverage) from baseballbattingpostseason))/(select stddev(battingaverage) from baseballbattingpostseason)),3) zScore,
								  ROUND(((slugging - (select avg(slugging) from baseballbattingpostseason))/(select stddev(slugging) from baseballbattingpostseason)),3) zScore2,
								  ROUND(((onbasepercent - (select avg(onbasepercent) from baseballbattingpostseason))/(select stddev(onbasepercent) from baseballbattingpostseason)),3) zScore3
								  from baseballbattingpostseason
								  where baseballbattingpostseason.playerid = '" . $playerid . "'  AND slugging != -1
								  order by year";
								  
			
			$queryfieldingstats = "select distinct year,
									ROUND(((fieldingpercent - (select avg(fieldingpercent) from baseballfielding))/(select stddev(fieldingpercent) from baseballfielding)),3) zScore
									from baseballfielding
									where baseballfielding.playerid = '" . $playerid . "'
									order by year";
									
			
			$querypostseasonfieldingstats = "select distinct year, round,
											ROUND(((fieldingpercent - (select avg(fieldingpercent) from baseballfieldingpostseason))/(select stddev(fieldingpercent) from baseballfieldingpostseason)),3) zScore
											from baseballfieldingpostseason
											where baseballfieldingpostseason.playerid = '" . $playerid . "' and baseballfieldingpostseason.fieldingpercent != -1
											order by year";
		}
		if ($playertype == 'Team'){
			$querystats = "select distinct year, 
					 ROUND(((winpercent - (select avg(winpercent) from baseballteams))/(select stddev(winpercent) from baseballteams)),3) zScore,				 
					 ROUND(((battingaverage - (select avg(battingaverage) from baseballteams))/(select stddev(battingaverage) from baseballteams)),3) zScore2,				 
					 ROUND(((slugging - (select avg(slugging) from baseballteams))/(select stddev(slugging) from baseballteams)),3) zScore3,				 
					 ROUND(((onbasepercent - (select avg(onbasepercent) from baseballteams))/(select stddev(onbasepercent) from baseballteams)),3) zScore4,					
					 ROUND(((era - (select avg(era) from baseballteams))/(select stddev(era) from baseballteams)),3) zScore5,
					 ROUND(((fieldingpercent - (select avg(fieldingpercent) from baseballteams))/(select stddev(fieldingpercent) from baseballteams)),3) zScore6
					 from baseballteams
					 where name = '" . $playerid . "'
					 order by year";
			
		}
	}
	
	else if ($sport == 'Basketball')
	{
		if ($playertype == 'Coach'){
			$querybio = "SELECT firstName, lastName, height, weight
				      FROM BASKETBALLMASTER
				      WHERE id = '" . $playerid . "' AND id IN (SELECT DISTINCT COACHID FROM BASKETBALLCOACHES)";
			$querystats = "SELECT distinct year, ROUND((winningpercentage - (select avg(winningpercentage) from basketballcoaches)) / (select stddev(winningpercentage) from basketballcoaches), 3) zScore
					 FROM BASKETBALLCoaches
					 WHERE coachid = '" . $playerid . "'
					 order by year";
			
			$querypostseasonstats = "SELECT distinct year, ROUND((POSTSEASONWINNINGPERCENTAGE - (SELECT AVG(POSTSEASONWINNINGPERCENTAGE) FROM BASKETBALLCOACHES)) / (SELECT STDDEV(POSTSEASONWINNINGPERCENTAGE) FROM BASKETBALLCOACHES), 3) zScore
						    FROM BASKETBALLCOACHES
						    WHERE BasketballCoaches.CoachID = '" . $playerid . "' AND POSTSEASONWINNINGPERCENTAGE != -1
						    order by year";
		}
		
		if ($playertype == 'Player'){
			$querybio = "SELECT firstName, lastName, height, weight
				      FROM BASKETBALLMASTER
				      WHERE id = '" . $playerid . "'";
					  
			$querystats = "SELECT distinct year, 
							ROUND(((pointspergame - (select avg(pointspergame) from basketballplayers))/(select stddev(pointspergame) from basketballplayers)),3) bavgZSCORE,
							ROUND(((reboundspergame - (select avg(reboundspergame) from basketballplayers))/(select stddev(reboundspergame) from basketballplayers)),3),
							ROUND(((assistspergame - (select avg(assistspergame) from basketballplayers))/(select stddev(assistspergame) from basketballplayers)),3),
							ROUND(((fieldgoalpercent - (select avg(fieldgoalpercent) from basketballplayers))/(select stddev(fieldgoalpercent) from basketballplayers)),3),
							ROUND(((freethrowpercent - (select avg(freethrowpercent) from basketballplayers))/(select stddev(freethrowpercent) from basketballplayers)),3),
							ROUND(((threepercent - (select avg(threepercent) from basketballplayers))/(select stddev(threepercent) from basketballplayers)),3)
							FROM BASKETBALLplayers
							WHERE playerid = '" . $playerid . "'
							order by year";
							
			
			$querypostseasonstats = "SELECT distinct year, 
							ROUND(((postseasonpointspergame - (select avg(postseasonpointspergame) from basketballplayers))/(select stddev(postseasonpointspergame) from basketballplayers)),3) bavgZSCORE,
							ROUND(((postseasonreboundspergame - (select avg(postseasonreboundspergame) from basketballplayers))/(select stddev(postseasonreboundspergame) from basketballplayers)),3),
							ROUND(((postseasonassistspergame - (select avg(postseasonassistspergame) from basketballplayers))/(select stddev(postseasonassistspergame) from basketballplayers)),3),
							ROUND(((postseasonfieldgoalpercent - (select avg(postseasonfieldgoalpercent) from basketballplayers))/(select stddev(postseasonfieldgoalpercent) from basketballplayers)),3),
							ROUND(((postseasonfreethrowpercent - (select avg(postseasonfreethrowpercent) from basketballplayers))/(select stddev(postseasonfreethrowpercent) from basketballplayers)),3),
							ROUND(((postseasonthreepercent - (select avg(postseasonthreepercent) from basketballplayers))/(select stddev(postseasonthreepercent) from basketballplayers)),3)
							FROM basketballplayers
							WHERE basketballplayers.playerid = '" . $playerid . "' and postseasonpointspergame != -1
							order by year";
			
			
		}
		if ($playertype == 'Team'){
			$querystats = "select distinct year, 
							ROUND(((fieldgoalpercent - (SELECT AVG(fieldgoalpercent) FROM BasketballTeams))/(SELECT STDDEV(fieldgoalpercent) FROM BasketballTeams)), 3) zScore,
							ROUND(((freethrowpercent - (SELECT AVG(freethrowpercent) FROM BasketballTeams))/(SELECT STDDEV(freethrowpercent) FROM BasketballTeams)), 3) zScore2,
							ROUND(((threepercent - (SELECT AVG(threepercent) FROM BasketballTeams))/(SELECT STDDEV(threepercent) FROM BasketballTeams)), 3) zScore3,
							ROUND(((reboundspergame - (SELECT AVG(reboundspergame) FROM BasketballTeams))/(SELECT STDDEV(reboundspergame) FROM BasketballTeams)), 3) zScore4,
							ROUND(((assistspergame - (SELECT AVG(assistspergame) FROM BasketballTeams))/(SELECT STDDEV(assistspergame) FROM BasketballTeams)), 3) zScore5,
							ROUND(((pointspergame - (SELECT AVG(pointspergame) FROM BasketballTeams))/(SELECT STDDEV(pointspergame) FROM BasketballTeams)), 3) zScore6,
							ROUND(((reboundsallowedpergame - (SELECT AVG(reboundsallowedpergame) FROM BasketballTeams))/(SELECT STDDEV(reboundsallowedpergame) FROM BasketballTeams)), 3) zScore7,
							ROUND(((assistsallowedpergame - (SELECT AVG(assistsallowedpergame) FROM BasketballTeams))/(SELECT STDDEV(assistsallowedpergame) FROM BasketballTeams)), 3) zScore8,
							ROUND(((pointsallowedpergame - (SELECT AVG(pointsallowedpergame) FROM BasketballTeams))/(SELECT STDDEV(pointsallowedpergame) FROM BasketballTeams)), 3) zScore9,
							ROUND(((winpercent- (SELECT AVG(winpercent) FROM BasketballTeams))/(SELECT STDDEV(winpercent) FROM BasketballTeams)), 3) zScore10
							from basketballteams
							where name = '" . $playerid . "'
							order by year";
		}
	}
	
	else if ($sport == 'Hockey')
	{
		if ($playertype == 'Coach'){
			$querybio = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
					FROM Hockeymaster
					WHERE coachid IS NOT NULL AND coachid = '" . $playerid . "'";
			$querystats = "SELECT DISTINCT YEAR, ROUND(((POINTSPERGAME - (SELECT AVG(POINTSPERGAME) FROM HOCKEYCOACHES))/(SELECT STDDEV(POINTSPERGAME) FROM HOCKEYCOACHES)), 3) zScore
			   FROM HOCKEYCOACHES
			   WHERE COACHID = '" . $playerid . "'
			   ORDER BY YEAR";
		
		}
		if ($playertype == 'Goalie'){
			$querybio = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
					FROM Hockeymaster
					WHERE playerid IS NOT NULL AND playerid = '" . $playerid . "'";
			$querystats = "select distinct year, ROUND(((pointspergame - (select avg(pointspergame) from hockeygoalies))/(select stddev(pointspergame) from hockeygoalies)),3) bavgZSCORE,
							ROUND(((savepercent - (select avg(savepercent) from hockeygoalies))/(select stddev(savepercent) from hockeygoalies)),3) bavgZSCORE2
							from hockeygoalies
							where hockeygoalies.goalieid = '" . $playerid . "'
							order by year";
			
			$querypostseasonstats = "select distinct year, ROUND(((postseasonwinpercent - (select avg(postseasonwinpercent) from hockeygoalies))/(select stddev(postseasonwinpercent) from hockeygoalies)),3),
									ROUND(((postseasonsavepercent - (select avg(postseasonsavepercent) from hockeygoalies))/(select stddev(postseasonsavepercent) from hockeygoalies)),3)
									from hockeygoalies
									where hockeygoalies.goalieid = '" . $playerid . "' and postseasongames != 0
									order by year";
			
			$queryshootoutstats = "select distinct year, 
									ROUND(((winpercent - (select avg(winpercent) from hockeygoaliesshootout))/(select stddev(winpercent) from hockeygoaliesshootout)),3),
									ROUND(((savepercent - (select avg(savepercent) from hockeygoaliesshootout))/(select stddev(savepercent) from hockeygoaliesshootout)),3)
									from hockeygoaliesshootout
									where hockeygoaliesshootout.goalieid = '" . $playerid . "'
									order by year";
									
			$queryscoringstats = "select distinct year, 
									ROUND(((pointspergame - (SELECT AVG(pointspergame) FROM hockeyscoring))/(SELECT STDDEV(pointspergame) + 0.0000001 FROM hockeyscoring)), 3), 
									ROUND(((shotpercent - (SELECT AVG(shotpercent) FROM hockeyscoring))/(SELECT STDDEV(shotpercent) + 0.000001 FROM hockeyscoring)), 3)
									from hockeyscoring
									where hockeyscoring.playerid = '" . $playerid . "' and shotpercent != -1
									order by year";
			
		}
		
		if ($playertype == 'Position Player'){
			$querybio = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
					FROM Hockeymaster
					WHERE playerid IS NOT NULL AND playerid = '" . $playerid . "'";
		    $queryscoringstats = "select distinct year,  
									ROUND(((pointspergame - (SELECT AVG(pointspergame) FROM hockeyscoring))/(SELECT STDDEV(pointspergame) + 0.0000001 FROM hockeyscoring)), 3), 
									ROUND(((shotpercent - (SELECT AVG(shotpercent) FROM hockeyscoring))/(SELECT STDDEV(shotpercent) + 0.000001 FROM hockeyscoring)), 3)
									from hockeyscoring
									where hockeyscoring.playerid = '" . $playerid . "' and shotpercent != -1
									order by year";
	
		}
		
		if ($playertype == 'Team'){
			$querystats = "select distinct year, ROUND(((goals - (select avg(goals) from hockeyteams))/(select stddev(goals) from hockeyteams)),3) zScore,
						ROUND(((goalsallowed - (select avg(goalsallowed) from hockeyteams))/(select stddev(goalsallowed) from hockeyteams)),3) zScore2
						from hockeyteams
						where name = '" . $playerid . "'
						order by year";
								
		}
	}
	
	
	
	
	/////////////////////////////////////////////////////////////////
	
	
	// STATEMENTBIO
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
					echo '<b>Regular Season Stats</b> </font>';
				}
				if($playertype == 'Pitcher'){
					echo '<font size = "4">';
					echo "<b> Biographical Information </b> <br>";
					echo 'Name: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . "<br>";
					echo 'Date of Birth: ' . $row['BIRTHMONTH'] . '/' . $row['BIRTHDAY'] . '/' . $row['BIRTHYEAR'] . "<br>";
					echo 'Height: ' . $row['HEIGHT'] . " inches <br>";
					echo 'Weight: ' . $row['WEIGHT'] . " pounds <br>";
					echo '<br>';
					echo '<b>Regular Season Pitching Stats</b> </font>';
				}
				if($playertype == 'Position Player')
				{
					echo '<font size = "4">';
					echo "<b> Biographical Information </b> <br>";
					echo 'Name: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . "<br>";
					echo 'Date of Birth: ' . $row['BIRTHMONTH'] . '/' . $row['BIRTHDAY'] . '/' . $row['BIRTHYEAR'] . "<br>";
					echo 'Height: ' . $row['HEIGHT'] . " inches <br>";
					echo 'Weight: ' . $row['WEIGHT'] . " pounds <br>";
					echo '<br>';
				}
			}
			else if($sport == 'Basketball')
			{
				if($playertype == 'Coach')
				{
					echo '<font size = "4">';
					echo "<b> Biographical Information </b> <br>";
					echo 'Name: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . "<br>";
					echo 'Height: ' . $row['HEIGHT'] . " inches <br>";
					echo 'Weight: ' . $row['WEIGHT'] . " pounds <br>";
					echo '<br>';
					echo '<b>Regular Season Stats</b> </font>';
				}
				if($playertype == 'Player')
				{
					echo '<font size = "4">';
					echo "<b> Biographical Information </b> <br>";
					echo 'Name: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . "<br>";
					echo 'Height: ' . $row['HEIGHT'] . " inches <br>";
					echo 'Weight: ' . $row['WEIGHT'] . " pounds <br>";
					echo '<br>';
					echo '<b>Regular Season Stats</b> </font>';
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
					echo '<b>Regular Season Stats</b> </font>';
				}
				if($playertype == 'Goalie'){
					echo '<font size = "4">';
					echo "<b> Biographical Information </b> <br>";
					echo 'Name: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . "<br>";
					echo 'Date of Birth: ' . $row['BIRTHMONTH'] . '/' . $row['BIRTHDAY'] . '/' . $row['BIRTHYEAR'] . "<br>";
					echo 'Height: ' . $row['HEIGHT'] . " inches <br>";
					echo 'Weight: ' . $row['WEIGHT'] . " pounds <br>";
					echo '<br>';
					echo '<b>Regular Season Goaltending Stats</b> </font>';
				}
				if($playertype == 'Position Player')
				{
					echo '<font size = "4">';
					echo "<b> Biographical Information </b> <br>";
					echo 'Name: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . "<br>";
					echo 'Date of Birth: ' . $row['BIRTHMONTH'] . '/' . $row['BIRTHDAY'] . '/' . $row['BIRTHYEAR'] . "<br>";
					echo 'Height: ' . $row['HEIGHT'] . " inches <br>";
					echo 'Weight: ' . $row['WEIGHT'] . " pounds <br>";
					echo '<br>';
				}
			}
		}
	}
	else
	{
		echo '<fontsize = "4"><b>Team Regular Season Stats</b></font><br>';
	}
	
	
	
	if(($sport == 'Baseball' && $playertype == 'Position Player') || ($sport == 'Hockey' && $playertype == 'Position Player'))
	{
		
	}
	else
	{
		$statementstats = oci_parse($connection, $querystats);
		oci_execute($statementstats);
	    echo "<table border='1'>\n";
		if($sport == 'Baseball')
		{
			if($playertype == 'Manager')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Win Percent z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Pitcher')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				
				echo '<th>Batting Average z-Score</th>';
				echo '<th>ERA z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Team')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				
				echo '<th>Win Percent z-Score</th>';
				
				echo '<th>Batting Average z-Score</th>';
				
				echo '<th>Slugging z-Score</th>';
				
				echo '<th>OBP z-Score</th>';
				
				echo '<th>ERA z-Score</th>';
				
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
				echo '<th>Win Percent z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Team')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				
				echo '<th>Field Goal Percent z-Score</th>';
				
				echo '<th>Free Throw Percent z-Score</th>';
				
				echo '<th>Three Point Percent z-Score</th>';
				
				echo '<th>Rebounds Per Game z-Score</th>';
				
				echo '<th>Assists Per Game z-Score</th>';
				
				echo '<th>Points Per Game z-Score</th>';
				
				echo '<th>Rebounds Allowed Per Game z-Score</th>';
				
				echo '<th>Assists Allowed Per Game z-Score</th>';
			
				echo '<th>Points Allowed Per Game z-Score</th>';
				
				echo '<th>Win Percent z-Score</th>';
			
				echo '</tr>';
			}
			if($playertype == 'Player')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				
				echo '<th>Points Per Game z-Score</th>';
				
				echo '<th>Rebounds Per Game z-Score</th>';
				
				echo '<th>Assists Per Game z-Score</th>';
			
				echo '<th>Field Goal Percent z-Score</th>';
				
				echo '<th>Free Throw Percent z-Score</th>';
				
				echo '<th>Three Point Percent z-Score</th>';
				echo '</tr>';
			}
		}
		else if($sport == 'Hockey')
		{
			if($playertype == 'Coach')
			{
				echo '<tr>';
				echo '<th>Year</th>';
			
				echo '<th>Points Per Game z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Goalie')
			{
				echo '<tr>';
				echo '<th>Year</th>';
		
				echo '<th>Points Per Game z-Score</th>';
				
				echo '<th>Save Percent z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Team')
			{
				echo '<tr>';
				echo '<th>Year</th>';
			
				echo '<th>Goals z-Score</th>';
				echo '<th>Goals Allowed z-Score</th>';
				
				echo '</tr>';
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
	}
	
	
		if($sport == 'Baseball'){
			if($playertype == 'Manager'){
				
			}
			if($playertype == 'Pitcher'){
				echo '<font size = "4"><b>Postseason Pitching Stats</b></font><br>';
			}
			if($playertype == 'Position Player'){
			}
		}
		else if($sport == 'Basketball'){
			if($playertype == 'Coach'){
				echo '<font size = "4"><b>Postseason Stats</b></font><br>';
			}
			if($playertype == 'Player')
			{
				echo '<font size = "4"><b>Postseason Stats</b></font><br>';
			}
		}
		else if($sport == 'Hockey'){
			if($playertype == 'Goalie'){
				echo '<font size = "4"><b>Postseason Goaltending Stats</b></font><br>';
			}
		}
	$statementpostseasonstats = oci_parse($connection, $querypostseasonstats);
	if(($sport == 'Baseball' && $playertype == 'Pitcher') ||($sport == 'Basketball' && $playertype == 'Coach') || ($sport == 'Hockey' && $playertype == 'Coach') || ($sport == 'Hockey' && $playertype == 'Team') || ($sport == 'Basketball' && $playertype == 'Player') || ($sport == 'Hockey' && $playertype == 'Goalie'))
	{
		oci_execute($statementpostseasonstats);
		echo "<table border='1'>\n";
		if($sport == 'Baseball'){
			if($playertype == 'Pitcher'){
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Round</th>';
				echo '<th>Batting Average z-Score</th>';
				echo '<th>ERA z-Score</th>';
				echo '</tr>';
			}
		}
		else if($sport == 'Basketball'){
			if($playertype == 'Coach')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Win Percent z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Player')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				
				echo '<th>Points Per Game z-Score</th>';
				
				echo '<th>Rebounds Per Game z-Score</th>';
				
				echo '<th>Assists Per Game z-Score</th>';
				
				echo '<th>Field Goal Percent z-Score</th>';
				
				echo '<th>Free Throw Percent z-Score</th>';
				
				echo '<th>Three Point Percent z-Score</th>';
				echo '</tr>';
			}
		}
		else if($sport == 'Hockey'){
			if($playertype == 'Goalie'){
					echo '<tr>';
					echo '<th>Year</th>';
				
					echo '<th>Win Percent z-Score</th>';
					
					echo '<th>Save Percent z-Score</th>';
					echo '</tr>';
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
	
	$statementbattingstats = oci_parse($connection, $querybattingstats);
	if($sport == 'Baseball' && ($playertype == 'Pitcher' || $playertype == 'Position Player'))
	{
		echo '<font size = "4"><b>Regular Season Batting Stats</b></font><br>';
		oci_execute($statementbattingstats);
		echo "<table border='1'>\n";
			    echo '<tr>';
				echo '<th>Year</th>';
				
				echo '<th>Batting Average z-Score</th>';
				
				echo '<th>Slugging z-Score</th>';
				
				echo '<th>OBP z-Score</th>';
				
				echo '</tr>';
		while ($row = oci_fetch_array($statementbattingstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			echo "<tr>\n";
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	
	$statementpostseasonbattingstats = oci_parse($connection, $querypostseasonbattingstats);
	if($sport == 'Baseball' && ($playertype == 'Pitcher' || $playertype == 'Position Player'))
	{
		echo '<font size = "4"><b>Postseason Batting Stats</b></font><br>';
		oci_execute($statementpostseasonbattingstats);
		echo "<table border='1'>\n";
			    echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Round</th>';
				echo '<th>Batting Average z-Score</th>';
				
				echo '<th>Slugging z-Score</th>';
				
				echo '<th>OBP z-Score</th>';
				
				echo '</tr>';
		while ($row = oci_fetch_array($statementpostseasonbattingstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			echo "<tr>\n";
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	
	$statementfieldingstats = oci_parse($connection, $queryfieldingstats);
	if($sport == 'Baseball' && ($playertype == 'Pitcher' || $playertype == 'Position Player'))
	{
		echo '<font size = "4"><b>Regular Season Fielding Stats</b></font><br>';
		oci_execute($statementfieldingstats);
		echo "<table border='1'>\n";
		echo "<tr>\n";
				echo '<th>Year</th>';
			
				echo '<th>Fielding Percent z-Score</th>';
				echo '</tr>';	   
		while ($row = oci_fetch_array($statementfieldingstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	

	$statementpostseasonfieldingstats = oci_parse($connection, $querypostseasonfieldingstats);
	if($sport == 'Baseball' && ($playertype == 'Pitcher' || $playertype == 'Position Player'))
	{
		echo '<font size = "4"><b>Postseason Fielding Stats</b></font><br>';
		oci_execute($statementpostseasonfieldingstats);
		echo "<table border='1'>\n";
		echo "<tr>\n";
				echo '<th>Year</th>';
				echo '<th>Round</th>';
				echo '<th>Fielding Percent z-Score</th>';
				echo '</tr>';	   
		while ($row = oci_fetch_array($statementpostseasonfieldingstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	
	
    $statementshootoutstats = oci_parse($connection, $queryshootoutstats);
	if($sport == 'Hockey' && $playertype == 'Goalie')
	{
		oci_execute($statementshootoutstats);
				echo '<font size = "4"><b>Shootout Goaltending Stats</b></font><br>';
				echo "<table border='1'>\n";
				echo '<tr>';
				echo '<th>Year</th>';
				
				echo '<th>Win Percent z-Score</th>';
				
				echo '<th>Save Percent z-Score</th>';
				echo '</tr>';
		while ($row = oci_fetch_array($statementshootoutstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	
	
	$statementscoringstats = oci_parse($connection, $queryscoringstats);
	if(($sport == 'Hockey' && $playertype == 'Goalie') || ($sport == 'Hockey' && $playertype == 'Position Player'))
	{
		oci_execute($statementscoringstats);
		echo '<font size = "4"><b>Regular Season Scoring Stats</b></font><br>';
		echo "<table border='1'>\n";
		echo '<tr>';
		echo '<th>Year</th>';
		
		echo '<th>Points Per Game z-Score</th>';
	
		echo '<th>Shot Percent z-Score</th>';
		echo '</tr>';
		while ($row = oci_fetch_array($statementscoringstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	
	echo "</td>";
	
	
	
	
	
	
	///////////////////////////////////////////////////////////////
	
	///////////////////////////////////////////////////////////////
	
	
	
	
	
	
	
	
	echo "<td valign='top'>";
	
	if ($sport == 'Baseball')
	{
		if ($playertype == 'Manager'){
			$querybio2 = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
					FROM Baseballmaster
					WHERE managerid IS NOT NULL AND managerid = '" . $playerid2 . "'";
			$querystats2 = "SELECT distinct year, ROUND((WINPERCENT - (SELECT AVG(WINPERCENT) FROM BASEBALLMANAGERS)) / (SELECT STDDEV(WINPERCENT) FROM BASEBALLMANAGERS), 3) zScore
						FROM Baseballmanagers
						WHERE managerid = '" . $playerid2 . "'
						ORDER BY year";
		}
		
		if ($playertype == 'Pitcher'){
			$querybio2 = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
			FROM Baseballmaster
			WHERE playerid = '" . $playerid2 . "'";
			
			$querystats2 = "SELECT distinct year,
			ROUND(((bavg - (select avg(bavg) from baseballpitching))/(select stddev(bavg) from baseballpitching)),3) bavgZSCORE,
			ROUND(((era - (select avg(era) from baseballpitching))/(select stddev(era) from baseballpitching)),3) eraZSCORE
			FROM BaseballPitching
			WHERE pitcherid = '" . $playerid2 . "'
			ORDER BY year";
			
			
			$querypostseasonstats2 = "SELECT distinct year, round, 
			ROUND(((battingaverage - (select avg(battingaverage) from baseballpitchingpostseason))/(select stddev(battingaverage) from baseballpitchingpostseason)),3) bavgZSCORE,
			ROUND(((era - (select avg(era) from baseballpitchingpostseason))/(select stddev(era) from baseballpitchingpostseason)),3) eraZSCORE
			FROM BaseballPitchingPostSeason
			WHERE playerid = '" . $playerid2 . "'
			ORDER BY year";
			
			$querybattingstats2 = "select distinct year, ROUND(((battingaverage - (select avg(battingaverage) from baseballbatting))/(select stddev(battingaverage) from baseballbatting)),3) zScore,
								  ROUND(((slugging - (select avg(slugging) from baseballbatting))/(select stddev(slugging) from baseballbatting)),3) zScore2,
								  ROUND(((onbasepercent - (select avg(onbasepercent) from baseballbatting))/(select stddev(onbasepercent) from baseballbatting)),3) zScore3
								  from baseballbatting
								  where baseballbatting.playerid = '" . $playerid2 . "' AND slugging != -1
								  order by year";
								  
			$querypostseasonbattingstats2 = "select distinct year, round, ROUND(((battingaverage - (select avg(battingaverage) from baseballbattingpostseason))/(select stddev(battingaverage) from baseballbattingpostseason)),3) zScore,
								  ROUND(((slugging - (select avg(slugging) from baseballbattingpostseason))/(select stddev(slugging) from baseballbattingpostseason)),3) zScore2,
								  ROUND(((onbasepercent - (select avg(onbasepercent) from baseballbattingpostseason))/(select stddev(onbasepercent) from baseballbattingpostseason)),3) zScore3
								  from baseballbattingpostseason
								  where baseballbattingpostseason.playerid = '" . $playerid2 . "'  AND slugging != -1
								  order by year";
								  
			
			$queryfieldingstats2 = "select distinct year,
									ROUND(((fieldingpercent - (select avg(fieldingpercent) from baseballfielding))/(select stddev(fieldingpercent) from baseballfielding)),3) zScore
									from baseballfielding
									where baseballfielding.playerid = '" . $playerid2 . "'
									order by year";
									
			
			$querypostseasonfieldingstats2 = "select distinct year, round,
											ROUND(((fieldingpercent - (select avg(fieldingpercent) from baseballfieldingpostseason))/(select stddev(fieldingpercent) from baseballfieldingpostseason)),3) zScore
											from baseballfieldingpostseason
											where baseballfieldingpostseason.playerid = '" . $playerid2 . "' and baseballfieldingpostseason.fieldingpercent != -1
											order by year";
											
			
			
		}
		if ($playertype == 'Position Player'){
			$querybio2 = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
			FROM Baseballmaster
			WHERE playerid = '" . $playerid2 . "'";
			$querybattingstats2 = "select distinct year, ROUND(((battingaverage - (select avg(battingaverage) from baseballbatting))/(select stddev(battingaverage) from baseballbatting)),3) zScore,
								  ROUND(((slugging - (select avg(slugging) from baseballbatting))/(select stddev(slugging) from baseballbatting)),3) zScore2,
								  ROUND(((onbasepercent - (select avg(onbasepercent) from baseballbatting))/(select stddev(onbasepercent) from baseballbatting)),3) zScore3
								  from baseballbatting
								  where baseballbatting.playerid = '" . $playerid2 . "' AND slugging != -1
								  order by year";
								  
			$querypostseasonbattingstats2 = "select distinct year, round, ROUND(((battingaverage - (select avg(battingaverage) from baseballbattingpostseason))/(select stddev(battingaverage) from baseballbattingpostseason)),3) zScore,
								  ROUND(((slugging - (select avg(slugging) from baseballbattingpostseason))/(select stddev(slugging) from baseballbattingpostseason)),3) zScore2,
								  ROUND(((onbasepercent - (select avg(onbasepercent) from baseballbattingpostseason))/(select stddev(onbasepercent) from baseballbattingpostseason)),3) zScore3
								  from baseballbattingpostseason
								  where baseballbattingpostseason.playerid = '" . $playerid2 . "'  AND slugging != -1
								  order by year";
								  
			
			$queryfieldingstats2 = "select distinct year,
									ROUND(((fieldingpercent - (select avg(fieldingpercent) from baseballfielding))/(select stddev(fieldingpercent) from baseballfielding)),3) zScore
									from baseballfielding
									where baseballfielding.playerid = '" . $playerid2 . "'
									order by year";
									
			
			$querypostseasonfieldingstats2 = "select distinct year, round,
											ROUND(((fieldingpercent - (select avg(fieldingpercent) from baseballfieldingpostseason))/(select stddev(fieldingpercent) from baseballfieldingpostseason)),3) zScore
											from baseballfieldingpostseason
											where baseballfieldingpostseason.playerid = '" . $playerid2 . "' and baseballfieldingpostseason.fieldingpercent != -1
											order by year";
		}
		if ($playertype == 'Team'){
			$querystats2 = "select distinct year, 
					 ROUND(((winpercent - (select avg(winpercent) from baseballteams))/(select stddev(winpercent) from baseballteams)),3) zScore,				 
					 ROUND(((battingaverage - (select avg(battingaverage) from baseballteams))/(select stddev(battingaverage) from baseballteams)),3) zScore2,				 
					 ROUND(((slugging - (select avg(slugging) from baseballteams))/(select stddev(slugging) from baseballteams)),3) zScore3,				 
					 ROUND(((onbasepercent - (select avg(onbasepercent) from baseballteams))/(select stddev(onbasepercent) from baseballteams)),3) zScore4,					
					 ROUND(((era - (select avg(era) from baseballteams))/(select stddev(era) from baseballteams)),3) zScore5,
					 ROUND(((fieldingpercent - (select avg(fieldingpercent) from baseballteams))/(select stddev(fieldingpercent) from baseballteams)),3) zScore6
					 from baseballteams
					 where name = '" . $playerid2 . "'
					 order by year";
			
		}
	}
	
	else if ($sport == 'Basketball')
	{
		if ($playertype == 'Coach'){
			$querybio2 = "SELECT firstName, lastName, height, weight
				      FROM BASKETBALLMASTER
				      WHERE id = '" . $playerid2 . "' AND id IN (SELECT DISTINCT COACHID FROM BASKETBALLCOACHES)";
			$querystats2 = "SELECT distinct year, ROUND((winningpercentage - (select avg(winningpercentage) from basketballcoaches)) / (select stddev(winningpercentage) from basketballcoaches), 3) zScore
					 FROM BASKETBALLCoaches
					 WHERE coachid = '" . $playerid2 . "'
					 order by year";
			
			$querypostseasonstats2 = "SELECT distinct year, ROUND((POSTSEASONWINNINGPERCENTAGE - (SELECT AVG(POSTSEASONWINNINGPERCENTAGE) FROM BASKETBALLCOACHES)) / (SELECT STDDEV(POSTSEASONWINNINGPERCENTAGE) FROM BASKETBALLCOACHES), 3) zScore
						    FROM BASKETBALLCOACHES
						    WHERE BasketballCoaches.CoachID = '" . $playerid2 . "' AND POSTSEASONWINNINGPERCENTAGE != -1
						    order by year";
		}
		
		if ($playertype == 'Player'){
			$querybio2 = "SELECT firstName, lastName, height, weight
				      FROM BASKETBALLMASTER
				      WHERE id = '" . $playerid2 . "'";
					  
			$querystats2 = "SELECT distinct year, 
							ROUND(((pointspergame - (select avg(pointspergame) from basketballplayers))/(select stddev(pointspergame) from basketballplayers)),3) bavgZSCORE,
							ROUND(((reboundspergame - (select avg(reboundspergame) from basketballplayers))/(select stddev(reboundspergame) from basketballplayers)),3),
							ROUND(((assistspergame - (select avg(assistspergame) from basketballplayers))/(select stddev(assistspergame) from basketballplayers)),3),
							ROUND(((fieldgoalpercent - (select avg(fieldgoalpercent) from basketballplayers))/(select stddev(fieldgoalpercent) from basketballplayers)),3),
							ROUND(((freethrowpercent - (select avg(freethrowpercent) from basketballplayers))/(select stddev(freethrowpercent) from basketballplayers)),3),
							ROUND(((threepercent - (select avg(threepercent) from basketballplayers))/(select stddev(threepercent) from basketballplayers)),3)
							FROM BASKETBALLplayers
							WHERE playerid = '" . $playerid2 . "'
							order by year";
							
			
			$querypostseasonstats2 = "SELECT distinct year, 
							ROUND(((postseasonpointspergame - (select avg(postseasonpointspergame) from basketballplayers))/(select stddev(postseasonpointspergame) from basketballplayers)),3) bavgZSCORE,
							ROUND(((postseasonreboundspergame - (select avg(postseasonreboundspergame) from basketballplayers))/(select stddev(postseasonreboundspergame) from basketballplayers)),3),
							ROUND(((postseasonassistspergame - (select avg(postseasonassistspergame) from basketballplayers))/(select stddev(postseasonassistspergame) from basketballplayers)),3),
							ROUND(((postseasonfieldgoalpercent - (select avg(postseasonfieldgoalpercent) from basketballplayers))/(select stddev(postseasonfieldgoalpercent) from basketballplayers)),3),
							ROUND(((postseasonfreethrowpercent - (select avg(postseasonfreethrowpercent) from basketballplayers))/(select stddev(postseasonfreethrowpercent) from basketballplayers)),3),
							ROUND(((postseasonthreepercent - (select avg(postseasonthreepercent) from basketballplayers))/(select stddev(postseasonthreepercent) from basketballplayers)),3)
							FROM basketballplayers
							WHERE basketballplayers.playerid = '" . $playerid2 . "' and postseasonpointspergame != -1
							order by year";
			
			
		}
		if ($playertype == 'Team'){
			$querystats2 = "select distinct year, 
							ROUND(((fieldgoalpercent - (SELECT AVG(fieldgoalpercent) FROM BasketballTeams))/(SELECT STDDEV(fieldgoalpercent) FROM BasketballTeams)), 3) zScore,
							ROUND(((freethrowpercent - (SELECT AVG(freethrowpercent) FROM BasketballTeams))/(SELECT STDDEV(freethrowpercent) FROM BasketballTeams)), 3) zScore2,
							ROUND(((threepercent - (SELECT AVG(threepercent) FROM BasketballTeams))/(SELECT STDDEV(threepercent) FROM BasketballTeams)), 3) zScore3,
							ROUND(((reboundspergame - (SELECT AVG(reboundspergame) FROM BasketballTeams))/(SELECT STDDEV(reboundspergame) FROM BasketballTeams)), 3) zScore4,
							ROUND(((assistspergame - (SELECT AVG(assistspergame) FROM BasketballTeams))/(SELECT STDDEV(assistspergame) FROM BasketballTeams)), 3) zScore5,
							ROUND(((pointspergame - (SELECT AVG(pointspergame) FROM BasketballTeams))/(SELECT STDDEV(pointspergame) FROM BasketballTeams)), 3) zScore6,
							ROUND(((reboundsallowedpergame - (SELECT AVG(reboundsallowedpergame) FROM BasketballTeams))/(SELECT STDDEV(reboundsallowedpergame) FROM BasketballTeams)), 3) zScore7,
							ROUND(((assistsallowedpergame - (SELECT AVG(assistsallowedpergame) FROM BasketballTeams))/(SELECT STDDEV(assistsallowedpergame) FROM BasketballTeams)), 3) zScore8,
							ROUND(((pointsallowedpergame - (SELECT AVG(pointsallowedpergame) FROM BasketballTeams))/(SELECT STDDEV(pointsallowedpergame) FROM BasketballTeams)), 3) zScore9,
							ROUND(((winpercent- (SELECT AVG(winpercent) FROM BasketballTeams))/(SELECT STDDEV(winpercent) FROM BasketballTeams)), 3) zScore10
							from basketballteams
							where name = '" . $playerid2 . "'
							order by year";
		}
	}
	
	else if ($sport == 'Hockey')
	{
		if ($playertype == 'Coach'){
			$querybio2 = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
					FROM Hockeymaster
					WHERE coachid IS NOT NULL AND coachid = '" . $playerid2 . "'";
			$querystats2 = "SELECT DISTINCT YEAR, ROUND(((POINTSPERGAME - (SELECT AVG(POINTSPERGAME) FROM HOCKEYCOACHES))/(SELECT STDDEV(POINTSPERGAME) FROM HOCKEYCOACHES)), 3) zScore
			   FROM HOCKEYCOACHES
			   WHERE COACHID = '" . $playerid2 . "'
			   ORDER BY YEAR";
		
		}
		if ($playertype == 'Goalie'){
			$querybio2 = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
					FROM Hockeymaster
					WHERE playerid IS NOT NULL AND playerid = '" . $playerid2 . "'";
			$querystats2 = "select distinct year, ROUND(((pointspergame - (select avg(pointspergame) from hockeygoalies))/(select stddev(pointspergame) from hockeygoalies)),3) bavgZSCORE,
							ROUND(((savepercent - (select avg(savepercent) from hockeygoalies))/(select stddev(savepercent) from hockeygoalies)),3) bavgZSCORE2
							from hockeygoalies
							where hockeygoalies.goalieid = '" . $playerid2 . "'
							order by year";
			
			$querypostseasonstats2 = "select distinct year, ROUND(((postseasonwinpercent - (select avg(postseasonwinpercent) from hockeygoalies))/(select stddev(postseasonwinpercent) from hockeygoalies)),3),
									ROUND(((postseasonsavepercent - (select avg(postseasonsavepercent) from hockeygoalies))/(select stddev(postseasonsavepercent) from hockeygoalies)),3)
									from hockeygoalies
									where hockeygoalies.goalieid = '" . $playerid2 . "' and postseasongames != 0
									order by year";
			
			$queryshootoutstats2 = "select distinct year, 
									ROUND(((winpercent - (select avg(winpercent) from hockeygoaliesshootout))/(select stddev(winpercent) from hockeygoaliesshootout)),3),
									ROUND(((savepercent - (select avg(savepercent) from hockeygoaliesshootout))/(select stddev(savepercent) from hockeygoaliesshootout)),3)
									from hockeygoaliesshootout
									where hockeygoaliesshootout.goalieid = '" . $playerid2 . "'
									order by year";
									
			$queryscoringstats2 = "select distinct year, 
									ROUND(((pointspergame - (SELECT AVG(pointspergame) FROM hockeyscoring))/(SELECT STDDEV(pointspergame) + 0.0000001 FROM hockeyscoring)), 3), 
									ROUND(((shotpercent - (SELECT AVG(shotpercent) FROM hockeyscoring))/(SELECT STDDEV(shotpercent) + 0.000001 FROM hockeyscoring)), 3)
									from hockeyscoring
									where hockeyscoring.playerid = '" . $playerid2 . "' and shotpercent != -1
									order by year";
			
		}
		
		if ($playertype == 'Position Player'){
			$querybio2 = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
					FROM Hockeymaster
					WHERE playerid IS NOT NULL AND playerid = '" . $playerid2 . "'";
		    $queryscoringstats2 = "select distinct year,  
									ROUND(((pointspergame - (SELECT AVG(pointspergame) FROM hockeyscoring))/(SELECT STDDEV(pointspergame) + 0.0000001 FROM hockeyscoring)), 3), 
									ROUND(((shotpercent - (SELECT AVG(shotpercent) FROM hockeyscoring))/(SELECT STDDEV(shotpercent) + 0.000001 FROM hockeyscoring)), 3)
									from hockeyscoring
									where hockeyscoring.playerid = '" . $playerid2 . "' and shotpercent != -1
									order by year";
	
		}
		
		if ($playertype == 'Team'){
			$querystats2 = "select distinct year, ROUND(((goals - (select avg(goals) from hockeyteams))/(select stddev(goals) from hockeyteams)),3) zScore,
						ROUND(((goalsallowed - (select avg(goalsallowed) from hockeyteams))/(select stddev(goalsallowed) from hockeyteams)),3) zScore2
						from hockeyteams
						where name = '" . $playerid2 . "'
						order by year";
								
		}
	}
	
	
	
	
	/////////////////////////////////////////////////////////////////
	
	
	// STATEMENTBIO
	$statementbio2 = oci_parse($connection, $querybio2);
	if($playertype != 'Team')
	{
		oci_execute($statementbio2);	
		while($row=oci_fetch_assoc($statementbio2)) {
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
					echo '<b>Regular Season Stats</b> </font>';
				}
				if($playertype == 'Pitcher'){
					echo '<font size = "4">';
					echo "<b> Biographical Information </b> <br>";
					echo 'Name: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . "<br>";
					echo 'Date of Birth: ' . $row['BIRTHMONTH'] . '/' . $row['BIRTHDAY'] . '/' . $row['BIRTHYEAR'] . "<br>";
					echo 'Height: ' . $row['HEIGHT'] . " inches <br>";
					echo 'Weight: ' . $row['WEIGHT'] . " pounds <br>";
					echo '<br>';
					echo '<b>Regular Season Pitching Stats</b> </font>';
				}
				if($playertype == 'Position Player')
				{
					echo '<font size = "4">';
					echo "<b> Biographical Information </b> <br>";
					echo 'Name: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . "<br>";
					echo 'Date of Birth: ' . $row['BIRTHMONTH'] . '/' . $row['BIRTHDAY'] . '/' . $row['BIRTHYEAR'] . "<br>";
					echo 'Height: ' . $row['HEIGHT'] . " inches <br>";
					echo 'Weight: ' . $row['WEIGHT'] . " pounds <br>";
					echo '<br>';
				}
			}
			else if($sport == 'Basketball')
			{
				if($playertype == 'Coach')
				{
					echo '<font size = "4">';
					echo "<b> Biographical Information </b> <br>";
					echo 'Name: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . "<br>";
					echo 'Height: ' . $row['HEIGHT'] . " inches <br>";
					echo 'Weight: ' . $row['WEIGHT'] . " pounds <br>";
					echo '<br>';
					echo '<b>Regular Season Stats</b> </font>';
				}
				if($playertype == 'Player')
				{
					echo '<font size = "4">';
					echo "<b> Biographical Information </b> <br>";
					echo 'Name: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . "<br>";
					echo 'Height: ' . $row['HEIGHT'] . " inches <br>";
					echo 'Weight: ' . $row['WEIGHT'] . " pounds <br>";
					echo '<br>';
					echo '<b>Regular Season Stats</b> </font>';
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
					echo '<b>Regular Season Stats</b> </font>';
				}
				if($playertype == 'Goalie'){
					echo '<font size = "4">';
					echo "<b> Biographical Information </b> <br>";
					echo 'Name: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . "<br>";
					echo 'Date of Birth: ' . $row['BIRTHMONTH'] . '/' . $row['BIRTHDAY'] . '/' . $row['BIRTHYEAR'] . "<br>";
					echo 'Height: ' . $row['HEIGHT'] . " inches <br>";
					echo 'Weight: ' . $row['WEIGHT'] . " pounds <br>";
					echo '<br>';
					echo '<b>Regular Season Goaltending Stats</b> </font>';
				}
				if($playertype == 'Position Player')
				{
					echo '<font size = "4">';
					echo "<b> Biographical Information </b> <br>";
					echo 'Name: ' . $row['FIRSTNAME'] . ' ' . $row['LASTNAME'] . "<br>";
					echo 'Date of Birth: ' . $row['BIRTHMONTH'] . '/' . $row['BIRTHDAY'] . '/' . $row['BIRTHYEAR'] . "<br>";
					echo 'Height: ' . $row['HEIGHT'] . " inches <br>";
					echo 'Weight: ' . $row['WEIGHT'] . " pounds <br>";
					echo '<br>';
				}
			}
		}
	}
	else
	{
		echo '<fontsize = "4"><b>Team Regular Season Stats</b></font><br>';
	}
	
	
	
	if(($sport == 'Baseball' && $playertype == 'Position Player') || ($sport == 'Hockey' && $playertype == 'Position Player'))
	{
		
	}
	else
	{
		$statementstats2 = oci_parse($connection, $querystats2);
		oci_execute($statementstats2);
	    echo "<table border='1'>\n";
		if($sport == 'Baseball')
		{
			if($playertype == 'Manager')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Win Percent z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Pitcher')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				
				echo '<th>Batting Average z-Score</th>';
				echo '<th>ERA z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Team')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				
				echo '<th>Win Percent z-Score</th>';
				
				echo '<th>Batting Average z-Score</th>';
				
				echo '<th>Slugging z-Score</th>';
				
				echo '<th>OBP z-Score</th>';
				
				echo '<th>ERA z-Score</th>';
				
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
				echo '<th>Win Percent z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Team')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				
				echo '<th>Field Goal Percent z-Score</th>';
				
				echo '<th>Free Throw Percent z-Score</th>';
				
				echo '<th>Three Point Percent z-Score</th>';
				
				echo '<th>Rebounds Per Game z-Score</th>';
				
				echo '<th>Assists Per Game z-Score</th>';
				
				echo '<th>Points Per Game z-Score</th>';
				
				echo '<th>Rebounds Allowed Per Game z-Score</th>';
				
				echo '<th>Assists Allowed Per Game z-Score</th>';
			
				echo '<th>Points Allowed Per Game z-Score</th>';
				
				echo '<th>Win Percent z-Score</th>';
			
				echo '</tr>';
			}
			if($playertype == 'Player')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				
				echo '<th>Points Per Game z-Score</th>';
				
				echo '<th>Rebounds Per Game z-Score</th>';
				
				echo '<th>Assists Per Game z-Score</th>';
			
				echo '<th>Field Goal Percent z-Score</th>';
				
				echo '<th>Free Throw Percent z-Score</th>';
				
				echo '<th>Three Point Percent z-Score</th>';
				echo '</tr>';
			}
		}
		else if($sport == 'Hockey')
		{
			if($playertype == 'Coach')
			{
				echo '<tr>';
				echo '<th>Year</th>';
			
				echo '<th>Points Per Game z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Goalie')
			{
				echo '<tr>';
				echo '<th>Year</th>';
		
				echo '<th>Points Per Game z-Score</th>';
				
				echo '<th>Save Percent z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Team')
			{
				echo '<tr>';
				echo '<th>Year</th>';
			
				echo '<th>Goals z-Score</th>';
				echo '<th>Goals Allowed z-Score</th>';
				
				echo '</tr>';
			}
		}
		
		while ($row = oci_fetch_array($statementstats2, OCI_ASSOC+OCI_RETURN_NULLS)) 
		{
			echo "<tr>\n";
			foreach ($row as $item) 
			{
				echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table><br>";
	}
	
	
		if($sport == 'Baseball'){
			if($playertype == 'Manager'){
				
			}
			if($playertype == 'Pitcher'){
				echo '<font size = "4"><b>Postseason Pitching Stats</b></font><br>';
			}
			if($playertype == 'Position Player'){
			}
		}
		else if($sport == 'Basketball'){
			if($playertype == 'Coach'){
				echo '<font size = "4"><b>Postseason Stats</b></font><br>';
			}
			if($playertype == 'Player')
			{
				echo '<font size = "4"><b>Postseason Stats</b></font><br>';
			}
		}
		else if($sport == 'Hockey'){
			if($playertype == 'Goalie'){
				echo '<font size = "4"><b>Postseason Goaltending Stats</b></font><br>';
			}
		}
	$statementpostseasonstats2 = oci_parse($connection, $querypostseasonstats2);
	if(($sport == 'Baseball' && $playertype == 'Pitcher') ||($sport == 'Basketball' && $playertype == 'Coach') || ($sport == 'Hockey' && $playertype == 'Coach') || ($sport == 'Hockey' && $playertype == 'Team') || ($sport == 'Basketball' && $playertype == 'Player') || ($sport == 'Hockey' && $playertype == 'Goalie'))
	{
		oci_execute($statementpostseasonstats2);
		echo "<table border='1'>\n";
		if($sport == 'Baseball'){
			if($playertype == 'Pitcher'){
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Round</th>';
				echo '<th>Batting Average z-Score</th>';
				echo '<th>ERA z-Score</th>';
				echo '</tr>';
			}
		}
		else if($sport == 'Basketball'){
			if($playertype == 'Coach')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Win Percent z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Player')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				
				echo '<th>Points Per Game z-Score</th>';
				
				echo '<th>Rebounds Per Game z-Score</th>';
				
				echo '<th>Assists Per Game z-Score</th>';
				
				echo '<th>Field Goal Percent z-Score</th>';
				
				echo '<th>Free Throw Percent z-Score</th>';
				
				echo '<th>Three Point Percent z-Score</th>';
				echo '</tr>';
			}
		}
		else if($sport == 'Hockey'){
			if($playertype == 'Goalie'){
					echo '<tr>';
					echo '<th>Year</th>';
				
					echo '<th>Win Percent z-Score</th>';
					
					echo '<th>Save Percent z-Score</th>';
					echo '</tr>';
			}
		}
		while ($row = oci_fetch_array($statementpostseasonstats2, OCI_ASSOC+OCI_RETURN_NULLS)) {
			echo "<tr>\n";
			foreach ($row as $item) {
				echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
			}
			echo "</tr>\n";
		}
		echo "</table><br>";
	}
	
	$statementbattingstats2 = oci_parse($connection, $querybattingstats2);
	if($sport == 'Baseball' && ($playertype == 'Pitcher' || $playertype == 'Position Player'))
	{
		echo '<font size = "4"><b>Regular Season Batting Stats</b></font><br>';
		oci_execute($statementbattingstats2);
		echo "<table border='1'>\n";
			    echo '<tr>';
				echo '<th>Year</th>';
				
				echo '<th>Batting Average z-Score</th>';
				
				echo '<th>Slugging z-Score</th>';
				
				echo '<th>OBP z-Score</th>';
				
				echo '</tr>';
		while ($row = oci_fetch_array($statementbattingstats2, OCI_ASSOC+OCI_RETURN_NULLS)) {
			echo "<tr>\n";
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	
	$statementpostseasonbattingstats2 = oci_parse($connection, $querypostseasonbattingstats2);
	if($sport == 'Baseball' && ($playertype == 'Pitcher' || $playertype == 'Position Player'))
	{
		echo '<font size = "4"><b>Postseason Batting Stats</b></font><br>';
		oci_execute($statementpostseasonbattingstats2);
		echo "<table border='1'>\n";
			    echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Round</th>';
				echo '<th>Batting Average z-Score</th>';
				
				echo '<th>Slugging z-Score</th>';
				
				echo '<th>OBP z-Score</th>';
				
				echo '</tr>';
		while ($row = oci_fetch_array($statementpostseasonbattingstats2, OCI_ASSOC+OCI_RETURN_NULLS)) {
			echo "<tr>\n";
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	
	$statementfieldingstats2 = oci_parse($connection, $queryfieldingstats2);
	if($sport == 'Baseball' && ($playertype == 'Pitcher' || $playertype == 'Position Player'))
	{
		echo '<font size = "4"><b>Regular Season Fielding Stats</b></font><br>';
		oci_execute($statementfieldingstats2);
		echo "<table border='1'>\n";
		echo "<tr>\n";
				echo '<th>Year</th>';
			
				echo '<th>Fielding Percent z-Score</th>';
				echo '</tr>';	   
		while ($row = oci_fetch_array($statementfieldingstats2, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	

	$statementpostseasonfieldingstats2 = oci_parse($connection, $querypostseasonfieldingstats2);
	if($sport == 'Baseball' && ($playertype == 'Pitcher' || $playertype == 'Position Player'))
	{
		echo '<font size = "4"><b>Postseason Fielding Stats</b></font><br>';
		oci_execute($statementpostseasonfieldingstats2);
		echo "<table border='1'>\n";
		echo "<tr>\n";
				echo '<th>Year</th>';
				echo '<th>Round</th>';
				echo '<th>Fielding Percent z-Score</th>';
				echo '</tr>';	   
		while ($row = oci_fetch_array($statementpostseasonfieldingstats2, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	
	
    $statementshootoutstats2 = oci_parse($connection, $queryshootoutstats2);
	if($sport == 'Hockey' && $playertype == 'Goalie')
	{
		oci_execute($statementshootoutstats2);
				echo '<font size = "4"><b>Shootout Goaltending Stats</b></font><br>';
				echo "<table border='1'>\n";
				echo '<tr>';
				echo '<th>Year</th>';
				
				echo '<th>Win Percent z-Score</th>';
				
				echo '<th>Save Percent z-Score</th>';
				echo '</tr>';
		while ($row = oci_fetch_array($statementshootoutstats2, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	
	
	$statementscoringstats2 = oci_parse($connection, $queryscoringstats2);
	if(($sport == 'Hockey' && $playertype == 'Goalie') || ($sport == 'Hockey' && $playertype == 'Position Player'))
	{
		oci_execute($statementscoringstats2);
		echo '<font size = "4"><b>Regular Season Scoring Stats</b></font><br>';
		echo "<table border='1'>\n";
		echo '<tr>';
		echo '<th>Year</th>';
		
		echo '<th>Points Per Game z-Score</th>';
	
		echo '<th>Shot Percent z-Score</th>';
		echo '</tr>';
		while ($row = oci_fetch_array($statementscoringstats2, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	
	echo "</td>";
	
	echo "</tr>";
	
	echo "</table>";

	
	//
	
	//
	// VERY important to close Oracle Database Connections and free statements!
	//
	oci_free_statement($statementbio);
	oci_free_statement($statementstats);
	oci_free_statement($statementcareerstats);
	oci_free_statement($statementpostseasonstats);
	oci_free_statement($statementcareerpostseasonstats);
	oci_free_statement($statementsplitstats);
	oci_free_statement($statementcareersplitstats);
	oci_free_statement($statementbattingstats);
	oci_free_statement($statementcareerbattingstats);
	oci_free_statement($statementpostseasonbattingstats);
	oci_free_statement($statementcareerpostseasonbattingstats);
	oci_free_statement($statementfieldingstats);
	oci_free_statement($statementcareerfieldingstats);
	oci_free_statement($statementpostseasonfieldingstats);
	oci_free_statement($statementcareerpostseasonfieldingstats);
	oci_free_statement($statementallstarstats);
	oci_free_statement($statementcareerallstarstats);
	oci_free_statement($statementcareerpostseasonstats1);
	oci_free_statement($statementshootoutstats);
	oci_free_statement($statementcareershootoutstats);
	oci_free_statement($statementscoringstats);
	oci_free_statement($statementcareerscoringstats);
	oci_free_statement($statementpostseasonscoringstats);
	oci_free_statement($statementcareerpostseasonscoringstats);
	oci_free_statement($statementshootoutstats1);
	oci_free_statement($statementcareershootoutstats1);
	
	oci_free_statement($statementbio2);
	oci_free_statement($statementstats2);
	oci_free_statement($statementcareerstats2);
	oci_free_statement($statementpostseasonstats2);
	oci_free_statement($statementcareerpostseasonstats2);
	oci_free_statement($statementsplitstats2);
	oci_free_statement($statementcareersplitstats2);
	oci_free_statement($statementbattingstats2);
	oci_free_statement($statementcareerbattingstats2);
	oci_free_statement($statementpostseasonbattingstats2);
	oci_free_statement($statementcareerpostseasonbattingstats2);
	oci_free_statement($statementfieldingstats2);
	oci_free_statement($statementcareerfieldingstats2);
	oci_free_statement($statementpostseasonfieldingstats2);
	oci_free_statement($statementcareerpostseasonfieldingstats2);
	oci_free_statement($statementallstarstats2);
	oci_free_statement($statementcareerallstarstats2);
	oci_free_statement($statementcareerpostseasonstats21);
	oci_free_statement($statementshootoutstats2);
	oci_free_statement($statementcareershootoutstats2);
	oci_free_statement($statementscoringstats2);
	oci_free_statement($statementcareerscoringstats2);
	oci_free_statement($statementpostseasonscoringstats2);
	oci_free_statement($statementcareerpostseasonscoringstats2);
	oci_free_statement($statementshootoutstats21);
	oci_free_statement($statementcareershootoutstats21);
	oci_close($connection);
?>

