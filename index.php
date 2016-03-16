<?php
    session_start();
    $error= '';
    if(isset($_POST['submit'])){
        if(empty($_POST['user'])|| empty($_POST['pass'])){
            $error= "Username or Password is invalid";
        }
        else{
            $username= $_POST['user'];
            $password= $_POST['password'];
            $connect= mysql_connect();
            $username=  stripslashes($username);
            $password= stripslashes($password);
            $username= mysql_real_escape_string($username);
            $password= mysql_real_escape_string($password);
            $data= mysql_select_db(,$connect);
            $query= mysql_query("select * from login where password= '$password' AND username='$username'", $connect);
            $rows= mysql_num_rows($query);
            if($rows == 1){
                $_SESSION['login-name']= $username;
            }
            else{
                $error= "Username or Password is invalid";
            }
            mysql_close($connect);
        }
    }
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <h1>Login Here!</h1>
        <form action="index.php" method="POST">
            Username: <input type="text" name="user"> <br>
            Password: <input type="password" name="pass"> <br>
            <input type="submit" name="submit" value="Login!">
            <span> <?php echo $error;?></span>
        </form>
    </body>
</html>
