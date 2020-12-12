<?php
  session_start();
	
// If session does not exist, redirect user to login page
if (empty($_SESSION['login']) || $_SESSION['login'] !== true) {
	echo 'You need to login before you can view this page. The browser will automatically redirect you to the <a href="login.php">login</a> page after 4 seconds.';
	header( "refresh:4;url=login.html" );
	die();
}

// Setting a few variables for the system. Don't mind them, continue ;)
	$alert = '';
	include ('db.php');
	$owner_id = $_SESSION['user_id'];
	
// If delete button is pressed, 
if (isset($_POST['delete']) && $_POST['delete'] > 0) {
	$delete_id = $_POST['delete'];
	$delete_query = "DELETE FROM services WHERE id=$delete_id";
	
	if (mysqli_query($con, $delete_query)) {
		$alert = '
		<div class="alert alert-success" role="alert">
		  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
		  Successfully deleted from the database.
		</div>';
	} else {
		$alert = '
		<div class="alert alert-danger" role="alert">
		  <span class="glyphicon exclamation-sign" aria-hidden="true"></span>
		  Error deleting record: '. mysqli_error($conn) .'
		</div>';
	}

}
	
// Add New Pet if form submitted
if (isset($_POST['submit'])) {
	
	$name = mysqli_real_escape_string ($con, $_POST['name']);
	$rate = mysqli_real_escape_string ($con, $_POST['rate']);
	$min_increment = mysqli_real_escape_string ($con, $_POST['min_increment']);
	
	$query="insert into services (name, rate, min_increment)values('$name','$rate','$min_increment')";
	$success=mysqli_query($con,$query);
	
	// Display a success message if entry successful
	$alert = '';
	if($success){
		$alert = '
		<div class="alert alert-success" role="alert">
		  <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
		  Successfully entered to the database.
		</div>';
	} else {
		// Show an Error
		$alert = '
		<div class="alert alert-danger" role="alert">
		  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		  Coundn\'t insert into the database!
		</div>';
	}
	// Redirect to self. to prevent form resubmission
	header('location:services.php');
}
	
// Fetch all the services of this pet
	$query = "select * from services";
	$result = mysqli_query($con,$query);
	$number_of_services = $result->num_rows;
	$pet_services = mysqli_fetch_all($result,MYSQLI_ASSOC);

// Close the connection to Mysql
mysqli_close($con);
?>
<html>
	<head>
		<title>Our Services</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="shortcut icon" href="favicon.png"/>
	</head>
	
	<body>
		<div class="container">
		<?php include ('menu.php'); ?>
		<?=$alert ?>
			<h2>Admin: <small>Our Services</small></h2>
			<table class="table table-bordered" align="center">
				<thead>
					<th>Add A Service</th>
					<th>List of Our Services</th>
				</thead>
				<tbody>
					<tr>
						<td width="35%">
							<form method="post" action="services.php">
								<table class="table table-striped">
									<tr>
										<td>Name</td>
										<td><input type="text" name="name" required/></td>
									</tr>
									<tr>
										<td>Rate per Increment (£)</td>
										<td><input type="number" name="rate" required/></td>
									</tr>
									<tr>
										<td>Minimum Increment (minutes)<br><small class="text-muted">Enter 0 to make it a unit of service. Time Independant</small></td>
										<td><input type="number" name="min_increment" required/></td>
									</tr>
									<tr>
										<td colspan="2">
											<input type="submit" name="submit" value="Add a Service" class="btn btn-primary"/>
										</td>
									</tr>
								</table>
							</form>
						</td>
						<td>
							<?php if ($number_of_services > 0): ?>
								<table class="table table-hover">
									<thead>
										<th>Name</th>
										<th>Rate</th>
										<th>Minimum Increment</th>
									<?php foreach ($pet_services as $service): ?>
									<tr>
										<td><?=$service['name'] ?></td>
										<td>£ <?=$service['rate'] ?></td>
										<td>
										<?php if ($service['min_increment'] == 0) {
											echo "<i>per unit</i>";
										} else
											echo $service['min_increment'].' min';
										?>
										</td>
										<td>
											<form method="post">
												<button class="btn btn-warning" type="submit" name="delete" value="<?=$service['id'] ?>" onclick="return confirm('Are you sure you want to delete this service?');"><span class="glyphicon glyphicon-remove"></span></button></td>
											</form>
									</tr>
									<?php endforeach; ?>
								</table>
							<?php endif; ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>

</html>