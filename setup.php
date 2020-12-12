<?php
	if (isset($_POST['submit'])) {
		$db_host	= $_POST['db_host'];
		$db_name	= $_POST['db_name'];
		$db_user	= $_POST['db_user'];
		$db_pass	= $_POST['db_pass'];
		
		//Write these settings to a config file
		$myfile = fopen("config.php", "w") or die("Unable to open file!");
		$txt = '<?php
	$db_host	= "'. $db_host .'";
	$db_user	= "'. $db_user .'";
	$db_pass	= "'. $db_pass .'";
	$db_name	= "'. $db_name .'";
?>';
		fwrite($myfile, $txt);
		fclose($myfile);
		
		header('location:setup-sql.php');
	}
?>
<html>
	<head>
		<title>My Pets</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="shortcut icon" href="favicon.png"/>
	</head>
	
	<body>
		<div class="container" style="text-align: center">
			<h1>To use this application, you need to set it up first!</h1>
			<h2>Please create a new database and provide the details</h2>
			<form method="post">
				<table class="table" align="center">
					<caption>MySQL Details</caption>
						<tr>
							<th>Database Host</th>
							<td><input class="form-control" type="text" name="db_host" value="localhost" required/></td>
						</tr>
						<tr>
							<th>
							Database Name
							<h4 class="text-danger">Note: you need to create a new database first</h4>
							</th>
							<td><input class="form-control" type="text" name="db_name" required/></td>
						</tr>
						<tr>
							<th>Database User</th>
							<td><input class="form-control" type="text" name="db_user" required/></td>
						</tr>
						<tr>
							<th>Database Password</th>
							<td><input class="form-control" type="text" name="db_pass"/></td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" class="btn btn-primary" name="submit" value="Save and Continue"/></td>
						</tr>
				</table>
			</form>

		</div>
	</body>
</html>