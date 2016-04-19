<?php
	$conn = mysqli_connect("localhost", "", "", "technozap");

	if (!$conn)
		die("Could not connect to MySQL server: ".mysqli_connect_error());
?>