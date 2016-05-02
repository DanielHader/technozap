
<?php
	session_start();
	require_once "db_connect.php";
	require_once "utils.php";
	echo '<meta charset="utf-8">';
	echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
	echo '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">';
	echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>';
  	echo '<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>';
  	echo '<body background="a.jpg">';

  	echo '<style>
    /.navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    

    .row.content {height: 450px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      //background-color: #f1f1f1;
      height: 100%;
    }
    
    

    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height:auto;} 
    }
  </style>';





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
		   <input type="submit" id="submitmsg" value="Send">
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
			// echo '[group picture maybe]<br>';
			// echo '<h1>'.$info["name"].'</h1>';
			// echo '<h3>'.$info["description"].'</h3>';

			if (isset($_SESSION["userId"])) {
				if ($result = mysqli_query($conn, "SELECT `linkid` FROM `uglink` WHERE `groupName` = '".$info["name"]."' AND `userid` = '".$_SESSION["userId"]."'")) {

		   echo '<nav class="navbar navbar-inverse">
			     <div class="container-fluid">
			      <div class="navbar-header">
			       <a class="navbar-brand ">clic</a>
			      </div>
 			      <ul class="nav navbar-nav ">
			       <li class="active"><a href="#">'.$_GET["groupName"].'</a></li>
			      </ul>
			      <ul class="nav navbar-nav navbar-right">
			       <li><a href="viewProfile.php?user='.($_SESSION["username"]).'">My Profile</a></li>
			      </ul>    
			     </div>
			    </nav>

			    <div class="container-fluid text-center">    
  			 	 <div class="row content">
    			  <div class="col-sm-2 sidenav">

                   <form action="'.($_SERVER["PHP_SELF"]).'?groupName='.$info["name"].'" method="POST">
			        <input type="hidden" name="groupName" value="'.$info["name"].'">
			        <button type="submit" class="btn btn-danger" name="leaveGroup" value="Post">Leave group</button>
				   </form>

                  </div>

    	          <div class="col-sm-8 text-left">

 		   		  <form class="form" role="form" action="'.($_SERVER["PHP_SELF"]).'?groupName='.$info["name"].'" method="POST">
				   <div class="form-group text-center">
					<input type="text" class="form-control" name="postContent" placeholder="What would you like to share?">
					<button type="submit" class="btn btn-info" name="postGroup" value="Post">Submit</button>
				   </div>
				   <div class="form-group sr-only">
					<input type="text" name="groupId" value="'.$info["id"].'">
				   </div>	  
  				  </form>
 			      <div class="container">
			      <div class="panel-group">';
				  $posts = "";
				  getGroupPosts($conn, $info["id"], $posts);
				  echo $posts;
				  echo '</div></div></div>
    			  <div class="col-sm-2 sidenav affix">';
      			  renderChatBox(str_replace(' ', '_', $groupName), 'displayGroup.php?groupName='.$info["name"]);

				  echo '</div></div>';

			}

		}			




				// if (mysqli_num_rows($result) > 0) {
				// 	// leave group button
				// 	echo '<form action="'.($_SERVER["PHP_SELF"]).'?groupName='.$info["name"].'" method="POST">';
				// 	echo '<input type="hidden" name="groupName" value="'.$info["name"].'">';
				// 	echo '<button type="submit" class="btn btn-danger" name="leaveGroup" value="Post">Leave group</button>';
				// 	echo '</form>';				
				// } else {
				// 	// join group button
				// 	echo '<form action="'.($_SERVER["PHP_SELF"]).'?groupName='.$info["name"].'" method="POST">';
				// 	echo '<input type="hidden" name="groupName" value="'.$info["name"].'">';
				// 	echo '<button type="submit" class="btn btn-info" name="joinGroup" value="Post">Join group</button>';
				// 	echo '</form>';
				// }







		} else {
			echo '<h2>Uh oh, you have 404\'d!</h2>';
			exit();
		}
	mysqli_free_result($result);
	}
?>