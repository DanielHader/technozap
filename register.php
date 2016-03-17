<?php
	require_once 'db_connect.php';

	// Make sure you escape all user-inputted fields; this protects against SQL Injections
	$username = mysqli_real_escape_string($conn, $_POST["username"]);
	$password = mysqli_real_escape_string($conn, $_POST["password"]);
	$firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
	$lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
	$email = mysqli_real_escape_string($conn, $_POST["email"]);

	if (strlen($username) < 3 || strlen($password) < 3 || strlen($firstname) < 3 || strlen($lastname) < 3 || strlen($email) < 3) {
		echo "Each field must have a minimum of 3 characters in length!";
		return;
	}

	// Check if an account already exists with the same username
	if ($result = mysqli_query($conn, "SELECT * FROM users WHERE `username` LIKE '$username'")) {
		if (mysqli_num_rows($result) == 0) {
			if (!mysqli_query($conn, "INSERT INTO users (`id`, `username`, `password`, `first name`, `last name`, `email`) VALUES (null, '$username', '$password', '$firstname', '$lastname', '$email')"))
				echo "An error occurred in creating your account: ".mysqli_error($conn);
			else
				echo "Registered!";
		} else
			echo "There is already an user with the name username!";

		mysqli_free_result($result);
	}
?>