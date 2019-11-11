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
	<style>

	</style>
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
			<?php
				include('config/connect.php');
				if (isset($_GET['pageno'])) {
					$pageno = $_GET['pageno'];
				} else {
					$pageno = 1;
				}
				$query = "SELECT count(`img_name`) FROM `images`";
				$query = $dbh->prepare($query);
				$query->execute();
				$row = $query->fetch();
				$numrows = $row[0];
				$rows_per_page = 10;
				$lastpage = ceil($numrows/$rows_per_page);
				$pagenot = (int)$pageno;
				if ($pageno > $lastpage) {
					$pageno = $lastpage;
				}
				if ($pageno < 1) {
					$pageno = 1;
				}
				$limit = 'LIMIT '.($pageno - 1) * $rows_per_page.','.$rows_per_page;
				$query = "SELECT `img_name` FROM `images` $limit";
				$query = $dbh->prepare($query);
				$query->execute();
				$result = $query->fetch();
				if ($pageno == 1) {
					echo " FIRST PREV ";
				} else {
					echo " <a href='{$_SERVER['PHP_SELF']}?pageno=1'>FIRST</a>";
					$prevpage = $pageno-1;
					echo " <a href='{$_SERVER['PHP_SELF']}?pageno=$prevpage'>PREV</a>";
				}
				echo " (Page $pageno of $lastpage) ";
				if ($pageno == $lastpage) {
					echo "NEXT LAST";
				} else {
					$nextpage = $pageno+1;
					echo "<a href='{$_SERVER['PHP_SELF']}?pageno=$nextpage'>NEXT</a>";
					echo "<a href='{$_SERVER['PHP_SELF']}?pageno=$lastpage'> LAST</a>";
				}
				include ('includes/functions.php');
				if(isset($_SESSION['user_email'])) {
					$user_email = $_SESSION['user_email'];
					if (isset($_GET['pageno'])) {
						$pageNum = $_GET['pageno'];
						$start = 5*$pageNum;

					$img = allUsersPosts($start);
					foreach ($img as $img) {
						echo "<a href=lookAll.php?img=$img><img src='users/user_posts/$img' alt='$img' style='width:100%;max-width:300px'></a>";
					}
					}
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
