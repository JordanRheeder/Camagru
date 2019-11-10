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
			<div class="navbar-item has-dropdown is-hoverable">
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
		<div>
		<form action="" method="post" enctype="multipart/form-data" align="center">
				<table align='center'>
				<tr>
					<td align='center' style='color: white'>......</td>
					<td><input placeholder='pic-post' type='file' name='UplPost' style="margin-left: -106px;"/></td>
					<td><input class='button is-primary' type='submit' name='CfmPost' value='Upload Post' style='margin-left: 3px; margin-top: 0px; width: 120px; height: 50%; font-size: 10px; align:center'/></td>

				</tr>
				</table>
				<td><a class='button is-primary' href='selfie.php' style='align:center; margin-left:162px;margin-top: 2px; width: 120px; height: 50%; font-size: 10px;'>Selfie?</a></td>
		</form>
			<?php
				if (isset($_POST['CfmPost'])) {
					if($_FILES['UplPost']['size'] == 0) {
						echo "try upload something next time...";
						exit(0);
					}
				}
				if (isset($_POST['CfmPost'])) {
					$new_img = $_FILES['UplPost']['name'];
					$img_tmp = $_FILES['UplPost']['tmp_name'];
					$postedWhenEpoch = time();
					$postedWhenFormatted = date('d-m-Y', $postedWhenEpoch);
					$hashedName = hash('md5', $new_img.$postedWhenEpoch);
					move_uploaded_file($img_tmp, "users/user_posts/$hashedName.png");
					if (isset($_SESSION['user_email'])) {
						include_once('config/connect.php');
						include_once('includes/functions.php');
						$user_email = $_SESSION['user_email'];
						$postQuery = ("SELECT * FROM `users` WHERE user_email='$user_email'");
						$postQuery = $dbh->prepare($postQuery);
						$postQuery->execute();
						$row = $postQuery->fetch();
						$postedBy = $row['user_id'];
						$user_email = $_SESSION['user_email'];
						$username = $row['username'];
						newPost($postedBy, $user_email, $new_img, $postedWhenEpoch, $username);
					}

					// echo "<script>alert('$hashedName')</script>";
				}
			?>
		</div>
		<!--footer starts-->
		<div id="footer">
			<h2 style="text-align:center; padding-top:30px;">jrheeder</h2>
		</div>
		<!--footer ends-->
		<!-- Scripts -->
		<script>document.addEventListener('DOMContentLoaded', () => {
			// Get all "navbar-burger" elements
			const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
			// Check if there are any navbar burgers
			if ($navbarBurgers.length > 0) {
				// Add a click event on each of them
				$navbarBurgers.forEach( el => {
					el.addEventListener('click', () => {
					// Get the target from the "data-target" attribute
						const target = el.dataset.target;
						const $target = document.getElementById(target);
						// Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
						el.classList.toggle('is-active');
						$target.classList.toggle('is-active');

					});
				});
			}
		});
		</script>
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
