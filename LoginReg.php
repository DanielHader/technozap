<html>
<title>Log in or Register</title>
<body bgcolor="lightblue">
<h1><center>Welcome to Techno Zap! Please register or log in below</center></h1>
<div style="width:400px; margin-right:auto; margin-left:auto; border:1px solid #000;">
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
</div>
<br>
<br>
<br>
<div style="width:400px; margin-right:auto; margin-left:auto; border:1px solid #000;">
	<form action="LoginReg.php" method="POST">
	    <b>Returning user? Log in below!</b><br>
		Username:	<input type="text" name="username"><br>
		Password:	<input type="password" name="password"><br>
		
		<input type="text" hidden="true" name="login" value="1">
		<input type="submit" value="Login">
	</form>
</div>
</body>
</html>