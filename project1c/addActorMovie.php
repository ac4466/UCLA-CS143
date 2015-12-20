<html>
	<head>
		<link type="text/css" rel="stylesheet" href="stylesheet.css"/>
		<title>Add Actor to Movie</title>
		<script>
			function ValidateInput() {
				alert("Actor linked to movie!");
			}
		</script>
	</head>
	<body bgcolor="#DFE2E5">
		<h2>Add Actor to Movie</h2>
		<form name="addActorMovie" action="addActorMovie.php" onsubmit="return ValidateInput()" method="GET">
			<div>
				Actor:  <select name="aid">
					<?php
						//establish connection
						$db_connection = mysql_connect("localhost", "cs143", "");
						mysql_select_db("CS143", $db_connection);
						
						//get all actors and create an option for each one
						$res = mysql_query("SELECT id, first, last, dob FROM Actor ORDER BY first, last, id;", $db_connection) or exit(mysql_error());
						while($row = mysql_fetch_row($res))
							echo '<option value="',$row[0],'">',$row[1],' ',$row[2],' (', $row[3], ')</option>';
						mysql_free_result($res);
					?>
					</select></br>
				Movie: <select name="mid">
					<?php
						//get all movies and create an option for each one
						$res = mysql_query("SELECT id, title, year FROM Movie ORDER BY title;", $db_connection) or exit(mysql_error());
						while($row = mysql_fetch_row($res))
							echo '<option value="',$row[0],'">',$row[1],' (',$row[2],')</option>';
						mysql_free_result($res);
					?>
					</select></br>
				Role: <input type="text" name="role" maxlength="50"><br/>
				<br/>
				<input type="submit" value="Submit">
			</div>
		</form>
		<?php
			//get variables
			$iaid = $_GET["aid"];
			$imid = $_GET["mid"];
			$irole = trim($_GET["role"]);
			
			if($iaid != "" && $imid != "")
			{
				//escape out of ' characters
				$irole = mysql_escape_string($irole);
				
				//insert tuple into MovieActor
				if ($irole == "")
					$query = "INSERT INTO MovieActor VALUES($imid, $iaid, NULL);";
				else
					$query = "INSERT INTO MovieActor VALUES($imid, $iaid, '$irole');";
				
				$res = mysql_query($query, $db_connection) or exit(mysql_error());
			}
			
			mysql_close($db_connection);
		?>
	</body>
</html>