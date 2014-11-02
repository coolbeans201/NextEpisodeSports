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
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script type="text/javascript">
	var varieties=[
	[],
	["Manager","Pitcher","Position Player","Team"],
	["Coach","Player","Team"],
	["Coach","Goalie","Position Player","Team"]
	];

	function Box2(idx) {
	var f=document.myform;
	f.box2.options.length=null;
	for(i=0; i<varieties[idx].length; i++) {
		f.box2.options[i]=new Option(varieties[idx][i], i); 
		}    
	}
	
	function Box3(idx) {
	var f=document.myform;
	f.box3.options.length=null;
	for(i=0; i<varieties[idx].length; i++) {
		f.box3.options[i]=new Option(varieties[idx][i], i); 
		}    
	}
	
	onload=function() {Box2(0); Box3(0)};
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
	<h1>Compare Query</h1>

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
	
	
	<form name="myform" method="post" action="CompareResult.php">
		<div>
			<font size = "4"> Select sport: <select name="box1" onchange="Box2(this.selectedIndex)" onchange="Box3(this.selectedIndex)">
				<option value="a">-Select a Sport-</option>
				<option value="b">Baseball</option>
				<option value="c">Basketball</option>
				<option value="d">Hockey</option>
			</select></font></div>
			<div><font size = "4"> Select player type: <select name="box2"></select></font></div>
			<div><font size = "4"> Select name: <select name = "box3"></select></font></div>
			<div><font size = "4"> vs. </font></div>
			<div><font size = "4">Select name: <select name="box3"></select></font></div>
	<input type="submit" style = "color: green" value="Compute">
	</form>
</body>
</html>
