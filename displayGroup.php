<?php
	session_start();
	require_once "db_connect.php";
	require_once "utils.php";


	function renderChatBox($groupName, $postLoc) {

	?>
		<div class="panel panel-default" id="chatbox">
			<div class="panel-body pre-scrollable" id="textbox">
				<?php
				if(file_exists($groupName.".html") && filesize($groupName.".html") > 0) {
					$handle = fopen($groupName.".html", "r");
					$contents = fread($handle, filesize($groupName.".html"));
					fclose($handle);

					echo $contents;
				}
				?>
			</div>
		</div>
		<input type="text" id="usermsg" class="form-control" name="usermsg" placeholder="Message">
		<button type="submit" id="submitmsg" value="send" class="btn btn-default">Send</button>
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

?>
<html>
<head>
	<script   src="https://code.jquery.com/jquery-2.2.3.min.js"   integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="   crossorigin="anonymous"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script type="text/javascript" src="https://gc.kis.scr.kaspersky-labs.com/1B74BD89-2A22-4B93-B451-1C9E1052A0EC/main.js" charset="UTF-8"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="default.css">
</head>
<body>

<?php

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
			echo '<h1 class="text-center">'.$info["name"].'</h1>';
			echo '<h3 class="text-center">'.$info["description"].'</h3>';
			echo '[group picture maybe]';

			if (isset($_SESSION["userId"])) {
				if ($result = mysqli_query($conn, "SELECT `linkid` FROM `uglink` WHERE `groupName` = '".$info["name"]."' AND `userid` = '".$_SESSION["userId"]."'")) {

					echo '<div class="row">';
					echo '<div class="col-sm-10"></div>';
					echo '<div class="col-sm-1">';
					//back to profile button
					echo '<form action="viewProfile.php?user='.($_SESSION["username"]).'" method="POST">';
					echo '<button type="submit" name="returnProfile" class="btn btn-default">Return to Profile</button>';
					echo '</form></div>';
					echo '<div class="col-sm-1"></div></div>';

					if (mysqli_num_rows($result) > 0) {
						// leave group button
						echo '<div class="row">';
						echo '<div class="col-sm-10"></div>';
						echo '<div class="col-sm-1">';
						echo '<form action="'.($_SERVER["PHP_SELF"]).'?groupName='.$info["name"].'" method="POST">';
						echo '<input type="hidden" name="groupName" value="'.$info["name"].'">';
						echo '<button type="submit" name="leaveGroup" class="btn btn-default">Leave group</button>';
						echo '</form>';
						echo '</div><div class="col-sm-1"></div>';
						echo '</div>';
						echo '<hr>';

/*
						// post to group option
						echo '<form action="'.($_SERVER["PHP_SELF"]).'?groupName='.$info["name"].'" method="POST">';
						echo '<input type="textbox" name="postContent">';
						echo '<input type="hidden" name="groupId" value="'.$info["id"].'">';
						echo '<input type="submit" name="postGroup" value="Post">';
						echo '</form>';
*/

					} else {
						// join group button
						echo '<div class="row">';
						echo '<div class="col-sm-10"></div>';
						echo '<div class="col-sm-1">';
						echo '<form action="'.($_SERVER["PHP_SELF"]).'?groupName='.$info["name"].'" method="POST">';
						echo '<input type="hidden" name="groupName" value="'.$info["name"].'">';
						echo '<button type="submit" name="joinGroup" class="btn btn-default">Join group</button>';
						echo '</form>';
						echo '</div><div class="col-sm-1"></div>';
						echo '</div>';
						echo '<hr>';
					}
				}
			}


			// grabbing posts
			$posts = '<div class="row">';
			$posts .= '<div class="col-sm-1"></div>';
			$posts .= '<div class="col-sm-5">';
			$posts .= '<div class="panel panel-default">';
			$posts .= '<div class="panel-heading">Group Posts</div>';
			$posts .= '<div class="panel-body">';
			
			getGroupPosts($conn, $info["id"], $posts);

			$posts .= '</div></div></div>';
			$posts .= '<div class="col-sm-5">';
			
			if (mysqli_num_rows($result) > 0) {

				$posts .= '<div class="panel panel-default">';
				$posts .= '<div class="panel-heading">Chat</div>';
				$posts .= '<div class="panel-body">';

				echo $posts;

				renderChatBox(str_replace(' ', '_', $groupName), 'displayGroup.php?groupName='.$info["name"]);

				$posts = '</div></div>';
	
			} else {

			}
			$posts .= '</div>';
			$posts .= '<div class="col-sm-1"></div>';
			$posts .= '</div>';
			//$posts .= '</div>';
			//$posts .= '</div>';
			//$posts .= '</div>';
			
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
</body>
</html>