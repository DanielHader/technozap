<?php
    require_once 'db_connect.php';
    session_start();
    
    $error = 'Did not run';
    if (empty($_POST['username'])|| empty($_POST['password']))
        $error = "Username or password is invalid";
    else {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $result = mysqli_query($conn, "SELECT `id` FROM users WHERE `password` LIKE '$password' AND `username` LIKE '$username'");
        
        if (!$result)
            echo mysqli_error($conn);
        else {
            if (mysqli_num_rows($result) > 0) {
                $_SESSION["userId"] = mysqli_fetch_array($result)["id"];
                $error = "Login success!";
            } else
                $error = "Username or password is invalid!";
        }
    }

    echo $error;
?>