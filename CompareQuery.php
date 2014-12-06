#!/usr/local/bin/php
<!--compare-->
<html>
<head>
	<title>Compare Query</title>
	<meta name="keywords" content="Next Episode, compare query">
	<meta name="description" content="Next Episode Sports Database">
	<meta name="author" content="Derek Hua, Matt Weingarten, Xin He, Jesse Chau">
	<meta name="copyright" content="Copyright &copy 2014, All Rights Reserved">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans|Shadows+Into+Light|Rock+Salt">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	
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
		selBox.options[selBox.options.length] = new Option('Position Player', 'Position Player');
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
	onload=function() {Box2(0);};
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
		 ajaxRequest.open("GET", "getname.php" + 
									  queryString, true);
		 ajaxRequest.send(null); 
	}
	
	function ajaxCompareQuery(){
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
			  var ajaxDisplay = document.getElementById('compareDiv');
			  ajaxDisplay.innerHTML = ajaxRequest.responseText;
		   }
		 }
		 // Now get the value from user and pass it to
		 // server script.
		 var sport = document.getElementById('sport').value;
		 var playertype = document.getElementById('playertype').value;
		 var playerid = document.getElementById('name1').value;
		 var playerid2 = document.getElementById('name2').value;
		 
		 var queryString = "?sport=" + sport;
		 queryString +=  "&playertype=" + playertype;
		 queryString += "&playerid=" + playerid;
		 queryString += "&playerid2=" + playerid2;
		 ajaxRequest.open("GET", "getCompareQuery.php" + queryString, true);
		 ajaxRequest.send(null); 
	}
	</script>
	

    <style style="text/css">
	  .datagrid table { border-collapse: collapse; text-align: left; width: 100%; } 
	.datagrid {
					
					font: Arial, Helvetica, sans-serif; 
					background: #fff; overflow: hidden; border: 10px solid #36752D; 
					-webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; 
					}
		.datagrid table td, .datagrid table th { padding: 3px 10px; }
		.datagrid table thead th {background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #36752D), color-stop(1, #275420) );background:-moz-linear-gradient( center top, #36752D 5%, #275420 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#36752D', endColorstr='#275420');background-color:#36752D; color:#FFFFFF; font-size: 15px; font-weight: bold; border-left: 1px solid #36752D; } .datagrid table thead th:first-child { border: none; }.datagrid table tbody td { color: #275420; border-left: 1px solid #C6FFC2;font-size: 20px;font-weight: normal; }.datagrid table tbody .alt td { background: #DFFFDE; color: #275420; }.datagrid table tbody td:first-child { border-left: none; }.datagrid table tbody tr:last-child td { border-bottom: none; }.datagrid table tfoot td div { border-top: 1px solid #36752D;background: #DFFFDE;} .datagrid table tfoot td { padding: 0; font-size: 18px } .datagrid table tfoot td div{ padding: 2px; }.datagrid table tfoot td ul { margin: 0; padding:0; list-style: none; text-align: right; }.datagrid table tfoot  li { display: inline; }.datagrid table tfoot li a { text-decoration: none; display: inline-block;  padding: 2px 8px; margin: 1px;color: #FFFFFF;border: 10px solid #36752D;-webkit-border-radius: 10px; -moz-border-radius: 10px; border-radius: 10px; background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #36752D), color-stop(1, #275420) );background:-moz-linear-gradient( center top, #36752D 5%, #275420 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#36752D', endColorstr='#275420');background-color:#36752D; }.datagrid table tfoot ul.active, .datagrid table tfoot ul a:hover { text-decoration: none;border-color: #275420; color: #FFFFFF; background: none; background-color:#36752D;}div.dhtmlx_window_active, div.dhx_modal_cover_dv { position: fixed !important; }
    
    
    
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
		
		.black{
			color:#000000
		}
		
		.query{
			background: #efefef; 
			background: linear-gradient(top, #efefef 0%, #bbbbbb 100%);  
			background: -moz-linear-gradient(top, #efefef 0%, #bbbbbb 100%); 
			background: -webkit-linear-gradient(top, #efefef 0%,#bbbbbb 100%); 
		}
		
		.banner-img {
			width: 100%;
		}
		
		 .buttoncenter {
            text-align:center;
			font-size: 24px;
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

<body>
	
	<div id="banner">
    <div id="wrapper">
        <div id="container">
                <img class="banner-img" src="NESBanner.png" alt="N.A.L.A. Apparel"/>
        </div>
    </div>
	</div>
	
	<h1>Compare Query</h1>

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
	
	<div  class = "query">
		<form name="myform" method="post">
		<div>
			<font size = "4"> Select sport: <select name="box1" id="sport" onchange="setOptions(document.myform.box1.options[document.myform.box1.selectedIndex].value, document.myform.box2); ajaxFunction();">
				<option value="a" selected = "selected">-Select a Sport-</option>
				<option value="Baseball">Baseball</option>
				<option value="Basketball">Basketball</option>
				<option value="Hockey">Hockey</option>
			</select></font></div>
			<div ><font size = "4">Select player type: <select name="box2" class="black" id="playertype" onchange='ajaxFunction()'></select></font></div>
			<div id='ajaxDiv'> <p >Your result will display here</p></div>
			<div id = 'buttonDiv'>&nbsp;
			<input type= "button" class="btn btn-success" style = "color:white" value="Compute" onclick="ajaxCompareQuery();"></input> <!--Button-->
			</div>
			</form>
		<nav class="datagrid ">
		<div id='compareDiv'></div>
		</nav>
	<div/>	
</body>
</html>	
