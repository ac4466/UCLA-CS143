<html>
	<head>
		<link type="text/css" rel="stylesheet" href="stylesheet.css"/>
		<title>Add Movie</title>
		<script>
		function ValidateInput() {
			var ititle = document.forms["addMovie"]["title"].value;
			var iyear = document.forms["addMovie"]["year"].value;
			
			ititle = ititle.trim();
			iyear = iyear.trim();
			
			if (ititle == null || ititle == "") {
				alert("Please enter a title.");
				return false;
			}
			if (iyear == null || iyear== "" || iyear.match(/[^0-9]/g) != null || parseInt(iyear, 10) < 1000 || parseInt(iyear, 10) > 9999) {
				alert("Year must be between 1000 and 9999, inclusive.");
				return false;
			}
			alert("New movie added!");
		}
		</script>
	</head>
	<body bgcolor="#DFE2E5">
		<h2>Add New Movie</h2>
		<form name="addMovie" action="addMovie.php" onsubmit="return ValidateInput()" method="GET">
			<div>
				Title: <input type="text" name="title" maxlength="100"><br/>
				Year: <input type="text" name="year" maxlength="4"><br/>
				Rating: <select name="rating">
							<option value="G">G</option>
							<option value="PG">PG</option>
							<option value="PG-13">PG-13</option>
							<option value="R">R</option>
							<option value="NC-17">NC-17</option>
							<option value="surrendere">surrendere</option>
						</select><br/>
				Company: <input type="text" name="company" maxlength="50"><br/>
				Genre(s):
					<table width="475px">
						<tr>
							<td><input type="checkbox" name="genre[]" value="Action">Action</td>
							<td><input type="checkbox" name="genre[]" value="Adult">Adult</td>
							<td><input type="checkbox" name="genre[]" value="Adventure">Adventure</td>
							<td><input type="checkbox" name="genre[]" value="Animation">Animation</td>
						</tr>
						<tr>
							<td><input type="checkbox" name="genre[]" value="Comedy">Comedy</td>
							<td><input type="checkbox" name="genre[]" value="Crime">Crime</td>
							<td><input type="checkbox" name="genre[]" value="Documentary">Documentary</td>
							<td><input type="checkbox" name="genre[]" value="Drama">Drama</td>
						</tr>
						<tr>
							<td><input type="checkbox" name="genre[]" value="Family">Family</td>
							<td><input type="checkbox" name="genre[]" value="Fantasy">Fantasy</td>
							<td><input type="checkbox" name="genre[]" value="Horror">Horror</td>
							<td><input type="checkbox" name="genre[]" value="Musical">Musical</td>
						</tr>
						<tr>
							<td><input type="checkbox" name="genre[]" value="Mystery">Mystery</td>
							<td><input type="checkbox" name="genre[]" value="Romance">Romance</td>
							<td><input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi</td>
							<td><input type="checkbox" name="genre[]" value="Short">Short</td>
						</tr>
						<tr>
							<td><input type="checkbox" name="genre[]" value="Thriller">Thriller</td>
							<td><input type="checkbox" name="genre[]" value="War">War</td>
							<td><input type="checkbox" name="genre[]" value="Western">Western</td>
						</tr>
					</table> 
				<br/>
				<input type="submit" value="Submit">
			</div>
		</form>
		
		<?php
			//get variables
			$ititle = trim($_GET["title"]);
			$iyear = $_GET["year"];
			$irating = $_GET["rating"];
			$icompany = trim($_GET["company"]);
			$igenre = $_GET["genre"];
		
			if ($ititle != "" && $iyear != "")
			{
				//establish db connection
				$db_connection = mysql_connect("localhost", "cs143", "");
				mysql_select_db("CS143", $db_connection);
				
				//increment MaxMovieID and get new id
				$res = mysql_query("UPDATE MaxMovieID SET id = id + 1;", $db_connection) or exit(mysql_error());
				$res = mysql_query("SELECT id FROM MaxMovieID;", $db_connection) or exit(mysql_error());
				$row = mysql_fetch_row($res);
				$new_id = $row[0];
				
				//escape out of ' characters
				$ititle = mysql_escape_string($ititle);
				$icompany = mysql_escape_string($icompany);
				
				//insert new movie
				if ($icompany == "")
					$query = "INSERT INTO Movie VALUES($new_id, '$ititle', $iyear, '$irating', NULL);";
				else
					$query = "INSERT INTO Movie VALUES($new_id, '$ititle', $iyear, '$irating', '$icompany');";
				
				$res = mysql_query($query, $db_connection) or exit(mysql_error());
				
				//for each chosen, genre insert new tuple into MovieGenre table
				for($i = 0; $i < count($igenre); $i++)
				{
					$query = "INSERT INTO MovieGenre VALUES('$new_id', '$igenre[$i]')";
					$res = mysql_query($query, $db_connection) or exit(mysql_error());
				}

				mysql_close($db_connection);				
			}
		?>
	</body>
</html>