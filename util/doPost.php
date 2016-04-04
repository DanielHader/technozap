<?php
	require_once "util.php";

	function doPost($conn, $userid, $groupname, $content, &$message) {
		cleanStrings($conn, $groupname);
		$groupid = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM groups WHERE `name` LIKE '$groupname'"))["id"];
		$content = mysqli_real_escape_string($conn, $content);
		$username = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM users WHERE `id`='$userid'"))["username"];
		mysqli_query($conn, "INSERT INTO posts(`id`, `userName`, `content`, `groupid`, `date`) VALUES (null, '$username', '$content', '$groupid', null)");
		$message .= "Posted!";
	}
?>