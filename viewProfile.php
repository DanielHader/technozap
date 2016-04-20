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

	} else if (isset($_POST["logout"])) {
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
<style>
h2 {
   	   color: yellow;
   	   text-align: center;
   	   letter-spacing: 2px;
   	   font-family: "Times New Roman", Times, serif;
   	   font-style: italic;
   	   font-size: 50px;
   	   font-weight: bold;
  	   font-variant: small-caps;
	}
body {
	background-color: black;
	color: white;
}
form {
          text-align: center;
          margin-left: 530px;
          margin-right: 530px;
          margin-bottom: 10px;
          border: 2px solid yellow;
       }
form.idk {
	border: 2px solid black;
}
input[type=submit] {
    padding:5px 15px; 
    background:#ccc; 
    border:0 none;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 5px; 
    margin-bottom: 10px;
}
input[type=text] {
    border: 2px solid red;
    border-radius: 4px;
}
p {
       	color: yellow;
   	   text-align: center;
   	   letter-spacing: 2px;
   	   font-family: "Times New Roman", Times, serif;
   	   font-style: italic;
   	   font-size: 20px;
   	   font-weight: bold;
  	   font-variant: small-caps;
       }
</style>
</head>
<body>



<?php
			echo '<h2>'.$info["first name"].' '.$info["last name"].'</h2>';

			if (isset($_SESSION["username"]) && strcmp($_SESSION["username"], $_GET["user"]) == 0) {
				// Logout form
				echo '<form class="idk" action="'.($_SERVER["PHP_SELF"]).'?user='.$_SESSION["username"].'" method="POST">';
				echo '<input type="submit" name="logout" value="Logout">';
				echo '</form>';

				// View user's groups
				$userGroups = getUserGroupList($conn, $_SESSION["userId"]);
				echo '<div id="view_user_group_div">';
				echo '<form action="displayGroup.php" method="GET">';
				echo '<p>My Groups</p>';
				echo '<select name="groupName">';

				foreach ($userGroups as $userGroup)
					echo "<option value=\"$userGroup[0]\">$userGroup[0]</option>";

				echo '</select><br><br>';
				echo '<input type="submit" value="View">';
				echo '</form>';
				echo '</div>';	

				// View group form
				$groups = getGroupList($conn);
				echo '<div id="view_group_div">';
				echo '<form action="displayGroup.php" method="GET">';
				echo '<p>All Groups</p>';
				echo '<select name="groupName">';

				foreach ($groups as $group)
					echo "<option value=\"$group[0]\">$group[0]</option>";

				echo '</select><br><br>';
				echo '<input type="submit" value="View">';
				echo '</form>';
				echo '</div>';

				// Create group form
				echo $createGroup_notify."<br>";
				echo '<form action="'.($_SERVER["PHP_SELF"]).'?user='.$_SESSION["username"].'" method="POST">';
				echo '<p>Create Group</p>';
				echo 'Group Name:<br><input type="text" name="groupName"><br>';
				echo 'Group Description:<br><input type="text" name="groupDesc"><br><br>';
				echo '<input type="submit" name="createGroup" value="Create group">';
				echo '</form>';

				echo '<br><br>';

				// Update user info form
				echo $update_notify."<br>";
				echo '<form action="'.($_SERVER["PHP_SELF"]).'?user='.$_SESSION["username"].'" method="POST">';
				echo '<p>Change User Settings</p>';
				echo 'Password:<br>';
				echo '<input type="password" name="password"><br>';
				echo 'First Name<br>';
				echo '<input type="text" name="fname"><br>';
				echo 'Last Name:<br>';
				echo '<input type="text" name="lname"><br>';
				echo 'Email<br>';
				echo '<input type="email" name="email"><br><br>';
				echo '<input type="submit" name="updateSettings" value="Update Settings">';
				echo '</form>';

			}
		} else
			echo '<h2>Uh oh, you have 404\'d!</h2>';

		mysqli_free_result($result);
	}
?>
</body>
</html>
