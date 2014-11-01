#!/usr/local/bin/php
<html>

<head>
	<title>NExt Episode</title>
	<meta name="keywords" content="Next Episode, homepage">
	<meta name="description" content="Next Episode Sports Database">
	<meta name="author" content="Derek Hua, Matt Weingarten, Xin He, Jesse Chau">
	<meta name="copyright" content="Copyright &copy 2014, All Rights Reserved">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans|Shadows+Into+Light|Alegreya+Sans+SC|Rock+Salt|Fredericka+the+Great">
	
    <style>
        <style style="text/css">
        
		h1 {
			
		}
		
		 body {
			font-family: 'Open Sans', sans-serif;
			font-size: 24px;
			background-image: url("park_firework.jpg");
			background-repeat: no-repeat;
			background-color: #FFFFFF;
			background-position: center top;
			background-size: 1920px;
			
     	}
				
        .buttoncenter {
            text-align:center;
			margin-top:127px;
        }
        
		#pagetitle{
			margin-top:150px;
			font-family: 'Rock Salt', sans-serif;
			font-size: 36px;
			color:#FFFFFF;
			text-align: center;
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
	
    </style>

</head>

<body>

	<div id=pagetitle>
		<h1>N E X T &nbsp E P I S O D E &nbsp S P O R T S</h1> 
	</div>

	
	<div  class="buttoncenter">
		<nav>
			<ul>
				<li><a href="#">Functions</a>
					<ul>
						<li><a href="StatsRetrievalQuery.php">Retrieve</a></li>
						<li><a href="CompareQuery.php">Compare</a></li>
						<li><a href="SortQuery.php">Sort</a></li>
						<li><a href="StatsQuery.php">Statistical Queries</a></li>
					</ul>
				</li>
				<li><a href="#">Team</a>
					
				</li>
				<li><a href="#">Inspiration</a></li>
			</ul>
		</nav>
	</div>


</body>
</html>










