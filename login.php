<?php
include('includes/functions.php');
ini_set("display_errors", true);
if (session_id() === "") {
  session_start();
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
		<div class="content_wrapper">
		<div class="loginForm" align="center">
	<form method="post" action="" align="center">
		<table align="center" bgcolor="white">
			<tr>
				<td align="right"></td>
				<td><input type="text" name="email" placeholder="Enter Email" required/></td>
			</tr>
			<tr>
				<td align="right"></td>
				<td><input type="password" name="pass" placeholder="Enter Password" required/></td>
			</tr>
		</table>
			<tr>
				<td colspan="3"><input class="button is-primary" type="submit" name="login" value="login"/></td>
			</tr>
	</form>
		<form action="reset.php">
			<button class="button is-primary">Forgot password?</button>
		</form>
				<!-- <button class="button is-primary">Forgot password?</button> -->
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
	//********* Try connect to db, else echo error *********
	try {
		include ('config/connect.php');
	}
	catch(PDOException $e) {
		echo "ERROR: ".$e->getMessage();
		exit(2);
	}
	//******************************************************

		if (isset($_POST['login'])) {
			try {
				$email = strtolower($_POST['email']);
				$passwd = hash('whirlpool', $_POST['pass']);

				//********* Select password and email from the database to check whether it's a match. Then login... *********
				$verifySQL = ("SELECT * FROM `users` WHERE user_passwd=:user_passwd AND user_email=:user_email");
				$verify = $dbh->prepare($verifySQL);
				$verify->bindParam(':user_email', $email, PDO::PARAM_STR);
				$verify->bindParam(':user_passwd', $passwd, PDO::PARAM_STR);
				$verify->execute();
				//************************************************************************************************************

				//********* Fetch from table to verify *********
				$row = $verify->fetch();
				$check_email  = $row['user_email'];
				$check_passwd  = $row['user_passwd'];
				$check_userID = $row['user_id'];
				//**********************************************

				//********* Compare values from DB to input, IF match THEN Login ELSE kick off *********

				if (($email === $check_email) && ($passwd === $check_passwd)) {
					echo "<script>alert('Logged in');</script>";
					echo "<script>window.open('index.php', '_self')</script>";
					$_SESSION['user_email'] = $email;
				}
				else {
					echo "<script>alert('Incorrect email or password')</script>";
				}
			}

			catch(PDOException $e) {
				echo "ERROR: ".$e->getMessage();
				exit(2);
			}
		}
		// ******* LOG OUT ********
		if (isset($_GET['Logout'])) {
			logout();
		}
		// ************************
?>
