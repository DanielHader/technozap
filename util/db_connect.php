<?php
	function connect() {
		$servername = "localhost";
		$username = "root";
		$password = "root";
		$database = "technozap";

		return mysqli_connect($servername, $username, $password, $database);
	}

	function close($conn) {
		mysqli_close($conn);
	}
?>
