<?php
	session_start();
	require_once "db_connect.php";
	require_once "utils.php";

	$createGroup_notify = "";
	$update_notify = "";

	if (!isset($_GET["user"])) {
		var_dump($_GET);
		echo '<h2>Uh oh, you have 404\'d!</h2>';
		exit();
	} else if (isset($_POST["createGroup"])) {
		createGroup($conn, $_POST["groupName"], $_POST["groupDesc"], $createGroup_notify);
	} else if (isset($_POST["updateSettings"])) {
		$password = mysqli_real_escape_string($conn, $_POST["password"]);
		$fname = mysqli_real_escape_string($conn, $_POST["fname"]);
		$lname = mysqli_real_escape_string($conn, $_POST["lname"]);
		$email = mysqli_real_escape_string($conn, $_POST["email"]);

		if (strlen($fname) >= 3 && strlen($lname) >= 3 && strlen($password) >= 5)
			doUpdateSettings($conn, $password, $fname, $lname, $email, $update_notify);
		else
			$update_notify = "Your first and last name should each be at least 3 characters long, and you password must be at least 5 characters long.";	

	}
	if (isset($_POST["logout"])) {
		doLogout();
		exit();
	}

	$viewUsername = mysqli_real_escape_string($conn, $_GET["user"]);
	if ($result = mysqli_query($conn, "SELECT * FROM `users` WHERE `username` LIKE '$viewUsername'")) {
		if (mysqli_num_rows($result) > 0) {
			$info = mysqli_fetch_array($result);
?>
<html>
<head>
	<script   src="https://code.jquery.com/jquery-2.2.3.min.js"   integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="   crossorigin="anonymous"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script type="text/javascript" src="https://gc.kis.scr.kaspersky-labs.com/1B74BD89-2A22-4B93-B451-1C9E1052A0EC/main.js" charset="UTF-8"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="default.css">
</head>
<body>
	<div class="container-fluid">
<?php
			echo '<h1 class="text-center">'.$info["first name"].' '.$info["last name"].'</h1>';

			if (isset($_SESSION["username"]) && strcmp($_SESSION["username"], $_GET["user"]) == 0) {
				// Logout form

				echo '<div class="row">';
					echo '<div class="col-sm-10"></div>';
					echo '<div class="col-sm-1">';
					echo '<form action="viewProfile.php?user='.$_SESSION["username"].'" method="POST">';
					echo '<button type="submit" name="logout" class="btn btn-default">Logout</button>';
					echo '</form>';
					echo '<div class="col-sm-1"></div>';
				echo '</div></div>';

				echo '<hr>';

				
				echo '<div class="row">';
				
					// View user's groups
					$userGroups = getUserGroupList($conn, $_SESSION["userId"]);
					echo '<div class="col-sm-1"></div>';
					echo '<div id="view_user_group_div" class="col-sm-5">';
					echo '<div class="panel panel-default">';
					echo '<div class="panel-heading">My Groups</div>';
					echo '<div class="panel-body">';
					echo '<form action="displayGroup.php" method="GET">';
					echo '<div class="form-group">';
					echo '<select name="groupName" class="form-control">';


					foreach ($userGroups as $userGroup)
						echo "<option value=\"$userGroup[0]\">$userGroup[0]</option>";

					echo '</select></div>';
					echo '<button type="submit" class="btn btn-default">View</button>';
					echo '</form>';
					echo '</div></div></div>';	

					// View group form
					$groups = getGroupList($conn);
					echo '<div id="view_group_div" class="col-sm-5">';
					echo '<div class="panel panel-default">';
					echo '<div class="panel-heading">All Groups</div>';
					echo '<div class="panel-body">';
					echo '<form action="displayGroup.php" method="GET">';
					echo '<div class="form-group">';
					echo '<select name="groupName" class="form-control">';

					foreach ($groups as $group)
						echo "<option value=\"$group[0]\">$group[0]</option>";

					echo '</select></div>';
					echo '<button type="submit" class="btn btn-default">View</button>';
					echo '</form>';
					echo '</div></div></div>';
					echo '<div class="col-sm-1"></div>';

				echo '</div>';

				echo '<div class="row">';
				echo '<div class="col-sm-3"></div>';
				echo '<div class="col-sm-6">';
				echo '<div class="panel panel-default">';
				echo '<div class="panel-heading">Create Group</div>';
				echo '<div class="panel-body">';
				// Create group form
				echo $createGroup_notify."<br>";
				echo '<form action="'.($_SERVER["PHP_SELF"]).'?user='.$_SESSION["username"].'" method="POST">';
				echo '<div class="form-group">';
				echo '<label for="name_in">Group Name:</label>';
				echo '<input type="text" name="groupName" class="form-control" id="name_in" placeholder="Group Name">';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<label for="desc_in">Group Description:</label>';
				echo '<textarea name="groupDesc" rows="3" class="form-control" id="desc_in" placeholder="Group Description"></textarea>';
				echo '</div>';
				echo '<button type="submit" name="createGroup" class="btn btn-default">Create group</button>';
				echo '</form>';

				echo '</div></div></div>';
				echo '<div class="col-sm-3"></div>';
				echo '</div>';

				echo '<div class="row">';
				echo '<div class="col-sm-3"></div>';
				echo '<div class="col-sm-6">';
				
				echo '<div class="panel panel-default">';
				echo '<div class="panel-heading">Change User Settings</div>';
				echo '<div class="panel-body">';
				// Update user info form
				echo $update_notify."<br>";
				echo '<form action="'.($_SERVER["PHP_SELF"]).'?user='.$_SESSION["username"].'" method="POST">';

				echo '<div class="form-group">';
				echo '<label for="passc">Password:</label>';
				echo '<input type="password" name="password" class="form-control" id="passc" placeholder="Password">';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<label for="fnamec">First Name:</label>';
				echo '<input type="text" name="fname" class="form-control" id="fnamec" placeholder="First Name">';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<label for="lnamec">Last Name:</label>';
				echo '<input type="text" name="lname" class="form-control" id="lnamec" placeholder="Last Name">';
				echo '</div>';
				echo '<div class="form-group">';
				echo '<label for="email">Email:</label>';
				echo '<input type="email" name="email" class="form-control" id="email" placeholder="Email">';
				echo '</div>';
				echo '<button type="submit" name="updateSettings" class="btn btn-default">Update Settings</button>';
				echo '</form>';

				echo '</div></div>';
				echo '</div><div class="col-sm-3"></div>';

				echo '</div>';


			}
		} else {
			echo '<h1 class="text-center">Uh oh, you have 404\'d!</h1>';
		}

		mysqli_free_result($result);
	}
?>
	</div>
</body>
</html>
