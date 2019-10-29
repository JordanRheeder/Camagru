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
		$message = "Good day, $email here is your reset password link:\n \t http://localhost:8080/Camagru/new.php?ID=$newToken";
		$headers = "From: jrheeder@student.wethinkcode.co.za";
		mail($email,$subject,$message,$headers);
		return (1);
	}

	function mailVerifCode($email, $token, $firstname) {
		$subject = "Account verification for Camagru";
		$message = "Good day, $firstname here is your verfication link:\n \t http://localhost:8080/Camagru/register.php?token=$token";
		$headers = "From: jrheeder@student.wethinkcode.co.za";
		mail($email,$subject,$message,$headers);
		return (1);
	}

	function resetValidEmail($email) {
		include_once('config/connect.php');
		ini_set("display_errors", TRUE);
		$SelectSQL = ("SELECT * from `users` WHERE user_email=:user_email");
		$select = $dbh->prepare($SelectSQL);
		$select->bindParam(':user_email', $email, PDO::PARAM_STR);
		$select->execute();
		$row = $select->fetch();
		$valid = $row['verified'];
		if ($valid == 1) {
			echo "<script>alert('1')</script>";
		}
		else
			echo "<script>alert('0')</script>";
		$query = ("UPDATE `users` SET verified=:zero WHERE user_email='$email'");
		$query = $dbh->prepare($query);
		$zero = '0';
		$query->bindParam(':zero', $zero, PDO::PARAM_STR);
		$query->execute();
		echo "executed";
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

?>
