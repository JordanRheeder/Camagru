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

		<?php
			if (isset($_GET['img'])) {
				$img = $_GET['img'];
				echo "<img id='myImg' src='users/user_posts/$img' alt='$img' style='width:100%;max-width:300px'>";
			}
		?>
		<div class="buttons">
			<!-- Query the db to see who owns this pic -->
			<!-- If it's true then show delete post button ELSE don't -->
			<!-- Create like and comments -->
		<?php
			include_once('includes/functions.php');
			if (isset($_GET['img'])) {
				$img = $_GET['img'];
			}
			$userEmail = $_SESSION['user_email'];
			echo ('Likes: '.tallyLikes($img));
			echo "<a class='button is-primary' href='lookMy.php?Like=TRUE&img=$img'>Like Post</a>";
			if (!isset($_GET['img'])) {
				echo "";
			}
			else {
				// query DB FUNCTION
				echo "<a class='button is-primary' href='lookMy.php?Delete=TRUE&img=$img'>Delete Post</a>";
			}

		?>
		<form action="#" method="post" enctype="multipart/form-data" align="center">
			<table align="center">
				<br>
				<br>
				<tr>
					<td align="right" style="color: white">......</td>
					<td><textarea name="txtcomment" style="width:350px; height: 100px;" maxlength="300"></textarea></td>
					<td><input class='button is-primary' type='submit' name='submitComment' value='Comment' style='margin-left: 5px; margin-top: 50px; width: 120px; height: 50%; font-size: 10px; align: center'/></td>
				</tr>
			</table>
			<!-- <a class='button is-primary' href='look.php'>Delete Post</a> -->
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
	include_once('includes/functions.php');
	if (isset($_GET['Logout'])) {
			if ($_GET['Logout'] == 'TRUE')
				logout();
			echo "<script>window.open('index.php', '_self')</script>";
		}
	try {
		include_once('includes/functions.php');
		$userEmail = $_SESSION['user_email'];
		// $img = $_GET['img'];
		echoComments($img);
		if (isset($_GET['Like']))
		{
			if ($_GET['Like'] == 'TRUE') {
			likePost($img, $userEmail);
			echo "<script>window.open('lookMy.php?img=$img', '_self')</script>";
			}
		}
	}
	catch(PDOException $e) {
		echo "ERROR: ".$e->getMessage();
		exit(2);
	}

		if (isset($_POST['submitComment'])) {
			include_once('includes/functions.php');

			$comment = $_POST['txtcomment'];
			$email = $_SESSION['user_email'];
			$img = $_GET['img'];
			commentNotif($img, $email);
			getPostID($img, $email, $comment);
			echo "<script>window.open('lookMy.php?img=$img', '_self')</script>";
			// --> get pk from the poster. needed? fuck no...
		}

	if (isset($_GET['Delete'])) {
		if ($_GET['Delete'] == 'TRUE') {
			// DELETE POST FUNCTION
			$userEmail = $_SESSION['user_email'];
			$img = $_GET['img'];
			echo $img;
			deletePost($userEmail, $img);
			echo "<script>window.open('index.php', '_self')</script>";
		}
	}
?>
