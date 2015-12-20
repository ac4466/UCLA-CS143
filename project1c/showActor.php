<html>
	<head>
		<link type="text/css" rel="stylesheet" href="stylesheet.css"/>
		<title>Show Actor Info</title>
	</head>
	<body bgcolor="#DFE2E5">
		<div>
			<h3>Actor Information</h3>
			<?php
				$aid = $_GET["id"];
				
				if ($aid != "")
				{
					$db_connection = mysql_connect("localhost", "cs143", "");
					mysql_select_db("CS143", $db_connection);

					$query = "SELECT last, first, sex, dob, dod FROM Actor WHERE id = $aid;";
					$res = mysql_query($query, $db_connection) or exit(mysql_error());
					$row = mysql_fetch_row($res);
					mysql_free_result($res);
					
					$last = $row[0];
					$first = $row[1];
					$sex = $row[2];
					$dob = $row[3];
					$dod = $row[4];
					
					echo "Name: $first $last<br/>";
					echo "Sex: $sex<br/>";
					echo "Date of Birth: $dob<br/>";
					if ($dod == null)
						echo "Date of Death: N/A<br/><hr>";
					else
						echo "Date of Death: $dod<br/><hr>";
					
					echo "<h3>Movies with $first $last</h3>";
					
					$query = "SELECT role, mid, title, year FROM Movie, MovieActor WHERE aid = $aid AND mid = id ORDER BY year;";
					$res = mysql_query($query, $db_connection) or exit(mysql_error());
					while ($row = mysql_fetch_row($res)) {
						echo "\"$row[0]\" in <a href=\"showMovie.php?id=$row[1]\">",$row[2]," (",$row[3],")</a><br/>";
					}
					
					mysql_close($db_connection);
				}
			?>
		</div>
	</body>
</html>