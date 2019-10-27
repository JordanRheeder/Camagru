<?php
session_start();
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
						echo "<a href='login.php?Logout=TRUE'>Logout</a>";
						}
						else {
							echo "<a href='login.php'>Login</a>";
						}
					  ?>
					  <a href="register.php">Register</a>
					  <a href="fml.php">Forgot account-temp-</a>
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
		<form action="register.php" method="post" enctype="multipart/form-data">
					<h2 align="center">Create an account</h2>
					<table align="center" width="750">
					<tr>
						<td align="right" style="color: white">Email:</td>
						<td><input type="text" name="email" required></td>
					</tr>
					<tr>
						<td align="right" style="color: white">Password:</td>
						<td><input type="password" name="user_passwd" required/></td>
					</tr>
					<tr>
						<td align="right" style="color: white">First Name:</td>
						<td><input type="text" name="firstname" required/></td>
					</tr>

					<tr>
						<td align="right" style="color: white">Surname:</td>
						<td><input type="text" name="surname" required/></td>
					</tr>
					<tr>
						<td align="right" style="color: white">Profile Photo:</td>
						<!-- <td><input type="file" name="profilePhoto" required/></td> ADD THIS IN LATER************************-->
						<td><input type="file" name="profilePhoto"/></td>
					</tr>
					<tr>
						<td align="right" style="color: white">Contact:</td>
						<td><input type="text" name="PhoneNumber" required/></td>
					</tr>


				<tr align="right">
					<td><input type="submit" name="register" value="Create Account" style="margin-left: 70px;"/></td>
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

<?php
	try {
		include ('includes/functions.php');
		include ('config/connect.php');
	} catch(PDOException $e) {
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
			$firstname = $_POST['firstname'];
			$surname = $_POST['surname'];
			$img = $_FILES['profilePhoto']['name'];
			$image_tmp = $_FILES['profilePhoto']['tmp_name'];
			$contact = $_POST['PhoneNumber'];
			$email = $_POST['email'];
			$token = hash('md5', $contact);
			$verified = 0;
			// print("$username, $passwd, $firstname, $surname, $img, $image_tmp, $contact, $email"); // verify inputs.
			move_uploaded_file($image_tmp, "users/user_images/$img");
			// $data = array($username,$passwd,$firstname,$surname,$img,$contact,$email);
			// $sql = ("INSERT INTO `users` (user_name, user_passwd, user_firstname, user_surname, user_email, user_contact, user_image) VALUES (:username, :passwd, :firstname, :surname, :img, :contact, :email, NOW())");
			// $pdo->prepare($sql)->execute($username,$password,$firstname,$surname,$image_tmp,$contact,$email);
			// $query = "INSERT INTO `users` (user_name, user_passwd, user_firstname, user_surname, user_email, user_contact, user_image) VALUES (:user_name,:user_passwd,:user_firstname,:user_surname,:user_email,:user_contact,:user_image)";
			$query = "INSERT INTO `users` (user_passwd, user_firstname, user_surname, user_email, user_contact, user_image, token, verified) VALUES (?,?,?,?,?,?,?,?)";
			$query = $dbh->prepare($query);
			// $query->bindParam(':user_name', $username);
			// $query->bindParam(':user_passwd', $passwd);
			// $query->bindParam(':user_firstname', $firstname);
			// $query->bindParam(':user_surname', $surname);
			// $query->bindParam(':user_email', $email);
			// $query->bindParam(':user_contact', $contact);
			// $query->bindParam(':user_image', $img);

			//********* checking the database for existing emails or users *********
			// $verifySQL = ("SELECT user_email FROM `users` WHERE user_email=:user_email AND user_name=:user_name");
			$verifySQL = ("SELECT user_email FROM `users` WHERE user_email=:user_email");
			$verify = $dbh->prepare($verifySQL);
			// $verify->bindParam(':user_email', $email);
			// $verify->bindParam(':user_name', $username);
			$verify->bindParam(':user_email', $email, PDO::PARAM_STR);
			// $verify->bindParam(':user_name', $username, PDO::PARAM_STR);
			$verify->execute();
			$row = $verify->fetch();

			// print_r($sql);
			$check_email  = $row['user_email'];
			// $check_user   = $row['user_name'];

			// ********* Testing if output exists *********
			// print("test:".$check_email ."\n".$check_user);
			// print_r("rows"."\n".$row);
			//*********************************************

			if (empty($row['user_email'])) {
			// print("Going to bind params and add to db.\n");
			// $query->bindParam('1', $username);
			$query->bindParam('1', $passwd);
			$query->bindParam('2', $firstname);
			$query->bindParam('3', $surname);
			$query->bindParam('4', $email);
			$query->bindParam('5', $contact);
			$query->bindParam('6', $img);
			$query->bindParam('7', $token);
			$query->bindParam('8', $verified);
			$query->execute();
			if (mailVerifCode($email, $token, $firstname));
				echo "<script>alert('email created!');</script>";
			echo "<script>alert('Account created!');</script>";
			}
			else {
				echo "<script>alert('You already have an account!');</script>";
			}
		}

		catch(PDOException $e) {
			echo "ERROR: ".$e->getMessage();
			exit(2);
		}
	}
?>
</html>
