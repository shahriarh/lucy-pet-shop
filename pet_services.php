<?php
  session_start();
if (empty($_GET['pet_id'])) {
	//Redirect user to My Pets page
	header('location:pets.php');
}
$pet_id = $_GET['pet_id'];
	
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
	$delete_query = "DELETE FROM pet WHERE id=$delete_id";
	
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
	$color = mysqli_real_escape_string ($con, $_POST['color']);
	$weight = mysqli_real_escape_string ($con, $_POST['weight']);
	$category = mysqli_real_escape_string ($con, $_POST['category']);
	$diet_preference = mysqli_real_escape_string ($con, $_POST['diet_preference']);
	
	$query="insert into pet(name, owner_id, color, weight, category, diet_preference)values('$name','$owner_id','$color','$weight','$category','$diet_preference')";
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
}

// Fetch the pet info
	$query = "select * from pet where id='$pet_id'";
	$result = mysqli_query($con,$query);
	$pet_info = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) < 1) {
		echo 'Wrong Pet ID';
		die();
	} elseif ($pet_info['owner_id'] !== $owner_id) {
		echo 'You are not this pet\'s owner';
		die();
	}
	
// Fetch all the services available
	$query = "select * from services";
	$result = mysqli_query($con,$query);
	$available_services = mysqli_fetch_all($result,MYSQLI_ASSOC);
	
// Fetch all the services of this pet
	$query = "select * from pet_services where id='$pet_id'";
	$result = mysqli_query($con,$query);
	$number_of_services = $result->num_rows;
	$pet_services = mysqli_fetch_all($result,MYSQLI_ASSOC);

// Close the connection to Mysql
$_POST = "";
mysqli_close($con);
?>
<html>
	<head>
		<title>Services For <?= $pet_info['name'] ?></title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="shortcut icon" href="favicon.png"/>
	</head>
	
	<body>
		<div class="container">
		<?php include ('menu.php'); ?>
		<?=$alert ?>
			<h2><small>Services for:</small> <?= $pet_info['name'] ?></h2>
			<div class="row">
				<form method="post" action="pet_services.php">
					<table class="table table-striped">
						<tr>
							<td>Service</td>
							<td>
								<select name="service_id" class="form-control" required>
								<?php foreach ($available_services as $service): ?>
									<option value="<?= $service['id'] ?>"><?= $service['name'] ?></option>
								<?php endforeach; ?>
							</td>
						</tr>
						<tr>
							<td>Duration</td>
							<td><input type="number" class="form-control" name="duration" required/></td>
						</tr>
						<tr>
							<td>Time of Day</td>
							<td><input type="time" class="form-control" name="time_of_day" required/></td>
						</tr>
						<tr>
							<td>Day Of Week <br/><small class="text-muted">Enter numeric representation of day in week.<br>Where Saterday is 1, Sunday is 2, and so on.<br>Separate numbers with comma.<br>i.e: <kbd>1,3,5</kbd> for Saturday, Monday, Wednesday</small></td>
							<td><input type="text" class="form-control" name="day_of_week" /></td>
						</tr>
						<tr>
							<td>Day Of Month <br/><small class="text-muted">If Specified the schedule will ignore Day of Week<br>Separate Entries with comma</small></td>
							<td><input type="number" name="day_of_week" class="form-control" /></td>
						</tr>
						<tr>
							<td>Service Off Date</td>
							<td><input type="date" name="service_off_day" class="form-control" /></td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="submit" name="submit" value="Add Service" class="btn btn-primary"/>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div class="row">
				<?php if ($number_of_services > 0): ?>
				<table class="table table-hover">
					<thead>
						<th>Name</th>
						<th>Color</th>
						<th>Weight</th>
						<th>Category</th>
						<th>Diet Preferences</th>
						<th>Delete</th>
					</thead>
					<?php foreach ($my_pets as $pet): ?>
					<tr>
						<td><a href="pet_services.php?pet_id=<?=$pet['id'] ?>"><?=$pet['name'] ?></a></td>
						<td><?=$pet['color'] ?></td>
						<td><?=$pet['weight'] ?></td>
						<td><?=$pet['category'] ?></td>
						<td><?=$pet['diet_preference'] ?></td>
						<td>
							<form method="post">
								<button class="btn btn-warning" type="submit" name="delete" value="<?=$pet['id'] ?>" onclick="return confirm('Are you sure you want to delete this pet?');"><span class="glyphicon glyphicon-remove"></span></button></td>
							</form>
					</tr>
					<?php endforeach; ?>
				</table>
				<?php endif; ?>
			</div>
		</div>
	</body>

</html>