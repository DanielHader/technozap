<html>
<head>
<title>Log in or Register</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1> Welcome to TechnoZap!</h1>
<div>
	<form action="LoginReg.php" method="POST">
	    <b>Don't have an account? Register below!</b><br>
		Username:	<input type="text" name="username"><br>
		Password:	<input type="password" name="password"><br>
		First Name:	<input type="text" name="firstname"><br>
		Last Name:	<input type="text" name="lastname"><br>
		Email:		<input type="text" name="email"><br>
		
		<input type="text" hidden="true" name="register" value="1">
		<input type="submit" value="Register">
	</form>
<br>
<br>
<br>
	<form action="LoginReg.php" method="POST" id="form2">
	    <b>Returning user? Log in below!</b><br>
		Username:	<input type="text" name="username"><br>
		Password:	<input type="password" name="password"><br>
		
		<input type="text" hidden="true" name="login" value="1">
		<input type="submit" value="Login">
	</form>
</div>
</body>
</html>