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
$message = "Good day, $firstname here is your verfication link:\n \t http://localhost:8080/Camagru/verify.php?token=$token";
$headers = "From: jrheeder@student.wethinkcode.co.za";
mail($email,$subject,$message,$headers);
}

function validate_email($check_mail) {
	if (!filter_var($check_mail, FILTER_VALIDATE_EMAIL))
		return (0);
	else
		return (1);
}
?>
