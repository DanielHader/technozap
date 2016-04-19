<?php
	session_start();
	require_once "db_connect.php";
	require_once "utils.php";

	$createGroup_notify = "";

	if (!isset($_GET["user"])) {
		echo '<h2>Uh oh, you have 404\'d!</h2>';
		exit();
	} else if (isset($_POST["createGroup"])) {
		createGroup($conn, $_POST["groupName"], $_POST["groupDesc"], $createGroup_notify);
	} else if (isset($_POST["logout"])) {
		doLogout();
		exit();
	}

	$viewUsername = mysqli_real_escape_string($conn, $_GET["user"]);
	if ($result = mysqli_query($conn, "SELECT * FROM `users` WHERE `username` LIKE '$viewUsername'")) {
		if (mysqli_num_rows($result) > 0) {
			$info = mysqli_fetch_array($result);
			echo "[picture here maybe]<br>";
			echo '<h2>'.$info["first name"].' '.$info["last name"].'</h2>';

			if (isset($_SESSION["username"]) && strcmp($_SESSION["username"], $_GET["user"]) == 0) {
				// Logout form
				echo '<form action="'.($_SERVER["PHP_SELF"]).'?user='.$_SESSION["username"].'" method="POST">';
				echo '<input type="submit" name="logout" value="Logout">';
				echo '</form>';

				
				// Create group form
				echo $createGroup_notify."<br>";
				echo '<form action="'.($_SERVER["PHP_SELF"]).'?user='.$_SESSION["username"].'" method="POST">';
				echo 'Group Name:<br><input type="text" name="groupName"><br>';
				echo 'Group Description:<br><input type="text" name="groupDesc"><br><br>';
				echo '<input type="submit" name="createGroup" value="Create group">';
				echo '</form>';

				echo '<br><br>';

				// View group form
				$groups = getGroupList($conn);
				echo '<div id="view_group_div">';
				echo 'View Group';
				echo '<form action="displayGroup.php" method="GET">';
				echo '<select name="groupName">';

				foreach ($groups as $group)
					echo "<option value=\"$group[0]\">$group[0]</option>";

				echo '</select><br><br>';
				echo '<input type="submit" value="View">';
				echo '</form>';
				echo '</div>';
				//
			}
		} else
			echo '<h2>Uh oh, you have 404\'d!</h2>';

		mysqli_free_result($result);
	}
?>