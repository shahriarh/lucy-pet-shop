<?php
	if (!file_exists ('config.php') ) {
		header('location:setup.php');
	}
	else 
		header('location:login.html');
?>