<?php
	$servername = "localhost";
	$username = "admin";
	$password = "password";
	$database = "technozap";

	$conn = mysqli_connect($servername, $username, $password, $database);

	if (!$conn)
		die("Could not connect to MySQL server: ".mysqli_connect_error());
?>