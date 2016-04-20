<?php
	session_start();
	require_once "db_connect.php";
	require_once "utils.php";


	function renderChatBox($groupName, $postLoc) {
	?>
		<link rel="stylesheet" type="text/css" href="chatstyle.css">
		<div id="chatbox">
			<div id="textbox">
				<?php
				if(file_exists($groupName.".html") && filesize($groupName.".html") > 0) {
					$handle = fopen($groupName.".html", "r");
					$contents = fread($handle, filesize($groupName.".html"));
					fclose($handle);

					echo $contents;
				}
				?>
			</div>
				<input type="text" id="usermsg" name="usermsg">
				<input type="submit" id="submitmsg" value="send">
		</div>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$("#submitmsg").click(function() {
					var clientmsg = $("#usermsg").val();
					
					if (clientmsg.length > 1) {
					
						$.post(<?php echo '"'.$postLoc.'"'; ?>, {postChat: clientmsg});
						loadLog();
						$("#usermsg").attr("value", "");
					}
					return false;
				});
			});

			function loadLog() {
				var oldscrollHeight = $("#textbox").attr("scrollHeight") - 20;
				$.ajax({
					url: <?php echo '"'.$groupName.'.html"'; ?>,
					cache: false,
					success: function(html){		
						$("#textbox").html(html);
						
						//Auto-scroll
						var newscrollHeight = $("#textbox").attr("scrollHeight") - 20;
						if(newscrollHeight > oldscrollHeight){
							$("#textbox").animate({ scrollTop: newscrollHeight }, 'normal');
						}				
					},
				});
				return false;
			}

			setInterval(loadLog, 5000);
		</script>
	<?php
	}

	if (!isset($_GET["groupName"])) {
		echo '<h2>Uh oh, you have 404\'d!</h2>';
		exit();
	}

	$groupName = mysqli_escape_string($conn, $_GET["groupName"]);
	
	if (isset($_POST["leaveGroup"])) {
		leaveGroup($conn, $_SESSION["userId"], $_POST["groupName"]);
	}
	if (isset($_POST["joinGroup"])) {
		joinGroup($conn, $_SESSION["userId"], $_POST["groupName"]);
	}
	if (isset($_POST["postGroup"])) {
		doPost($conn, $_POST["groupId"], $_POST["postContent"]);
		unset($_POST["postContent"]);
	}
	if (isset($_POST["postChat"])) {
		$text = $_POST["postChat"];
		unset($_POST["postChat"]);

		$fp = fopen(str_replace(' ', '_', $groupName).".html", "a");
		fwrite($fp,"<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['username']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
		fclose($fp);
	}

	if ($result = mysqli_query($conn, "SELECT * FROM `groups` WHERE `name` LIKE '$groupName'")) {
		if (mysqli_num_rows($result) > 0) {
			$info = mysqli_fetch_array($result);
			echo '[group picture maybe]<br>';
			echo '<h1>'.$info["name"].'</h1>';
			echo '<h3>'.$info["description"].'</h3>';

			if (isset($_SESSION["userId"])) {
				if ($result = mysqli_query($conn, "SELECT `linkid` FROM `uglink` WHERE `groupName` = '".$info["name"]."' AND `userid` = '".$_SESSION["userId"]."'")) {

					//back to profile button
					echo '<form action="viewProfile.php?user='.($_SESSION["username"]).'" method="POST">';
					echo '<input type="submit" name="returnProfile" value="Return to Profile">';
					echo '</form>';

					if (mysqli_num_rows($result) > 0) {
						// leave group button
						echo '<form action="'.($_SERVER["PHP_SELF"]).'?groupName='.$info["name"].'" method="POST">';
						echo '<input type="hidden" name="groupName" value="'.$info["name"].'">';
						echo '<input type="submit" name="leaveGroup" value="Leave group">';
						echo '</form>';

						renderChatBox(str_replace(' ', '_', $groupName), 'displayGroup.php?groupName='.$info["name"]);

						// post to group option
						echo '<form action="'.($_SERVER["PHP_SELF"]).'?groupName='.$info["name"].'" method="POST">';
						echo '<input type="textbox" name="postContent">';
						echo '<input type="hidden" name="groupId" value="'.$info["id"].'">';
						echo '<input type="submit" name="postGroup" value="Post">';
						echo '</form>';


					} else {
						// join group button
						echo '<form action="'.($_SERVER["PHP_SELF"]).'?groupName='.$info["name"].'" method="POST">';
						echo '<input type="hidden" name="groupName" value="'.$info["name"].'">';
						echo '<input type="submit" name="joinGroup" value="Join group">';
						echo '</form>';
					}
				}
			}


			// grabbing posts
			$posts = "";
			getGroupPosts($conn, $info["id"], $posts);
			echo $posts;
			//

			// 
		} else {
			echo '<h2>Uh oh, you have 404\'d!</h2>';
			exit();
		}

		mysqli_free_result($result);
	}
?>