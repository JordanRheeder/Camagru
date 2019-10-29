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
				<a class="navbar-item" href="index2.0.php">
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
		<div class="content_wrapper">
				<h1 style="text-align:left; padding-top:30px;">Hello
					<?php
						$user_email = $_SESSION['user_email'];
						// echo "user: $user_email";
					?>
				</h1>
				<figure class="image is-128x128" style="margin-left:50px;">
					<?php
						include ('config/connect.php');
						// We need to select the users profile picture from DB.
						// ***************************************************
						$queryIMG = ("SELECT * from `users` WHERE user_email=:user_email");
						$queryPrep = $dbh->prepare($queryIMG);
						$queryPrep->bindParam(':user_email', $user_email, PDO::PARAM_STR);
						$queryPrep->execute();
						$row = $queryPrep->fetch();
						$check_img = $row['user_image'];
						// echo $check_img;
						// echo "<script>alert('1');</script>";
						// echo "123";
						if (empty($check_img)) { // might throw error...
							// display default img
							// echo "<img class='is-rounded' src='users/default.png'>";
							echo "<img class='is-rounded' src='https://bulma.io/images/placeholders/128x128.png'>";
						}
						else {
							echo "<img class='is-rounded' src='users/user_images/$check_img'>";
						}
					?>
					<!-- <img class="is-rounded" src="https://bulma.io/images/placeholders/128x128.png"> -->
				</figure>

		</div>
		<br/>
		<!-- <div class="buttons" style="margin-top:10px; margin-left: 50px;"> -->
		<div class="buttons">
			<!-- <button class="button is-primary">Edit account</button> -->
			<button class="button is-primary modal-button" data-target="#myModal" aria-haspopup="true" style="margin-top:10px; margin-left: 50px;">Edit Account</button>
			<div class="modal" id="myModal">
				<div class="modal-background"></div>
				<div class="modal-card">
					<header class="modal-card-head">
						<p class="modal-card-title">Edit Account</p>
						<button class="delete" aria-label="close"></button>
					</header>
					<section class="modal-card-body">
						<!-- Content ... -->
						<!-- Insert forms -->
						<div class="field">
							<div class="control">
								<?php
									include ('config/connect.php');
									// We need to select the users profile picture from DB.
									// ***************************************************
									$queryUser = ("SELECT * from `users` WHERE user_email=:user_email");
									$queryU = $dbh->prepare($queryUser);
									$queryU->bindParam(':user_email', $user_email, PDO::PARAM_STR);
									$queryU->execute();
									$row = $queryU->fetch();
									$user_email = $row['user_email'];
									$user_img = $row['user_image'];
									$user_surname = $row['user_surname'];
									$user_contact = $row['user_contact'];
									$user_img = $row['user_image'];
									$user_name = $row['user_firstname'];
									if (empty($user_email)) {
										echo "<img class='is-rounded' src='https://bulma.io/images/placeholders/128x128.png'>";
									}
									else {
										echo "<input class='input is-primary' type='text' name='email' placeholder='Email' value='$user_email'/>";
									}

									if (empty($user_name)) {
										echo "<input class='input is-primary' type='text' name='FirstName' placeholder='First name'/>";
									}
									else {
										echo "<input class='input is-primary' type='text' name='FirstName' placeholder='First name' value='$user_name'/>";
									}

									if (empty($user_surname)) {
										echo "<input class='input is-primary' type='text' name='Surname' placeholder='Surname'/>";
									}
									else {
										echo "<input class='input is-primary' type='text' name='Surname' placeholder='Surname' value='$user_surname'/>";
									}
									if (empty($user_contact)) {
										echo "<input class='input is-primary' type='text' name='Contact' placeholder='Contact'/>";
									}
									else {
										echo "<input class='input is-primary' type='text' name='Contact' placeholder='Contact' value='$user_contact'/>";
									}
									if (empty($user_img)) {
										echo "<input class='input is-primary' type='file' name='email' placeholder='Profile Photo'/>";
									}
									else {
										echo "<input class='input is-primary' type='file' name='email' placeholder='Profile Photo' value='$user_img'/>";
									}

								?>
							</div>
						</div>
					</section>
					<footer class="modal-card-foot">
						<button class="button is-success">Save changes</button>
						<!-- <button class="button">Cancel</button> -->
					</footer>
				</div>
				</div>
				<script>
			document.querySelectorAll('.modal-button').forEach(function(el) {
				el.addEventListener('click', function() {
					var target = document.querySelector(el.getAttribute('data-target'));

					target.classList.add('is-active');
						target.querySelector('.button').addEventListener('click',   function() {
							target.classList.remove('is-active');
						});
						target.querySelector('.delete').addEventListener('click',   function() {
							target.classList.remove('is-active');
						});
				});
			});
			</script>
		</div>
		<!--content wrapper ends-->
		<!--footer starts-->
		<div id="footer">
			<h2 style="text-align:center; padding-top:30px;">jrheeder</h2>
		</div>
		<!--footer ends-->
</body>
<?php
	try {
		include ('config/connect.php');
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
