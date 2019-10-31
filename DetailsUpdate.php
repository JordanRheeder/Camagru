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
		<br/>
		<div class="content_wrapper" align="center">
		<form action="my_account.php" method="post" enctype="multipart/form-data" align="center">
				<table align='center'>
				<tr>
					<td align='right' style='color: white'>......</td>
					<td><input placeholder='E-mail' type='text' name='user_email' ></td>
				</tr>
				<tr>
					<td align='right' style='color: white'>.</td>
					<td><input placeholder='Password' type='password' name='user_passwd' /></td>
				</tr>
				<tr>
					<td align='right' style='color: white'>First Name:</td>
					<td><input placeholder='First name' type='text' name='user_firstname' /></td>
				</tr>

				<tr>
					<td align='right' style='color: white'>Surname:</td>
					<td><input placeholder='Surname' type='text' name='user_surname' /></td>
				</tr>
				<tr>
					<td align='right' style='color: white'>Profile Photo:</td>
					<!-- <td><input type='file' name='profilePhoto' required/></td> ADD THIS IN LATER************************ -->
					<td><input placeholder='Profile Photo' type='file' name='user_photo'/></td>
				</tr>
				<tr>
					<td align='right' style='color: white'>Contact:</td>
					<td><input placeholder='Phone Number' type='text' name='user_contact' /></td>
				</tr>
		</table>
			<tr align='right'>
				<td><input class='button is-primary' type='submit' name='update' value='Update Account' style='margin-left: -8px; align:center'/></td>
			</tr>
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
		$user_email = $_SESSION['user_email'];
		$queryU->bindParam(':user_email', $user_email, PDO::PARAM_STR);
		$queryU->execute();
		$row = $queryU->fetch();
		$user_email = $row['user_email'];
		$user_img = $row['user_image'];
		$user_surname = $row['user_surname'];
		$user_contact = $row['user_contact'];
		$user_img = $row['user_image'];
		$user_name = $row['user_firstname'];
		print_r($row);

		// resetValidEmail()
		?>
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
