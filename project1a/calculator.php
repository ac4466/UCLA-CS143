<html>
<head><title>Calculator</title></head>
<body>

<h1>Calculator</h1>
<form action="calculator.php" method="GET">
	Expression: <input type="text" name="expr" />
	<input type="submit" value="Calculate" />
</form>

<?php
	$expr = $_GET["expr"];
	$expr = str_replace("--", "+", $expr);
	$match = preg_match("/^[+\-*\/0-9. ]+$/", $expr);
	$divZero = preg_match("/\/0[+\-*\/]+/", $expr);
	if (!$divZero)
		$divZero = preg_match("/\/0$/", $expr);
	
	if ($expr != "")
	{
		?>
		<h2>Result</h2>
		<?php
		if ($divZero)
			echo "Division by zero error.";
		elseif ($match)
		{	
			$try = @eval("\$ans=$expr;");
			
			if($try === FALSE)
				echo "Invalid expression.";
			else
				echo $expr." = ".$ans;
		}
		else
			echo "Invalid Expression!";
	}
?>

<br/><br/><br/><br/>
Created by Aaron Cheng and Yuan Yuan for CS143 at UCLA.
</body>
</html>