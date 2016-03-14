<?php
	require_once 'db_connect.php';

	// Make sure you escape all user-inputted fields; this protects against SQL Injections
	$groupName = mysqli_escape_string($_POST["groupName"]);
	$groupDesc = mysqli_escape_string($_POST["groupDesc"]);

	// Check if a group already exists with the same name
	if ($result = mysqli_query($conn, "SELECT * FROM Groups WHERE `name` LIKE '$groupName'")) {
		if (mysqli_num_rows($result) == 0) {
			if (!mysqli_query($conn, "INSERT INTO groups (id, name, description) VALUES (null, '$groupName', '$groupDesc')"))
				echo "An error occurred in creating this group: ".mysqli_error($conn);
		} else
			echo "There is already a group with the name '$groupName'!";

		mysqli_free_result($result);
	}
?>