<?php
	if (isset($_POST['submit'])) {
		$name	= $_POST['name'];
		$address = $_POST['address'];
		$email = $_POST['email'];
		$password = md5($_POST['password']);
		$cpassword = md5($_POST['cpassword']);
		
		if ($password !== $cpassword) {
			echo 'Passwords do not match!';
			die();
		} else {
			include ('db.php');
			$query="select * from owner where email='$email'";
			$result=mysqli_query($con,$query);
			$num=mysqli_num_rows($result);
			if($num==0){
				$query="insert into owner(name,address,email,password,is_admin)values('$name','$address','$email','$password','1')";
				$result=mysqli_query($con,$query);
				if($result){
					echo "User created succesfully, Go to <a href='login.html'>Login</a></br>";
				}
			} else {
				echo "This email is being used by another user, please <a href='javascript:history.go(-1)'>[Go Back]</a> and give another valid email";
			}
		}

		header('location:login.html');
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
			<h1>Database Details Saved!</h1>
			<h2>Now we will create an admin account for you.</h2>

			<form method="post">
				<table class="table" align="center" style="max-width:600px">
					<caption>Admin Account Details</caption>
					<tr>
						<td>Admin Name</td>
						<td><input type="text" class="form-control" name="name" required/></td>
					</tr>
					<tr>
						<td>Address</td>
						<td><input type="text" class="form-control" name="address" required/></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="email" class="form-control" name="email" required/></td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input type="password" class="form-control" name="password" required/></td>
					</tr>
					<tr>
						<td>Confirm Password</td>
						<td><input type="password" class="form-control" name="cpassword" required/></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="right">
						<input type="submit" class="btn btn-primary" name="submit" value="Create Admin Account">
					</tr>
							
				</table>
			</form>

		</div>
	</body>
</html>