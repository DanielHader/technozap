<?php
require_once "util.php";

function register($conn, $username, $password, $firstname, $lastname, $email, &$message) {
	
	cleanStrings($conn, $username, $password, $firstname, $lastname, $email);

	if (strlen($username) < 3 || strlen($password) < 3 || strlen($firstname) < 3 || strlen($lastname) < 3 || strlen($email) < 3) {
		$message = "Each field must have a minimum of 3 characters in length!";
		return false;
	}

	// Check if an account already exists with the same username
	if ($result = mysqli_query($conn, "SELECT * FROM users WHERE 'username' LIKE '$username'")) {
		if (mysqli_num_rows($result) == 0) {

			$hash = password_hash($password, PASSWORD_DEFAULT);
			
			if (!mysqli_query($conn, "INSERT INTO users (`id`, `username`, `hash`, `first name`, `last name`, `email`) VALUES (null, '$username', '$hash', '$firstname', '$lastname', '$email')")) {
				$message = "An error occurred in creating your account: ".mysqli_error($conn);
				$success = false;
			} else {
				$message = "Registered!";
				$success = true;
			}
		} else {
			$message = "There is already an user with the name username!";
			$success = false;
		}

		mysqli_free_result($result);
	} else {
		$message = "Unable to access users database!";
		$success = false;
	}

	return $success;
}

?>