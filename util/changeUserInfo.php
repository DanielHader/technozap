<?php
require_once "util.php";

function changeUserInfo($conn, $userid, $password, $firstname, $lastname, $email, &$message) {
	
	cleanStrings($conn, $password, $firstname, $lastname, $email);

	if (strlen($password) < 3 || strlen($firstname) < 3 || strlen($lastname) < 3 || strlen($email) < 3) {
		$message = "Each field must have a minimum of 3 characters in length!";
		return false;
	}

	if ($result = mysqli_query($conn, "SELECT * FROM users WHERE `email` LIKE '$email'")) {

		if (mysqli_num_rows($result) == 0) {
			$hash = password_hash($password, PASSWORD_DEFAULT);
			
				if (!mysqli_query($conn, "UPDATE users SET `password` = '$hash', `first name` = '$firstname', `last name` = '$lastname', `email` = '$email' WHERE `id` = '$userid'), {
					$message = "An error occurred in changing your settings: ".mysqli_error($conn);
					$success = false;
				} else {
					$message = "Settings updated!";
					$success = true;
				}
			}

		} else {
			$message = "That email is already in use!";
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
