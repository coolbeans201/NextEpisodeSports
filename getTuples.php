#!/usr/local/bin/php
<?php
	$connection = oci_connect($username = 'weingart',
							  $password = 'bridgeoverlord201',
							  $connection_string = '//oracle.cise.ufl.edu/orcl');						  
	if (!$connection) {
		die('Could not connect');
	}
	$query = "SELECT a.aCount + b.bCount + c.cCount + d.dCount+ e.eCount + f.fCount + g.gCount + h.hCount + i.iCount + j.jCount + k.kCount + l.lCount + m.mCount + n.nCount + o.oCount + p.pCount + q.qCount + r.rCount + s.sCount + t.tCount
					 from(select COUNT(*) aCount from BasketballCoaches) a, 
					 (select count(*) bCount from basketballplayers) b,
					 (select count(*) cCount from basketballplayerallstar) c,					 
					 (select count(*) dCount from basketballteams) d,
					 (select count(*) eCount from hockeycoaches) e,
					 (select count (*) fCount from hockeygoalies) f, 
					 (select count(*) gCount from hockeygoaliesshootout) g,
					 (select count(*) hCount from hockeyscoring) h,
					 (select count(*) iCount from hockeyscoringshootout) i, 
					 (select count(*) jCount from hockeyteams) j,
					 (select count(*) kCount from hockeyteamspostseason) k, 
					 (select count(*) lCount from hockeyteamssplit) l, 
					 (select count(*) mCount from baseballmanagers) m,
					 (select count(*) nCount from baseballpitching) n,
					 (select count(*) oCount from baseballpitchingpostseason) o,
					 (select count(*) pCount from baseballbatting) p,
					 (select count(*) qCount from baseballbattingpostseason) q,
					 (select count(*) rCount from baseballfielding) r,
					 (select count(*) sCount from baseballfieldingpostseason) s,
					 (select count(*) tCount from baseballteams) t";
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
