<?php

function cleanStrings($conn, &...$params) {
	foreach ($params as &$str) {
		$str = mysqli_real_escape_string($conn, $str);
	}
}

function getGroupList($conn) {

	$query = "SELECT * FROM groups";
	$groups = [];

	if ($result = mysqli_query($conn, $query)) {
		while ($row = mysqli_fetch_array($result)) {
			$groups[] = array($row["name"], $row["description"]);
		}
	} else {
		return NULL;
	}

	mysqli_free_result($result);
	return $groups;
}

?>