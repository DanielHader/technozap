<?php
require_once "util.php";

function sendRecoveryEmail($conn, $email, &$message) {

	cleanStrings($email);

	if ($result = mysqli_query($conn, "SELECT * FROM users WHERE `email` LIKE '$email'")) {
		if (mysqli_num_rows($result) != 0) {
			
			$recoveryLink = "";
			$content = "Click this link to set a new password\n\n" . $recoveryLink;
			mail($email,"TechnoZap Account Recovery",$content,"From: recovery@techozap.net");
		

		} else {
			$message = "No account exists with that email!";
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