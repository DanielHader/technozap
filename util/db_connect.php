<?php

function connect() {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$database = "technozap";

	return mysqli_connect($servername, $username, $password, $database);

	if (!$conn)
		die("Could not connect to MySQL server: ".mysqli_connect_error());
}

function close($conn) {
	mysqli_close($conn);
}
?>