<html>
	<head>
		<link type="text/css" rel="stylesheet" href="stylesheet.css"/>
		<title>Show Movie Info</title>
	</head>
	<body bgcolor="#DFE2E5">
		<div class="left">
			<h3>Movie Information</h3>
			<?php
				$mid = $_GET["id"];

				if ($mid != "")
				{
					$db_connection = mysql_connect("localhost", "cs143", "");
					mysql_select_db("CS143", $db_connection);

					$query = "SELECT title, year, rating, company FROM Movie WHERE id = $mid;";
					$res = mysql_query($query, $db_connection) or exit(mysql_error());
					$row = mysql_fetch_row($res);
					mysql_free_result($res);
					
					$title = $row[0];
					$year = $row[1];
					$rating = $row[2];
					$company = $row[3];

					echo "Title: $title<br/>";
					echo "Year: $year<br/>";
					echo "MPAA Rating: $rating<br/>";
					if ($company == null)
						echo "Company: N/A<br/>";
					else
						echo "Company: $company<br/>";
					
					$query = "SELECT first, last, dob FROM MovieDirector, Director WHERE mid = $mid AND did = id ORDER BY first;";
					$res = mysql_query($query, $db_connection) or exit(mysql_error());
					echo "Director(s): ";
					
					$comma = false;
					while ($row = mysql_fetch_row($res)) {
						if ($comma)
							echo ", ";
						else
							$comma = true;
						echo "$row[0] $row[1] ($row[2])";
					}
					if (!$comma)
						echo "N/A<br/>";
					else
						echo "<br/>";
					mysql_free_result($res);

					$query = "SELECT DISTINCT genre FROM MovieGenre WHERE mid = $mid ORDER BY genre;";
					$res = mysql_query($query, $db_connection) or exit(mysql_error());
					echo "Genre(s): ";
					
					$comma = false;
					while ($row = mysql_fetch_row($res)) {
						if ($comma)
							echo ", ";
						else
							$comma = true;
						echo "$row[0]";
					}
					if (!$comma)
						echo "None listed<br/><hr>";
					else
						echo "<br/><hr>";
					mysql_free_result($res);
					
					echo "<h3>Actors in \"$title\"</h3>";
					$query = "SELECT id, first, last, dob, role FROM Actor, MovieActor WHERE mid = $mid AND aid = id;";
					$res = mysql_query($query, $db_connection) or exit(mysql_error());
					while ($row = mysql_fetch_row($res))
						echo "<a href=\"showActor.php?id=$row[0]\">",$row[1]," ",$row[2]," (",$row[3],")</a> as \"$row[4]\"<br/>";
					mysql_free_result($res);
				}
			?>
		</div>
		<div class="right">
			<h3>User Reviews</h3>
			<?php
				echo "<a href=\"addMovieReview.php?id=$mid\" target=\"main\">Submit a review</a><br/>";
				echo "Average Rating: ";
				$query = "SELECT COUNT(*), AVG(rating) FROM Review WHERE mid = $mid;";
				$res = mysql_query($query, $db_connection) or exit(mysql_error());
				$row = mysql_fetch_row($res);
				if ($row[0] == 0)
					echo "N/A<br/>";
				else
					printf("%.2f / 10 from %d review(s).<br/>", $row[1], $row[0]);
				
				$query = "SELECT name, time, rating, comment FROM Review WHERE mid = $mid;";
				$res = mysql_query($query, $db_connection) or exit(mysql_error());
				while ($row = mysql_fetch_row($res)) {
					$name = $row[0];
					$time = $row[1];
					$rating = $row[2];
					$comment = $row[3];
					
					echo "<hr>On $time, ";
					if ($name == null)
						echo '<font color="gray">Anonymous</font>';
					else
						echo "<font color=\"blue\">$name</font>";
					echo " rated $rating/10<br/>";
					echo "Comments: $comment";
				}
			?>
		</div>
	</body>
</html>