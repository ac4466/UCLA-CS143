<html>
	<head>
		<link type="text/css" rel="stylesheet" href="stylesheet.css"/>
		<title>Add Actor/Director</title>
		<script>
		function ValidateInput() {
			var iposition = document.getElementsByName('position');
			var ifirst = document.forms["addActorDirector"]["first"].value;
			var ilast = document.forms["addActorDirector"]["last"].value;
			var idob = document.forms["addActorDirector"]["dob"].value;
			var idod = document.forms["addActorDirector"]["dod"].value;
			
			ifirst = ifirst.trim();
			ilast = ilast.trim();
			
			if (ifirst == null || ifirst == "" || ifirst.match(/[^-\'A-Za-z]/g) != null) {
				alert("Please enter a valid first name.");
				return false;
			}
			if (ilast == null || ilast == "" || ilast.match(/[^-\'A-Za-z]/g) != null) {
				alert("Please enter a valid last name.");
				return false;
			}
			if (idob.length != 8 || idob.match(/[^0-9]/g) != null || parseInt(idob.substr(4, 2), 10) > 12 || parseInt(idob.substr(6, 2), 10) > 31) {
				alert("Please enter a valid date of birth.");
				return false;
			}
			if (idod != "") {
				if (idod.length != 8 || idod.match(/[^0-9]/g) != null || parseInt(idod.substr(4, 2), 10) > 12 || parseInt(idod.substr(6, 2), 10) > 31) {
					alert("Please enter a valid date of death.");
					return false;
				}
			}
			if (iposition[0].checked)
				alert("New actor added!");
			else
				alert("New director added!");
		}
		</script>
	</head>
	<body bgcolor="#DFE2E5">
		<h2>Add New Actor or Director</h2>
		<form name="addActorDirector" action="addActorDirector.php" onsubmit="return ValidateInput()" method="GET">
			<div>
				Position: <input type="radio" name="position" value="Actor" checked>Actor <input type="radio" name="position" value="Director">Director<br/>
				First Name: <input type="text" name="first" maxlength="20"><br/>
				Last Name: <input type="text" name="last" maxlength="20"><br/>
				Sex: <input type="radio" name="sex" value="Male" checked>Male <input type="radio" name="sex" value="Female">Female<br/>
				Date of Birth: <input type="text" name="dob" maxlength="8"> (YYYYMMDD)<br/>
				Date of Death: <input type="text" name="dod" maxlength="8"> (YYYYMMDD, leave blank if still alive)<br/>
				<br/>
				<input type="submit" value="Submit">
			</div>
		</form>
		
		<?php
			//get variables
			$iposition = $_GET["position"];
			$ifirst = trim($_GET["first"]);
			$ilast = trim($_GET["last"]);
			$isex = $_GET["sex"];
			$idob = $_GET["dob"];
			$idod = $_GET["dod"];
			
			if ($ifirst != "" && $ilast != "" && $idob != "")
			{
				//establish db connection
				$db_connection = mysql_connect("localhost", "cs143", "");
				mysql_select_db("CS143", $db_connection);

				//increment MaxPersonID and get new id
				$res = mysql_query("UPDATE MaxPersonID SET id = id + 1;", $db_connection) or exit(mysql_error());
				$res = mysql_query("SELECT id FROM MaxPersonID;", $db_connection) or exit(mysql_error());
				$row = mysql_fetch_row($res);
				$new_id = $row[0];
				
				//escape out of ' characters
				$ifirst = mysql_escape_string($ifirst);
				$ilast = mysql_escape_string($ilast);
				
				if ($iposition == 'Actor') {
					if ($idod == "")
						$query = "INSERT INTO Actor VALUES($new_id, '$ilast', '$ifirst', '$isex', '$idob', NULL);";
					else
						$query = "INSERT INTO Actor VALUES($new_id, '$ilast', '$ifirst', '$isex', '$idob', '$idod');";
				}
				else {
					if ($idod == "")
						$query = "INSERT INTO Director VALUES($new_id, '$ilast', '$ifirst', '$idob', NULL);";
					else
						$query = "INSERT INTO Director VALUES($new_id, '$ilast', '$ifirst', '$idob', '$idod');";
				}
				
				$res = mysql_query($query, $db_connection) or exit(mysql_error());
				mysql_close($db_connection);
			}
		?>
	</body>
</html>