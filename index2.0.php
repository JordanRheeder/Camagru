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
		          More
		        </a>

		        <div class="navbar-dropdown">
		          <a class="navbar-item">
		            About
		          </a>
		          <a class="navbar-item">
		            Jobs
		          </a>
		          <a class="navbar-item">
		            Contact
		          </a>
		          <hr class="navbar-divider">
		          <a class="navbar-item">
		            Report an issue
		          </a>
		        </div>
		      </div>
		    </div>
			    <div class="navbar-end">
			      <div class="navbar-item">
			        <div class="buttons">
			          <a class="button is-primary" href="register.php">
			            <strong>Sign up</strong>
			          </a>
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
		<!--Navigation bar starts-->
		<!-- <div class="menubar">
			<ul id="menu">
					<li><a href="index.php">Home</a></li>
					<li><a href="my_account.php">My Account</a></li>
					<li><a href="#">PH</a></li>
			</ul>
			<div class="dropdown">
					<button onclick="myFunction()" class="dropbtn">Login - Register</button>
					<div id="myDropdown" class="dropdown-content">
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
				</script> -->
		</div>
		<!--footer starts-->
		<div id="footer">
			<h2 style="text-align:center; padding-top:30px;">jrheeder</h2>
		</div>
		<!--footer ends-->
  </body>
</html>
<?php
  if (isset($_GET['Logout'])) {
	if ($_GET['Logout'] == 'TRUE')
	  session_destroy();
	  echo "<script>window.open('index.php', '_self')</script>";
  }
?>