<?php
	ini_set("display_errors", true);
	include_once("config/db_setup.php");
	include_once("includes/functions.php");
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
					<a class="navbar-item" href="index.php?pageno=1">
						Home
					</a>
			<?php
				if(isset($_SESSION['user_email'])) {
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
						echo "<a class='navbar-item' href='view-posts-all.php?pageno=1'>All Posts</a>";
					}
				}
			?>
			</div>

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
		<!--content wrapper starts-->
		<div class="content_wrapper">
		<!-- test; -->
			<form action="" method="post" enctype="multipart/form-data">
						<h2 align="center">Reset password</h2>
						<table align="center">
							<tr>
								<td><input placeholder="Enter your e-mail" type="text" name="email" required></td>
							</tr>
							<tr>
								<td><input placeholder="Enter your new password" type="password" name="password" required></td>
							</tr>

					</table>
						<div align="center">
							<tr>
								<td><input class="button is-primary" type="submit" name="reset" value="Reset password"/></td>
							</tr>
						</div>

			</form>
		</div>
		<!--content wrapper ends-->
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
	try {
		include_once('includes/functions.php');
		include_once('config/connect.php');
	}
	catch(PDOException $e) {
		echo "ERROR: ".$e->getMessage();
		exit(2);
	}
	if (isset($_GET['Logout'])) {
		if ($_GET['Logout'] == 'TRUE')
			session_destroy();
		echo "<script>window.open('index.php', '_self')</script>";
	}
	if (isset($_POST['reset'])) {
		try {
			if (verify_token($_GET['ID'])) {
				$passwd = hash('whirlpool',$_POST['password']);
				$email = $_POST['email'];
				$query = ("UPDATE `users` SET user_passwd='$passwd' WHERE user_email='$email'");
				$query = $dbh->prepare($query);
				$query->execute();
				echo "<script>alert('Password Changed!');</script>";
			}
		}
		catch(PDOException $e) {
			echo "ERROR: ".$e->getMessage();
			exit(2);
		}
	}
?>
