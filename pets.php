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
	// Redirect to self. to prevent form resubmission
	header('location:pets.php');

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
	// Redirect to self. to prevent form resubmission
	header('location:pets.php');
}

// Fetch all the pets of this user
	$query = "select * from pet where owner_id='$owner_id'";
	$result = mysqli_query($con,$query);
	$my_pets = mysqli_fetch_all($result,MYSQLI_ASSOC);
	$number_of_pets = mysqli_num_rows($result);

// Close the connection to Mysql
mysqli_close($con);
?>
<html>
	<head>
		<title>My Pets</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="shortcut icon" href="favicon.png"/>
	</head>
	
	<body>
		<div class="container">
		<?php include ('menu.php'); ?>
		<?=$alert ?>
			<h2>My Pets</h2>
			<table class="table table-bordered" align="center">
				<thead>
					<th>Add A Pet</th>
					<th>List of My Pets</th>
				</thead>
				<tbody>
					<tr>
						<td width="35%">
							<form method="post" action="pets.php">
								<table class="table table-striped">
									<tr>
										<th>Name</th>
										<td><input type="text" name="name" required/></td>
									</tr>
									<tr>
										<th>Color</th>
										<td><input type="text" name="color" required/></td>
									</tr>
									<tr>
										<th>Weight (KG)</th>
										<td><input type="number" name="weight" required/></td>
									</tr>
									<tr>
										<th>Dog Category/ Breed Group</th>
										<td><input type="text" name="category" required/></td>
									</tr>
									<tr>
										<th>Diet Preferences</th>
										<td><textarea name="diet_preference" rows="4"  required></textarea></td>
									</tr>
									<tr>
										<td colspan="2">
											<input type="submit" name="submit" value="Add Pet" class="btn btn-primary"/>
										</td>
									</tr>
								</table>
							</form>
						</td>
						<td>
							<?php if ($number_of_pets > 0): ?>
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
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>

</html>