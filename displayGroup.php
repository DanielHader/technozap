<?php
	session_start();
	require_once "db_connect.php";
	require_once "utils.php";

	if (!isset($_GET["groupName"])) {
		echo '<h2>Uh oh, you have 404\'d!</h2>';
		exit();
	} else if (isset($_POST["leaveGroup"])) {
		leaveGroup($conn, $_SESSION["userId"], $_POST["groupId"]);
	} else if (isset($_POST["joinGroup"])) {
		joinGroup($conn, $_SESSION["userId"], $_POST["groupId"]);
	} else if (isset($_POST["postGroup"])) {
		doPost($conn, $_POST["groupId"], $_POST["postContent"]);
	}

	$groupName = mysqli_escape_string($conn, $_GET["groupName"]);
	if ($result = mysqli_query($conn, "SELECT * FROM `groups` WHERE `name` LIKE '$groupName'")) {
		if (mysqli_num_rows($result) > 0) {
			$info = mysqli_fetch_array($result);
			echo '[group picture maybe]<br>';
			echo '<h1>'.$info["name"].'</h1>';
			echo '<h3>'.$info["description"].'</h3>';

			if (isset($_SESSION["userId"])) {
				if ($result = mysqli_query($conn, "SELECT `linkid` FROM `uglink` WHERE `groupid` = '".$info["id"]."' AND `userid` = '".$_SESSION["userId"]."'")) {
					if (mysqli_num_rows($result) > 0) {
						// leave group button
						echo '<form action="'.($_SERVER["PHP_SELF"]).'?groupName='.$info["name"].'" method="POST">';
						echo '<input type="hidden" name="groupId" value="'.$info["id"].'">';
						echo '<input type="submit" name="leaveGroup" value="Leave group">';
						echo '</form>';

						// post to group option
						echo '<form action="'.($_SERVER["PHP_SELF"]).'?groupName='.$info["name"].'" method="POST">';
						echo '<input type="textbox" name="postContent">';
						echo '<input type="hidden" name="groupId" value="'.$info["id"].'">';
						echo '<input type="submit" name="postGroup" value="Post">';
						echo '</form>';
					} else {
						// join group button
						echo '<form action="'.($_SERVER["PHP_SELF"]).'?groupName='.$info["name"].'" method="POST">';
						echo '<input type="hidden" name="groupId" value="'.$info["id"].'">';
						echo '<input type="submit" name="joinGroup" value="Join group">';
						echo '</form>';
					}

					//back to profile button
					echo '<form action="viewProfile.php" method="POST">';
					echo '<input type="submit" name="returnProfile" value="Return to Profile">';
					echo '</form>';
				}
			}


			// grabbing posts
			$posts = "";
			getGroupPosts($conn, $info["id"], $posts);
			echo $posts;
			//

			// 
		} else {
			echo '<h2>Uh oh, you have 404\'d!</h2>';
			exit();
		}

		mysqli_free_result($result);
	}
?>