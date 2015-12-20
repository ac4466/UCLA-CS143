<html>
	<head>
		<link type="text/css" rel="stylesheet" href="stylesheet.css"/>
		<title>Add Director to Movie</title>
		<script>
			function ValidateInput() {
				alert("Director linked to movie!");
			}
		</script>
	</head>
	<body bgcolor="#DFE2E5">
		<h2>Add Director to Movie</h2>
		<form name="addDirectorMovie" action="addDirectorMovie.php" onsubmit="return ValidateInput()" method="GET">
			<div>
				Director: <select name="did">
					<?php
						$db_connection = mysql_connect("localhost", "cs143", "");
						mysql_select_db("CS143", $db_connection);
						$res = mysql_query("SELECT id, first, last, dob FROM Director ORDER BY first, last, id", $db_connection) or exit(mysql_error());
						while($row = mysql_fetch_row($res))
							echo '<option value="',$row[0],'">',$row[1],' ',$row[2],' (', $row[3], ')</option>';
						mysql_free_result($res);
					?>
					</select></br>
				Movie: <select name="mid">
					<?php
						$res = mysql_query("SELECT id, title, year FROM Movie ORDER BY title", $db_connection) or exit(mysql_error());
						while($row = mysql_fetch_row($res))
							echo '<option value="',$row[0],'">',$row[1],' (',$row[2],')</option>';
						mysql_free_result($res);
					?>
					</select></br>
				<br/>
				<input type="submit" value="Submit">
			</div>
		</form>
		<?php
			//get variables
			$idid = $_GET["did"];
			$imid = $_GET["mid"];
			
			if($idid != "" && $imid != "")
			{
				//insert tuple into MovieActor
				$query = "INSERT INTO MovieDirector VALUES($imid, $idid);";
				$res = mysql_query($query, $db_connection) or exit(mysql_error());
			}
			
			mysql_close($db_connection);
		?>
	</body>
</html>