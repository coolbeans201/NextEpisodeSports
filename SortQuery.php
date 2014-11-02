#!/usr/local/bin/php
<html>

<head>
	<title>Sort Query</title>
	<meta name="keywords" content="Next Episode, sort query">
	<meta name="description" content="Next Episode Sports Database">
	<meta name="author" content="Derek Hua, Matt Weingarten, Xin He, Jesse Chau">
	<meta name="copyright" content="Copyright &copy 2014, All Rights Reserved">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans|Shadows+Into+Light|Rock+Salt">

	<script type="text/javascript">
	var varieties=[
	[""],
	["Manager","Pitcher","Position Player","Team"],
	["Coach","Player","Team"],
	["Coach","Goalie","Position Player","Team"]
	];
	
	function playerType(idx) {
	var f=document.myform;
	f.playertype.options.length=null;
	for(i=0; i<varieties[idx].length; i++) {
    	f.playertype.options[i]=new Option(varieties[idx][i], i); 
    		}    
	}
	var stats=[
	[],
	["Games","Starts","Atbats","Runs","Hits","Batting average","Doubles", "Triples","Home runs","Slugging","RBI","Stolen bases","Caught stealing","Walks","Strikeouts", "Intentional walks", "Hit by pitch", "OBP", "Sac hits", "Sac flies", "GIDP", "Outs", "Putouts", "Assists", "Errors", "Double plays", "Passed balls", "Wild pitches", "Stolen bases allowed", "Caught stealing allowed", "Fielding percent", "Wins", "Losses", "Winning percentage", "Complete games", "Shutouts", "Saves", "Outs", "Earned runs", "ERA", "Balks", "Batters faced", "Finishes", "H9", "HR9", "BB9", "SO9", "Runs allowed", "Hits allowed", "Home runs allowed", "Walks allowed", "Strikeouts forced"],
	["Wins", "Losses", "Winning percentage", "Postseason wins", "Postseason losses", "Postseason winning percentage", "Minutes", "Points", "Offensive rebounds", "Defensive rebounds", "Rebounds", "Assists", "Steals", "Blocks", "Turnovers", "Fouls", "Field goal attempts", "Field goals made", "Field goal percentage", "Free throw attempts", "Free throws made", "Free throw percentage", "Three point attempts", "Three point percentage", "Points per game", "Rebounds per game", "Assists per game", "Field goals made allowed", "Field goal attempts allowed", "Field goal percentage allowed", "Free throws made allowed", "Free throw attempts allowed", "Three point made allowed", "Three point attempts allowed", "Three point percentage allowed", "Offensive rebounds allowed", "Defensive rebounds allowed", "Rebounds allowed", "Rebounds allowed per game", "Assists allowed", "Assists allowed per game", "Fouls allowed", "Steals allowed", "Turnovers allowed", "Blocks allowed", "Points allowed", "Points allowed per game", "Offensive team rebounds", "Defensive team rebounds", "Home wins", "Home losses", "Home winning percentage", "Away wins", "Away losses", "Away winning percentage", "Neutral wins", "Neutral losses", "Neutral winning percentage", "Conference wins", "Conference losses", "Conference winning percentage", "Division wins", "Division losses", "Division winning percentage", "Games"],
	["Wins", "Losses", "Ties", "Points per game", "Postseason wins", "Postseason losses", "Postseason ties", "Postseason winning percentage", "Games", "Minutes", "Empty net goals", "Shutouts", "Goals allowed", "Shots allowed", "Save percentage", "Shootout wins", "Shootout losses", "Shootout winning percentage", "Shootout shots allowed", "Shootout goals allowed", "Shootout save percentage", "Goals", "Goals per game", "Assists", "Assists per game", "Points", "Points per game", "Penalty minutes", "+/-", "Power play goals", "Power play assists", "Short handed goals", "Short handed assists", "Game winning goals", "Game tying goals", "Shots", "Shot percent", "Shootout shots", "Shootout goals", "Shootout goal deciding goals", "Shootout shot percent", "Overtime losses", "Goal differential", "Bench minutes", "Power play chances", "Short handed goals allowed", "Penalty kill goals", "Penalty kill chances", "Home wins", "Home losses", "Home ties", "Home OT losses", "Home points per game", "Road wins", "Road losses", "Road ties", "Road OT losses", "Road points per game"]
	];
	
	function Box3(idx) {
	var f=document.myform;
	f.box3.options.length=null;
	for(i=0; i<stats[idx].length; i++) {
		f.box3.options[i]=new Option(stats[idx][i], i); 
		}    
	}
	onload=function() {playertype(0); Box3(0);};
	</script>
	
    <style>
        <style style="text/css">
        html {overflow-y: scroll}
        
		h1 {
			font-family: 'Rock Salt', sans-serif;
			font-size: 60px;
			font-weight: normal;
			color:#000000;
			text-align: center;
		}
		
		body {
			font-family: 'Open Sans', sans-serif;
			font-size: 24px;
			background-color: #F9F4E1;
     	}
		
		.chooseoperation {
			text-align:center;
		}
		
        .buttoncenter {
            text-align:center;
        }
        
        
		nav ul ul {
			display: none;
		}
		nav ul li:hover > ul {
			display: block;
		}
		
		nav ul {
			background: #efefef; 
			background: linear-gradient(top, #efefef 0%, #bbbbbb 100%);  
			background: -moz-linear-gradient(top, #efefef 0%, #bbbbbb 100%); 
			background: -webkit-linear-gradient(top, #efefef 0%,#bbbbbb 100%); 
			box-shadow: 0px 0px 9px rgba(0,0,0,0.15);
			padding: 0 20px;
			border-radius: 10px;  
			list-style: none;
			position: relative;
			display: inline-table;
		}
		nav ul:after {
			content: ""; clear: both; display: block;
		}
		
		nav ul li {
			float: left;
		}
		nav ul li:hover {
			background: #4b545f;
			background: linear-gradient(top, #4f5964 0%, #5f6975 40%);
			background: -moz-linear-gradient(top, #4f5964 0%, #5f6975 40%);
			background: -webkit-linear-gradient(top, #4f5964 0%,#5f6975 40%);
		}
		
		nav ul li:hover a {
			color: #fff;
		}
		
		nav ul li a {
			display: block; padding: 25px 40px;
			color: #757575; text-decoration: none;
		}
		
		nav ul ul {
			background: #5f6975; border-radius: 0px; padding: 0;
			position: absolute; top: 100%;
		}
		nav ul ul li {
			float: none; 
			border-top: 1px solid #6b727c;
			border-bottom: 1px solid #575f6a;
			position: relative;
		}
		
		nav ul ul li a {
			padding: 15px 40px;
			color: #fff;
		}	
		
		nav ul ul li a:hover {
			background: #4b545f;
		}
		
		nav ul ul ul {
			position: absolute; left: 100%; top:0;
		}
    </style>
</head>
<body background="squared_metal.png">
<h1>Sort Query</h1>
<hr noshade size=5 width="100%">

	<nav class="buttoncenter">
		<ul>
			<li><a href="HomePage.php">Home</a></li>
			<li><a href="#">Functions</a>
				<ul>
					<li><a href="StatsRetrievalQuery.php">Retrieve</a></li>
					<li><a href="CompareQuery.php">Compare</a></li>
					<li><a href="SortQuery.php">Sort</a></li>
					<li><a href="StatsQuery.php">Statistical Queries</a></li>
				</ul>
			</li>
			<li><a href="Team.php">Team</a>			
			</li>
			<li><a href="Inspiration.php">Inspiration</a></li>
		</ul>
	</nav>



<form name="myform" method="post" action="#">
<div>
<font size="4">Select sport: </font>
<select name="box1" onchange="playerType(this.selectedIndex), Box3(this.selectedIndex)">
	<option>-Select a Sport-</option>
	<option>Baseball</option>
	<option>Basketball</option>
	<option>Hockey</option>
</select>
</div>
<div>
<font size="4">Select player type: </font>
<select name="playertype"></select>
</div>
<div>
<font size="4">Select Statistics Type: </font>
<select name="box3"></select>
</div>
<div>
<font size="4">Select data range: </font>
<select name="datarange">
  <option value = "5">Top 5</option>
  <option value = "10">Top 10</option>
  <option value = "20">Top 20</option>
  <option value = "50">Top 50</option>
  <option value = "100">Top 100</option>
</select>
</div>
<input type="submit" style = "color: green" value="Compute">
</form>
</body>
</html>
