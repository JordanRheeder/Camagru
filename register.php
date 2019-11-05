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
			<a class="navbar-link">
				Placeholder
			</a>

		<div class="navbar-dropdown">
			<a class="navbar-item">
				Placeholder
			</a>
			<a class="navbar-item">
				Placeholder
			</a>
			<a class="navbar-item">
				Placeholder
			</a>
			<hr class="navbar-divider">
				<a class="navbar-item">
					Placeholder
				</a>
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
		</div>
		</nav>

		<!--content wrapper starts-->
		<div class="content_wrapper" align="center">
		<form action="register.php" method="post" enctype="multipart/form-data" align="center">
					<table align="center">
            <tr>
							<td align="right" style="color: white">......</td>
							<td><input placeholder="Username"type="text" name="username" required></td>
						</tr>
            <tr>
							<td align="right" style="color: white">......</td>
							<td><input placeholder="E-mail"type="text" name="email" required></td>
						</tr>
						<tr>
							<td align="right" style="color: white">.</td>
							<td><input placeholder="Password" type="password" name="user_passwd" required/></td>
						</tr>
						<tr>
							<td align="right" style="color: white">First Name:</td>
							<td><input placeholder="First name" type="text" name="firstname" required/></td>
						</tr>

						<tr>
							<td align="right" style="color: white">Surname:</td>
							<td><input placeholder="Surname" type="text" name="surname" required/></td>
						</tr>
						<tr>
							<td align="right" style="color: white">Profile Photo:</td>
							<!-- <td><input type="file" name="profilePhoto" required/></td> ADD THIS IN LATER************************ -->
							<td><input placeholder="Profile Photo" type="file" name="profilePhoto"/></td>
						</tr>
						<tr>
							<td align="right" style="color: white">Contact:</td>
							<td><input placeholder="Phone Number" type="text" name="PhoneNumber" required/></td>
						</tr>
				</table>
					<tr align="right">
						<td><input class="button is-primary" type="submit" name="register" value="Create Account" style="margin-left: -8px; align:center"/></td>
					</tr>
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

<?php
	try {
		include ('includes/functions.php');
		include ('config/connect.php');
	}
	catch(PDOException $e) {
		echo "ERROR: ".$e->getMessage();
		exit(2);
	}
	// trying to validate the email for authenticity.
	if (isset($_POST['register'])) {
		$check_mail = $_POST['email'];
		if (validate_email($check_mail) === 1)
			echo "";
		else {
			echo "<script>alert('Please enter a real e-mail.');</script>";
			exit(2);
		}
	}

	if (isset($_POST['register'])) {
		try {
			$passwd = hash('whirlpool',$_POST['user_passwd']);
      $username = $_POST['username'];
			$firstname = $_POST['firstname'];
			$surname = $_POST['surname'];
			$img = $_FILES['profilePhoto']['name'];
			$image_tmp = $_FILES['profilePhoto']['tmp_name'];
			$contact = $_POST['PhoneNumber'];
			$email = $_POST['email'];
			$token = hash('md5', $email);
			$verified = 0;
			move_uploaded_file($image_tmp, "users/user_images/$img");
			$query = "INSERT INTO `users` (user_passwd, user_firstname, user_surname, user_email, username, user_contact, user_image, token, verified) VALUES (?,?,?,?,?,?,?,?,?)";
      $query = $dbh->prepare($query);

			//********* checking the database for existing emails or users *********
			$verifySQL = ("SELECT user_email FROM `users` WHERE user_email=:user_email");
			$verify = $dbh->prepare($verifySQL);
			$verify->bindParam(':user_email', $email, PDO::PARAM_STR);
			$verify->execute();
			$row = $verify->fetch();
			$check_email  = $row['user_email'];

			if (empty($row['user_email'])) {
			$query->bindParam('1', $passwd);
			$query->bindParam('2', $firstname);
			$query->bindParam('3', $surname);
			$query->bindParam('4', $email);
      $query->bindParam('5', $username);
			$query->bindParam('6', $contact);
			$query->bindParam('7', $img);
			$query->bindParam('8', $token);
			$query->bindParam('9', $verified);
			$query->execute();
				if (mailVerifCode($email, $token, $firstname))
					echo "<script>alert('Account created!');</script>";
			}
			else
				echo "<script>alert('You already have an account!');</script>";
		}
		catch(PDOException $e) {
			echo "ERROR: ".$e->getMessage();
			exit(2);
		}
	}

	if (isset($_GET['token'])) {
		$token = $_GET['token'];
		try {
			if (verify_token($token)) {
				$verifyToken = ("SELECT * FROM `users`");
				$verifyToken = $dbh->prepare($verifyToken);
				$verifyToken->execute();
				$row = $verifyToken->fetch();
				$updateValid = ("UPDATE `users` SET `verified` = 1 WHERE `token`=?");
				$updateValid = $dbh->prepare($updateValid);
				$updateValid->bindParam('1', $token, PDO::PARAM_STR);
				$updateValid->execute();
			}
			else {
				echo "<script>alert('Failed, please try again.');</script>";
			}
		}
		catch(PDOException $e) {
			echo "ERROR: ".$e->getMessage();
			exit(2);
		}
	}
?>
</html>
