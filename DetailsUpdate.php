<?php
	ini_set("display_errors", true);
	session_start();
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
			</div>
		</nav>
		<br/>
		<div class="content_wrapper" align="center">
		<form action="" method="post" enctype="multipart/form-data" align="center">
				<table align='center'>
				<tr>
					<td align='center' style='color: white'>......</td>
					<td><input placeholder='E-mail' type='text' name='user_email' ></td>
					<td><input class='button is-primary' type='submit' name='updateEMAIL' value='Change Email' style='margin-left: 3px; margin-top: 0px; height: 50%; width: 120px; font-size: 10px; align:center'/></td>
				</tr>
				</table>
		</form>

		<form action="" method="post" enctype="multipart/form-data" align="center">
				<table align='center'>
				<tr>
					<td align='center' style='color: white'>......</td>
					<td><input placeholder='Username' type='text' name='UN' ></td>
					<td><input class='button is-primary' type='submit' name='updateUN' value='Change Username' style='margin-left: 3px; margin-top: 0px; height: 50%; width: 120px; font-size: 10px; align:center'/></td>
				</tr>
				</table>
		</form>

		<form action="" method="post" enctype="multipart/form-data" align="center">
				<table align='center'>
				<tr>
					<td align='center' style='color: white'>......</td>
					<td><input placeholder='Password' type='password' name='user_password' ></td>
					<td><input class='button is-primary' type='submit' name='updatePASSWORD' value='Change Password' style='margin-left: 3px; margin-top: 0px; width: 120px;  height: 50%; font-size: 10px; align:center'/></td>
				</tr>
				</table>
		</form>

		<form action="" method="post" enctype="multipart/form-data" align="center">
				<table align='center'>
				<tr>
					<td align='center' style='color: white'>......</td>
					<td><input placeholder='First Name' type='text' name='user_firstname' ></td>
					<td><input class='button is-primary' type='submit' name='updateNAME' value='Update First Name' style='margin-left: 3px; margin-top: 0px; width: 120px; height: 50%; font-size: 10px; align:center'/></td>
				</tr>
				</table>
		</form>

		<form action="" method="post" enctype="multipart/form-data" align="center">
				<table align='center'>
				<tr>
					<td align='center' style='color: white'>......</td>
					<td><input placeholder='Surname' type='text' name='user_surname' ></td>
					<td><input class='button is-primary' type='submit' name='updateSURNAME' value='Update Surname' style='margin-left: 3px; margin-top: 0px; width: 120px; height: 50%; font-size: 10px; align:center'/></td>
				</tr>
				</table>
		</form>
				<form action="" method="post" enctype="multipart/form-data" align="center">
						<table align='center'>
						<tr>
							<td align='center' style='color: white'>......</td>
							<td><input placeholder='1 = ON 0 = OFF' type='text' name='notify' ></td>
							<td><input class='button is-primary' type='submit' name='updateNotify' value='Update Acc Notications' style='margin-left: 3px; margin-top: 0px; width: 120px; height: 50%; font-size: 10px; align:center'/></td>
						</tr>
						</table>
				</form>
				<form action="" method="post" enctype="multipart/form-data" align="center">
						<table align='center'>
						<tr>
							<td align='center' style='color: white'>......</td>
							<td><input placeholder='1 = ON 0 = OFF' type='text' name='cNotify' ></td>
							<td><input class='button is-primary' type='submit' name='commentNotify' value='Comment Notications' style='margin-left: 3px; margin-top: 0px; width: 120px; height: 50%; font-size: 10px; align:center'/></td>
						</tr>
						</table>
				</form>
		<form action="" method="post" enctype="multipart/form-data" align="center">
				<table align='center'>
				<tr>
					<td align='center' style='color: white'>......</td>
					<td><input placeholder='Contact' type='text' name='user_contact' ></td>
					<td><input class='button is-primary' type='submit' name='updateCONTACT' value='Update Contact' style='margin-left: 3px; margin-top: 0px; width: 120px; height: 50%; font-size: 10px; align:center'/></td>
				</tr>
				</table>
		</form>
		<form action="" method="post" enctype="multipart/form-data" align="center">
				<table align='center'>
				<tr>
					<td align='center' style='color: white'>......</td>
					<td><input placeholder='ProfilePhoto' type='file' name='user_IMG' style="margin-left: -106px;"/></td>
					<td><input class='button is-primary' type='submit' name='updatePHOTO' value='Update Profile Photo' style='margin-left: 3px; margin-top: 0px; width: 120px; height: 50%; font-size: 10px; align:center'/></td>
				</tr>
				</table>
		</form>

		</div>
	<?php
		include_once('config/connect.php');
		include_once('includes/functions.php');
		// ini_set("display_errors", TRUE);
		// We need to select the users profile picture from DB.
		// ***************************************************
		$queryUser = ("SELECT * FROM `users` WHERE user_email=:user_email");
		$queryU = $dbh->prepare($queryUser);
		$user_email = $_SESSION['user_email']; // old email
		$queryU->bindParam(':user_email', $user_email, PDO::PARAM_STR);
		$queryU->execute();
		$row = $queryU->fetch();
		$user_email = $row['user_email'];
		$old_img = $row['user_image'];
		$old_username = $row['username'];
		// echo $old_img;
		$old_surname = $row['user_surname'];
		$old_contact = $row['user_contact'];
		// $old_img = $row['user_image'];
		$old_name = $row['user_firstname'];
		$old_pass = $row['user_passwd'];
		if (isset($_POST['updateEMAIL'])) {
			$newEmail = strtolower($_POST['user_email']);
			if (validate_email($newEmail) === 1)
				echo "";
			else {
				echo "<script>alert('Please enter a valid e-mail.');</script>";
				exit(2);
			}
			// NEW EMAIL FUNCTION ++ RESET VALID EMAIL;
			resetValidEmail($user_email, $newEmail);
			session_destroy();
			echo "<script>alert('Please re-validate your account and log back in.');</script>";
			echo "<script>window.open('index.php', '_self')</script>";
		}
		else if (isset($_POST['updatePASSWORD'])) {
			$test = $_POST['user_password'];
			$new_pass = hash('whirlpool', $_POST['user_password']);
			newPass($old_pass, $new_pass, $user_email);
		}
		else if (isset($_POST['updateNAME'])) {
			$new_name = $_POST['user_firstname'];
			newFName($old_name, $new_name, $user_email);
		}
		else if (isset($_POST['updateSURNAME'])) {
			$new_surname = $_POST['user_surname'];
			newSurname($old_surname, $new_surname, $user_email);
		}
		else if (isset($_POST['updateCONTACT'])) {
			$new_contact = $_POST['user_contact'];
			newContact($old_contact, $new_contact, $user_email);
		}
		else if (isset($_POST['updatePHOTO'])) {
			$new_img = $_FILES['user_IMG']['name'];
			$img_tmp = $_FILES['user_IMG']['tmp_name'];
			move_uploaded_file($_FILES['user_IMG']['tmp_name'], "users/user_images/$new_img");
			newImg($old_img, $new_img, $user_email);
			// copy($_FILES['user_IMG']['name'], "users/user_images/'$new_img'");
			// echo $new_img;
		}
		else if (isset($_POST['updateUN'])) {
			$new_username = $_POST['UN'];
			newUN($old_username, $new_username, $user_email);
		}
		else if (isset($_POST['updateNotify'])) {
			$notify = $_POST['notify'];
			$user_email = $_SESSION['user_email'];
			update_notify($user_email, $notify);
		}
		else if (isset($_POST['commentNotify'])) {
			$cNotify = $_POST['cNotify'];
			$user_email = $_SESSION['user_email'];
			// update_ComNotify($user_email, $cNotify);
		}
		?>
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
<?php
	try {
		include('config/connect.php');
	}
	catch(PDOException $e) {
		echo "ERROR: ".$e->getMessage();
		exit(2);
	}
?>
</html>
<?php
	if (isset($_GET['Logout'])) {
		if ($_GET['Logout'] == 'TRUE')
		session_destroy();
		echo "<script>window.open('index.php', '_self')</script>";
	}
?>
