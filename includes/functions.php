<?php
function logout() {
	if (isset($_GET['Logout'])) {
		if ($_GET['Logout'] == 'TRUE') {
			session_destroy();
			echo "<script>window.open('index.php', '_self')</script>";
		}
	}
}

function mailVerifCode($email, $token, $firstname) {
	$subject = "Account verification for Camagru";
	$message = "Good day, $firstname here is your verfication link:\n \t http://localhost:8080/Camagru/register.php?token=$token";
	$headers = "From: jrheeder@student.wethinkcode.co.za";
	mail($email,$subject,$message,$headers);
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
