#!/usr/local/bin/php
<html>
<head>
	<title>Team</title>
	<meta name="keywords" content="Next Episode, team">
	<meta name="description" content="Next Episode Sports Database">
	<meta name="author" content="Derek Hua, Matt Weingarten, Xin He, Jesse Chau">
	<meta name="copyright" content="Copyright &copy 2014, All Rights Reserved">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans|Shadows+Into+Light|Rock+Salt|Open+Sans+Condensed">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
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
			background-color: #F9F4E1;
     	}
		
		.chooseoperation {
			text-align:center;
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
		
		#main {
			margin-left: 250px;
			margin-right: 250px;
			font-family: 'Shadows Into Light', sans-serif;
			font-size: 36px;
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
<h1>Team</h1>
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
<div id=main>
	<table >
		<colgroup>
			<col span="1" style="width: 75%;">
			<col span="1" style="width: 25%;">
		</colgroup>
		<tr> 
			<td> <p><b><u>Jesse Chau</u></b></p> </td>
			<td> PIC </td>
		</tr>	
		<tr> 
			<td> <p><b><u>Xin He</u></b></p> </td>
			<td> <img src="https://fbcdn-sphotos-d-a.akamaihd.net/hphotos-ak-xpf1/v/t1.0-9/304095_2413614714151_327036085_n.jpg?oh=751118a2b7f9fd35c471e1327713e4ac&oe=54F47EA7&__gda__=1423248366_b69ff1e3a905b0174196f83c7390a541" height = "100"/> </td>
		</tr>
		<tr> 
			<td> <p><b><u>Derek Hua</u></b><br/>My name is Derek Hua and I'm a 3rd year Computer Science & Engineering student at the University of Florida. I am currently seeking opportunities to apply myself in the form of a technical Co-Op or an internship. I am not only seeking opportunities that will test my technical knowledge, but ones that will also encourage me to step out of my comfort zone, actively learn, and connect with others.</p> </td>
			<td> PIC </td>
		</tr>
		<tr> 
			<td> <p><b><u>Matt Weingarten</u></b><br/>Matt is a third-year Computer Science major with minors in Mathematics and Statistics from Safety Harbor, FL. In his free time, he likes to watch and play sports (hence, the inspiration for this website), play video games, and play Bridge. He never regrets being a Computer Science major, even though the projects that it entails can be time-consuming.</p> </td>
			<td> PIC </td>
		</tr>
	</table>
</div>
</body></html>
