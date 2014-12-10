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
		
	
		
		
		table {
			width: 65%;
		}
		td {
			text-align: center;
			 padding: 15px;
		}
		
		
    </style>

</head>
<body>
	<div id="banner">
    <div id="wrapper">
        <div id="container">
                <img class="banner-img" src="NESBanner.png" alt=""/>
        </div>
    </div>
	</div>
	
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
	
		<div>
			<table align="center">
				<colgroup>
					<col span="1" style="width: 65%;">
					<col span="1" style="width: 35%;">
				</colgroup>
				<tr> 
					<td> <p style="color:white"><b><u>Jesse Chau</u></b><br/>A country boy in his origins, Jesse was born in Clyde, North Carolina. He and his family hovered around the southern states north of Florida until the day the Sunlight called to them to venture down to Sunny South Florida. Jesse essentially grew up in Florida having lived there for one-fourth of his young life. It is no coincidence that his future bastion of education would be the University of Florida. A computer science major with a physics minor, his prevailing fascination in computers and science ended up becoming the focal point of his life, something he would not want any other way.</p> </td>
					<td> <img src="https://scontent-b-mia.xx.fbcdn.net/hphotos-xfa1/v/t1.0-9/p417x417/393080_10151642856640833_1186289759_n.jpg?oh=226b96a499931729a658068c4dd3f6fe&oe=550D5EA5" height = "100" /> </td>
				</tr>	
				<tr> 
					<td> <p style="color:white"><b><u>Xin He</u></b><br/>Xin is a third-year Computer Science major with a minor in Business Administration from Boca Raton, FL. In his free time, Xin likes to watch movies, browse the Internet, and play Planetside 2, a computer game he has dedicated much of his time to. He hopes to land an internship for the summer and beyond.</p></td>
					<td> <img src="https://fbcdn-sphotos-d-a.akamaihd.net/hphotos-ak-xpf1/v/t1.0-9/304095_2413614714151_327036085_n.jpg?oh=751118a2b7f9fd35c471e1327713e4ac&oe=54F47EA7&__gda__=1423248366_b69ff1e3a905b0174196f83c7390a541" height = "100" /> </td>
				</tr>
				<tr> 
					<td> <p style="color:white"><b><u>Derek Hua</u></b><br/>Derek is a third-year Computer Science and Engineering major with a minor in Business Administration from Boca Raton, FL. His interests include, programming, weight-lifting, cooking, and discovering new hobbies. He is currently seeking opportunities to apply himself in the form of a technical Co-Op or an internship. He not only seeking opportunities that will test my technical knowledge, but ones that will also encourage me to step out of my comfort zone, actively learn, and connect with others.</p> </td>
					<td> <img src="https://scontent-a-mia.xx.fbcdn.net/hphotos-xpa1/v/t1.0-9/p417x417/10433079_401682496648066_6183619574339687075_n.jpg?oh=936862b69bef7511e5e9c1cc075e9072&oe=54FBC559" height = "100"/></td>
				</tr>
				<tr> 
					<td> <p style="color:white"><b><u>Matt Weingarten</u></b><br/>Matt is a third-year Computer Science major with minors in Mathematics and Statistics from Safety Harbor, FL. In his free time, he likes to watch and play sports (hence, the inspiration for this website), play video games, and play Bridge. He never regrets being a Computer Science major, even though the projects that it entails can be time-consuming.</p> </td>
					<td> <img src="https://scontent-b-mia.xx.fbcdn.net/hphotos-xpa1/v/t1.0-9/1920334_10203996137276308_8992998182298037988_n.jpg?oh=703adef206b1629659d03624303816d7&oe=551A3C78" height = "100" /> </td>
				</tr>
			</table>
		</div>
	
</body></html>
