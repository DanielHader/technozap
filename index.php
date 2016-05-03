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
	<title>grϋp</title>
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
	<h1 class="text-center">grϋp</h1>

	<?php
		if (!isset($_SESSION["userId"])) { // Not logged in; display login, register, and possibly password recovery
			echo $login_notify;
	?>

	<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
		<div class="panel panel-default">
		<div class="panel-heading">Login</div>
		<div class="panel-body">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<div class="form-group">
					<label for="username_input">Username:</label>
					<input type="text" name="username" class="form-control" id="username_input" placeholder="Username">
				</div>
				<div class="form-group">
					<label for="password_input">Password:</label>
					<input type="password" name="password" class="form-control" id="password_input" placeholder="Password">
				</div>
				<button type="submit" name="login" class="btn btn-default">Login</button>
			</form>
		</div>
		</div>
	</div>
	<div class="col-sm-3"></div>
	</div>

	<?php
			echo $register_notify;
	?>

	<div class="row">
	<div class="col-sm-3"></div>
	<div class="col-sm-6">
		<div class="panel panel-default">
		<div class="panel-heading">Register</div>
		<div class="panel-body">
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<div class="form-group">
					<label for="username_reg">Username:</label>
					<input type="text" name="username" class="form-control" id="username_reg" placeholder="Username">
				</div>
				<div class="form-group">
					<label for="password_reg">Password:</label>
					<input type="password" name="password" class="form-control" id="password_reg" placeholder="Password">
				</div>
				<div class="form-group">
					<label for="firstname_reg">First Name:</label>
					<input type="text" name="fname" class="form-control" id="firstname_reg" placeholder="First Name">
				</div>
				<div class="form-group">
					<label for="lastname_reg">Last Name:</label>
					<input type="text" name="lname" class="form-control" id="lastname_reg" placeholder="Last Name">
				</div>
				<div class="form-group">
					<label for="email_reg">Email:</label>
					<input type="email" name="email" class="form-control" id="email_reg" placeholder="Email">
				</div>
				<button type="submit" name="register" class="btn btn-default">Register</button>
			</form>
		</div>
		</div>
		</div>
	</div>
	<div class="col-sm-3"></div>
	</div>
	</div>
	
	</body>
</html>

<?php
	} else { // Is logged in; redirect to profile page
		header("Location: viewProfile.php?user=".$_SESSION["username"]);
		exit();
	}
?>