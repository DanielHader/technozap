<?php

	require_once "util.php";

	function leaveGroup($conn, $group_select, $userId, &$message) {	
		$message = "";

		foreach ($group_select as $group) {
			cleanStrings($conn, $group);

			// Check if the group exists
			if ($result = mysqli_query($conn, "SELECT id FROM groups WHERE `name` LIKE '$group'")) {
				if (mysqli_num_rows($result) > 0) {
					$groupId = mysqli_fetch_array($result)["id"];

					// Checks if the user is already a part of this group
					$result = mysqli_query($conn, "SELECT * FROM uglink WHERE `groupid` = '$groupId' AND `userid` = '$userId'");
					if (mysqli_num_rows($result) > 0) {
						if (!mysqli_query($conn, "DELETE FROM `uglink` WHERE `groupid` = '$groupId' AND `userid` = '$userId'"))
							$message .= "<p>An error occurred in leaving the group: ".mysqli_error($conn)."</p>";
						else
							$message .= "<p>Left group '$group'!</p>";
					} else
						$message .= "<p>You are not a part of this group!</p>";
				} else
					$message .= "<p>There is no group called '$groupName'!<p>";
					
				mysqli_free_result($result);
			}
		}
	}

?>