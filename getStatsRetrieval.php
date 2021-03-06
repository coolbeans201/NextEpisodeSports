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
		    $querycareerstats = "SELECT SUM(BaseballManagers.WINS) , SUM(BaseballManagers.LOSS), ROUND((SUM(BaseballManagers.WINS) / (SUM(BaseballManagers.WINS) + SUM(BaseballManagers.LOSS))),3)
						FROM BaseballManagers
						WHERE BaseballManagers.MANAGERID = '" . $playerid . "'";
		}
		if ($playertype == 'Pitcher'){
			$querybio = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
			FROM Baseballmaster
			WHERE playerid = '" . $playerid . "'";
			$querystats = "SELECT distinct year, team, league, wins, losses, ROUND(wins/(wins + losses),3) winpercent, 
			games, starts, completegames, shutouts, saves, outs, hits, earnedruns, homeruns,
			walks, strikeouts, bavg, 
			ROUND(((bavg - (select avg(bavg) from baseballpitching))/(select stddev(bavg) from baseballpitching)),3) bavgZSCORE,
			era, ROUND(((era - (select avg(era) from baseballpitching))/(select stddev(era) from baseballpitching)),3) eraZSCORE,
			intentionalwalks, wildpitches, hitbypitches, balks, battersfaced, finishes, pitcherruns, whip, h9, hr9, bb9, so9
			FROM BaseballPitching
			WHERE pitcherid = '" . $playerid . "'
			ORDER BY year";
			$querycareerstats = "SELECT SUM(BaseballPitching.WINS) , SUM(BaseballPitching.LOSSES), ROUND((SUM(BaseballPitching.WINS) / (SUM(BaseballPitching.WINS) + SUM(BaseballPitching.LOSSES))),3)
			FROM BaseballPitching
			WHERE BaseballPitching.pitcherid = '" . $playerid . "'";
			$querypostseasonstats = "SELECT distinct year, round, team, league, wins, losses, ROUND(wins/(wins + losses+0.000000000000000000000000000000000000001),3) winpercent,
			games, starts, completegames, shutouts, saves, outs, hits, earnedruns, homeruns, walks, strikeouts,
			battingaverage, 
			ROUND(((battingaverage - (select avg(battingaverage) from baseballpitchingpostseason))/(select stddev(battingaverage) from baseballpitchingpostseason)),3) bavgZSCORE,
			era, ROUND(((era - (select avg(era) from baseballpitchingpostseason))/(select stddev(era) from baseballpitchingpostseason)),3) eraZSCORE,
			intentionalwalks, wildpitches, hitbypitches, balks, battersfaced, finishes, runs, whip, h9, hr9, bb9, so9
			FROM BaseballPitchingPostSeason
			WHERE playerid = '" . $playerid . "'
			ORDER BY year";
			$querycareerpostseasonstats = "SELECT SUM(Wins), SUM(losses), ROUND((SUM(wins) / (SUM(losses) + SUM(wins))), 3)
			FROM baseballpitchingpostseason
			WHERE playerid = '" . $playerid . "'";
			$querybattingstats = "select distinct year, team, league, games, starts, atbats, runs, hits, battingaverage, ROUND(((battingaverage - (select avg(battingaverage) from baseballbatting))/(select stddev(battingaverage) from baseballbatting)),3) zScore,
								  doubles, triples, homeruns, slugging, ROUND(((slugging - (select avg(slugging) from baseballbatting))/(select stddev(slugging) from baseballbatting)),3) zScore2,
								  rbi, stolenbases, caughtstealing, walks, strikeouts, intentionalwalks, hitbypitch, onbasepercent,
								  ROUND(((onbasepercent - (select avg(onbasepercent) from baseballbatting))/(select stddev(onbasepercent) from baseballbatting)),3) zScore3,
								  sachits, sacflies, gidp
								  from baseballbatting
								  where baseballbatting.playerid = '" . $playerid . "' AND slugging != -1
								  order by year";
			$querycareerbattingstats = "select sum(games), sum(starts), sum(atbats), sum(runs), sum(hits), ROUND((sum(hits)/sum(atbats)),3)bAvg, 
								  sum(doubles), sum(triples), sum(homeruns), ROUND(((sum(triples) * 3 + sum(homeruns) * 4 + sum(doubles) * 2 + (sum(hits)-sum(homeruns)-sum(triples)-sum(doubles)))/sum(atbats)),3) slugging,
								  sum(rbi), sum(stolenbases), sum(caughtstealing), sum(walks), sum(strikeouts), sum(intentionalwalks), sum(hitbypitch),
								  sum(sachits), sum(sacflies), sum(gidp)
								  from baseballbatting
								  where baseballbatting.playerid = '" . $playerid . "' AND slugging != -1";
			$querypostseasonbattingstats = "select distinct year, round, team, league, games, atbats, runs, hits, battingaverage, ROUND(((battingaverage - (select avg(battingaverage) from baseballbattingpostseason))/(select stddev(battingaverage) from baseballbattingpostseason)),3) zScore,
								  doubles, triples, homeruns, slugging, ROUND(((slugging - (select avg(slugging) from baseballbattingpostseason))/(select stddev(slugging) from baseballbattingpostseason)),3) zScore2,
								  rbi, stolenbases, caughtstealing, walks, strikeout, intentionalwalk, hitbypitch, onbasepercent,
								  ROUND(((onbasepercent - (select avg(onbasepercent) from baseballbattingpostseason))/(select stddev(onbasepercent) from baseballbattingpostseason)),3) zScore3,
								  sachits, sacflies, gidp
								  from baseballbattingpostseason
								  where baseballbattingpostseason.playerid = '" . $playerid . "'  AND slugging != -1
								  order by year";
			$querycareerpostseasonbattingstats = "select sum(games), sum(atbats), sum(runs), sum(hits), ROUND((sum(hits)/sum(atbats)),3)bAvg, 
								  sum(doubles), sum(triples), sum(homeruns), ROUND(((sum(triples) * 3 + sum(homeruns) * 4 + sum(doubles) * 2 + (sum(hits)-sum(homeruns)-sum(triples)-sum(doubles)))/sum(atbats)),3) slugging,
								  sum(rbi), sum(stolenbases), sum(caughtstealing), sum(walks), sum(strikeout), sum(intentionalwalk), sum(hitbypitch),
								  sum(sachits), sum(sacflies), sum(gidp)
								  from baseballbattingpostseason
								  where baseballbattingpostseason.playerid = '" . $playerid . "' AND slugging != -1";
			$queryfieldingstats = "select distinct year, team, league, position, games, starts, outs, putouts, errors, doubleplays, passedballs, stolenbasesallowed,
									caughtstealingallowed, fieldingpercent, 
									ROUND(((fieldingpercent - (select avg(fieldingpercent) from baseballfielding))/(select stddev(fieldingpercent) from baseballfielding)),3) zScore
									from baseballfielding
									where baseballfielding.playerid = '" . $playerid . "'
									order by year";
			$querycareerfieldingstats = "select  sum(games), sum(starts), sum(outs), sum(putouts), sum(errors), sum(doubleplays), sum(passedballs), sum(stolenbasesallowed),
										sum(caughtstealingallowed), ROUND(((sum(assists) + sum(putouts))/(sum(putouts) + sum(assists) + sum(errors))),3) fieldingPercent 
										from baseballfielding
										where baseballfielding.playerid = '" . $playerid . "'";
			$querypostseasonfieldingstats = "select distinct year, round, team, league, position, games, starts, outs, putouts, errors, doubleplays, passedballs, stolenbasesallowed,
											caughtstealingallowed, fieldingpercent, 
											ROUND(((fieldingpercent - (select avg(fieldingpercent) from baseballfieldingpostseason))/(select stddev(fieldingpercent) from baseballfieldingpostseason)),3) zScore
											from baseballfieldingpostseason
											where baseballfieldingpostseason.playerid = '" . $playerid . "' and baseballfieldingpostseason.fieldingpercent != -1
											order by year";
			$querycareerpostseasonfieldingstats = "select  sum(games), sum(starts), sum(outs), sum(putouts), sum(errors), sum(doubleplays), sum(passedballs), sum(stolenbasesallowed),
													sum(caughtstealingallowed), ROUND(((sum(assists) + sum(putouts))/(sum(putouts) + sum(assists) + sum(errors))),3) fieldingPercent 
													from baseballfieldingpostseason
													where baseballfieldingpostseason.playerid = '" . $playerid . "'";
		}
		if ($playertype == 'Position Player'){
			$querybio = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
			FROM Baseballmaster
			WHERE playerid = '" . $playerid . "'";
			$querybattingstats = "select distinct year, team, league, games, starts, atbats, runs, hits, battingaverage, ROUND(((battingaverage - (select avg(battingaverage) from baseballbatting))/(select stddev(battingaverage) from baseballbatting)),3) zScore,
								  doubles, triples, homeruns, slugging, ROUND(((slugging - (select avg(slugging) from baseballbatting))/(select stddev(slugging) from baseballbatting)),3) zScore2,
								  rbi, stolenbases, caughtstealing, walks, strikeouts, intentionalwalks, hitbypitch, onbasepercent,
								  ROUND(((onbasepercent - (select avg(onbasepercent) from baseballbatting))/(select stddev(onbasepercent) from baseballbatting)),3) zScore3,
								  sachits, sacflies, gidp
								  from baseballbatting
								  where baseballbatting.playerid = '" . $playerid . "' AND slugging != -1
								  order by year";
			$querycareerbattingstats = "select sum(games), sum(starts), sum(atbats), sum(runs), sum(hits), ROUND((sum(hits)/sum(atbats)),3)bAvg, 
								  sum(doubles), sum(triples), sum(homeruns), ROUND(((sum(triples) * 3 + sum(homeruns) * 4 + sum(doubles) * 2 + (sum(hits)-sum(homeruns)-sum(triples)-sum(doubles)))/sum(atbats)),3) slugging,
								  sum(rbi), sum(stolenbases), sum(caughtstealing), sum(walks), sum(strikeouts), sum(intentionalwalks), sum(hitbypitch),
								  sum(sachits), sum(sacflies), sum(gidp)
								  from baseballbatting 
								  where baseballbatting.playerid = '" . $playerid . "' AND slugging != -1";
			$querypostseasonbattingstats = "select distinct year, round, team, league, games, atbats, runs, hits, battingaverage, ROUND(((battingaverage - (select avg(battingaverage) from baseballbattingpostseason))/(select stddev(battingaverage) from baseballbattingpostseason)),3) zScore,
								  doubles, triples, homeruns, slugging, ROUND(((slugging - (select avg(slugging) from baseballbattingpostseason))/(select stddev(slugging) from baseballbattingpostseason)),3) zScore2,
								  rbi, stolenbases, caughtstealing, walks, strikeout, intentionalwalk, hitbypitch, onbasepercent,
								  ROUND(((onbasepercent - (select avg(onbasepercent) from baseballbattingpostseason))/(select stddev(onbasepercent) from baseballbattingpostseason)),3) zScore3,
								  sachits, sacflies, gidp
								  from baseballbattingpostseason
								  where baseballbattingpostseason.playerid = '" . $playerid . "'  AND slugging != -1
								  order by year";
			$querycareerpostseasonbattingstats = "select sum(games), sum(atbats), sum(runs), sum(hits), ROUND((sum(hits)/sum(atbats)),3)bAvg, 
								  sum(doubles), sum(triples), sum(homeruns), ROUND(((sum(triples) * 3 + sum(homeruns) * 4 + sum(doubles) * 2 + (sum(hits)-sum(homeruns)-sum(triples)-sum(doubles)))/sum(atbats)),3) slugging,
								  sum(rbi), sum(stolenbases), sum(caughtstealing), sum(walks), sum(strikeout), sum(intentionalwalk), sum(hitbypitch),
								  sum(sachits), sum(sacflies), sum(gidp)
								  from baseballbattingpostseason
								  where baseballbattingpostseason.playerid = '" . $playerid . "' AND slugging != -1";
			$queryfieldingstats = "select distinct year, team, league, position, games, starts, outs, putouts, errors, doubleplays, passedballs, stolenbasesallowed,
									caughtstealingallowed, fieldingpercent, 
									ROUND(((fieldingpercent - (select avg(fieldingpercent) from baseballfielding))/(select stddev(fieldingpercent) from baseballfielding)),3) zScore
									from baseballfielding
									where baseballfielding.playerid = '" . $playerid . "'
									order by year";
			$querycareerfieldingstats = "select  sum(games), sum(starts), sum(outs), sum(putouts), sum(errors), sum(doubleplays), sum(passedballs), sum(stolenbasesallowed),
										sum(caughtstealingallowed), ROUND(((sum(assists) + sum(putouts))/(sum(putouts) + sum(assists) + sum(errors))),3) fieldingPercent 
										from baseballfielding
										where baseballfielding.playerid = '" . $playerid . "'";
			$querypostseasonfieldingstats = "select distinct year, round, team, league, position, games, starts, outs, putouts, errors, doubleplays, passedballs, stolenbasesallowed,
											caughtstealingallowed, fieldingpercent, 
											ROUND(((fieldingpercent - (select avg(fieldingpercent) from baseballfieldingpostseason))/(select stddev(fieldingpercent) from baseballfieldingpostseason)),3) zScore
											from baseballfieldingpostseason
											where baseballfieldingpostseason.playerid = '" . $playerid . "' and baseballfieldingpostseason.fieldingpercent != -1
											order by year";
			$querycareerpostseasonfieldingstats = "select  sum(games), sum(starts), sum(outs), sum(putouts), sum(errors), sum(doubleplays), sum(passedballs), sum(stolenbasesallowed),
													sum(caughtstealingallowed), ROUND(((sum(assists) + sum(putouts))/(sum(putouts) + sum(assists) + sum(errors))),3) fieldingPercent 
													from baseballfieldingpostseason
													where baseballfieldingpostseason.playerid = '" . $playerid . "'";
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
			$querycareerstats = "SELECT SUM(WINS), (SUM(LOSSES)), ROUND((SUM(WINS) / (SUM(LOSSES) + SUM(WINS))), 3)
						from BasketballCoaches
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
			$querybio = "SELECT firstName, lastName, height, weight
				      FROM BASKETBALLMASTER
				      WHERE id = '" . $playerid . "'";
			$querystats = "SELECT distinct year, team, league, games, minutes, points, pointspergame, 
							ROUND(((pointspergame - (select avg(pointspergame) from basketballplayers))/(select stddev(pointspergame) from basketballplayers)),3) bavgZSCORE,
							offensiverebounds, defensiverebounds, rebounds, reboundspergame,
							ROUND(((reboundspergame - (select avg(reboundspergame) from basketballplayers))/(select stddev(reboundspergame) from basketballplayers)),3),
							assists, assistspergame, 
							ROUND(((assistspergame - (select avg(assistspergame) from basketballplayers))/(select stddev(assistspergame) from basketballplayers)),3),
							steals, blocks, turnovers, fouls, fieldgoalattempts, fieldgoalmade, fieldgoalpercent,
							ROUND(((fieldgoalpercent - (select avg(fieldgoalpercent) from basketballplayers))/(select stddev(fieldgoalpercent) from basketballplayers)),3),
							freethrowattempts, freethrowmade, freethrowpercent, 
							ROUND(((freethrowpercent - (select avg(freethrowpercent) from basketballplayers))/(select stddev(freethrowpercent) from basketballplayers)),3),
							threeattempts, threemade, threepercent,
							ROUND(((threepercent - (select avg(threepercent) from basketballplayers))/(select stddev(threepercent) from basketballplayers)),3)
							FROM BASKETBALLplayers
							WHERE playerid = '" . $playerid . "'
							order by year";
			$querycareerstats = "SELECT sum(games), sum(minutes), sum(points), ROUND((sum(points)/sum(games)),3), 
							sum(offensiverebounds), sum(defensiverebounds), sum(rebounds), ROUND((sum(rebounds)/sum(games)),3), 
							sum(assists), ROUND((sum(assists)/sum(games)),3), 
							sum(steals), sum(blocks), sum(turnovers), sum(fouls), sum(fieldgoalattempts), sum(fieldgoalmade), ROUND((sum(fieldgoalmade)/sum(fieldgoalattempts)),3), 	
							sum(freethrowattempts), sum(freethrowmade), ROUND((sum(freethrowmade)/sum(freethrowattempts)),3),
							sum(threeattempts), sum(threemade), ROUND((sum(threemade)/sum(threeattempts)),3)
							FROM BASKETBALLplayers
							WHERE playerid = '" . $playerid . "'";
			$querypostseasonstats = "SELECT distinct year, team, league, postseasongames, postseasonminutes, postseasonpoints, postseasonpointspergame, 
							ROUND(((postseasonpointspergame - (select avg(postseasonpointspergame) from basketballplayers))/(select stddev(postseasonpointspergame) from basketballplayers)),3) bavgZSCORE,
							postseasonoffensiverebounds, postseasondefensiverebounds, postseasonrebounds, postseasonreboundspergame,
							ROUND(((postseasonreboundspergame - (select avg(postseasonreboundspergame) from basketballplayers))/(select stddev(postseasonreboundspergame) from basketballplayers)),3),
							postseasonassists, postseasonassistspergame, 
							ROUND(((postseasonassistspergame - (select avg(postseasonassistspergame) from basketballplayers))/(select stddev(postseasonassistspergame) from basketballplayers)),3),
							postseasonsteals, postseasonblocks, postseasonturnovers, postseasonfouls, postfieldgoalattempts, postseasonfieldgoalmade, postseasonfieldgoalpercent,
							ROUND(((postseasonfieldgoalpercent - (select avg(postseasonfieldgoalpercent) from basketballplayers))/(select stddev(postseasonfieldgoalpercent) from basketballplayers)),3),
							postseasonfreethrowattempts, postseasonfreethrowmade, postseasonfreethrowpercent, 
							ROUND(((postseasonfreethrowpercent - (select avg(postseasonfreethrowpercent) from basketballplayers))/(select stddev(postseasonfreethrowpercent) from basketballplayers)),3),
							postseasonthreeattempts, postseasonthreemade, postseasonthreepercent,
							ROUND(((postseasonthreepercent - (select avg(postseasonthreepercent) from basketballplayers))/(select stddev(postseasonthreepercent) from basketballplayers)),3)
							FROM basketballplayers
							WHERE basketballplayers.playerid = '" . $playerid . "' and postseasonpointspergame != -1
							order by year";
			$querycareerpostseasonstats = "SELECT sum(postseasongames), sum(postseasonminutes), sum(postseasonpoints), ROUND((sum(postseasonpoints)/sum(postseasongames)),3), 
							sum(postseasonoffensiverebounds), sum(postseasondefensiverebounds), sum(postseasonrebounds), ROUND((sum(postseasonrebounds)/sum(postseasongames)),3), 
							sum(postseasonassists), ROUND((sum(postseasonassists)/sum(postseasongames)),3), 
							sum(postseasonsteals), sum(postseasonblocks), sum(postseasonturnovers), sum(postseasonfouls), sum(postfieldgoalattempts), sum(postseasonfieldgoalmade),
							ROUND((sum(postseasonfieldgoalmade)/sum(postfieldgoalattempts)),3), 
							sum(postseasonfreethrowattempts), sum(postseasonfreethrowmade), ROUND((sum(postseasonfreethrowmade)/sum(postseasonfreethrowattempts)),3), 	
							sum(postseasonthreeattempts), sum(postseasonthreemade), ROUND((sum(postseasonthreemade)/sum(postseasonthreeattempts)),3)
							FROM basketballplayers
							WHERE playerid = '" . $playerid . "'";
			$queryallstarstats = "select distinct year, conference, league, minutes, points, offensiverebounds, defensiverebounds, rebounds, assists, steals,
									blocks, turnovers, fouls, fieldgoalattempts, fieldgoalmade,
									freethrowattempts, freethrowmade, 
									threeattempts, threemade
									from basketballplayerallstar
									where basketballplayerallstar.player_id = '" . $playerid . "'
									order by year";
			$querycareerallstarstats = "select sum(minutes), sum(points), sum(offensiverebounds), sum(defensiverebounds), sum(rebounds), sum(assists), sum(steals),
										sum(blocks), sum(turnovers), sum(fouls), sum(fieldgoalattempts), sum(fieldgoalmade),
										sum(freethrowattempts), sum(freethrowmade), 
										sum(threeattempts), sum(threemade)
										from basketballplayerallstar
										where basketballplayerallstar.player_id = '" . $playerid . "'";
			
		}
		if ($playertype == 'Team'){
			$querystats = "select distinct year, team, league, conference, division, rank, conferencerank, fieldgoalmade, fieldgoalattempts, fieldgoalpercent,
							ROUND(((fieldgoalpercent - (SELECT AVG(fieldgoalpercent) FROM BasketballTeams))/(SELECT STDDEV(fieldgoalpercent) FROM BasketballTeams)), 3) zScore,
							freethrowmade, freethrowattempt, freethrowpercent, 
							ROUND(((freethrowpercent - (SELECT AVG(freethrowpercent) FROM BasketballTeams))/(SELECT STDDEV(freethrowpercent) FROM BasketballTeams)), 3) zScore2,
							threemade, threeattempts, threepercent,
							ROUND(((threepercent - (SELECT AVG(threepercent) FROM BasketballTeams))/(SELECT STDDEV(threepercent) FROM BasketballTeams)), 3) zScore3,
							offensiverebounds, defensiverebounds, rebounds, reboundspergame,
							ROUND(((reboundspergame - (SELECT AVG(reboundspergame) FROM BasketballTeams))/(SELECT STDDEV(reboundspergame) FROM BasketballTeams)), 3) zScore4,
							assists, assistspergame,
							ROUND(((assistspergame - (SELECT AVG(assistspergame) FROM BasketballTeams))/(SELECT STDDEV(assistspergame) FROM BasketballTeams)), 3) zScore5,
							fouls, steals,turnovers, blocks, points, pointspergame,
							ROUND(((pointspergame - (SELECT AVG(pointspergame) FROM BasketballTeams))/(SELECT STDDEV(pointspergame) FROM BasketballTeams)), 3) zScore6,
							fieldgoalallowedmade, fieldgoalallowedattempts, fieldgoalallowedpercent, freethrowallowedmade, freethrowallowedattempts, threeallowedmade, threeallowedattempts, threeallowedpercent,
							offensiveallowedrebounds, defensiveallowedrebounds, reboundsallowed, reboundsallowedpergame,
							ROUND(((reboundsallowedpergame - (SELECT AVG(reboundsallowedpergame) FROM BasketballTeams))/(SELECT STDDEV(reboundsallowedpergame) FROM BasketballTeams)), 3) zScore7,
							assistsallowed, assistsallowedpergame,
							ROUND(((assistsallowedpergame - (SELECT AVG(assistsallowedpergame) FROM BasketballTeams))/(SELECT STDDEV(assistsallowedpergame) FROM BasketballTeams)), 3) zScore8,
							foulsallowed, stealsallowed, turnoversallowed, blocksallowed, pointsallowed, pointsallowedpergame,
							ROUND(((pointsallowedpergame - (SELECT AVG(pointsallowedpergame) FROM BasketballTeams))/(SELECT STDDEV(pointsallowedpergame) FROM BasketballTeams)), 3) zScore9,
							homewon, homelost, homewinpercent, awaywon, awaylost, awaywonpercent, conferencewon, conferenceloss, confwinpercent, divisionwon, divisionloss, divisionwinpercent,
							win, losses, winpercent,
							ROUND(((winpercent- (SELECT AVG(winpercent) FROM BasketballTeams))/(SELECT STDDEV(winpercent) FROM BasketballTeams)), 3) zScore10,games, minutes
							from basketballteams
							where name = '" . $playerid . "'
							order by year";
			$querycareerstats = "select sum(games), sum(fieldgoalmade), sum(fieldgoalattempts), (ROUND(sum(fieldgoalmade) / sum(fieldgoalattempts), 3)) fieldGoalPercent,
								sum(freethrowmade), sum(freethrowattempt), (ROUND(sum(freethrowmade) / sum(freethrowattempt), 3)) freethrowPercent,
								sum(threemade), sum(threeattempts), (ROUND(sum(threemade) / sum(threeattempts), 3)) threePercent,
								sum(offensiverebounds), sum(defensiverebounds), sum(rebounds), (ROUND(sum(rebounds) / sum(games), 3)) reboundspergame,
								sum(assists), (ROUND(sum(assists) / sum(games), 3)) assistspergame, sum(fouls), sum(steals), sum(turnovers), sum(blocks), sum(points), (ROUND(sum(points) / sum(games), 3)) pointspergame,
								sum(fieldgoalallowedmade), sum(fieldgoalallowedattempts), (ROUND(sum(fieldgoalallowedmade) / sum(fieldgoalallowedattempts), 3)) fieldgoalallowedpercent,
								sum(freethrowallowedmade), sum(freethrowallowedattempts),sum(threeallowedmade), sum(threeallowedattempts), (ROUND(sum(threeallowedmade) / sum(threeallowedattempts), 3)) threeallowedPercent,
								sum(offensiveallowedrebounds), sum(defensiveallowedrebounds), sum(reboundsallowed), (ROUND(sum(reboundsallowed) / sum(games), 3)) reboundsallowedpergame,
								sum(assistsallowed), (ROUND(sum(assistsallowed) / sum(games), 3)) assistsallowedpergame, sum(foulsallowed), sum(stealsallowed), sum(turnoversallowed), sum(blocksallowed), sum(pointsallowed), (ROUND(sum(pointsallowed) / sum(games), 3)) pointsallowedpergame,
								sum(homewon),sum(homelost),(ROUND(SUM(homewon)/(sum(homelost) + sum(homewon)),3)) homewinpercent, sum(awaywon),sum(awaylost),(ROUND(SUM(awaywon)/(sum(awaylost) + sum(awaywon)),3)) awaywinpercent,
								sum(conferencewon),sum(conferenceloss),(ROUND(SUM(conferencewon)/(sum(conferenceloss) + sum(conferencewon)),3)) conferencewinpercent,
								sum(divisionwon),sum(divisionloss),(ROUND(SUM(divisionwon)/(sum(divisionloss) + sum(divisionwon)),3)) divisionwinpercent, sum(win),sum(losses),(ROUND(SUM(win)/(sum(win) + sum(losses)),3)) winpercent,sum(minutes)
								from basketballteams
								where name = '" . $playerid . "'";
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
						 WHERE COACHID = '" . $playerid . "' AND postseasonwinpercent != -1
						 order by year";
			$querycareerpostseasonstats = "SELECT SUM(POSTSEASONWIN), SUM(POSTSEASONLOSS), SUM(POSTSEASONTIE), ROUND((SUM(POSTSEASONWIN) / (SUM(POSTSEASONLOSS) + SUM(POSTSEASONWIN))), 3)
							   FROM HockeyCoaches
							   WHERE COACHID = '" . $playerid . "'";
		}
		if ($playertype == 'Goalie'){
			$querybio = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
					FROM Hockeymaster
					WHERE playerid IS NOT NULL AND playerid = '" . $playerid . "'";
			$querystats = "select distinct year, team, league, games, minutes, wins, loss, ties, pointspergame, ROUND(((pointspergame - (select avg(pointspergame) from hockeygoalies))/(select stddev(pointspergame) from hockeygoalies)),3) bavgZSCORE,
							emptynetgoals, shutouts, goalsallowed, shotsallowed, savepercent, ROUND(((savepercent - (select avg(savepercent) from hockeygoalies))/(select stddev(savepercent) from hockeygoalies)),3) bavgZSCORE2
							from hockeygoalies
							where hockeygoalies.goalieid = '" . $playerid . "'
							order by year";
			$querycareerstats = "select sum(games), sum(minutes), sum(wins), sum(loss), sum(ties), 
								sum(emptynetgoals), sum(shutouts), sum(goalsallowed), sum(shotsallowed),ROUND(((1 - (SUM(GOALSALLOWED)/SUM(SHOTSALLOWED)))),3)
								from hockeygoalies
								where hockeygoalies.goalieid = '" . $playerid . "'";
			$querypostseasonstats = "select distinct year, team, league, postseasongames, postseasonminutes, postseasonwins, postseasonloss, postseasonwinpercent,
									ROUND(((postseasonwinpercent - (select avg(postseasonwinpercent) from hockeygoalies))/(select stddev(postseasonwinpercent) from hockeygoalies)),3),
									postseasonemptynetgoals, postseasonshutouts, postseasongoalsallowed, postseasonshotsallowed, postseasonsavepercent,
									ROUND(((postseasonsavepercent - (select avg(postseasonsavepercent) from hockeygoalies))/(select stddev(postseasonsavepercent) from hockeygoalies)),3)
									from hockeygoalies
									where hockeygoalies.goalieid = '" . $playerid . "' and postseasongames != 0
									order by year";
			$querycareerpostseasonstats1 = "select sum(postseasongames), sum(postseasonminutes), sum(postseasonwins), sum(postseasonloss),
											ROUND((sum(postseasonwins)/(sum(postseasonwins) + sum(postseasonloss))),3),
											sum(postseasonemptynetgoals), sum(postseasonshutouts), sum(postseasongoalsallowed), sum(postseasonshotsallowed), 
											ROUND((1 - (sum(postseasongoalsallowed)/(sum(postseasonshotsallowed)))),3)
											from hockeygoalies
											where hockeygoalies.goalieid = '" . $playerid . "'";
			$queryshootoutstats = "select distinct year, team, wins, loss, winpercent, 
									ROUND(((winpercent - (select avg(winpercent) from hockeygoaliesshootout))/(select stddev(winpercent) from hockeygoaliesshootout)),3),
									goalsallowed, shotsallowed, savepercent,
									ROUND(((savepercent - (select avg(savepercent) from hockeygoaliesshootout))/(select stddev(savepercent) from hockeygoaliesshootout)),3)
									from hockeygoaliesshootout
									where hockeygoaliesshootout.goalieid = '" . $playerid . "'
									order by year";
			$querycareershootoutstats = "select sum(wins), sum(loss), ROUND((sum(wins)/(sum(wins) + sum(loss))),3),
										sum(goalsallowed), sum(shotsallowed), ROUND((1 - (sum(goalsallowed)/(sum(shotsallowed)))),3)
										from hockeygoaliesshootout
										where hockeygoaliesshootout.goalieid = '" . $playerid . "'";
			$queryscoringstats = "select distinct year, team, league, games, goals, goalspergame, assists, assistspergame,
								  points, pointspergame, 
									ROUND(((pointspergame - (SELECT AVG(pointspergame) FROM hockeyscoring))/(SELECT STDDEV(pointspergame) + 0.0000001 FROM hockeyscoring)), 3), 
									penaltyminutes, plusminus, powerplaygoals, powerplayassists, shorthandedgoals, shorthandedassists,
									gamewinninggoals, gametyinggoals, shots, shotpercent,
									ROUND(((shotpercent - (SELECT AVG(shotpercent) FROM hockeyscoring))/(SELECT STDDEV(shotpercent) + 0.000001 FROM hockeyscoring)), 3)
									from hockeyscoring
									where hockeyscoring.playerid = '" . $playerid . "' and shotpercent != -1
									order by year";
			$querycareerscoringstats = "select sum(games), sum(goals), ROUND((sum(goals)/(sum(games))),3), sum(assists), ROUND((sum(assists)/(sum(games))),3),
									sum(points), ROUND((sum(points)/(sum(games))),3), 
									sum(penaltyminutes), sum(plusminus), sum(powerplaygoals), sum(powerplayassists), sum(shorthandedgoals), sum(shorthandedassists),
									sum(gamewinninggoals), sum(gametyinggoals), sum(shots), ROUND((sum(goals)/(sum(shots))),3)
									from hockeyscoring
									where hockeyscoring.playerid = '" . $playerid . "'";
			$querypostseasonscoringstats = "select distinct year, team, league, postseasongames, postseasongoals, postseasongoalspergame, postseasonassists, postseasonassistspergame,
											postseasonpoints, postseasonpointspergame, 
											postseasonpenaltyminutes, postseasonplusminus, postseasonpowerplaygoals, postseasonpowerplayassists, postseasonshorthandedgoals, postseasonshorthandedassists,
											postseasongamewinninggoals, postseasonshots, postseasonshotpercent
											from hockeyscoring
											where hockeyscoring.playerid = '" . $playerid . "' and postseasonshotpercent != -1
											order by year";
			$querycareerpostseasonscoringstats = "select sum(postseasongames), sum(postseasongoals), ROUND((sum(postseasongoals)/(sum(postseasongames))),3), sum(postseasonassists), ROUND((sum(postseasonassists)/(sum(postseasongames))),3),
													sum(postseasonpoints), ROUND((sum(postseasonpoints)/(sum(postseasongames))),3), 
													sum(postseasonpenaltyminutes), sum(postseasonplusminus), sum(postseasonpowerplaygoals), sum(postseasonpowerplayassists), sum(postseasonshorthandedgoals), sum(postseasonshorthandedassists),
													sum(postseasongamewinninggoals), sum(postseasonshots), ROUND((sum(postseasongoals)/(sum(postseasonshots))),3)
													from hockeyscoring
													where hockeyscoring.playerid = '" . $playerid . "'";
		}
		if ($playertype == 'Position Player'){
			$querybio = "SELECT firstname, lastname, birthmonth, birthday, birthyear, weight, height
					FROM Hockeymaster
					WHERE playerid IS NOT NULL AND playerid = '" . $playerid . "'";
		    $queryscoringstats = "select distinct year, team, league, games, goals, goalspergame, assists, assistspergame,
								  points, pointspergame, 
									ROUND(((pointspergame - (SELECT AVG(pointspergame) FROM hockeyscoring))/(SELECT STDDEV(pointspergame) + 0.0000001 FROM hockeyscoring)), 3), 
									penaltyminutes, plusminus, powerplaygoals, powerplayassists, shorthandedgoals, shorthandedassists,
									gamewinninggoals, gametyinggoals, shots, shotpercent,
									ROUND(((shotpercent - (SELECT AVG(shotpercent) FROM hockeyscoring))/(SELECT STDDEV(shotpercent) + 0.000001 FROM hockeyscoring)), 3)
									from hockeyscoring
									where hockeyscoring.playerid = '" . $playerid . "' and shotpercent != -1
									order by year";
			$querycareerscoringstats = "select sum(games), sum(goals), ROUND((sum(goals)/(sum(games))),3), sum(assists), ROUND((sum(assists)/(sum(games))),3),
									sum(points), ROUND((sum(points)/(sum(games))),3), 
									sum(penaltyminutes), sum(plusminus), sum(powerplaygoals), sum(powerplayassists), sum(shorthandedgoals), sum(shorthandedassists),
									sum(gamewinninggoals), sum(gametyinggoals), sum(shots), ROUND((sum(goals)/(sum(shots))),3)
									from hockeyscoring
									where hockeyscoring.playerid = '" . $playerid . "'";
			$querypostseasonscoringstats = "select distinct year, team, league, postseasongames, postseasongoals, postseasongoalspergame, postseasonassists, postseasonassistspergame,
											postseasonpoints, postseasonpointspergame, 
											postseasonpenaltyminutes, postseasonplusminus, postseasonpowerplaygoals, postseasonpowerplayassists, postseasonshorthandedgoals, postseasonshorthandedassists,
											postseasongamewinninggoals, postseasonshots, postseasonshotpercent
											from hockeyscoring
											where hockeyscoring.playerid = '" . $playerid . "' and postseasonshotpercent != -1
											order by year";
			$querycareerpostseasonscoringstats = "select sum(postseasongames), sum(postseasongoals), ROUND((sum(postseasongoals)/(sum(postseasongames))),3), sum(postseasonassists), ROUND((sum(postseasonassists)/(sum(postseasongames))),3),
													sum(postseasonpoints), ROUND((sum(postseasonpoints)/(sum(postseasongames))),3), 
													sum(postseasonpenaltyminutes), sum(postseasonplusminus), sum(postseasonpowerplaygoals), sum(postseasonpowerplayassists), sum(postseasonshorthandedgoals), sum(postseasonshorthandedassists),
													sum(postseasongamewinninggoals), sum(postseasonshots), ROUND((sum(postseasongoals)/(sum(postseasonshots))),3)
													from hockeyscoring
													where hockeyscoring.playerid = '" . $playerid . "'";
			$queryshootoutstats1 = "select distinct year, team, shots, goals, gamedecidinggoals, shotpercent,
									ROUND(((shotpercent - (SELECT AVG(shotpercent) FROM hockeyscoringshootout))/(SELECT STDDEV(shotpercent) + 0.000001 FROM hockeyscoringshootout)), 3)
									from hockeyscoringshootout
									where hockeyscoringshootout.playerid = '" . $playerid . "' and shotpercent != -1
									order by year";
			$querycareershootoutstats1 = "select sum(shots), sum(goals), sum(gamedecidinggoals), ROUND((sum(goals)/(sum(shots))),3)
									from hockeyscoringshootout
									where hockeyscoringshootout.playerid = '" . $playerid . "'
									order by year";
		}
		if ($playertype == 'Team'){
			$querystats = "select distinct year, team, league, conference, division, rank, games, win, loss, points,  goals, ROUND(((goals - (select avg(goals) from hockeyteams))/(select stddev(goals) from hockeyteams)),3) zScore,
						goalsallowed, ROUND(((goalsallowed - (select avg(goalsallowed) from hockeyteams))/(select stddev(goalsallowed) from hockeyteams)),3) zScore2, goaldifferential,
						penaltyminutes, benchminutes, powerplaygoals, powerplaychances, shorthandedgoalsallowed, penaltykillgoals, penaltykillchances, shorthandedgoals
						from hockeyteams
						where name = '" . $playerid . "'
						order by year";
			$querycareerstats = "select sum(games)/(count(distinct year) * count(distinct year)), sum(win)/(count(distinct year) * count(distinct year)), sum(loss)/(count(distinct year) * count(distinct year)),
								sum(points)/(count(distinct year) * count(distinct year)), sum(goals)/(count(distinct year) * count(distinct year)), ROUND((AVG(A.zScore)),3), sum(goalsallowed)/(count(distinct year) * count(distinct year)),
								ROUND((AVG(B.zScore)),3), (sum(goals) - sum(goalsallowed))/(count(distinct year) * count(distinct year)), sum(penaltyminutes)/(count(distinct year) * count(distinct year)),
								sum(benchminutes)/(count(distinct year) * count(distinct year)), sum(powerplaygoals)/(count(distinct year) * count(distinct year)), sum(powerplaychances)/(count(distinct year) * count(distinct year)),
								sum(shorthandedgoalsallowed)/(count(distinct year) * count(distinct year)),sum(penaltykillgoals)/(count(distinct year) * count(distinct year)), sum(penaltykillchances)/(count(distinct year) * count(distinct year)),
								sum(shorthandedgoals)/(count(distinct year) * count(distinct year))
								from(SELECT ROUND((goals - (SELECT AVG(goals) FROM HOCKEYTEAMS)) / 
								     						(SELECT STDDEV(goals) FROM HOCKEYTEAMS), 3) 
								      						zScore FROM HOCKEYTEAMS WHERE name = '" . $playerid . "')A,
								     (SELECT ROUND((goalsallowed - (SELECT AVG(goalsallowed) FROM HOCKEYTEAMS)) / 
								     						(SELECT STDDEV(goalsallowed) FROM HOCKEYTEAMS), 3) 
								      						zScore FROM HOCKEYTEAMS WHERE name = '" . $playerid . "')B, hockeyteams
								where name = '" . $playerid . "'";
			$querypostseasonstats = "select distinct HockeyTeamsPostseason.*, ROUND(((HockeyTeamsPostseason.winpercent - (select avg(winpercent) from hockeyteamspostseason))/(select stddev(winpercent) from hockeyteamspostseason)),3) zScore,
									ROUND(((HockeyTeamsPostseason.goals - (select avg(goals) from hockeyteamspostseason))/(select stddev(goals) from hockeyteamspostseason)),3) zScore2,
									ROUND(((HockeyTeamsPostseason.goalsallowed - (select avg(goalsallowed) from hockeyteamspostseason))/(select stddev(goalsallowed) from hockeyteamspostseason)),3) zScore3
									from HockeyTeamsPostseason, hockeyteams
									where HockeyTeamsPostseason.team = hockeyteams.team AND hockeyteams.name = '" . $playerid . "'
									order by HockeyTeamsPostseason.year";
			$querysplitstats = "select distinct HockeyTeamsSplit.year, HockeyTeamsSplit.league, HockeyTeamsSplit.team, HockeyTeamsSplit.homewin, HockeyTeamsSplit.homeloss, HockeyTeamsSplit.homepointspergame,
								HockeyTeamsSplit.roadwin, HockeyTeamsSplit.roadloss, HockeyTeamsSplit.roadpointspergame, HockeyTeamsSplit.januarywin, HockeyTeamsSplit.januaryloss, HockeyTeamsSplit.januarypointspergame,
								HockeyTeamsSplit.februarywin, HockeyTeamsSplit.februaryloss, HockeyTeamsSplit.februarypointspergame, HockeyTeamsSplit.marchwin, HockeyTeamsSplit.marchloss, HockeyTeamsSplit.marchpointspergame,
								HockeyTeamsSplit.aprilwin, HockeyTeamsSplit.aprilloss, HockeyTeamsSplit.aprilpointspergame
								from HockeyTeamsSplit, HockeyTeams
								where HockeyTeamsSplit.team = HockeyTeams.team AND HockeyTeams.name = '" . $playerid . "'
								order by HockeyTeamsSplit.year";
			$querycareersplitstats = "select sum(HockeyTeamsSplit.homewin)/(count(distinct HockeyTeamsSplit.year)), sum(HockeyTeamsSplit.homeloss)/ count(distinct HockeyTeamsSplit.year) , ROUND((sum(HockeyTeamsSplit.homewin)/(sum(HockeyTeamsSplit.homewin) + sum(HockeyTeamsSplit.homeloss))),3),
										sum(HockeyTeamsSplit.roadwin)/(count(distinct HockeyTeamsSplit.year)), sum(HockeyTeamsSplit.roadloss)/ count(distinct HockeyTeamsSplit.year) , ROUND((sum(HockeyTeamsSplit.roadwin)/(sum(HockeyTeamsSplit.roadwin) + sum(HockeyTeamsSplit.roadloss))),3),
										sum(HockeyTeamsSplit.januarywin)/(count(distinct HockeyTeamsSplit.year)), sum(HockeyTeamsSplit.januaryloss)/ count(distinct HockeyTeamsSplit.year) , ROUND((sum(HockeyTeamsSplit.januarywin)/(sum(HockeyTeamsSplit.januarywin) + sum(HockeyTeamsSplit.januaryloss))),3),
										sum(HockeyTeamsSplit.februarywin)/(count(distinct HockeyTeamsSplit.year)), sum(HockeyTeamsSplit.februaryloss)/ count(distinct HockeyTeamsSplit.year) , ROUND((sum(HockeyTeamsSplit.februarywin)/(sum(HockeyTeamsSplit.februarywin) + sum(HockeyTeamsSplit.februaryloss))),3),
										sum(HockeyTeamsSplit.marchwin)/(count(distinct HockeyTeamsSplit.year)), sum(HockeyTeamsSplit.marchloss)/ count(distinct HockeyTeamsSplit.year) , ROUND((sum(HockeyTeamsSplit.marchwin)/(sum(HockeyTeamsSplit.marchwin) + sum(HockeyTeamsSplit.marchloss))),3),
										sum(HockeyTeamsSplit.aprilwin)/(count(distinct HockeyTeamsSplit.year)), sum(HockeyTeamsSplit.aprilloss)/ count(distinct HockeyTeamsSplit.year) , ROUND((sum(HockeyTeamsSplit.aprilwin)/(sum(HockeyTeamsSplit.aprilwin) + sum(HockeyTeamsSplit.aprilloss))),3)
										from HockeyTeamsSplit, HockeyTeams
										where HockeyTeamsSplit.team = HockeyTeams.team AND HockeyTeams.name = '" . $playerid . "'";
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
			if($playertype == 'Pitcher')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Wins</th>';
				echo '<th>Losses</th>';
				echo '<th>Win Percent</th>';
				echo '<th>Games</th>';
				echo '<th>Starts</th>';
				echo '<th>Complete Games</th>';
				echo '<th>Shutouts</th>';
				echo '<th>Saves</th>';
				echo '<th>Outs</th>';
				echo '<th>Hits Allowed</th>';
				echo '<th>Earned Runs</th>';
				echo '<th>Home Runs Allowed</th>';
				echo '<th>Walks</th>';
				echo '<th>Strikeouts</th>';
				echo '<th>Batting Average</th>';
				echo '<th>Batting Average z-Score</th>';
				echo '<th>ERA</th>';
				echo '<th>ERA z-Score</th>';
				echo '<th>Intentional Walks</th>';
				echo '<th>Wild Pitches</th>';
				echo '<th>Hit By Pitches</th>';
				echo '<th>Balks</th>';
				echo '<th>Batters Faced</th>';
				echo '<th>Finishes</th>';
				echo '<th>Runs Allowed</th>';
				echo '<th>WHIP</th>';
				echo '<th>H9</th>';
				echo '<th>HR9</th>';
				echo '<th>BB9</th>';
				echo '<th>SO9</th>';
				echo '</tr>';
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
			if($playertype == 'Team')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Conference</th>';
				echo '<th>Division</th>';
				echo '<th>Rank</th>';
				echo '<th>Conference Rank</th>';
				echo '<th>Field Goals Made</th>';
				echo '<th>Field Goal Attempts</th>';
				echo '<th>Field Goal Percent</th>';
				echo '<th>Field Goal Percent z-Score</th>';
				echo '<th>Free Throws Made</th>';
				echo '<th>Free Throw Attempts</th>';
				echo '<th>Free Throw Percent</th>';
				echo '<th>Free Throw Percent z-Score</th>';
				echo '<th>Three Pointers Made</th>';
				echo '<th>Three Point Attempts</th>';
				echo '<th>Three Point Percent</th>';
				echo '<th>Three Point Percent z-Score</th>';
				echo '<th>Offensive Rebounds</th>';
				echo '<th>Defensive Rebounds</th>';
				echo '<th>Rebounds</th>';
				echo '<th>Rebounds Per Game</th>';
				echo '<th>Rebounds Per Game z-Score</th>';
				echo '<th>Assists</th>';
				echo '<th>Assists Per Game</th>';
				echo '<th>Assists Per Game z-Score</th>';
				echo '<th>Fouls</th>';
				echo '<th>Steals</th>';
				echo '<th>Turnovers</th>';
				echo '<th>Blocks</th>';
				echo '<th>Points</th>';
				echo '<th>Points Per Game</th>';
				echo '<th>Points Per Game z-Score</th>';
				echo '<th>Made Field Goals Allowed</th>';
				echo '<th>Field Goal Attempts Allowed</th>';
				echo '<th>Field Goal Percent Allowed</th>';
				echo '<th>Made Free Throws Allowed</th>';
				echo '<th>Free Throw Attempts Allowed</th>';
				echo '<th>Made Three Pointers Allowed</th>';
				echo '<th>Three Point Attempts Allowed</th>';
				echo '<th>Three Point Percent Allowed</th>';
				echo '<th>Offensive Rebounds Allowed</th>';
				echo '<th>Defensive Rebounds Allowed</th>';
				echo '<th>Rebounds Allowed</th>';
				echo '<th>Rebounds Allowed Per Game</th>';
				echo '<th>Rebounds Allowed Per Game z-Score</th>';
				echo '<th>Assists Allowed</th>';
				echo '<th>Assists Allowed Per Game</th>';
				echo '<th>Assists Allowed Per Game z-Score</th>';
				echo '<th>Fouls Allowed</th>';
				echo '<th>Steals Allowed</th>';
				echo '<th>Turnovers Allowed</th>';
				echo '<th>Blocks Allowed</th>';
				echo '<th>Points Allowed</th>';
				echo '<th>Points Allowed Per Game</th>';
				echo '<th>Points Allowed Per Game z-Score</th>';
				echo '<th>Home Wins</th>';
				echo '<th>Home Losses</th>';
				echo '<th>Home Win Percent</th>';
				echo '<th>Away Wins</th>';
				echo '<th>Away Losses</th>';
				echo '<th>Away Win Percent</th>';
				echo '<th>Conference Wins</th>';
				echo '<th>Conference Losses</th>';
				echo '<th>Conference Win Percent</th>';
				echo '<th>Division Wins</th>';
				echo '<th>Divison Losses</th>';
				echo '<th>Division Win Percent</th>';
				echo '<th>Wins</th>';
				echo '<th>Losses</th>';
				echo '<th>Win Percent</th>';
				echo '<th>Win Percent z-Score</th>';
				echo '<th>Games</th>';
				echo '<th>Minutes</th>';
				echo '</tr>';
			}
			if($playertype == 'Player')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Games</th>';
				echo '<th>Minutes</th>';
				echo '<th>Points</th>';
				echo '<th>Points Per Game</th>';
				echo '<th>Points Per Game z-Score</th>';
				echo '<th>Offensive Rebounds</th>';
				echo '<th>Defensive Rebounds</th>';
				echo '<th>Rebounds</th>';
				echo '<th>Rebounds Per Game</th>';
				echo '<th>Rebounds Per Game z-Score</th>';
				echo '<th>Assists</th>';
				echo '<th>Assists Per Game</th>';
				echo '<th>Assists Per Game z-Score</th>';
				echo '<th>Steals</th>';
				echo '<th>Blocks</th>';
				echo '<th>Turnovers</th>';
				echo '<th>Fouls</th>';
				echo '<th>Field Goal Attempts</th>';
				echo '<th>Field Goals Made</th>';
				echo '<th>Field Goal Percent</th>';
				echo '<th>Field Goal Percent z-Score</th>';
				echo '<th>Free Throw Attempts</th>';
				echo '<th>Free Throws Made</th>';
				echo '<th>Free Throw Percent</th>';
				echo '<th>Free Throw Percent z-Score</th>';
				echo '<th>Three Point Attempts</th>';
				echo '<th>Three Pointers Made</th>';
				echo '<th>Three Point Percent</th>';
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
			if($playertype == 'Goalie')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Games</th>';
				echo '<th>Minutes</th>';
				echo '<th>Wins</th>';
				echo '<th>Losses</th>';
				echo '<th>Ties</th>';
				echo '<th>Points Per Game</th>';
				echo '<th>Points Per Game z-Score</th>';
				echo '<th>Empty Net Goals</th>';
				echo '<th>Shutouts</th>';
				echo '<th>Goals Allowed</th>';
				echo '<th>Shots Allowed</th>';
				echo '<th>Save Percent</th>';
				echo '<th>Save Percent z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Team')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Conference</th>';
				echo '<th>Division</th>';
				echo '<th>Rank</th>';
				echo '<th>Games</th>';
				echo '<th>Wins</th>';
				echo '<th>Losses</th>';
				echo '<th>Points</th>';
				echo '<th>Goals</th>';
				echo '<th>Goals z-Score</th>';
				echo '<th>Goals Allowed</th>';
				echo '<th>Goals Allowed z-Score</th>';
				echo '<th>Goal Differential</th>';
				echo '<th>Penalty Minutes</th>';
				echo '<th>Bench Minutes</th>';
				echo '<th>Power Play Goals</th>';
				echo '<th>Power Play Chances</th>';
				echo '<th>Short Handed Goals Allowed</th>';
				echo '<th>Penalty Kill Goals</th>';
				echo '<th>Penalty Kill Chances</th>';
				echo '<th>Short Handed Goals</th>';
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
	if($sport == 'Baseball')
	{
		if($playertype == 'Manager')
		{
			echo '<font size = "4"><b>Career Stats</b></font><br>';
		}
		if($playertype == 'Pitcher')
		{
			echo '<font size = "4"><b>Career Regular Season Pitching Stats</b></font><br>';
		}
		if($playertype == 'Position Player'){
		}
		if ($playertype == 'Team')
		{
			echo '<font size = "4"><b>Career Regular Season Stats</b></font><br>';
		}
	}
	else if($sport == 'Basketball'){
		if($playertype == 'Coach')
		{
				echo '<font size = "4"><b>Career Regular Season Stats</b></font><br>';
		}
		if($playertype == 'Team')
		{
				echo '<font size = "4"><b>Career Regular Season Stats</b></font><br>';
		}
		if($playertype == 'Player')
		{
				echo '<font size = "4"><b>Career Regular Season Stats</b></font><br>';
		}
	}
	else if($sport == 'Hockey')
	{
		if($playertype == 'Coach')
		{
			echo '<font size = "4"><b>Career Regular Season Stats</b></font><br>';
		}
		if($playertype == 'Goalie')
		{
			echo '<font size = "4"><b>Career Regular Season Goaltending Stats</b></font><br>';
		}
		if($playertype == 'Team')
		{
			echo '<font size = "4"><b>Career Regular Season Stats</b></font><br>';
		}
	}
	if(($sport == 'Baseball' && $playertype == 'Position Player') || ($sport == 'Hockey' && $playertype == 'Position Player'))
	{
		
	}
	else
	{
		$statementcareerstats = oci_parse($connection, $querycareerstats);
		oci_execute($statementcareerstats);
		echo "<table border='1'>\n";
		if($sport == 'Baseball')
		{
			if($playertype == 'Manager')
			{
				echo '<tr>';
				echo '<th>Total Wins</th>';
				echo '<th>Total Losses</th>';
				echo '<th>Total Win Percent</th>';
				echo '</tr>';
			}
			if($playertype == 'Pitcher')
			{
				echo '<tr>';
				echo '<th>Total Wins</th>';
				echo '<th>Total Losses</th>';
				echo '<th>Total Win Percent</th>';
				echo '</tr>';
			}
			if($playertype == 'Team')
			{
				echo '<tr>';
				echo '<th>Total Games</th>';
				echo '<th>Total Home Games</th>';
				echo '<th>Total Wins</th>';
				echo '<th>Total Losses</th>';
				echo '<th>Total Win Percent</th>';
				echo '<th>Average Win Percent z-Score</th>';
				echo '<th>Total Runs</th>';
				echo '<th>Total At-bats</th>';
				echo '<th>Total Hits</th>';
				echo '<th>Total Batting Average</th>';
				echo '<th>Average Batting Average z-Score</th>';
				echo '<th>Total Doubles</th>';
				echo '<th>Total Triples</th>';
				echo '<th>Total Home Runs</th>';
				echo '<th>Total Slugging</th>';
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
				echo '<th>Total Win Percent</th>';
				echo '</tr>';
			}
			if($playertype == 'Team')
			{
				echo '<tr>';
				echo '<th>Total Games</th>';
				echo '<th>Total Field Goals Made</th>';
				echo '<th>Total Field Goal Attempts</th>';
				echo '<th>Total Field Goal Percent</th>';
				echo '<th>Total Free Throws Made</th>';
				echo '<th>Total Free Throw Attempts</th>';
				echo '<th>Total Free Throw Percent</th>';
				echo '<th>Total Three Pointers Made</th>';
				echo '<th>Total Three Point Attempts</th>';
				echo '<th>Total Three Point Percent</th>';
				echo '<th>Total Offensive Rebounds</th>';
				echo '<th>Total Defensive Rebounds</th>';
				echo '<th>Total Rebounds</th>';
				echo '<th>Total Rebounds Per Game</th>';
				echo '<th>Total Assists</th>';
				echo '<th>Total Assists Per Game</th>';
				echo '<th>Total Fouls</th>';
				echo '<th>Total Steals</th>';
				echo '<th>Total Turnovers</th>';
				echo '<th>Total Blocks</th>';
				echo '<th>Total Points</th>';
				echo '<th>Total Points Per Game</th>';
				echo '<th>Total Made Field Goals Allowed</th>';
				echo '<th>Total Field Goal Attempts Allowed</th>';
				echo '<th>Total Field Goal Percent Allowed</th>';
				echo '<th>Total Made Free Throws Allowed</th>';
				echo '<th>Total Free Throw Attempts Allowed</th>';
				echo '<th>Total Made Three Pointers Allowed</th>';
				echo '<th>Total Three Point Attempts Allowed</th>';
				echo '<th>Total Three Point Percent Allowed</th>';
				echo '<th>Total Offensive Rebounds Allowed</th>';
				echo '<th>Total Defensive Rebounds Allowed</th>';
				echo '<th>Total Rebounds Allowed</th>';
				echo '<th>Total Rebounds Allowed Per Game</th>';
				echo '<th>Total Assists Allowed</th>';
				echo '<th>Total Assists Allowed Per Game</th>';
				echo '<th>Total Fouls Allowed</th>';
				echo '<th>Total Steals Allowed</th>';
				echo '<th>Total Turnovers Allowed</th>';
				echo '<th>Total Blocks Allowed</th>';
				echo '<th>Total Points Allowed</th>';
				echo '<th>Total Points Allowed Per Game</th>';
				echo '<th>Total Home Wins</th>';
				echo '<th>Total Home Losses</th>';
				echo '<th>Total Home Win Percent</th>';
				echo '<th>Total Away Wins</th>';
				echo '<th>Total Away Losses</th>';
				echo '<th>Total Away Win Percent</th>';
				echo '<th>Total Conference Wins</th>';
				echo '<th>Total Conference Losses</th>';
				echo '<th>Total Conference Win Percent</th>';
				echo '<th>Total Division Wins</th>';
				echo '<th>Total Divison Losses</th>';
				echo '<th>Total Division Win Percent</th>';
				echo '<th>Total Wins</th>';
				echo '<th>Total Losses</th>';
				echo '<th>Total Win Percent</th>';
				echo '<th>Total Minutes</th>';
				echo '</tr>';
			}
			if($playertype == 'Player')
			{
				echo '<tr>';
				echo '<th>Total Games</th>';
				echo '<th>Total Minutes</th>';
				echo '<th>Total Points</th>';
				echo '<th>Total Points Per Game</th>';
				echo '<th>Total Offensive Rebounds</th>';
				echo '<th>Total Defensive Rebounds</th>';
				echo '<th>Total Rebounds</th>';
				echo '<th>Total Rebounds Per Game</th>';
				echo '<th>Total Assists</th>';
				echo '<th>Total Assists Per Game</th>';
				echo '<th>Total Steals</th>';
				echo '<th>Total Blocks</th>';
				echo '<th>Total Turnovers</th>';
				echo '<th>Total Fouls</th>';
				echo '<th>Total Field Goal Attempts</th>';
				echo '<th>Total Field Goals Made</th>';
				echo '<th>Total Field Goal Percent</th>';
				echo '<th>Total Free Throw Attempts</th>';
				echo '<th>Total Free Throws Made</th>';
				echo '<th>Total Free Throw Percent</th>';
				echo '<th>Total Three Point Attempts</th>';
				echo '<th>Total Three Pointers Made</th>';
				echo '<th>Total Three Point Percent</th>';
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
				echo '<th>Total Points Per Game</th>';
				echo '<th>Total Points Per Game z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Goalie'){
				echo '<tr>';
				echo '<th>Total Games</th>';
				echo '<th>Total Minutes</th>';
				echo '<th>Total Wins</th>';
				echo '<th>Total Losses</th>';
				echo '<th>Total Ties</th>';
				echo '<th>Total Empty Net Goals</th>';
				echo '<th>Total Shutouts</th>';
				echo '<th>Total Goals Allowed</th>';
				echo '<th>Total Shots Allowed</th>';
				echo '<th>Total Save Percent</th>';
				echo '</tr>';
			}
			if($playertype == 'Team')
			{
				echo '<tr>';
				echo '<th>Total Games</th>';
				echo '<th>Total Wins</th>';
				echo '<th>Total Losses</th>';
				echo '<th>Total Points</th>';
				echo '<th>Total Goals</th>';
				echo '<th>Total Goals z-Score</th>';
				echo '<th>Total Goals Allowed</th>';
				echo '<th>Total Goals Allowed z-Score</th>';
				echo '<th>Total Goal Differential</th>';
				echo '<th>Total Penalty Minutes</th>';
				echo '<th>Total Bench Minutes</th>';
				echo '<th>Total Power Play Goals</th>';
				echo '<th>Total Power Play Chances</th>';
				echo '<th>Total Short Handed Goals Allowed</th>';
				echo '<th>Total Penalty Kill Goals</th>';
				echo '<th>Total Penalty Kill Chances</th>';
				echo '<th>Total Short Handed Goals</th>';
				echo '</tr>';
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
			if($playertype == 'Coach'){
				echo '<font size = "4"><b>Postseason Stats</b></font><br>';
			}
			if($playertype == 'Team')
			{
				echo '<font size = "4"><b>Postseason Stats</b></font><br>';
			}
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
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Wins</th>';
				echo '<th>Losses</th>';
				echo '<th>Win Percent</th>';
				echo '<th>Games</th>';
				echo '<th>Starts</th>';
				echo '<th>Complete Games</th>';
				echo '<th>Shutouts</th>';
				echo '<th>Saves</th>';
				echo '<th>Outs</th>';
				echo '<th>Hits</th>';
				echo '<th>Earned Runs</th>';
				echo '<th>Home Runs Allowed</th>';
				echo '<th>Walks</th>';
				echo '<th>Strikeouts</th>';
				echo '<th>Batting Average</th>';
				echo '<th>Batting Average z-Score</th>';
				echo '<th>ERA</th>';
				echo '<th>ERA z-Score</th>';
				echo '<th>Intentional Walks</th>';
				echo '<th>Wild Pitches</th>';
				echo '<th>Hit By Pitches</th>';
				echo '<th>Balks</th>';
				echo '<th>Batters Faced</th>';
				echo '<th>Finishes</th>';
				echo '<th>Runs Allowed</th>';
				echo '<th>WHIP</th>';
				echo '<th>H9</th>';
				echo '<th>HR9</th>';
				echo '<th>BB9</th>';
				echo '<th>SO9</th>';
				echo '</tr>';
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
			if($playertype == 'Player')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Games</th>';
				echo '<th>Minutes</th>';
				echo '<th>Points</th>';
				echo '<th>Points Per Game</th>';
				echo '<th>Points Per Game z-Score</th>';
				echo '<th>Offensive Rebounds</th>';
				echo '<th>Defensive Rebounds</th>';
				echo '<th>Rebounds</th>';
				echo '<th>Rebounds Per Game</th>';
				echo '<th>Rebounds Per Game z-Score</th>';
				echo '<th>Assists</th>';
				echo '<th>Assists Per Game</th>';
				echo '<th>Assists Per Game z-Score</th>';
				echo '<th>Steals</th>';
				echo '<th>Blocks</th>';
				echo '<th>Turnovers</th>';
				echo '<th>Fouls</th>';
				echo '<th>Field Goal Attempts</th>';
				echo '<th>Field Goals Made</th>';
				echo '<th>Field Goal Percent</th>';
				echo '<th>Field Goal Percent z-Score</th>';
				echo '<th>Free Throw Attempts</th>';
				echo '<th>Free Throws Made</th>';
				echo '<th>Free Throw Percent</th>';
				echo '<th>Free Throw Percent z-Score</th>';
				echo '<th>Three Point Attempts</th>';
				echo '<th>Three Pointers Made</th>';
				echo '<th>Three Point Percent</th>';
				echo '<th>Three Point Percent z-Score</th>';
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
			if($playertype == 'Team')
			{
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>League</th>';
				echo '<th>Teams</th>';
				echo '<th>Games</th>';
				echo '<th>Wins</th>';
				echo '<th>Losses</th>';
				echo '<th>Ties</th>';
				echo '<th>Win Percent</th>';
				echo '<th>Goals</th>';
				echo '<th>Goals Allowed</th>';
				echo '<th>Goals Differential</th>';
				echo '<th>Penalty Minutes</th>';
				echo '<th>Bench Minutes</th>';
				echo '<th>Power Play Goals</th>';
				echo '<th>Power Play Chances</th>';
				echo '<th>Short Handed Goals Allowed</th>';
				echo '<th>Penalty Kill Goals</th>';
				echo '<th>Penalty Kill Chances</th>';
				echo '<th>Short Handed Goals</th>';
				echo '<th>Win Percent z-Score</th>';
				echo '<th>Goals z-Score</th>';
				echo '<th>Goals Allowed z-Score</th>';
				echo '</tr>';
			}
			if($playertype == 'Goalie'){
					echo '<tr>';
					echo '<th>Year</th>';
					echo '<th>Team</th>';
					echo '<th>League</th>';
					echo '<th>Games</th>';
					echo '<th>Minutes</th>';
					echo '<th>Wins</th>';
					echo '<th>Losses</th>';
					echo '<th>Win Percent</th>';
					echo '<th>Win Percent z-Score</th>';
					echo '<th>Empty Net Goals</th>';
					echo '<th>Shutouts</th>';
					echo '<th>Goals Allowed</th>';
					echo '<th>Shots Allowed</th>';
					echo '<th>Save Percent</th>';
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
	
		if($sport == 'Baseball'){
			if($playertype == 'Manager'){
				
			}
			if($playertype == 'Pitcher'){
				echo '<font size = "4"><b>Career Postseason Pitching Stats</b></font><br>';
			}
			if($playertype == 'Position Player'){
			}
		}
		else if($sport == 'Basketball'){
			if($playertype == 'Coach'){
				echo '<font size = "4"><b>Career Postseason Stats</b></font><br>';
			}
			if($playertype == 'Player')
			{
				echo '<font size = "4"><b>Career Postseason Stats</b></font><br>';
			}
		}
		else if($sport == 'Hockey'){
			if($playertype == 'Coach'){
				echo '<font size = "4"><b>Career Postseason Stats</b></font><br>';
			}
		}
	$statementcareerpostseasonstats = oci_parse($connection, $querycareerpostseasonstats);
	if($playertype == 'Team' || ($sport == 'Hockey' && $playertype == 'Goalie') || ($sport == 'Hockey' && $playertype == 'Position Player'))
	{
		
	}
	else
	{
		if(($sport == 'Baseball' && $playertype == 'Pitcher') || ($sport == 'Basketball' && $playertype == 'Coach') || ($sport == 'Hockey' && $playertype = 'Coach') || ($sport == 'Basketball' && $playertype == 'Player'))
		{
			oci_execute($statementcareerpostseasonstats);
			echo "<table border='1'>\n";
			if($sport == 'Baseball')
			{
				if($playertype == 'Manager'){
					
				}
				if($playertype == 'Pitcher' || $playertype == 'Position Player'){
					echo '<tr>';
					echo '<th>Total Wins</th>';
					echo '<th>Total Losses</th>';
					echo '<th>Total Win Percent</th>';
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
					echo '<th>Total Win Percent</th>';
					echo '</tr>';
				}
				if($playertype == 'Player')
				{
					echo '<tr>';
					echo '<th>Total Games</th>';
					echo '<th>Total Minutes</th>';
					echo '<th>Total Points</th>';
					echo '<th>Total Points Per Game</th>';
					echo '<th>Total Offensive Rebounds</th>';
					echo '<th>Total Defensive Rebounds</th>';
					echo '<th>Total Rebounds</th>';
					echo '<th>Total Rebounds Per Game</th>';
					echo '<th>Total Assists</th>';
					echo '<th>Total Assists Per Game</th>';
					echo '<th>Total Steals</th>';
					echo '<th>Total Blocks</th>';
					echo '<th>Total Turnovers</th>';
					echo '<th>Total Fouls</th>';
					echo '<th>Total Field Goal Attempts</th>';
					echo '<th>Total Field Goals Made</th>';
					echo '<th>Total Field Goal Percent</th>';
					echo '<th>Total Free Throw Attempts</th>';
					echo '<th>Total Free Throws Made</th>';
					echo '<th>Total Free Throw Percent</th>';
					echo '<th>Total Three Point Attempts</th>';
					echo '<th>Total Three Pointers Made</th>';
					echo '<th>Total Three Point Percent</th>';
					echo '</tr>';
				}
			}
			else if($sport == 'Hockey')
			{
				if($playertype != 'Goalie'){
					echo '<tr>';
					echo '<th>Total Wins</th>';
					echo '<th>Total Losses</th>';
					echo '<th>Total Ties</th>';
					echo '<th>Total Win Percent</th>';
					echo '</tr>';	
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
	}
	$statementsplitstats = oci_parse($connection, $querysplitstats);
	if($sport == 'Hockey' && $playertype == 'Team')
	{
		echo '<font size = "4"><b>Team Split Stats</b></font><br>';
		oci_execute($statementsplitstats);
		echo "<table border='1'>\n";
		echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>League</th>';
				echo '<th>Team</th>';
				echo '<th>Home Wins</th>';
				echo '<th>Home Losses</th>';
				echo '<th>Home Points Per Game</th>';
				echo '<th>Road Wins</th>';
				echo '<th>Road Losses</th>';
				echo '<th>Road Points Per Game</th>';
				echo '<th>January Wins</th>';
				echo '<th>January Losses</th>';
				echo '<th>January Points Per Game</th>';
				echo '<th>February Wins</th>';
				echo '<th>February Losses</th>';
				echo '<th>February Points Per Game</th>';
				echo '<th>March Wins</th>';
				echo '<th>March Losses</th>';
				echo '<th>March Points Per Game</th>';
				echo '<th>April Wins</th>';
				echo '<th>April Losses</th>';
				echo '<th>April Points Per Game</th>';
				echo '</tr>';
		while ($row = oci_fetch_array($statementsplitstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			echo "<tr>\n";
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	$statementcareersplitstats = oci_parse($connection, $querycareersplitstats);
	if($sport == 'Hockey' && $playertype == 'Team')
	{
		echo '<font size = "4"><b>Team Career Split Stats</b></font><br>';
		oci_execute($statementcareersplitstats);
		echo "<table border='1'>\n";
		echo '<tr>';
				echo '<th>Total Home Wins</th>';
				echo '<th>Total Home Losses</th>';
				echo '<th>Total Home Win Percent</th>';
				echo '<th>Total Road Wins</th>';
				echo '<th>Total Road Losses</th>';
				echo '<th>Total Road Win Percent</th>';
				echo '<th>Total January Wins</th>';
				echo '<th>Total January Losses</th>';
				echo '<th>Total January Win Percent</th>';
				echo '<th>Total February Wins</th>';
				echo '<th>Total February Losses</th>';
				echo '<th>Total February Win Percent</th>';
				echo '<th>Total March Wins</th>';
				echo '<th>Total March Losses</th>';
				echo '<th>Total March Win Percent</th>';
				echo '<th>Total April Wins</th>';
				echo '<th>Total April Losses</th>';
				echo '<th>Total April Win Percent</th>';
				echo '</tr>';
		while ($row = oci_fetch_array($statementcareersplitstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
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
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Games</th>';
				echo '<th>Starts</th>';
				echo '<th>At-bats</th>';
				echo '<th>Runs</th>';
				echo '<th>Hits</th>';
				echo '<th>Batting Average</th>';
				echo '<th>Batting Average z-Score</th>';
				echo '<th>Doubles</th>';
				echo '<th>Triples</th>';
				echo '<th>Home Runs</th>';
				echo '<th>Slugging</th>';
				echo '<th>Slugging z-Score</th>';
				echo '<th>RBI</th>';
				echo '<th>Stolen Bases</th>';
				echo '<th>Caught Stealing</th>';
				echo '<th>Walks</th>';
				echo '<th>Strikeouts</th>';
				echo '<th>Intentional Walks</th>';
				echo '<th>Hit By Pitches</th>';
				echo '<th>OBP</th>';
				echo '<th>OBP z-Score</th>';
				echo '<th>Sac Hits</th>';
				echo '<th>Sac Flies</th>';
				echo '<th>GIDP</th>';
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
	$statementcareerbattingstats = oci_parse($connection, $querycareerbattingstats);
	if($sport == 'Baseball' && ($playertype == 'Pitcher' || $playertype == 'Position Player'))
	{
		echo '<font size = "4"><b>Regular Season Career Batting Stats</b></font><br>';
		oci_execute($statementcareerbattingstats);
		echo "<table border='1'>\n";
			    echo '<tr>';
				echo '<th>Total Games</th>';
				echo '<th>Total Starts</th>';
				echo '<th>Total At-bats</th>';
				echo '<th>Total Runs</th>';
				echo '<th>Total Hits</th>';
				echo '<th>Total Batting Average</th>';
				echo '<th>Total Doubles</th>';
				echo '<th>Total Triples</th>';
				echo '<th>Total Home Runs</th>';
				echo '<th>Total Slugging</th>';
				echo '<th>Total RBI</th>';
				echo '<th>Total Stolen Bases</th>';
				echo '<th>Total Caught Stealing</th>';
				echo '<th>Total Walks</th>';
				echo '<th>Total Strikeouts</th>';
				echo '<th>Total Intentional Walks</th>';
				echo '<th>Total Hit By Pitches</th>';
				echo '<th>Total Sac Hits</th>';
				echo '<th>Total Sac Flies</th>';
				echo '<th>Total GIDP</th>';
				echo '</tr>';
		while ($row = oci_fetch_array($statementcareerbattingstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
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
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Games</th>';
				echo '<th>At-bats</th>';
				echo '<th>Runs</th>';
				echo '<th>Hits</th>';
				echo '<th>Batting Average</th>';
				echo '<th>Batting Average z-Score</th>';
				echo '<th>Doubles</th>';
				echo '<th>Triples</th>';
				echo '<th>Home Runs</th>';
				echo '<th>Slugging</th>';
				echo '<th>Slugging z-Score</th>';
				echo '<th>RBI</th>';
				echo '<th>Stolen Bases</th>';
				echo '<th>Caught Stealing</th>';
				echo '<th>Walks</th>';
				echo '<th>Strikeouts</th>';
				echo '<th>Intentional Walks</th>';
				echo '<th>Hit By Pitches</th>';
				echo '<th>OBP</th>';
				echo '<th>OBP z-Score</th>';
				echo '<th>Sac Hits</th>';
				echo '<th>Sac Flies</th>';
				echo '<th>GIDP</th>';
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
	$statementcareerpostseasonbattingstats = oci_parse($connection, $querycareerpostseasonbattingstats);
	if($sport == 'Baseball' && ($playertype == 'Pitcher' || $playertype == 'Position Player'))
	{
		echo '<font size = "4"><b>Career Postseason Batting Stats</b></font><br>';
		oci_execute($statementcareerpostseasonbattingstats);
		echo "<table border='1'>\n";
			    echo '<tr>';
				echo '<th>Total Games</th>';
				echo '<th>Total At-bats</th>';
				echo '<th>Total Runs</th>';
				echo '<th>Total Hits</th>';
				echo '<th>Total Batting Average</th>';
				echo '<th>Total Doubles</th>';
				echo '<th>Total Triples</th>';
				echo '<th>Total Home Runs</th>';
				echo '<th>Total Slugging</th>';
				echo '<th>Total RBI</th>';
				echo '<th>Total Stolen Bases</th>';
				echo '<th>Total Caught Stealing</th>';
				echo '<th>Total Walks</th>';
				echo '<th>Total Strikeouts</th>';
				echo '<th>Total Intentional Walks</th>';
				echo '<th>Total Hit By Pitches</th>';
				echo '<th>Total Sac Hits</th>';
				echo '<th>Total Sac Flies</th>';
				echo '<th>Total GIDP</th>';
				echo '</tr>';
		while ($row = oci_fetch_array($statementcareerpostseasonbattingstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
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
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Position</th>';
				echo '<th>Games</th>';
				echo '<th>Starts</th>';
				echo '<th>Outs</th>';
				echo '<th>Putouts</th>';
				echo '<th>Errors</th>';
				echo '<th>Double Plays</th>';
				echo '<th>Passed Balls</th>';
				echo '<th>Stolen Bases Allowed</th>';
				echo '<th>Caught Stealing</th>';
				echo '<th>Fielding Percent</th>';
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
	$statementcareerfieldingstats = oci_parse($connection, $querycareerfieldingstats);
	if($sport == 'Baseball' && ($playertype == 'Pitcher' || $playertype == 'Position Player'))
	{
		echo '<font size = "4"><b>Career Regular Season Fielding Stats</b></font><br>';
		oci_execute($statementcareerfieldingstats);
		echo "<table border='1'>\n";
		echo "<tr>\n";
				echo '<th>Total Games</th>';
				echo '<th>Toal Starts</th>';
				echo '<th>Total Outs</th>';
				echo '<th>Total Putouts</th>';
				echo '<th>Total Errors</th>';
				echo '<th>Total Double Plays</th>';
				echo '<th>Total Passed Balls</th>';
				echo '<th>Total Stolen Bases Allowed</th>';
				echo '<th>Total Caught Stealing</th>';
				echo '<th>Total Fielding Percent</th>';
				echo '</tr>';	   
		while ($row = oci_fetch_array($statementcareerfieldingstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
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
		echo '<font size = "4"><b>Regular Season Fielding Stats</b></font><br>';
		oci_execute($statementpostseasonfieldingstats);
		echo "<table border='1'>\n";
		echo "<tr>\n";
				echo '<th>Year</th>';
				echo '<th>Round</th>';
				echo '<th>Team</th>';
				echo '<th>League</th>';
				echo '<th>Position</th>';
				echo '<th>Games</th>';
				echo '<th>Starts</th>';
				echo '<th>Outs</th>';
				echo '<th>Putouts</th>';
				echo '<th>Errors</th>';
				echo '<th>Double Plays</th>';
				echo '<th>Passed Balls</th>';
				echo '<th>Stolen Bases Allowed</th>';
				echo '<th>Caught Stealing</th>';
				echo '<th>Fielding Percent</th>';
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
	$statementcareerpostseasonfieldingstats = oci_parse($connection, $querycareerpostseasonfieldingstats);
	if($sport == 'Baseball' && ($playertype == 'Pitcher' || $playertype == 'Position Player'))
	{
		echo '<font size = "4"><b>Career Postseason Fielding Stats</b></font><br>';
		oci_execute($statementcareerpostseasonfieldingstats);
		echo "<table border='1'>\n";
		echo "<tr>\n";
				echo '<th>Total Games</th>';
				echo '<th>Toal Starts</th>';
				echo '<th>Total Outs</th>';
				echo '<th>Total Putouts</th>';
				echo '<th>Total Errors</th>';
				echo '<th>Total Double Plays</th>';
				echo '<th>Total Passed Balls</th>';
				echo '<th>Total Stolen Bases Allowed</th>';
				echo '<th>Total Caught Stealing</th>';
				echo '<th>Total Fielding Percent</th>';
				echo '</tr>';	   
		while ($row = oci_fetch_array($statementcareerpostseasonfieldingstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	$statementallstarstats = oci_parse($connection, $queryallstarstats);
	if($sport == 'Basketball' && $playertype == 'Player')
	{
		echo '<font size = "4"><b>All-Star Game Stats</b></font><br>';
		oci_execute($statementallstarstats);
		echo "<table border='1'>\n";
		echo "<tr>\n";
		echo '<th>Year</th>';
		echo '<th>Conference</th>';
		echo '<th>League</th>';
		echo '<th>Minutes</th>';
		echo '<th>Points</th>';
		echo '<th>Offensive Rebounds</th>';
		echo '<th>Defensive Rebounds</th>';
		echo '<th>Rebounds</th>';
		echo '<th>Assists</th>';
		echo '<th>Steals</th>';
		echo '<th>Blocks</th>';
		echo '<th>Turnovers</th>';
		echo '<th>Fouls</th>';
		echo '<th>Field Goal Attempts</th>';
		echo '<th>Field Goals Made</th>';
		echo '<th>Free Throw Attempts</th>';
		echo '<th>Free Throws Made</th>';
		echo '<th>Three Point Attempts</th>';
		echo '<th>Three Pointers Made</th>';
		echo '</tr>';	   
		while ($row = oci_fetch_array($statementallstarstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	$statementcareerallstarstats = oci_parse($connection, $querycareerallstarstats);
	if($sport == 'Basketball' && $playertype == 'Player')
	{
		echo '<font size = "4"><b>Career All-Star Game Stats</b></font><br>';
		oci_execute($statementcareerallstarstats);
		echo "<table border='1'>\n";
		echo "<tr>\n";
		echo '<th>Total Minutes</th>';
		echo '<th>Total Points</th>';
		echo '<th>Total Offensive Rebounds</th>';
		echo '<th>Total Defensive Rebounds</th>';
		echo '<th>Total Rebounds</th>';
		echo '<th>Total Assists</th>';
		echo '<th>Total Steals</th>';
		echo '<th>Total Blocks</th>';
		echo '<th>Total Turnovers</th>';
		echo '<th>Total Fouls</th>';
		echo '<th>Total Field Goal Attempts</th>';
		echo '<th>Total Field Goals Made</th>';
		echo '<th>Total Free Throw Attempts</th>';
		echo '<th>Total Free Throws Made</th>';
		echo '<th>Total Three Point Attempts</th>';
		echo '<th>Total Three Pointers Made</th>';
		echo '</tr>';	   
		while ($row = oci_fetch_array($statementcareerallstarstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	$statementcareerpostseasonstats1 = oci_parse($connection, $querycareerpostseasonstats1);
	if($sport == 'Hockey' && $playertype == 'Goalie')
	{
		echo '<font size = "4"><b>Career Postseason Goaltending Stats</b></font><br>';
		oci_execute($statementcareerpostseasonstats1);
		echo "<table border='1'>\n";
		echo '<tr>';
					echo '<th>Total Games</th>';
					echo '<th>Total Minutes</th>';
					echo '<th>Total Wins</th>';
					echo '<th>Total Losses</th>';
					echo '<th>Total Win Percent</th>';
					echo '<th>Total Empty Net Goals</th>';
					echo '<th>Total Shutouts</th>';
					echo '<th>Total Goals Allowed</th>';
					echo '<th>Total Shots Allowed</th>';
					echo '<th>Total Save Percent</th>';
					echo '</tr>';   
		while ($row = oci_fetch_array($statementcareerpostseasonstats1, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
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
				echo '<th>Team</th>';
				echo '<th>Wins</th>';
				echo '<th>Lossses</th>';
				echo '<th>Win Percent</th>';
				echo '<th>Win Percent z-Score</th>';
				echo '<th>Goals Allowed</th>';
				echo '<th>Shots Allowed</th>';
				echo '<th>Save Percent</th>';
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
	$statementcareershootoutstats = oci_parse($connection, $querycareershootoutstats);
	if($sport == 'Hockey' && $playertype == 'Goalie')
	{
		oci_execute($statementcareershootoutstats);
				echo '<font size = "4"><b>Career Shootout Goaltending Stats</b></font><br>';
				echo "<table border='1'>\n";
				echo '<tr>';
				echo '<th>Total Wins</th>';
				echo '<th>Total Lossses</th>';
				echo '<th>Total Win Percent</th>';
				echo '<th>Total Goals Allowed</th>';
				echo '<th>Total Shots Allowed</th>';
				echo '<th>Total Save Percent</th>';
				echo '</tr>'; 
		while ($row = oci_fetch_array($statementcareershootoutstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
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
		echo '<th>Team</th>';
		echo '<th>League</th>';
		echo '<th>Games</th>';
		echo '<th>Goals</th>';
		echo '<th>Goals Per Game</th>';
		echo '<th>Assists</th>';
		echo '<th>Assists Per Game</th>';
		echo '<th>Points</th>';
		echo '<th>Points Per Game</th>';
		echo '<th>Points Per Game z-Score</th>';
		echo '<th>Penalty Minutes</th>';
		echo '<th>+/-</th>';
		echo '<th>Power Play Goals</th>';
		echo '<th>Power Play Assists</th>';
		echo '<th>Short Handed Goals</th>';
		echo '<th>Short Handed Assists</th>';
		echo '<th>Game Winning Goals</th>';
		echo '<th>Game Tying Goals</th>';
		echo '<th>Shots</th>';
		echo '<th>Shot Percent</th>';
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
	$statementcareerscoringstats = oci_parse($connection, $querycareerscoringstats);
	if(($sport == 'Hockey' && $playertype == 'Goalie') || ($sport == 'Hockey' && $playertype == 'Position Player'))
	{
		oci_execute($statementcareerscoringstats);
		echo '<font size = "4"><b>Career Regular Season Scoring Stats</b></font><br>';
		echo "<table border='1'>\n";
		echo '<tr>';
		echo '<th>Total Games</th>';
		echo '<th>Total Goals</th>';
		echo '<th>Total Goals Per Game</th>';
		echo '<th>Total Assists</th>';
		echo '<th>Total Assists Per Game</th>';
		echo '<th>Total Points</th>';
		echo '<th>Total Points Per Game</th>';
		echo '<th>Total Penalty Minutes</th>';
		echo '<th>Total +/-</th>';
		echo '<th>Total Power Play Goals</th>';
		echo '<th>Total Power Play Assists</th>';
		echo '<th>Total Short Handed Goals</th>';
		echo '<th>Total Short Handed Assists</th>';
		echo '<th>Total Game Winning Goals</th>';
		echo '<th>Total Game Tying Goals</th>';
		echo '<th>Total Shots</th>';
		echo '<th>Total Shot Percent</th>';
		echo '</tr>';
		while ($row = oci_fetch_array($statementcareerscoringstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	$statementpostseasonscoringstats = oci_parse($connection, $querypostseasonscoringstats);
	if(($sport == 'Hockey' && $playertype == 'Goalie') || ($sport == 'Hockey' && $playertype == 'Position Player'))
	{
		oci_execute($statementpostseasonscoringstats);
		echo '<font size = "4"><b>Postseason Scoring Stats</b></font><br>';
		echo "<table border='1'>\n";
		echo '<tr>';
		echo '<th>Year</th>';
		echo '<th>Team</th>';
		echo '<th>League</th>';
		echo '<th>Games</th>';
		echo '<th>Goals</th>';
		echo '<th>Goals Per Game</th>';
		echo '<th>Assists</th>';
		echo '<th>Assists Per Game</th>';
		echo '<th>Points</th>';
		echo '<th>Points Per Game</th>';
		echo '<th>Penalty Minutes</th>';
		echo '<th>+/-</th>';
		echo '<th>Power Play Goals</th>';
		echo '<th>Power Play Assists</th>';
		echo '<th>Short Handed Goals</th>';
		echo '<th>Short Handed Assists</th>';
		echo '<th>Game Winning Goals</th>';
		echo '<th>Shots</th>';
		echo '<th>Shot Percent</th>';
		echo '</tr>';
		while ($row = oci_fetch_array($statementpostseasonscoringstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	$statementcareerpostseasonscoringstats = oci_parse($connection, $querycareerpostseasonscoringstats);
	if(($sport == 'Hockey' && $playertype == 'Goalie') || ($sport == 'Hockey' && $playertype == 'Position Player'))
	{
		oci_execute($statementcareerpostseasonscoringstats);
		echo '<font size = "4"><b>Career Postseason Scoring Stats</b></font><br>';
		echo "<table border='1'>\n";
		echo '<tr>';
		echo '<th>Total Games</th>';
		echo '<th>Total Goals</th>';
		echo '<th>Total Goals Per Game</th>';
		echo '<th>Total Assists</th>';
		echo '<th>Total Assists Per Game</th>';
		echo '<th>Total Points</th>';
		echo '<th>Total Points Per Game</th>';
		echo '<th>Total Penalty Minutes</th>';
		echo '<th>Total +/-</th>';
		echo '<th>Total Power Play Goals</th>';
		echo '<th>Total Power Play Assists</th>';
		echo '<th>Total Short Handed Goals</th>';
		echo '<th>Total Short Handed Assists</th>';
		echo '<th>Total Game Winning Goals</th>';
		echo '<th>Total Shots</th>';
		echo '<th>Total Shot Percent</th>';
		echo '</tr>';
		while ($row = oci_fetch_array($statementcareerpostseasonscoringstats, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	$statementshootoutstats1 = oci_parse($connection, $queryshootoutstats1);
	if($sport == 'Hockey' && $playertype == 'Position Player')
	{
				oci_execute($statementshootoutstats1);
				echo '<font size = "4"><b>Shootout Scoring Stats</b></font><br>';
				echo "<table border='1'>\n";
				echo '<tr>';
				echo '<th>Year</th>';
				echo '<th>Team</th>';
				echo '<th>Shots</th>';
				echo '<th>Goals</th>';
				echo '<th>Game Deciding Goals</th>';
				echo '<th>Shot Percent</th>';
				echo '<th>Shot Percent z-Score</th>';
				echo '</tr>'; 
		while ($row = oci_fetch_array($statementshootoutstats1, OCI_ASSOC+OCI_RETURN_NULLS)) {
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	}
	$statementcareershootoutstats1 = oci_parse($connection, $querycareershootoutstats1);
	if($sport == 'Hockey' && $playertype == 'Position Player')
	{
				oci_execute($statementcareershootoutstats1);
				echo '<font size = "4"><b>Career Shootout Scoring Stats</b></font><br>';
				echo "<table border='1'>\n";
				echo '<tr>';
				echo '<th>Total Shots</th>';
				echo '<th>Total Goals</th>';
				echo '<th>Total Game Deciding Goals</th>';
				echo '<th>Total Shot Percent</th>';
				echo '</tr>'; 
		while ($row = oci_fetch_array($statementcareershootoutstats1, OCI_ASSOC+OCI_RETURN_NULLS)) {
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
	oci_close($connection);
?>

