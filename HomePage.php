#!/usr/local/bin/php
<html>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<head>
	<title>Next Episode</title>
	<meta name="keywords" content="Next Episode, homepage">
	<meta name="description" content="Next Episode Sports Database">
	<meta name="author" content="Derek Hua, Matt Weingarten, Xin He, Jesse Chau">
	<meta name="copyright" content="Copyright &copy 2014, All Rights Reserved">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans|Shadows+Into+Light|Rock+Salt|Stalinist+One">
	
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
			font-size: 36px;
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
		.banner-img {
			width: 100%;
		}
		
		.chooseoperation {
			text-align:center;
		}
		
        .buttoncenter {
			margin-top:10px;
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
		
		
		#summary{
			display:block;
			padding:0;
			border:100px;
			text-align:center;
			font-size:18px;
		}
		
		p {
			margin-right: 100px;
			margin-left: 100px;
			margin-bottom: 20px;
			align: center;
			color:#FFFFFF;
		}
		
		p.groove {border-style: groove;}
		
    </style>

	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript">
		$(function() {
		$('.fadein img:gt(0)').hide();

		setInterval(function () {
			$('.fadein :first-child').fadeOut()
									 .next('img')
									 .fadeIn()
									 .end()
									 .appendTo('.fadein');
		}, 7000); // 7 seconds
		});
	</script>
	
</head>

<body>

<div id="banner">
    <div id="wrapper">
        <div id="container">
                <img class="banner-img" src="NESBanner.png" alt="N.A.L.A. Apparel"/>
        </div>
    </div>
</div>


<nav class="buttoncenter">
	<ul>
		<font size="5"><li><a href="#">Functions</a>
			<ul>
				<li><a href="StatsRetrievalQuery.php">Retrieve</a></li>
				<li><a href="CompareQuery.php">Compare</a></li>
				<li><a href="SortQuery.php">Sort</a></li>
				<li><a href="StatsQuery.php">Statistical Queries</a></li>
			</ul>
		</li>
		<li><a href="Team.php">Team</a>			
		</li>
		<li><a href="Inspiration.php">Inspiration</a></li></font>
	</ul>
</nav>

<hr>

<!--
	<div class="fadein">
		<img src="http://icdn2.digitaltrends.com/image/6efb2224e7a20942e784a29d6e9ad1e2-4136x1424.jpg?ver=1" size="1920px 500px">
		<img src="horseheadnebula.jpg">
	</div>
	
-->

<div id ="summary">
	<table align="center">
			<tr>	<!-- table row -->
				<td> <div><h1>Welcome to Next Episode Sports!</h1></div> </td>		<!-- table column/data -->
			</tr>	
				
			<tr>
				<td> 
					<div id=summary>
						<p>This databases project will create a webpage that will contain a comprehensive sports database, </p>
						<p>covering basketball, baseball, and hockey. The webpage will allow the user to retrieve season-by-season </p>
						<p>and career stats for players, coaches, and teams, as well as see how many standard deviations a player, </p>
						<p>coach, or team falls below or above the mean in a certain statistic. The webpage will also allow the user </p>
						<p>to sort players, coaches, or teams by a certain statistic, as well as compare two or more players, coaches, </p>
						<p>or teams.</p>
						<br/>
						<hr>
					</div>
				</td>		
				
			</tr>
			
	</table>
</div>

</body></html>



