<?php
	require_once 'db_connect.php';
	session_start();

	// Make sure you escape all user-inputted fields; this protects against SQL Injections
	$groupName = mysqli_real_escape_string($conn, $_POST["groupName"]);
	$groupDesc = mysqli_real_escape_string($conn, $_POST["groupDesc"]);

	// Make sure the user is logged in
	if (!isset($_SESSION["userId"])) {
		echo "You must be logged in to create a group!";
		return;
	}

	// Making sure that they don't just put an empty name / description
	if (strlen($groupName) < 3 || strlen($groupDesc) < 10) {
		echo "The group name must be at least 3 characters long and the description must be at least 10 characters long.";
		return;
	}

	// Check if a group already exists with the same name
	if ($result = mysqli_query($conn, "SELECT * FROM groups WHERE `name` LIKE '$groupName'")) {
		if (mysqli_num_rows($result) == 0) {
			if (!mysqli_query($conn, "INSERT INTO groups (id, name, description) VALUES (null, '$groupName', '$groupDesc')"))
				echo "An error occurred in creating this group: ".mysqli_error($conn);
			else
				echo "Created group '$groupName'!";
		} else
			echo "There is already a group with the name '$groupName'!";

		mysqli_free_result($result);
	}
?>