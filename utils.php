<?php
	function doLogin($conn, $username, $password, &$login_notify) {
		$hashed = hash("sha256", "SUPERSECRETSALT".$password);
		if ($result = mysqli_query($conn, "SELECT `id` FROM `users` WHERE `username` LIKE '".$username."' AND `password` LIKE '".$hashed."'")) {
			if (mysqli_num_rows($result) > 0) {
				$info = mysqli_fetch_array($result);
				$_SESSION["userId"] = $info['id'];
				$_SESSION["username"] = strtolower($username);
			} else
				$login_notify = "That combination of username and password does not exist for any accounts.<br>";

			mysqli_free_result($result);
		}
	}

	function doLogout() {
		session_unset();
	    session_destroy();
	    session_write_close();
	    setcookie(session_name(),'',0,'/');
	    session_regenerate_id(true);
	    header("Location: ../");
	}

	function doRegister($conn, $username, $password, $fname, $lname, $email, &$register_notify) {
		if ($result = mysqli_query($conn, "SELECT `id` FROM `users` WHERE `username` LIKE '".$username."' OR `email` LIKE '".$email."'")) {
			if (mysqli_num_rows($result) == 0) {
				$hashed = hash("sha256", "SUPERSECRETSALT".$password);
				if (mysqli_query($conn, "INSERT INTO `users` (`id`, `username`, `password`, `first name`, `last name`, `email`) VALUES (NULL, '$username', '$hashed', '$fname', '$lname', '$email')"))
					$register_notify = "Successfully registered!<br>";
			} else
				$register_notify = "That username and/or email has already been taken.<br>";
			mysqli_free_result($result);
		}
	}

	function doUpdateSettings($conn, $password, $fname, $lname, $email, &$update_notify) {
		if ($result = mysqli_query($conn, "SELECT `id` FROM `users` WHERE `email` LIKE '$email' AND `id` !=  '".$_SESSION["userId"]."'")) {
			if (mysqli_num_rows($result) == 0) {
				$hashed = hash("sha256", "SUPERSECRETSALT".$password);
				if (mysqli_query($conn, "UPDATE users SET `password` = '$hashed', `first name` = '$fname', `last name` = '$lname', `email` = '$email' WHERE `id` = '".$_SESSION["userId"]."'"))
					$update_notify = "Settings updated!<br>";
			} else
				$update_notify = "That email has already been taken.<br>";
			mysqli_free_result($result);
		}
	}	

	function createGroup($conn, $groupName, $groupDesc, &$createGroup_notify) {
		$groupName = mysqli_real_escape_string($conn, $groupName);
		$groupDesc = mysqli_real_escape_string($conn, $groupDesc);
		
		if (strlen($groupName) < 3 || strlen($groupDesc) < 10) {
			$createGroup_notify = "The group name must be at least 3 characters long and the description must be at least 10 characters long.";
			return false;
		}

		if ($result = mysqli_query($conn, "SELECT * FROM groups WHERE name LIKE '$groupName'")) {
			if (mysqli_num_rows($result) == 0) {
				if (!mysqli_query($conn, "INSERT INTO groups (id, name, description) VALUES (null, '$groupName', '$groupDesc')"))
					$createGroup_notify = "An error occurred in creating this group: " . mysqli_error($conn);
				else
					$createGroup_notify = "Created group '$groupName'!";
			} else
				$createGroup_notify = "There is already a group with the name '$groupName'!";

			mysqli_free_result($result);
		}
	}

	function getGroupList($conn) {
		$groups = [];
		if ($result = mysqli_query($conn, "SELECT * FROM groups")) {
			while ($row = mysqli_fetch_array($result))
				$groups[] = array($row["name"], $row["description"]);

			mysqli_free_result($result);
		} else
			return NULL;

		return $groups;
	}

	function getUserGroupList($conn, $userId) {
		$userGroups = [];
		if ($result = mysqli_query($conn, "SELECT `groupName` FROM `uglink` WHERE `userid` = '$userId'")) {
			while ($row = mysqli_fetch_array($result))
				$userGroups[] = array($row["groupName"]);

			mysqli_free_result($result);
		} else
			return NULL;

		return $userGroups;
	}	

	function getGroupPosts($conn, $groupId, &$output) {
		if ($result = mysqli_query($conn, "SELECT * FROM posts WHERE `groupid` = '$groupId' ORDER BY `date` DESC")) {
			while ($curPost = mysqli_fetch_array($result, MYSQLI_ASSOC))
				$output .= '<div style="width:500px;height:100px;border:1px solid #000;">'.$curPost["userName"].' - '.($curPost["date"]).'<br>'.$curPost["content"].'</div><br>';

			mysqli_free_result($result);
		}
	}

	function leaveGroup($conn, $userId, $groupname) {
		mysqli_query($conn, "DELETE FROM `uglink` WHERE `groupName` = '$groupname' AND `userId` = '$userId' LIMIT 1");
	}

	function joinGroup($conn, $userId, $groupname) {
		mysqli_query($conn, "INSERT INTO `uglink` (`linkid`, `groupName`, `userid`) VALUES (NULL, '$groupname', '$userId')");
	}

	function doPost($conn, $groupId, $content) {
		$content = mysqli_real_escape_string($conn, $content);
		mysqli_query($conn, "INSERT INTO posts(`id`, `userName`, `content`, `groupid`, `date`) VALUES (null, '".$_SESSION["username"]."', '$content', '$groupId', null)");
	}
?>