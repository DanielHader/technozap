<?php
	session_start();

	if (isset($_POST["logout"])) {
		echo "You are now logged out";
		unset($_SESSION["userId"]);
	}
?>

<html>
  <title>TechnoZap</title>
  <h1>TechnoZap</h1>
  
	<body>

  		<hr><br>
		<form action="register.php" method="POST">
      		Username:<input type="text" name="username"><br>
      		Password:<input type="text" name="password"><br>
      		First Name:<input type="text" name="firstname"><br>
      		Last Name:<input type="text" name="lastname"><br>
      		Email:<input type="text" name="email"><br>
    		<input type="submit" value="Register">
    	</form>
  		<hr><br>
  		<?php
  			if (!isset($_SESSION["userId"])) {
  				?>
		    	<form action="login.php" method="POST">
		      		Username:<input type="text" name="username"><br>
		      		Password:<input type="text" name="password"><br>
		    		<input type="submit" value="Login">
		    	</form>
		    	<?php
		    } else {
		    	echo "Logged in as userid: ".$_SESSION["userId"];
		    	?>
		    	<form action="" method="POST">
					<input type="text" hidden="true" name="logout" value="1">
		    		<input type="submit" value="Logout">
		    	</form>
		    	<?php
		    }
    	?>
  		<hr><br>
    	<form action="createGroup.php" method="POST">
      		Group Name:<input type="text" name="groupName"><br>
      		Group Description:<input type="text" name="groupDesc"><br>
    		<input type="submit" value="Create group">
    	</form>
		<hr><br>
		<form action="joinGroup.php" method="POST">
      		Group Name:<input type="text" name="groupName"><br>
    		<input type="submit" value="Join group">
    	</form>
		<hr><br>

	</body>


</html>