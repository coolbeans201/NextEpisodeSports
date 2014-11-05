#!/usr/local/bin/php
<html>

<head>
	<title>Stats Retrieval Query</title>
	<meta name="keywords" content="Next Episode, stats retrieval query">
	<meta name="description" content="Next Episode Sports Database">
	<meta name="author" content="Derek Hua, Matt Weingarten, Xin He, Jesse Chau">
	<meta name="copyright" content="Copyright &copy 2014, All Rights Reserved">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans|Shadows+Into+Light|Rock+Salt">
	
	<script type="text/javascript">
	var players =[
	[],
	["Manager","Pitcher","Position Player","Team"],
	["Coach","Player","Team"],
	["Coach","Goalie","Position Player","Team"]
	]

	function PlayerType(idx) {
	var f=document.myform;
	f.playertype.options.length=null;
	for(i=0; i<players[idx].length; i++) {
		f.playertype.options[i]=new Option(players[idx][i], players[idx][i]); 
		}    
	}
	onload=function() {PlayerType(0);};
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
		 ajaxRequest.open("GET", "getnames2.php" + queryString, true);
		 ajaxRequest.send(null); 
	}

	function ajaxStatsRetrieval(){
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
		 var playername = document.getElementById('name1').value;
		 
		 var queryString = "?sport=" + sport ;
		 queryString +=  "&playertype=" + playertype;
		 queryString += "&playername=" + playername;
		 ajaxRequest.open("GET", "getStatsRetrieval.php" + queryString, true);
		 ajaxRequest.send(null); 
	}
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
		#footer {
    			position : absolute;
    			bottom : 0;
    			height : 40px;
    			align : left;
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
</head>
<body background="squared_metal.png">
<h1>Stats Retrieval Query</h1>
<hr noshade size=5 width="100%">
<nav class="buttoncenter">
	<ul>
		<li><a href="HomePage.php">Home</a>
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

<form name="myform" method="post">
<div>
<font size = "4">Select sport:</font>
<select name="sport" id = "sport" onchange="PlayerType(this.selectedIndex); ajaxFunction();">
    <option value="a">-Select a Sport-</option>
    <option value="Baseball">Baseball</option>
    <option value="Basketball">Basketball</option>
    <option value="Hockey">Hockey</option>
</select>
</div>
<div>
<font size = "4">Select player type:</font>
<select name="playertype" id = "playertype" onchange = "ajaxFunction();"></select>
</div>
<div id='ajaxDiv'>Names will be loaded here</div>
<input type= "button" style = "color:green" value="Compute" onclick="ajaxStatsRetrieval();"></input> <!--Button-->
</form>
<div id='textBoxDiv'></div>
</body>
</html>

