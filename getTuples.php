#!/usr/local/bin/php
<?php
	$connection = oci_connect($username = 'weingart',
							  $password = 'bridgeoverlord201',
							  $connection_string = '//oracle.cise.ufl.edu/orcl');						  
	if (!$connection) {
		die('Could not connect');
	}
	$query = "";
	echo '<font size = "4">';
	echo "<b> Tuple Count </b> <br>";
	$statement = oci_parse($connection, $query);
	oci_execute($statement);
	echo "<table border='1'>\n";
	echo "<tr>\n";
	echo '<th>Total Tuples</th>';
	echo '</tr>';
	while ($row = oci_fetch_array($statement, OCI_ASSOC+OCI_RETURN_NULLS)) {
			
				foreach ($row as $item) {
					echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
				}
				echo "</tr>\n";
			}
			echo "</table><br>";
	oci_free_statement($statement);
?>
