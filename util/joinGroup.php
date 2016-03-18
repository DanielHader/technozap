<?php

require_once "util.php";

function joinGroup($conn, $group_select, $userId, &$message) {
		
	$message = "";

	foreach ($group_select as $group) {
		cleanStrings($conn, $group);

		// Check if a group already exists with the same name
		if ($result = mysqli_query($conn, "SELECT id FROM groups WHERE `name` LIKE '$group'")) {
			if (mysqli_num_rows($result) > 0) {
				$groupId = mysqli_fetch_array($result)["id"];

				if (!mysqli_query($conn, "INSERT INTO uglink (linkid, groupid, userid) VALUES (null, '$groupId', '$userId')")) {
					$message .= "<p>An error occurred in joining the group: ".mysqli_error($conn)."</p>";
				}
				else
					$message .= "<p>Joined group '$group'!</p>";
			} else
				$message .= "<p>There is no group called '$groupName'!<p>";

			mysqli_free_result($result);
		}
	}
}

?>