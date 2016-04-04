<?php
require_once "util/db_connect.php";
require_once "util/createGroup.php";
require_once "util/joinGroup.php";
require_once "util/login.php";
require_once "util/register.php";
require_once "util/getGroupPosts.php";
require_once "util/doPost.php";
require_once "util/leaveGroup.php";

session_start();

function registerForm() {
?>
	<form action="index.php" method="POST">
		Username:	<input type="text" name="username"><br>
		Password:	<input type="password" name="password"><br>
		First Name:	<input type="text" name="firstname"><br>
		Last Name:	<input type="text" name="lastname"><br>
		Email:		<input type="text" name="email"><br>
		
		<input type="text" hidden="true" name="register" value="1">
		<input type="submit" value="Register">
	</form>
<?php
}

function loginForm() {
?>
	<form action="index.php" method="POST">
		Username:	<input type="text" name="username"><br>
		Password:	<input type="password" name="password"><br>
		
		<input type="text" hidden="true" name="login" value="1">
		<input type="submit" value="Login">
	</form>
<?php
}

function logoutForm() {
?>
	<form action="index.php" method="POST">

		<input type="text" hidden="true" name="logout" value="1">
		<input type="submit" value="Logout">
	</form>	
<?php
}

function createGroupForm() {
?>
	<form action="index.php" method="POST">
		
		Group Name:			<input type="text" name="groupName"><br>
		Group Description:	<input type="text" name="groupDesc"><br>
		
		<input type="text" hidden="true" name="create_group" value="1">
		<input type="submit" value="Create group">
	</form>
<?php
}

function joinGroupForm() {
	$conn = connect();
	$groups	= getGroupList($conn);
	close($conn);
?>
	<div id="join_group_div">
		Join Group
		<form action="index.php" method="POST">
			<select name="group_select[]" multiple="multiple">
			
			<?php
			foreach ($groups as $group) {
				echo "<option value=\"$group[0]\">$group[0]</option>";
			}
			?>

			</select>
			<input type="text" hidden="true" name="join_group" value="1">
			<input type="submit" value="join">
		</form>
	</div>
<?php
}

function leaveGroupForm() {
	$conn = connect();
	$groups	= getGroupList($conn);
	close($conn);
?>
	<div id="leave_group_div">
		Leave Group
		<form action="index.php" method="POST">
			<select name="group_select[]" multiple="multiple">
			
			<?php
			foreach ($groups as $group) {
				echo "<option value=\"$group[0]\">$group[0]</option>";
			}
			?>

			</select>
			<input type="text" hidden="true" name="leave_group" value="1">
			<input type="submit" value="leave">
		</form>
	</div>
<?php
}

function viewGroupContentForm() {
	$conn = connect();
	$groups	= getGroupList($conn);
	close($conn);
?>
	<div id="view_group_div">
		View Group Content
		<form action="index.php" method="POST">
			<select name="group_select[]" multiple="multiple">
			
			<?php
			foreach ($groups as $group) {
				echo "<option value=\"$group[0]\">$group[0]</option>";
			}
			?>

			</select>
			<input type="text" hidden="true" name="view_group" value="1">
			<input type="submit" value="view">
		</form>
	</div>
<?php
}

function doPostForm() {
	$conn = connect();
	$groups	= getGroupList($conn);
	close($conn);
?>
	<div id="post_group_div">
		Post
		<form action="index.php" method="POST">
			<select name="group_select[]" multiple="multiple">
			
			<?php
			foreach ($groups as $group) {
				echo "<option value=\"$group[0]\">$group[0]</option>";
			}
			?>

			</select>
			<br>
			<input type="text" name="post_group_content">
			<input type="text" hidden="true" name="post_group" value="1">
			<input type="submit" value="post">
		</form>
	</div>
<?php
}


function generateHTML($message) {
	
	?>
	<html>
		<title>Techno Zap!</title>
		<body>
			<h1>Techno Zap!</h1>
	<?php

	echo "<h3>$message</h3><hr>";

	if (!isset($_SESSION["userId"])) {
		loginForm();
		echo "<hr>";
		registerForm();
	
	} else {
		logoutForm();
		echo "<hr>";
		createGroupForm();
		echo "<hr>";
		joinGroupForm();
		echo "<hr>";
		leaveGroupForm();
		echo "<hr>";
		viewGroupContentForm();
		echo "<hr>";
		doPostForm();
	}

	?>
		</body>
	</html>
	<?php
}

	$conn = connect();
	if (!$conn)
		die("Could not connect to MySQL server: ".mysqli_connect_error());

	$message = "";
	if (isset($_POST["logout"])) {
		$message = "you are now logged out";
		unset($_SESSION["userId"]);
		unset($_POST["logout"]);
	} else if (isset($_POST["register"])) {
		register($conn, $_POST["username"], $_POST["password"], $_POST["firstname"], $_POST["lastname"], $_POST["email"], $message);
		unset($_POST["register"]);
	} else if (isset($_POST["create_group"])) {
		createGroup($conn, $_POST["groupName"], $_POST["groupDesc"], $message);
		unset($_POST["create_group"]);
	} else if (isset($_POST["login"])) {
		$userId = 0;
		if (login($conn, $_POST["username"], $_POST["password"], $userId, $message))
			$_SESSION["userId"] = $userId;
		unset($_POST["login"]);
	} else if (isset($_POST["join_group"])) {
		joinGroup($conn, $_POST["group_select"], $_SESSION["userId"], $message);
		unset($_POST["join_group"]);
	} else if (isset($_POST["leave_group"])) {
		leaveGroup($conn, $_POST["group_select"], $_SESSION["userId"], $message);
		unset($_POST["leave_group"]);
	} else if (isset($_POST["view_group"])) {
		viewGroupContent($conn, $_POST["group_select"], $message);
		unset($_POST["view_group"]);
	} else if (isset($_POST["post_group"])) {
		doPost($conn, $_SESSION["userId"], $_POST["group_select"], $_POST["post_group_content"], $message);
		unset($_POST["post_group"]);
	}

	generateHTML($message);

	close($conn);
?>
