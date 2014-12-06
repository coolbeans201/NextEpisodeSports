#!/usr/local/bin/php
<html>

<head>
	<title>Sort Query</title>
	<meta name="keywords" content="Next Episode, sort query">
	<meta name="description" content="Next Episode Sports Database">
	<meta name="author" content="Derek Hua, Matt Weingarten, Xin He, Jesse Chau">
	<meta name="copyright" content="Copyright &copy 2014, All Rights Reserved">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans|Shadows+Into+Light|Rock+Salt">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

	<script type="text/javascript">
	function setOptions(chosen, selBox){
	selBox.options.length = 0;
	if (chosen == "selectasport")
	{
	}
	if (chosen == "Baseball")
	{
		selBox.options[selBox.options.length] = new Option('Manager', 'Manager');
		selBox.options[selBox.options.length] = new Option('Pitcher', 'Pitcher');
		selBox.options[selBox.options.length] = new Option('Position Player Batting', 'Position Player Batting');
		selBox.options[selBox.options.length] = new Option('Position Player Fielding', 'Position Player Fielding');
		selBox.options[selBox.options.length] = new Option('Team', 'Team');
	}
	if (chosen == "Basketball")
	{
		selBox.options[selBox.options.length] = new Option('Coach', 'Coach');
		selBox.options[selBox.options.length] = new Option('Player', 'Player');
		selBox.options[selBox.options.length] = new Option('Team', 'Team');
	}
	if (chosen == "Hockey")
	{
		selBox.options[selBox.options.length] = new Option('Coach', 'Coach');
		selBox.options[selBox.options.length] = new Option('Goalie', 'Goalie');
		selBox.options[selBox.options.length] = new Option('Position Player', 'Position Player');
		selBox.options[selBox.options.length] = new Option('Team', 'Team');
	}
	}
	function ajaxFunction(){
		 var ajaxRequest;  // The variable that makes Ajax possible!
			
		 try{
		   // Opera 8.0+, Firefox, Safari
		   ajaxRequest = new XMLHttpRequest();
		 }catch (e){
		   // Internet Explorer Browsers
		   try{
			  ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		   }catch (e) {
			  try{
				 ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			  }catch (e){
				 // Something went wrong
				 alert("Your browser broke!");
				 return false;
			  }
		   }
		 }
		 // Create a function that will receive data 
		 // sent from the server and will update
		 // div section in the same page.
		 ajaxRequest.onreadystatechange = function(){
		   if(ajaxRequest.readyState == 4){
			  var ajaxDisplay = document.getElementById('ajaxDiv');
			  ajaxDisplay.innerHTML = ajaxRequest.responseText;
		   }
		 }
		 // Now get the value from user and pass it to
		 // server script.
		 var sport = document.getElementById('sport').value;
		 var playertype = document.getElementById('playertype').value;
		 var queryString = "?sport=" + sport ;
		 queryString +=  "&playertype=" + playertype;
		 ajaxRequest.open("GET", "getcolumns.php" + queryString, true);
		 ajaxRequest.send(null);  
	}
	
		function ajaxSortRetrieval(){
		 var ajaxRequest;  // The variable that makes Ajax possible!
			
		 try{
		   // Opera 8.0+, Firefox, Safari
		   ajaxRequest = new XMLHttpRequest();
		 }catch (e){
		   // Internet Explorer Browsers
		   try{
			  ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		   }catch (e) {
			  try{
				 ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			  }catch (e){
				 // Something went wrong
				 alert("Your browser broke!");
				 return false;
			  }
		   }
		 }
		 // Create a function that will receive data 
		 // sent from the server and will update
		 // div section in the same page.
		 ajaxRequest.onreadystatechange = function(){
		   if(ajaxRequest.readyState == 4){
			  var ajaxDisplay = document.getElementById('textBoxDiv');
			  ajaxDisplay.innerHTML = ajaxRequest.responseText;
		   }
		 }
		 // Now get the value from user and pass it to
		 // server script.
		 var sport = document.getElementById('sport').value;
		 var playertype = document.getElementById('playertype').value;
		 var stats = document.getElementById('stats').value;
		 var range = document.getElementById('range').value;
		 
		 var queryString = "?sport=" + sport;
		 queryString +=  "&playertype=" + playertype;
		 queryString += "&stats=" + stats;
		 queryString += "&range=" + range;
		 ajaxRequest.open("GET", "getSortRetrieval.php" + queryString, true);
		 ajaxRequest.send(null);
		 }
		 
		 function ajaxSortLifetimeRetrieval(){
		 var ajaxRequest;  // The variable that makes Ajax possible!
			
		 try{
		   // Opera 8.0+, Firefox, Safari
		   ajaxRequest = new XMLHttpRequest();
		 }catch (e){
		   // Internet Explorer Browsers
		   try{
			  ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		   }catch (e) {
			  try{
				 ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			  }catch (e){
				 // Something went wrong
				 alert("Your browser broke!");
				 return false;
			  }
		   }
		 }
		 // Create a function that will receive data 
		 // sent from the server and will update
		 // div section in the same page.
		 ajaxRequest.onreadystatechange = function(){
		   if(ajaxRequest.readyState == 4){
			  var ajaxDisplay = document.getElementById('textBoxDiv');
			  ajaxDisplay.innerHTML = ajaxRequest.responseText;
		   }
		 }
		 // Now get the value from user and pass it to
		 // server script.
		 var sport = document.getElementById('sport').value;
		 var playertype = document.getElementById('playertype').value;
		 var stats = document.getElementById('stats').value;
		 var range = document.getElementById('range').value;
		 
		 var queryString = "?sport=" + sport;
		 queryString +=  "&playertype=" + playertype;
		 queryString += "&stats=" + stats;
		 queryString += "&range=" + range;
		 ajaxRequest.open("GET", "getSortLifetimeRetrieval.php" + queryString, true);
		 ajaxRequest.send(null); 
	}
	
	</script>
	
    <style>
        <style style="text/css">
        html {overflow-y: scroll}
        
		h1 {
			font-family: 'Rock Salt', sans-serif;
			font-size: 26px;
			font-weight: normal;
			color:#FFFFFF;
			text-align: center;
			text-shadow: 2px 2px #000000;
			padding-bottom: 15px;
		}
		
		body {
			font-size: 16px;
			background-color: #F9F4E1;
			background-image: url("black-gradient-background.png");
			background-size: 100% 100%;
			background-repeat: no-repeat;
     	}
		
		.wrapper {
			width: 100%;
			overflow: hidden;
		}
		.container {
			width: 100%;
			margin: 0 auto;
		}
		
		.white{
			color:#FFFFFF
		}
		.banner-img {
			width: 100%;
		}
		
		 .buttoncenter {
            text-align:center;
			font-size: 24px;
        }
		
		.chooseoperation {
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
		
		hr{
			border: 0;
			color: #9E9E9E;
			background-color: #9E9E9E;
			height: 5px;
			width: 100%;
			text-align: left;
		}
    </style>
</head>
<body >

<div id="banner">
    <div id="wrapper">
        <div id="container">
                <img class="banner-img" src="NESBanner.png" alt="N.A.L.A. Apparel"/>
        </div>
    </div>
</div>

<h1>Sort Query</h1>
<hr>
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
	
<div class = "white">
	<form name="myform" method="post">
	<div>
	<font size="4">Select sport: </font>
	<select name="box1" id = "sport" onchange="setOptions(document.myform.box1.options[document.myform.box1.selectedIndex].value, document.myform.playertype); ajaxFunction();">
		<option value = "a" selected = "selected">-Select a Sport-</option>
		<option value = "Baseball">Baseball</option>
		<option value = "Basketball">Basketball</option>
		<option value = "Hockey">Hockey</option>
	</select>
	</div>
	<div>
	<font size="4">Select player type: </font>
	<select name="playertype" id = "playertype" onchange = "ajaxFunction();"></select>
	</div>
	<div id = "ajaxDiv">Column names will be loaded here</div>
	<div>
	<font size="4">Select data range: </font>
	<select name="datarange" id = "range">
	  <option value = "5">Top 5</option>
	  <option value = "10">Top 10</option>
	  <option value = "20">Top 20</option>
	  <option value = "50">Top 50</option>
	  <option value = "100">Top 100</option>
	</select>
	</div>
	<div>&nbsp;
	<input type= "button" class="btn btn-success" style = "color:white" value="Compute Per Year" onclick="ajaxSortRetrieval();"></input>
	<input type= "button" class="btn btn-primary" style = "color:white" value="Compute Lifetime" onclick="ajaxSortLifetimeRetrieval();"></input>
	</div>
	</form>
	<div id='textBoxDiv'></div>
	</body>

</div>
</html>
