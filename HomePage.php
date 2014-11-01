#!/usr/local/bin/php
<html><head><title>Home Page</title></head>
<style>
	html {overflow-y: scroll}
</style>
<body bgcolor="#FFA500">
<p align = "center"><b><font size = 6>Welcome to Next Episode Sports!</font></b></p>
<hr noshade size=5 width="100%">
<p align = "center"><font size = 4>Choose an operation:</font></p>
<select name = "operationChoice" size = "1" required>
  <option value="StatsRetrieval">Retrieve Stats</option>
  <option value="ComparePlayers">Compare</option>
  <option value="Sort">Sort by Statistic</option>
  <option value="StatQueries">Statistical Queries</option>
</select>
<a href="http://cise.ufl.edu/~weingart">
    <button type = "submit" style = "background-color: lightgreen">Go</button>
</a>
</body></html>
