<?php
	try {
		ini_set("display_errors", TRUE);
		include('config/connect.php');
	}
	catch(PDOException $e) {
		echo "ERROR: ".$e->getMessage();
		exit(2);
	}

	function logout() {
		if (isset($_GET['Logout'])) {
			if ($_GET['Logout'] == 'TRUE') {
				session_destroy();
				echo "<script>window.open('index.php', '_self')</script>";
			}
		}
	}

	function hashResetPassword($email) {
		$timestamp = time();
		$hashed = hash('md5', $email);
		mailResetPassword($email, $hashed, $timestamp);
		return (1);
	}

	function mailResetPassword($email, $hashed, $timestamp) {
		try {
			include('config/connect.php');
		}
		catch(PDOException $e) {
			echo "ERROR: ".$e->getMessage();
			exit(2);
		}
		$newToken = hash('md5', $email.$timestamp);

		$SelectSQL = ("SELECT * from `users` WHERE user_email=:user_email");
		$select = $dbh->prepare($SelectSQL);
		$select->bindParam(':user_email', $email, PDO::PARAM_STR);
		$select->execute();
		$row = $select->fetch();
		$token = $row['token'];
		$query = ("UPDATE `users` SET token=:newHash WHERE token='$token'");
		$query = $dbh->prepare($query);
		$query->bindParam(':newHash', $newToken, PDO::PARAM_STR);
		$query->execute();
		$subject = "Account reset for Camagru";
		$message = "Good day, $email here is your reset password link:\n \t http://localhost/Camagru/new.php?ID=$newToken";
		$headers = "From: jrheeder@student.wethinkcode.co.za";
		mail($email,$subject,$message,$headers);
		return (1);
	}

	function mailVerifCode($email, $token, $firstname) {
		$subject = "Account verification for Camagru";
		$message = "Good day, $firstname here is your verfication link:\n \t http://localhost/Camagru/register.php?token=$token";
		$headers = "From: jrheeder@student.wethinkcode.co.za";
		mail($email,$subject,$message,$headers);
		return (1);
	}

	function resetValidEmail($old_email, $newEmail) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		$SelectSQL = ("SELECT * FROM `users` WHERE user_email=:Email");
		$SelectSQL = $dbh->prepare($SelectSQL);
		$SelectSQL->bindParam(':Email', $old_email, PDO::PARAM_STR);
		$SelectSQL->execute();
		$row = $SelectSQL->fetch();
		// $valid = $row['token'];
		// need to update token and then send a verification code.
		$firstname = $row['user_firstname'];
		$timestamp = time();
		// $hashed = hash('md5', $email);
		$newToken = hash('md5', $newEmail.$timestamp);
		// echo $newToken;
		$query = ("UPDATE `users` SET user_email='$newEmail', token='$newToken', verified='0' WHERE user_email='$old_email'");
		$query = $dbh->prepare($query);
		$query->execute();
		mailVerifCode($newEmail, $newToken, $firstname);

		return (1);
	}

	function validate_email($check_mail) {
		if (!filter_var($check_mail, FILTER_VALIDATE_EMAIL))
			return (0);
		else
			return (1);
	}

	function verify_token($token) {

			try {
				// ini_set("display_errors", true);
				include('config/connect.php');
			}
			catch(PDOException $e) {
				echo "ERROR: ".$e->getMessage();
				exit(2);
			}
			try {
					$SQL = ("SELECT `token` FROM `users` WHERE token=?");
					$verify = $dbh->prepare($SQL);
					$verify->bindParam('1', $token, PDO::PARAM_STR);
					$verify->execute();
					$result = $verify->fetch(\PDO::FETCH_ASSOC);
					$comp_toke = json_encode($result);
					$comp_tokes = json_decode($comp_toke, TRUE);
					if ($token == $comp_tokes['token']) {
						return (1);
					}
					else {
						return (0);
					}
			}
			catch(PDOException $e) {
				echo "ERROR: ".$e->getMessage();
				exit(2);
			}
		}

	function newPass($old_pass, $new_pass, $email) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		// $SelectSQL = ("SELECT * FROM `users` WHERE user_email=:email");
		// $SelectSQL = $dbh->prepare($SelectSQL);
		// $SelectSQL->bindParam(':email', $email, PDO::PARAM_STR);
		// $SelectSQL->execute();
		// $row = $SelectSQL->fetch();
		$query = ("UPDATE `users` SET user_passwd='$new_pass' WHERE user_email='$email'");
		$query = $dbh->prepare($query);
		$query->execute();
		return (1);
	}

	function newFName($old_name, $new_name, $email) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		$query = ("UPDATE `users` SET user_firstname='$new_name' WHERE user_email='$email'");
		$query = $dbh->prepare($query);
		$query->execute();
		return (1);
	}

	function newSurname($old_surname, $new_surname, $email) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		$query = ("UPDATE `users` SET user_surname='$new_surname' WHERE user_email='$email'");
		$query = $dbh->prepare($query);
		$query->execute();
		return (1);
	}

	function newContact($old_contact, $new_contact, $email) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		$query = ("UPDATE `users` SET user_contact='$new_contact' WHERE user_email='$email'");
		$query = $dbh->prepare($query);
		$query->execute();
		return (1);
	}

	function check_file_uploaded_name ($filename)
	{
		return((bool) ((preg_match("`^[-0-9A-Z_\.]+$`i",$filename)) ? TRUE : FALSE));
	}

	function newImg($old_img, $new_img, $email) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		$query = ("UPDATE `users` SET user_image='$new_img' WHERE user_email='$email'");
		$query = $dbh->prepare($query);
		$query->execute();
		return (1);
	}

	function newPost($postedBy, $user_email, $postImg, $postedWhen) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		try {
		$readableDate = date('d-m-Y', $postedWhen);
		$postQuery = ("INSERT INTO `images` (`img_name`, `post_byEmail`, `post_byID`) VALUES ('$postImg', '$user_email', '$postedBy')");
		$postQuery = $dbh->prepare($postQuery);
		$postQuery->execute();
		}
		catch(PDOException $e) {
			echo "ERROR: ".$e->getMessage();
			exit(2);
		}
		return(1);
	}

?>
