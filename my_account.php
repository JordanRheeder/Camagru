<?php
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
						echo "user: $user_email";
					?>
				</h1>
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
