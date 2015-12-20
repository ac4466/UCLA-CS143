<html>
	<head>
		<link type="text/css" rel="stylesheet" href="stylesheet.css"/>
		<title>Search Results</title>
	</head>
	<body bgcolor="#DFE2E5">
		<?php
			$input = trim($_GET["input"]);
			$input = mysql_escape_string($input);
			if ($input != "")
			{
				$words = explode(" ", $input);
				$db_connection = mysql_connect("localhost", "cs143", "");
				mysql_select_db("CS143", $db_connection);

				$query = "SELECT id, first, last, dob FROM Actor WHERE CONCAT(first, ' ', last) LIKE '%$words[0]%'";
				for ($i = 1; $i < count($words); $i++)
					$query = $query."AND CONCAT(first, ' ', last) LIKE '%$words[$i]%'";
				$query = $query.";";
				?>
				<div class="left">
					<h3>Actor Results</h3>				
					<?php
					$res = mysql_query($query, $db_connection) or exit(mysql_error());
					while($row = mysql_fetch_row($res))
						echo "<a href=\"showActor.php?id=$row[0]\">",$row[1]," ",$row[2]," (",$row[3],")</a><br/>";
					mysql_free_result($res);
					?>
				</div>
				<div class="right">
					<h3>Movie Results</h3>				
					<?php
					$query = "SELECT id, title, year FROM Movie WHERE title LIKE '%$words[0]%'";
					for ($i = 1; $i < count($words); $i++)
						$query = $query."AND title LIKE '%$words[$i]%'";
					$query = $query.";";

					$res = mysql_query($query, $db_connection) or exit(mysql_error());
					while($row = mysql_fetch_row($res))
						echo "<a href=\"showMovie.php?id=$row[0]\">",$row[1]," (",$row[2],")</a><br/>";

					mysql_close($db_connection);
					?>
				</div>
				<?php
			}
		?>
	</body>
</html>