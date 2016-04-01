<?php
	session_start();

	$_SESSION["name"] = "test_user" . rand(0, 100);

	require_once "chat.php";
?>
<!doctype html>
<html>
<body>
	<p>Howdy, <?php echo $_SESSION["name"] ?></p>

<?php
renderChatBox();
?>

</body>
</html>