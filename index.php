<?php
	session_start();

	require_once "db_connect.php"; // defines $conn
	require_once "utils.php";

	$login_notify = "";
	$register_notify = "";

	if (isset($_POST["login"])) {
		$username = mysqli_real_escape_string($conn, $_POST["username"]);
		$password = mysqli_real_escape_string($conn, $_POST["password"]);

		if (strlen($username) >= 3 && strlen($password) >= 5)
			doLogin($conn, $username, $password, $login_notify);
		else
			$login_notify = "Your username must be at least 3 characters long and password 5 characters long.";
	} else if (isset($_POST["register"])) {
		$username = mysqli_real_escape_string($conn, $_POST["username"]);
		$password = mysqli_real_escape_string($conn, $_POST["password"]);
		$fname = mysqli_real_escape_string($conn, $_POST["fname"]);
		$lname = mysqli_real_escape_string($conn, $_POST["lname"]);
		$email = mysqli_real_escape_string($conn, $_POST["email"]);

		if (strlen($username) >= 3 && strlen($password) >= 5) {
			if (strlen($fname) >= 3 && strlen($lname) >= 3)
				doRegister($conn, $username, $password, $fname, $lname, $email, $register_notify);
			else
				$register_notify = "Your first and last name should each be at least 3 characters long.";
		} else
			$register_notify = "Your username must be at least 3 characters long and password 5 characters long.";
	}
?>

<html>
	<title>TechnoZap</title>
	<h1>TechnoZap</h1>

	<?php
		if (!isset($_SESSION["userId"])) { // Not logged in; display login, register, and possibly password recovery
			echo $login_notify;
	?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				Username:<br>
				<input type="text" name="username"><br>
				Password:<br>
				<input type="password" name="password"><br><br>
				<input type="submit" name="login" value="Login">
			</form>
			
			<br>
	<?php
			echo $register_notify;
	?>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				Username:<br>
				<input type="text" name="username"><br>
				Password:<br>
				<input type="password" name="password"><br>
				First Name<br>
				<input type="text" name="fname"><br>
				Last Name:<br>
				<input type="text" name="lname"><br>
				Email<br>
				<input type="email" name="email"><br><br>
				<input type="submit" name="register" value="Register">
			</form>
	<?php
		} else { // Is logged in; redirect to profile page
			header("Location: viewProfile.php?user=".$_SESSION["username"]);
			exit();
		}
	?>
</html>