<html>
<head><title>CS143 Project 1B</title></head>
<body>
	<h1>Movie Database</h1>
	<p>Type an SQL query in the following box: </p>
	<p>Example: <tt>SELECT * FROM Actor WHERE id=10;</tt></p>
	<form action="query.php" method="GET">
		<textarea name="query" cols="60" rows="8"><?php echo $_GET["query"];?></textarea><br/>
		<input type="submit" value="Submit" />
	</form>
	
	<?php
		$query = $_GET["query"];
		if ($query != "")
		{
			$db_connection = mysql_connect("localhost", "cs143", "");
			mysql_select_db("CS143", $db_connection);
			$rs = mysql_query($query, $db_connection);
		?>
		<h3>Results from MySQL:</h3>
		<table border=1>
			<thead>
				<tr align=center>
					<?php
						$numFields = mysql_num_fields($rs);
						for ($i = 0; $i < $numFields; $i++) {
							echo '<td><b>',mysql_field_name($rs, $i),'</b></td>';
						}
					?>
				</tr>
			</thead>
			<tbody>
				<?php
					while($row = mysql_fetch_row($rs)) {
						echo '<tr align=center>';
							for ($i = 0; $i < $numFields; $i++) {
								if (is_null($row[$i]))
									echo'<td>N/A</td>';
								else
									echo '<td>',$row[$i],'</td>';
							}
						echo '</tr>';
					}
				?>
			</tbody>
		</table>
		<?php
			mysql_close($db_connection);
		}
	?>
</body>
</html>