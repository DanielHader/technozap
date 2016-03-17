<?php
	require_once 'db_connect.php';
	session_start();

	// Make sure you escape all user-inputted fields; this protects against SQL Injections
	$groupName = mysqli_real_escape_string($conn, $_POST["groupName"]);

	// Makes sure the user is logged in
	if (!isset($_SESSION["userId"])) {
		echo "You must be logged in to join a group!";
		return;
	}

	// Check if a group already exists with the same name
	if ($result = mysqli_query($conn, "SELECT `id` FROM groups WHERE `name` LIKE '$groupName'")) {
		if (mysqli_num_rows($result) > 0) {
			$groupId = mysqli_fetch_array($result)["id"];
			$userId = $_SESSION["userId"];

			if (!mysqli_query($conn, "INSERT INTO uglink (linkid, groupid, userid) VALUES (null, '$groupId', '$userId')"))
				echo "An error occurred in joining the group: ".mysqli_error($conn);
			else
				echo "Joined group '$groupName'!";
		} else
			echo "There is no group called '$groupName'!";

		mysqli_free_result($result);
	}
?>