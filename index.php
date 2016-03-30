<?php
require_once "util/db_connect.php";
require_once "util/createGroup.php";
require_once "util/joinGroup.php";
require_once "util/login.php";
require_once "util/register.php";

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
		echo"<hr>";
		joinGroupForm();
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

		if (login($conn, $_POST["username"], $_POST["password"], $userId, $message)) {
			$_SESSION["userId"] = $userId;
		}
		
		unset($_POST["login"]);

	} else if (isset($_POST["join_group"])) {

		joinGroup($conn, $_POST["group_select"], $_SESSION["userId"], $message);
		unset($_POST["join_group"]);
	}

	generateHTML($message);

	close($conn);
?>
