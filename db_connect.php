<?php
	$conn = mysqli_connect("localhost", "root", "root", "grup");

	if (!$conn)
		die("Could not connect to MySQL server: ".mysqli_connect_error());
?>