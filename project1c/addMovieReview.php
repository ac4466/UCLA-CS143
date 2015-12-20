<html>
	<head>
		<link type="text/css" rel="stylesheet" href="stylesheet.css"/>
		<title>Add Movie Review</title>
		<script>
			function ValidateInput() {
				if (confirm("Would you like to submit this review?")) {
					alert("Review submitted!");
					return true;
				}
				else
					return false;
			}
		</script>
	</head>
	<body bgcolor="#DFE2E5">
		<h2>Add Movie Review</h2>
		<form name="addMovieReview" action="addMovieReview.php" onsubmit="return ValidateInput()" method="GET">
			<div>
				Your Name: <input type="text" name="name" maxlength="20"><br/>
				Movie: <select name="mid">
					<?php
						$urlid = $_GET["id"];
						
						$db_connection = mysql_connect("localhost", "cs143", "");
						mysql_select_db("CS143", $db_connection);
						
						if ($urlid == null) {						
							$res = mysql_query("SELECT id, title, year FROM Movie ORDER BY title", $db_connection) or exit(mysql_error());
							while($row = mysql_fetch_row($res))
								echo '<option value="',$row[0],'">',$row[1],' (',$row[2],')</option>';
						}
						else {
							$res = mysql_query("SELECT title, year FROM Movie where id = $urlid", $db_connection) or exit(mysql_error());
							$row = mysql_fetch_row($res);
							echo "<option value=\"$urlid\">",$row[0],' (',$row[1],')</option>';
						}
					?>
					</select></br>
				Your Rating: <select name="rating">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
							</select> / 10</br>
				Comments: <br/><textarea name="comment" cols="80" rows="8" maxlength="500"></textarea><br/>
				<br/>
				<input type="submit" value="Submit">
			</div>
		</form>
		<?php
			//get variables
			$iname = trim($_GET["name"]);
			$imid = $_GET["mid"];
			$irating = $_GET["rating"];
			$icomment = trim($_GET["comment"]);
			
			if ($imid != "" && $irating != "")
			{
				//escape out of ' characters
				$iname = mysql_escape_string($iname);
				$icomment = mysql_escape_string($icomment);
				
				//create timestamp of current time
				$timestamp = date('Y-m-d G:i:s');

				//insert new review
				if ($iname == "") {
					if ($icomment == "")
						$query = "INSERT INTO Review VALUES(NULL, '$timestamp', $imid, $irating, NULL);";
					else
						$query = "INSERT INTO Review VALUES(NULL, '$timestamp', $imid, $irating, '$icomment');";
				}
				else {
					if ($icomment == "")
						$query = "INSERT INTO Review VALUES('$iname', '$timestamp', $imid, $irating, NULL);";
					else
						$query = "INSERT INTO Review VALUES('$iname', '$timestamp', $imid, $irating, '$icomment');";
				}
				$res = mysql_query($query, $db_connection) or exit(mysql_error());
			}
			mysql_close($db_connection);
		?>
	</body>
</html>