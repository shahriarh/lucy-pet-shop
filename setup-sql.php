<?php
	if (isset($_POST['submit'])) {
		include ('db.php');
			// Temporary variable, used to store current query
			$templine = '';
			// Read in entire file
			$lines = file('sql/db.sql');
			// Loop through each line
			foreach ($lines as $line)
			{
				// Skip it if it's a comment
				if (substr($line, 0, 2) == '--' || $line == '')
					continue;

				// Add this line to the current segment
				$templine .= $line;
				// If it has a semicolon at the end, it's the end of the query
				if (substr(trim($line), -1, 1) == ';')
				{
					// Perform the query
					mysqli_query($con,$templine)
					or 
						print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error() . '<br /><br />');
					// Reset temp variable to empty
					$templine = '';
				}
			}
			 echo "Tables imported successfully";
		header('location:setup-step2.php');
	}
?>
<html>
	<head>
		<title>Setup Database Tables</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="shortcut icon" href="favicon.png"/>
	</head>
	
	<body>
		<div class="container" style="text-align: center">
			<h1>Creating Database Tables</h1>
			<h3>Please wait a few minutes to complete the sql commands after you click the submit button</h3><br><br>
			<form method="post">
				<input type="submit" class="btn btn-primary" name="submit" value="Create DB Tables and Continue"/>
			</form>
		</div>
	</body>
</html>