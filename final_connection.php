<?php 
	$server_name="localhost";
	$username="id6364010_nih";
	$password="12345";
	$dbname="id6364010_android_db";

	$conn=mysqli_connect($server_name,$username,$password,$dbname);
	//Connection Test
	if (mysqli_connect_errno()) {
		die("Database connection failed." . mysqli_connect_error(). "(" .mysqli_connect_errno().")"
	);
	}
	
	$query ="SELECT * FROM client_location";
	$result =mysqli_query($conn,$query);
	$query1="SELECT * FROM ambulance_location";
	$result1=mysqli_query($conn,$query1);
			
 ?>