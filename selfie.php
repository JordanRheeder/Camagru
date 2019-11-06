<?php
	ini_set("display_errors", true);
	include ("config/db_setup.php");
	if (session_id() === "") {
		session_start();
	}
	else {
		$session_id=session_id();
	}
	// include("functions/functions.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Camagru</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
	</head>
<body>
	<!-- <div class="main_wrapper"> -->
		<nav class="navbar" role="navigation" aria-label="main navigation">
			<div class="navbar-brand">
				<a class="navbar-item" href="index.php">
					<img src="images/final.gif" width="112px" height="112px">
				</a>
				<a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
					<span aria-hidden="true"></span>
					<span aria-hidden="true"></span>
					<span aria-hidden="true"></span>
				</a>
			</div>
			<div id="navbarBasicExample" class="navbar-menu">
				<div class="navbar-start">
					<a class="navbar-item" href="index.php">
						Home
					</a>
			<?php
				if(isset($_SESSION['user_email'])) {
					// echo "<a href='index.php?Logout=TRUE'>Logout</a>";
					echo "<a class='navbar-item' href='my_account.php'>My Account</a>";
				}
				else {
					echo "";
				}
			?>
			<div class="navbar-item">
			<?php
				if(!isset($_SESSION['user_email'])) {
					echo "";
				}
				else {
					echo "</a>";
					echo "<a class='navbar-item' href='post-img.php'>";
					echo "Post";
					echo "</a>";
					if (isset($_SESSION['user_email'])) {
						echo "<a class='navbar-item' href='view-posts.php'>My Posts</a>";
					}
					if (isset($_SESSION['user_email'])) {
						echo "<a class='navbar-item' href='view-posts-all.php'>All Posts</a>";
					}
				}
			?>

				</div>
			</div>
		</div>
			<div class="navbar-end">
				<div class="navbar-item">
					<div class="buttons">
						<?php
							if(isset($_SESSION['user_email'])) {
								echo "";
							}
							else {
								echo "<a class='button is-primary' href='register.php'>";
								echo "<strong>Sign up</strong>";
								echo "</a>";
							}
						?>
						<?php
						if(isset($_SESSION['user_email'])) {
							echo "<a class='button is-light' href='login.php?Logout=TRUE'>Log out</a>";
						}
						else {
								echo "<a class='button is-light' href='login.php'>Log in</a>";
						}
						?>

					</div>
				</div>
			</div>
		</nav>

<!-- Stream video via webcam -->
	<div class="video-wrap">
	    <video id="video" autoplay></video>
	</div>

	<!-- Trigger canvas web API -->
	<div class="controller">
	    <button id="snap" class="button is-primary">Capture</button>
	</div>

	<!-- Webcam video snapshot -->
	<canvas id="canvas" width="640" height="480"></canvas>

	<form action="" method="post" enctype="multipart/form-data" align="center">
		<table align='center'>
		<tr>
			<td><input id='selfie' type='hidden' name='selfie' value='' style="margin-left: -106px;"/></td>
			<td><input id='submitSelfie' class='button is-primary' onClick="download()" type='submit' name='submitSelfie' value='Upload Post' style='margin-left: 3px; margin-top: 0px; width: 120px; height: 50%; font-size: 10px; align:center'/></td>
		</tr>
		</table>
	</form>
<!-- <a id="download" download="image.png"><button type="button" onClick="download()">Download</button></a> -->
		<script>
		// 'use strict';

		const video = document.getElementById('video');
		const canvas = document.getElementById('canvas');
		const snap = document.getElementById("snap");
		const errorMsgElement = document.querySelector('span#errorMsg');


		const constraints = {
		  audio: false,
		  video: {
		    width: 640, height: 480
		  }
		};

		// Access webcam
		async function init() {
		  try {
		    const stream = await navigator.mediaDevices.getUserMedia(constraints);
		    handleSuccess(stream);
		  } catch (e) {
		    errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
		  }
		}

		// Success
		function handleSuccess(stream) {
		  window.stream = stream;
		  video.srcObject = stream;
		}

		// Load init
		init();

		// Draw image
		var context = canvas.getContext('2d');
		snap.addEventListener("click", function() {
			context.drawImage(video, 0, 0, 640, 480);
		});
		function download(){
        	// var download = document.getElementById("download");
        	var image = document.getElementById("canvas").toDataURL("image/png")
			// var image = document.getElementById("canvas").toDataURL("image/png");
        	// download.setAttribute("href", image);
			document.getElementById("selfie").value = image;
    }
</script>


	<?php
		include('includes/functions.php');
		if (isset($_POST['submitSelfie'])) {
			$test = $_POST['selfie'];
			echo $test;
			// $output_file = $_SESSION['user_email'];
			// $output_fileHash = hash('md5', $output_file);
			// $file = base64_to_jpeg($test, $output_fileHash);
			$filename_path = md5(time().uniqid()).".png";
			$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $test));
			file_put_contents("users/user_selfie/".$filename_path,$data);
			// $new_img = $_FILES['selfie']['name'];
			// $img_tmp = $_FILES['selfie']['tmp_name'];
			// echo "<script>alert('$new_img')</script>";
			// echo "<script>alert('$img_tmp')</script>";
			// echo $file;
		}
	?>
		<!-- <div>
		</div> -->
		<!--footer starts-->
		<div id="footer">
			<h2 style="text-align:center; padding-top:30px;">jrheeder</h2>
		</div>
		<!--footer ends-->
		<!-- Scripts -->


		<!-- Scripts end -->


  </body>
</html>
<?php
  if (isset($_GET['Logout'])) {
	if ($_GET['Logout'] == 'TRUE')
	  session_destroy();
	  echo "<script>window.open('index.php', '_self')</script>";
  }
?>
