#!/usr/local/bin/php
<html>
<head>
    <title>Next Episode</title>
    <style>
        <style style="text/css">
        html {overflow-y: scroll}
        .buttoncenter {
            text-align:center;
        }
    </style>
</head>
<body bgcolor="#FFA500">
<h1 align = "center"><b><font size = 6>Welcome to Next Episode Sports!</font></b></h1>
<hr noshade size=5 width="100%">
<p align = "center"><font size = 4>Choose an operation:</font></p>
<div class="buttoncenter">
<form action = "process.php" method = "post">
<select name = "operationChoice" size = "1" required>
  <option value="StatsRetrieval">Retrieve Stats</option>
  <option value="ComparePlayers">Compare</option>
  <option value="Sort">Sort by Statistic</option>
  <option value="StatQueries">Statistical Queries</option>
</select>
<input type = "submit" style = "background-color: lightgreen"/>
</form>
<?php $selectedValue = $_POST['operationChoice']; echo $selectedValue; ?> 
</div>
</body></html>
