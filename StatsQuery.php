#!/usr/local/bin/php
<html>

<head>
	<title>Stats Query</title>
	<meta name="keywords" content="Next Episode, stats query">
	<meta name="description" content="Next Episode Sports Database">
	<meta name="author" content="Derek Hua, Matt Weingarten, Xin He, Jesse Chau">
	<meta name="copyright" content="Copyright &copy 2014, All Rights Reserved">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans|Shadows+Into+Light|Rock+Salt">
	
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
			font-size: 20px;
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
<script>
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
</script>
<script type = "text/javascript">
function ajaxFunction2(){
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
			  var ajaxDisplay = document.getElementById('ajaxDiv2');
			  ajaxDisplay.innerHTML = ajaxRequest.responseText;
		   }
		 }
		 // Now get the value from user and pass it to
		 // server script.
		 var sport = document.getElementById('sport1').value;
		 var playertype = document.getElementById('playerType1').value;
		 var queryString = "?sport=" + sport ;
		 queryString +=  "&playertype=" + playertype;
		 ajaxRequest.open("GET", "getcolumns.php" + queryString, true);
		 ajaxRequest.send(null); 
}
</script>
<script type = "text/javascript">
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
		 var sport = document.getElementById('sport1').value;
		 var playertype = document.getElementById('playerType1').value;
		 var queryString = "?sport=" + sport ;
		 queryString += "&playertype=" + playertype;
		 ajaxRequest.open("GET", "getYears.php" + queryString, true);
		 ajaxRequest.send(null); 
}
</script>
<script type = "text/javascript">
function ajaxStats(){
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
			  var ajaxDisplay = document.getElementById('ResultDiv');
			  ajaxDisplay.innerHTML = ajaxRequest.responseText;
		   }
		 }
		 // Now get the value from user and pass it to
		 // server script.
		 var sport = document.getElementById('sport1').value;
		 var playertype = document.getElementById('playerType1').value;
		 var operation = document.getElementById('operation1').value;
		 var stats = document.getElementById('stats').value;
		 var begYear = document.getElementById('year1').value;
		 var endYear = document.getElementById('year2').value;
		 var queryString = "?sport=" + sport;
		 queryString += "&playertype=" + playertype;
		 queryString += "&operation=" + operation;
		 queryString += "&stats=" + stats;
		 queryString += "&begYear=" + begYear;
		 queryString += "&endYear=" + endYear;
		 ajaxRequest.open("GET", "getStats.php" + queryString, true);
		 ajaxRequest.send(null);
</script>
</head>
<body background="squared_metal.png">
<h1>Stats Query</h1>
<hr noshade size=5 width="100%">
<nav class="buttoncenter">
	<ul>
		<li><a href = "HomePage.php">Home</a></li>
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
<form name = "myForm" method = "post">
<div>
<font size = "4">Select sport: </font>
<select name = "sport" id = "sport1" onChange = "setOptions(document.myForm.sport.options[document.myForm.sport.selectedIndex].value, document.myForm.playerType); ajaxFunction2(); ajaxFunction();">
	<option value = "selectasport" selected = "selected">-Select a Sport-</option>
	<option value = "Baseball">Baseball</option>
	<option value = "Basketball">Basketball</option>
	<option value = "Hockey">Hockey</option>
</select>
</div>
<div>
<font size = "4">Select player type:</font>
<select name = "playerType" id = "playerType1" onchange = "ajaxFunction2(); ajaxFunction();"></select>
</div>
<div>
<font size = "4">Select an operation:</font>
<select name = "operation" id = "operation1">
	<option value = "average">Average</option>
	<option value = "min">Minimum</option>
	<option value = "max">Maximum</option>
	<option value = "standardDeviation">Standard Deviation</option>
</select>
</div>
<div id = "ajaxDiv2">Statistics will be loaded here</div>
<div>
<div id='ajaxDiv'>Date ranges will be loaded here</div>
<input type= "button" style = "color:green" value="Compute" onclick="ajaxStats();"></input>
</form>
<div id = "ResultDiv"></div>
</body>
</html>


