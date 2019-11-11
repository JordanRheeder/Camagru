<?php
	ini_set("display_errors", true);
	include_once("config/db_setup.php");
	if (session_id() === "") {
		session_start();
	}
	else {
		$session_id=session_id();
	}
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
				<a class="navbar-item" href="index.php?pageno=1">
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
					<a class="navbar-item" href="index.php?pageno=1">Home</a>
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
						echo "<a class='navbar-item' href='view-posts-all.php?pageno=1'>All Posts</a>";
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
	<div class="video-wrap" align="center">
	    <video id="video" autoplay align="center"></video>
	</div>

	<!-- Trigger canvas web API -->
	<div class="controller" align="center">
	    <button id="snap" class="button is-primary" align="center">Capture</button>
	</div>

	<!-- Webcam video snapshot -->
<div align="center">
	<canvas  align="center" id="canvas" width="640" height="480"></canvas>
</div>
	<!-- <form action="" method="post" enctype="multipart/form-data" align="center">
		<table align='center'>
		<tr>
<td><input id='selfie' type='hidden' name='selfie' value='' style="margin-left: -106px;"/></td>
<td><input id='submitSelfie' class='button is-primary' onClick="download()" type='submit' name='submitSelfie' value='Upload Post' style='margin-left: 3px; margin-top: 0px; width: 120px; height: 50%; font-size: 10px; align:center'/></td>
		</tr>
		</table>
	</form> -->
	<div align="center" style="margin-left: 5px; margin-top: 10px;">
	<div class="dropdown is-hoverable">
	  <div class="dropdown-trigger">
	    <button class="button is-primary" aria-haspopup="true" aria-controls="dropdown-menu4">
	      <span>Stickers</span>
	      <span class="icon is-small">
	        <i class="fas fa-angle-down" aria-hidden="true"></i>
	      </span>
	    </button>
	  </div>
	  <div class="dropdown-menu" id="dropdown-menu4" role="menu">
	    <div class="dropdown-content" style="margin-left: -70px;">
	      <div class="dropdown-item">
	        <p>
					<form action="#" method="post" enctype="multipart/form-data" align="center">
						<table align='center'>
	<tr>
		<td><input class="checkbox is-primary" type='checkbox' name='sticker[]' value='1'/>1</td>
	</tr>
	<tr>
		<td><input class="checkbox is-primary" type='checkbox' name='sticker[]' value='2'/>2</td>
	</tr>
	<tr>
		<td><input class="checkbox is-primary" type='checkbox' name='sticker[]' value='3'/>3</td>
	</tr>
	<tr>
		<td><input class="checkbox is-primary" type='checkbox' name='sticker[]' value='4'/>4</td>
	</tr>
	<td><input id='selfie' type='hidden' name='selfie' value='' style="margin-left: -106px;"/></td>
	<td><input id='submitSelfie' class='button is-primary' onClick="download()" type='submit' name='submitSelfie' value='Upload Post' style='margin-left: 3px; margin-top: 0px; width: 120px; height: 50%; font-size: 10px; align:center'/></td>
						</table>
					</form>
			</p>
		</div>
	</div>
	</div>
	</div>
	</div>
		<script>
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
        	var image = document.getElementById("canvas").toDataURL("image/png");
			// var image = document.getElementById("canvas").toDataURL("image/png");
        	// download.setAttribute("href", image);
			document.getElementById("selfie").value = image;
    }
</script>
<script>
	function onlyOne(checkbox) {
	    var checkboxes = document.getElementsByName('check')
	    checkboxes.forEach((item) => {
	        if (item !== checkbox) item.checked = false
	    })
	}
</script>
	<?php
		include_once('includes/functions.php');
			if(isset($_POST['submitSelfie'])) {
				$selfie = $_POST['selfie'];

			$filename_path = md5(time().uniqid()).".png";
			$imgsrc = storeImage($selfie, $filename_path);
			}
			if (isset($_POST['submitSelfie'])) {
				if(!empty($_POST['sticker'])) {
				foreach($_POST['sticker'] as $check) {
					$imgs = superImpose($imgsrc, $check);
				}
				echo "<div align=middle style='margin-top:-536px'><img src='users/user_posts/$imgsrc' style='')/></div>";
				if (isset($_SESSION['user_email'])) {
					include_once('config/connect.php');
					$user_email = $_SESSION['user_email'];
					$postQuery = ("SELECT * FROM `users` WHERE user_email='$user_email'");
					$postQuery = $dbh->prepare($postQuery);
					$postQuery->execute();
					$row = $postQuery->fetch();
					$postedBy = $row['user_id'];
					$user_email = $_SESSION['user_email'];
					$username = $row['username'];
					$postedWhen = time();
					newPostSelfie($postedBy, $user_email, $filename_path, $postedWhen, $username);
				}
			}
		}

	?>
	<div>
		<?php
			include_once("includes/functions.php");
			$email = $_SESSION['user_email'];
			get_upload_thumbs($email);
		?>
	</div>
	</body>
</html>
<?php
	// if ($_SESSION == NULL){
	// 	echo "";
	// }
	// else {
	// 	$email = $_SESSION['user_email'];
	// 	if (isVerifiedUser($email) == '1') {
	// 		echo "";
	// 	}
	// 	else if (isVerifiedUser($email) == '0')
	// 	{
	// 		echo "<script>alert('Verify your account please')</script>";
	// 		echo "<script>window.open('index.php', '_self')</script>";
	// 		session_destroy();
	// 	}
	// }
	if (isset($_GET['Logout'])) {
		if ($_GET['Logout'] == 'TRUE')
			session_destroy();
		echo "<script>window.open('index.php', '_self')</script>";
	}
?>
