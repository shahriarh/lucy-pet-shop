<?php
	$name = $_POST['name'];
	$address = $_POST['address'];
	$distance_from_pet_shop = $_POST['distance_from_pet_shop'];
	$email = strtolower(trim($_POST['email']));
	$password = md5($_POST['password']);
	
	$cpassword = md5($_POST['cpassword']);
	
	$phone = $_POST['phone'];
	$zipcode=$_POST['zipcode'];
	
	
	if($password==$cpassword){
		include ('db.php');
		$query="select * from owner where email='$email'";
		$result=mysqli_query($con,$query);
		$num=mysqli_num_rows($result);
		if($num==0){
			$query="insert into owner(name,address,distance_from_pet_shop,email,password,phone,zipcode)values('$name','$address','$distance_from_pet_shop','$email','$password','$phone','$zipcode')";
			$result=mysqli_query($con,$query);
			if($result){
				echo "User created succesfully, Go to <a href='login.html'>Login</a></br>";
			}
		} else {
			echo "This email is using by another user, please <a href='javascript:history.go(-1)'>[Go Back]</a> and give another valid email";
		}
	} else {
		echo 'Passwords do not match <a href="javascript:history.go(-1)">[Go Back]</a>';
	}
?>