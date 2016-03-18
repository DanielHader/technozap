<?php
require_once "util.php";

function login($conn, $username, $password, &$user_id, &$message) {

	cleanStrings($conn, $username, $password);
	$query = "SELECT hash, id FROM users WHERE username = '$username' LIMIT 1";
	
	if ($result = mysqli_query($conn, $query)) {
		if (mysqli_num_rows($result) == 0) {
			$message = "Invalid username: " . $username;
			$success = false;
		} else {
			$row = mysqli_fetch_array($result);
			//echo $row["hash"];
			if (password_verify($password, $row["hash"])) {
				$user_id = $row["id"];
				$message = "You are now logged in";
				$success = true;
			} else {
				$message = "Incorrect password!";
				$success = false;
			}
		}
		mysqli_free_result($result);
	} else {
		$message = "Error accessing users database";
		return false;
	}

	return $success;
}


	// $error = 'Did not run';
	// if (empty($_POST['username'])|| empty($_POST['password']))
	// 	$error = "Username or password is invalid";
	// else {
	// 	$username = mysqli_real_escape_string($conn, $_POST['username']);
	// 	$password = mysqli_real_escape_string($conn, $_POST['password']);
	// 	$result = mysqli_query($conn, "SELECT `id` FROM users WHERE `password` LIKE '$password' AND `username` LIKE '$username'");
		
	// 	if (!$result)
	// 		echo mysqli_error($conn);
	// 	else {
	// 		if (mysqli_num_rows($result) > 0) {
	// 			$_SESSION["userId"] = mysqli_fetch_array($result)["id"];
	// 			$error = "Login success!";
	// 		} else
	// 			$error = "Username or password is invalid!";
	// 	}
	// }

	// echo $error;
?>