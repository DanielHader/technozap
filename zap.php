<?php
$loggedin = false;
$error = false;
$wecool = false;
$wenotcool = false;
$existing = false;
$weevencooler = false;
$omg = false;
$wenotbad = false;
$usernames = array();
$passwords = array();
$firstnames = array();
$lastnames = array();
$emails = array();
$count = 0;
$file = fopen("users.txt", "r") or die("Unable to open file.");
while(!feof($file)){
   $line = fgets($file);
   $line = trim($line);
   if(strlen($line) > 0){
      $arr = explode(";", $line);
	  $usernames[$count] = $arr[0];
      $passwords[$count] = $arr[1];
      $firstnames[$count] = $arr[2];
      $lastnames[$count] = $arr[3];
      $emails[$count] = $arr[4];
	  $count = $count + 1;
	  if((isset($_REQUEST['usr'])) && (isset($_REQUEST['pswd']))) {
         if(($_REQUEST['usr'] == $arr[0]) && ($_REQUEST['pswd'] == $arr[1])) {
            $loggedin = true;
         }
         else {
            $error = true;
         }
     }
   }
}
fclose($file);
   
if(isset($_REQUEST['registered'])) {
      if((empty($_REQUEST['usr2']) || (empty($_REQUEST['pswd2'])) || (empty($_REQUEST['fname'])) || (empty($_REQUEST['lname'])) || (empty($_REQUEST['email']))))
         $wenotcool = true; 
      else
         $wecool = true;
}

if($wecool == true) {
    for($x = 0; $x < $count; $x++) {
       if($usernames[$x] == $_REQUEST['usr2'])
          $existing = true;
       else
          $wenotbad = true;
    }
if($wenotbad == true) {
   if($existing == false)
      $weevencooler = true;
}
}

if($weevencooler == true) {
   $file = fopen("users.txt", "a") or die("Unable to open file.");
   $newuser = $_REQUEST['usr2'].';'.$_REQUEST['pswd2'].';'.$_REQUEST['fname'].';'.$_REQUEST['lname'].';'.$_REQUEST['email'].PHP_EOL;
   fwrite($file, $newuser);
   fclose($file);
   $omg = true;
   session_destroy();
}

if($wenotcool == true) {
?>
<html>
	
	<head>
		<meta charset="UTF-8">
		<title>cool website</title>
	</head>

	<body>
		<img src="title.png">
		<h1>yo! what's up guys?</h1>
		<p>check out our website so far!</p>
		<p>it's pretty rad</p>
		
		<p>Log in to your Technozap account</p>
		<form name="loginForm" action="zap.php" method="GET">
		Username:<br>
		<input type="text" name="username"><br>
		Password:<br>
		<input type="text" name="password"><br>
		<input type="submit" value="Login">
		</form>
		
		<p>Don't have an account? Register here!</p>
		<p>ERROR REGISTERING. ALL FORM FIELDS MUST BE FILLED IN</p>
		<form name="regForm" action="zap.php" method="GET">
		First Name:<br>
		<input type="text" name="fname"><br>
		Last Name:<br>
		<input type="text" name="lname"><br>
		Username:<br>
		<input type="text" name="usr2"><br>
		Password:<br>
		<input type="text" name="pswd2"><br>
		Email:<br>
		<input type="text" name="email"><br>
		<input type="hidden" name="registered" value="hoi">
		<input type="submit" value="Register">
		</form>
	</body>

</html>
<?php
}
else if($existing == true) {
?>
<html>
	
	<head>
		<meta charset="UTF-8">
		<title>cool website</title>
	</head>

	<body>
		<img src="title.png">
		<h1>yo! what's up guys?</h1>
		<p>check out our website so far!</p>
		<p>it's pretty rad</p>
		
		<p>Log in to your Technozap account</p>
		<form name="loginForm" action="zap.php" method="GET">
		Username:<br>
		<input type="text" name="username"><br>
		Password:<br>
		<input type="text" name="password"><br>
		<input type="submit" value="Login">
		</form>
		
		<p>Don't have an account? Register here!</p>
		<p>ERROR REGISTERING. USERNAME IS ALREADY TAKEN</p>
		<form name="regForm" action="zap.php" method="GET">
		First Name:<br>
		<input type="text" name="fname"><br>
		Last Name:<br>
		<input type="text" name="lname"><br>
		Username:<br>
		<input type="text" name="usr2"><br>
		Password:<br>
		<input type="text" name="pswd2"><br>
		Email:<br>
		<input type="text" name="email"><br>
		<input type="hidden" name="registered" value="hoi">
		<input type="submit" value="Register">
		</form>
	</body>

</html>
<?php
}
else if($omg == true) {
?>
<html>
	
	<head>
		<meta charset="UTF-8">
		<title>cool website</title>
	</head>

	<body>
		<img src="title.png">
		<h1>yo! what's up guys?</h1>
		<p>check out our website so far!</p>
		<p>it's pretty rad</p>
		
		<p>Log in to your Technozap account</p>
		<form name="loginForm" action="zap.php" method="GET">
		Username:<br>
		<input type="text" name="username"><br>
		Password:<br>
		<input type="text" name="password"><br>
		<input type="submit" value="Login">
		</form>
		
		<p>Don't have an account? Register here!</p>
		<p>REGISTRATION SUCCESSFUL</p>
		<form name="regForm" action="zap.php" method="GET">
		First Name:<br>
		<input type="text" name="fname"><br>
		Last Name:<br>
		<input type="text" name="lname"><br>
		Username:<br>
		<input type="text" name="usr2"><br>
		Password:<br>
		<input type="text" name="pswd2"><br>
		Email:<br>
		<input type="text" name="email"><br>
		<input type="hidden" name="registered" value="hoi">
		<input type="submit" value="Register">
		</form>
	</body>

</html>
<?php
}
else {
?>
<html>
	
	<head>
		<meta charset="UTF-8">
		<title>cool website</title>
	</head>

	<body>
		<img src="title.png">
		<h1>yo! what's up guys?</h1>
		<p>check out our website so far!</p>
		<p>it's pretty rad</p>
		
		<p>Log in to your Technozap account</p>
		<form name="loginForm" action="zap.php" method="GET">
		Username:<br>
		<input type="text" name="username"><br>
		Password:<br>
		<input type="text" name="password"><br>
		<input type="submit" value="Login">
		</form>
		
		<p>Don't have an account? Register here!</p>
		<form name="regForm" action="zap.php" method="GET">
		First Name:<br>
		<input type="text" name="fname"><br>
		Last Name:<br>
		<input type="text" name="lname"><br>
		Username:<br>
		<input type="text" name="usr2"><br>
		Password:<br>
		<input type="text" name="pswd2"><br>
		Email:<br>
		<input type="text" name="email"><br>
		<input type="hidden" name="registered" value="hoi">
		<input type="submit" value="Register">
		</form>
	</body>

</html>
<?php
}
?>