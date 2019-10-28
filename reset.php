<?php
	ini_set("display_errors", true);
	include ("config/db_setup.php");
	if (session_id() === "") {
		session_start();
	}
	else {
		$session_id=session_id();
		// echo ($session_id);
	}
	// include("functions/functions.php");
?>
<html lang="en" dir="ltr">
  <head>
	<meta charset="utf-8">
	<title>Camagru</title>
	<link rel="stylesheet" href="styles/index.css" media="all" />
	</head>
<body>
	<div class="main_wrapper">
		<div class="header_wrapper">
			<a href="index.php">
				<img id="banner" src="images/logom.png">
			</a>
		</div>
		<!--Navigation bar starts-->
		<div class="menubar">
			<ul id="menu">
					<li><a href="index.php">Home</a></li>
					<li><a href="my_account.php">My Account</a></li>
					<li><a href="#">PH</a></li>
			</ul>
			<div class="dropdown">
					<button onclick="myFunction()" class="dropbtn">Login - Register</button>
					<div id="myDropdown" class="dropdown-content">
					  <?php
						if(isset($_SESSION['user_email'])) {
						echo "<a href='index.php?Logout=TRUE'>Logout</a>";
						}
						else {
						  echo "<a href='login.php'>Login</a>";
						}
					  ?>
					  <a href="register.php">Register</a>
					  <a href="reset.php">Forgot account-temp-</a>
					</div>
				</div>
				<script>
				  /* When the user clicks on the button,
				  toggle between hiding and showing the dropdown content */
				function myFunction() {
					document.getElementById("myDropdown").classList.toggle("show");
				}

				  // Close the dropdown if the user clicks outside of it
				window.onclick = function(event) {
					if (!event.target.matches('.dropbtn')) {
						var dropdowns = document.getElementsByClassName("dropdown-content");
						var i;
						for (i = 0; i < dropdowns.length; i++) {
							var openDropdown = dropdowns[i];
							if (openDropdown.classList.contains('show')) {
								openDropdown.classList.remove('show');
							}
						}
					}
				}
				</script>
		</div>
		<!--content wrapper starts-->
		<div class="content_wrapper">
		<!-- test; -->
			<form action="reset.php" method="post" enctype="multipart/form-data">
						<h2 align="center">Reset password</h2>
						<table align="center" width="750">
							<tr>
								<td align="right" style="color: white">Email:</td>
								<td><input type="text" name="email" required></td>
							</tr>
						<tr align="right">
							<td align="right"><input type="submit" name="reset" value="Reset Account" style="margin-left: 70px;"/></td>
						</tr>
					</table>
			</form>
		</div>
		<!--content wrapper ends-->
		<!--footer starts-->
		<div id="footer">
			<h2 style="text-align:center; padding-top:30px;">jrheeder</h2>
		</div>
		<!--footer ends-->
  </body>
</html>
<?php
	try {
		include ('includes/functions.php');
	}
	catch(PDOException $e) {
		echo "ERROR: ".$e->getMessage();
		exit(2);
	}
	if (isset($_GET['Logout'])) {
		if ($_GET['Logout'] == 'TRUE')
			session_destroy();
		echo "<script>window.open('index.php', '_self')</script>";
		// echo ("Will kill session");
		// print_r($_SESSION);
		// echo "<script>alert('Logged out');</script>";
	}
	if (isset($_POST['reset'])) {
		// echo "<script>alert('reset');</script>";
		if (hashResetPassword($_POST['email'])){
			echo "<script>alert('reset');</script>";
		}
		else {
			echo "<script>alert('nah');</script>";
		}
	}
?>
