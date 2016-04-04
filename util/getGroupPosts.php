<?php
	function viewGroupContent($conn, $groupName, &$message) {
		cleanStrings($conn, $groupName);
		$message .= "<b>".$groupName."</b><br>";
		$groupId = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM groups WHERE `name` LIKE '$groupName'"))["id"];
		
		$result = mysqli_query($conn, "SELECT * FROM posts WHERE `groupid` = '$groupId' ORDER BY `date` DESC");
		
		while ($curPost = mysqli_fetch_array($result, MYSQLI_ASSOC))
			$message .= '<div style="width:500px;height:100px;border:1px solid #000;">'.$curPost["userName"].' - '.($curPost["date"]).'<br>'.$curPost["content"].'</div><br>';
	}
?>