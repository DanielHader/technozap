<?php

require_once "util.php";

function createGroup($conn, $groupName, $groupDesc, &$message) {
	// Make sure you escape all user-inputted fields; this protects against SQL Injections
	cleanStrings($conn, $groupName, $groupDesc);

	// Making sure that they don't just put an empty name / description
	if (strlen($groupName) < 3 || strlen($groupDesc) < 10) {
		$message = "The group name must be at least 3 characters long and the description must be at least 10 characters long.";
		return false;
	}

	// Check if a group already exists with the same name
	if ($result = mysqli_query($conn, "SELECT * FROM groups WHERE name LIKE '$groupName'")) {
		if (mysqli_num_rows($result) == 0) {
			if (!mysqli_query($conn, "INSERT INTO groups (id, name, description) VALUES (null, '$groupName', '$groupDesc')")) {
				$message = "An error occurred in creating this group: " . mysqli_error($conn);
				$success = false;
			} else {
				$message = "Created group '$groupName'!";
				$success = true;
			}
		} else {
			$message = "There is already a group with the name '$groupName'!";
			$success = false;
		}

		mysqli_free_result($result);
	} else {
		$message = "Unable to query group database!";
		$success = false;
	}
	
	return $success;
}

?>