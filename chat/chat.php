<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION["name"]) && isset($_POST["text"])) {
	echo $_POST["text"];
	$text = $_POST["text"];

	$fp = fopen("log.html", "a");
	fwrite($fp,"<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
	fclose($fp);
}

function renderChatBox() {
?>
	<link rel="stylesheet" type="text/css" href="chatstyle.css">
	<div id="chatbox">
		<div id="textbox">
			<?php
			if(file_exists("log.html") && filesize("log.html") > 0) {
				$handle = fopen("log.html", "r");
				$contents = fread($handle, filesize("log.html"));
				fclose($handle);

				echo $contents;
			}
			?>
		</div>
		<form id="message" name="message" action="">
			<input type="text" id="usermsg" name="usermsg">
			<input type="submit" id="submitmsg" value="send">
		</form>
	</div>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#submitmsg").click(function() {
				var clientmsg = $("#usermsg").val();
				$.post("chat.php", {text: clientmsg});
				loadLog();
				$("#usermsg").attr("value", "");
				return false;
			});
		});

		function loadLog() {
			var oldscrollHeight = $("#textbox").attr("scrollHeight") - 20;
			$.ajax({
				url: "log.html",
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
		}

		setInterval(loadLog, 5000);
	</script>
<?php
}



?>