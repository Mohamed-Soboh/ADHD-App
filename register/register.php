<?php
require_once 'C:\xampp\htdocs\event-management\event-management\library\config.php';
	$firstName = $_POST['firstName'];
	$address = $_POST['address'];
	$typeof = $_POST['typeof'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$number = $_POST['number'];
	// Database connection
	$status='active';
	 echo $typeof;
		$stmt = $dbConn->prepare("insert into tbl_users(name,pwd,address,phone,email,type,status) values(?, ?, ?, ?, ?,?,'active')");
		 echo $typeof;
		$stmt->bind_param("ssssss", $firstName,$password, $address,$number,$email,$typeof );
		 
		$execval = $stmt->execute();
		echo $execval;
		echo "Registration successfully...";
		$stmt->close();
		 header('Location: http://10.0.0.1/event-management/event-management/login.php');
	 
?>