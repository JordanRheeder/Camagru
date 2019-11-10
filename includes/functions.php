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
		session_destroy();
		echo "<script>window.open('index.php', '_self')</script>";
		return;
	}

	function update_notify($user_email, $notify) {
		include('config/connect.php');
		if ($notify == 1) {
			$query = ("UPDATE `users` SET notify=1 WHERE user_email='$user_email'");
			$updt_notif = $dbh->prepare($query);
			$updt_notif->execute();
			$_SESSION['notify'] = 1;
			sendNotif($user_email);
		} else {
			$updt_sql = ("UPDATE `users` SET notify=0 WHERE user_email='$user_email'");
			$updt_notif = $con->prepare($updt_sql);
			$updt_notif->execute();
			$_SESSION['notify'] = 0;
			sendNotif($user_email);
		}
	}

	function sendNotif($user_email) {
		include('config/connect.php');
		$SelectSQL = ("SELECT `notify` from `users` WHERE user_email=:user_email");
		$select = $dbh->prepare($SelectSQL);
		$select->bindParam(':user_email', $user_email, PDO::PARAM_STR);
		$select->execute();
		$row = $select->fetch();
		$notify = $row['notify'];
		if ($notify == 1) {
			$subject = "Changes on your account";
			$message = "Hello, $user_email changes have been made on your account...";
			$headers = "From: jrheeder@student.wethinkcode.co.za";
			mail($user_email,$subject,$message,$headers);
			return (1);
		}
		else {
			return (0);
		}
		return (1);
	}

	function passwordStrength($password) {
		// Validate password strength
		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);
		$specialChars = preg_match('@[^\w]@', $password);

		if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
			echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
			return (0);
		}else{
			return (1);
		}
		return (0);
	}

	function hashResetPassword($email) {
		$timestamp = time();
		$hashed = hash('md5', $email);
		mailResetPassword($email, $hashed, $timestamp);
		return (1);
	}

	function isVerifiedUser($email) {
		try {
			include('config/connect.php');
		}
		catch(PDOException $e) {
			echo "ERROR: ".$e->getMessage();
			exit(2);
		}
		$SelectSQL = ("SELECT * from `users` WHERE user_email=:user_email");
		$select = $dbh->prepare($SelectSQL);
		$select->bindParam(':user_email', $email, PDO::PARAM_STR);
		$select->execute();
		$row = $select->fetch();
		$verified = $row['verified'];
		if ($verified == '1') {
			return (1);
		}
		else {
			return (0);
		}
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
		sendNotif($email);
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
		$query = ("UPDATE `users` SET user_passwd='$new_pass' WHERE user_email='$email'");
		$query = $dbh->prepare($query);
		$query->execute();
		sendNotif($email);
		return (1);
	}

	function newFName($old_name, $new_name, $email) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		$query = ("UPDATE `users` SET user_firstname='$new_name' WHERE user_email='$email'");
		$query = $dbh->prepare($query);
		$query->execute();
		sendNotif($email);
		return (1);
	}

	function newSurname($old_surname, $new_surname, $email) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		$query = ("UPDATE `users` SET user_surname='$new_surname' WHERE user_email='$email'");
		$query = $dbh->prepare($query);
		$query->execute();
		sendNotif($email);
		return (1);
	}

	function newContact($old_contact, $new_contact, $email) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		$query = ("UPDATE `users` SET user_contact='$new_contact' WHERE user_email='$email'");
		$query = $dbh->prepare($query);
		$query->execute();
		sendNotif($email);
		return (1);
	}
	function newUN($old_username, $new_username, $email) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		$query = ("UPDATE `users` SET username='$new_username' WHERE user_email='$email'");
		$query = $dbh->prepare($query);
		$query->execute();
		sendNotif($email);
		return (1);
	}

	function check_file_uploaded_name($filename)
	{
		return((bool) ((preg_match("`^[-0-9A-Z_\.]+$`i",$filename)) ? TRUE : FALSE));
	}

	function newImg($old_img, $new_img, $email) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		$query = ("UPDATE `users` SET user_image='$new_img' WHERE user_email='$email'");
		$query = $dbh->prepare($query);
		$query->execute();
		sendNotif($email);
		return (1);
	}

	function newPost($postedBy, $user_email, $postImg, $postedWhen) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		try {
		$postImg = hash('md5', ($postImg.$postedWhen));
		$postImg = $postImg.'.png';
		// $readableDate = date('d-m-Y', $postedWhen);
		$postQuery = ("INSERT INTO `images` (`img_name`, `post_byEmail`, `user-PK`) VALUES ('$postImg', '$user_email', '$postedBy')");
		$postQuery = $dbh->prepare($postQuery);
		$postQuery->execute();
		}
		catch(PDOException $e) {
			echo "ERROR: ".$e->getMessage();
			exit(2);
		}
		return(1);
	}

	function newPostSelfie($postedBy, $user_email, $postImg, $postedWhen, $username) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		try {
		// $postImg = hash('md5', ($postImg.$postedWhen));

		// $readableDate = date('d-m-Y', $postedWhen);
		$postQuery = ("INSERT INTO `images` (`img_name`, `post_byEmail`, `user-PK`) VALUES ('$postImg', '$user_email', '$postedBy')");
		$postQuery = $dbh->prepare($postQuery);
		$postQuery->execute();
		}
		catch(PDOException $e) {
			echo "ERROR: ".$e->getMessage();
			exit(2);
		}
		return(1);
	}


	function usersPosts($user_email) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		try {
			$postQuery = ("SELECT * FROM `images` WHERE post_byEmail='$user_email'");
			$postQuery = $dbh->prepare($postQuery);
			$postQuery->execute();
			$row = $postQuery->fetchAll(PDO::FETCH_COLUMN, '1');
			$array = array();
			foreach ($row as $img) {
				$array[] = $img;
			}
		}
		catch(PDOException $e) {
			echo "ERROR: ".$e->getMessage();
			exit(2);
		}
		return ($array);
	}
	function allUsersPosts() {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		try {
			$postQuery = ("SELECT * FROM `images`");
			$postQuery = $dbh->prepare($postQuery);
			$postQuery->execute();
			$row = $postQuery->fetchAll(PDO::FETCH_COLUMN, '1');
			$array = array();
			foreach ($row as $img) {
				$array[] = $img;
			}
		}
		catch(PDOException $e) {
			echo "ERROR: ".$e->getMessage();
			exit(2);
		}
		return ($array);
	}

	function deletePost($email, $img) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);
		try {
			$postDelete = ("DELETE FROM `images` WHERE img_name='$img'");
			$postDelete = $dbh->prepare($postDelete);
			$postDelete->execute();
		}
		catch(PDOException $e) {
			echo "ERROR: ".$e->getMessage();
			exit(2);
		}
		return (1);
	}
	function storeImage($rawData, $filename_path, $choice) {
		$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $rawData));
		file_put_contents("users/user_posts/".$filename_path,$data);
		$truePath = $filename_path;
		superImpose($truePath, $choice);
		return;
	}
	function superImpose($imgsrc, $choice) {
		$your_original_image = ("users/user_posts/$imgsrc");
		$your_frame_image = ("users/user_stickers/$choice.png");
		# If you don't know the type of image you are using as your originals.
		$image = imagecreatefromstring(file_get_contents($your_original_image));
		$frame = imagecreatefromstring(file_get_contents($your_frame_image));
		# If you know your originals are of type PNG.
		$image = imagecreatefrompng($your_original_image);
		$frame = imagecreatefrompng($your_frame_image);
		imagecopymerge($image, $frame, 0, 0, 0, 0, 128, 128, 40);
		# Save the image to a file

		imagepng($image, "users/user_posts/$imgsrc");
		# Output straight to the browser.
		echo "<div align=middle style='margin-top:-525px'><img src='users/user_posts/$imgsrc' style='')/></div>";
		return (1);
	}

	function getPostID($img, $email, $comment) {
		include ('config/connect.php');

		$postQuery = ("SELECT * FROM `images` WHERE img_name='$img'");
		$postQuery = $dbh->prepare($postQuery);
		$postQuery->execute();
		$row = $postQuery->fetch();
		$UID = $row['UID'];
		submitcomment($email, $img, $comment, $UID);
		return;
	}

	function submitcomment($email, $img, $comment, $UID) {
		include ('config/connect.php');
		$postQuery = ("INSERT INTO `comment` (`post_id`, `user_email`, `content`, `image_name`) VALUES ('$UID', '$email', '$comment', '$img')");
		$postQuery = $dbh->prepare($postQuery);
		$postQuery->execute();
		return (1);
	}

	function commentNotif($img, $email) {
		include('config/connect.php');
		$SelectQuery = ("SELECT `content` FROM `comment` WHERE image_name='$img'");
		$SelectQuery = $dbh->prepare($SelectQuery);
		$SelectQuery->execute();
		$row = $SelectQuery->fetch();
		$row = $row['content'];

		$subject = "Comment notify";
		$message = "Good day, $email someone commented on your post http://localhost:8080/Camagru/lookAll.php?img=$img";
		$headers = "From: jrheeder@student.wethinkcode.co.za";
		mail($email,$subject,$message,$headers);
	}

	function echoComments($img) {
		include('config/connect.php');
		ini_set("display_errors", TRUE);

		$SelectQuery = ("SELECT `content`, `user_email` FROM `comment` WHERE image_name='$img'");
		$SelectQuery = $dbh->prepare($SelectQuery);
		$SelectQuery->execute();
		$row1 = $SelectQuery->fetchAll();
		foreach ($row1 as $row1) {
			$y =1 ;
			$x = 0;
			echo "<div class='media-content'><div class='content'><p><strong>$row1[$y]</strong> <br/>$row1[$x]</p></div></div>";
			$y++;
			$x += $x + 2;
		}
		return;
	}

	function array_has_dupes($array) {
		if (!empty($array)) {
			return count($array) !== count(array_unique($array));
		}
		else {
			return (0);
		}
	}

	function likePost($img, $userEmail) {
		include('config/connect.php');
		$SelectQuery = ("SELECT `UID`, `post_byEmail` FROM `images` WHERE img_name='$img'");
		$SelectQuery = $dbh->prepare($SelectQuery);
		$SelectQuery->execute();
		$row = $SelectQuery->fetch();
		$post_id = $row['UID'];

		// found the post id. now we need to check for duplicate likes...
		$SelectQuery = ("SELECT `user_email` FROM `likes` WHERE image_name='$img'");
		$SelectQuery = $dbh->prepare($SelectQuery);
		$SelectQuery->execute();
		$dupeCheck = $SelectQuery->fetch();
		if (array_has_dupes($dupeCheck) == 1) {
			return;
		}
		$SelectQuery = ("INSERT INTO `likes` (`post_id`,`user_email`, `image_name`) VALUES ('$post_id', '$userEmail', '$img')");
		$SelectQuery = $dbh->prepare($SelectQuery);
		$SelectQuery->execute();
		return;
	}

	function tallyLikes($img) {
		include('config/connect.php');
		// ini_set("display_errors", TRUE);
		$SelectQuery = ("SELECT `user_email` FROM `likes` WHERE image_name='$img'");
		$SelectQuery = $dbh->prepare($SelectQuery);
		$SelectQuery->execute();
		$row = $SelectQuery->fetchAll();
		$count = count($row);
		return $count;
	}

	function get_upload_thumbs($email) {
		include('config/connect.php');
		if (!empty($email)) {
			$getImages = ("SELECT * FROM `images` WHERE post_byEmail='$email' ORDER BY post_date DESC LIMIT 5");
			$getImages = $dbh->prepare($getImages);
			$getImages->execute();
			while ($img = $getImages->fetch()) {
				$img_name = $img['img_name'];
				// $img_id = $img['UID'];
				echo ("<figure class='image'><a href='lookAll.php?img=$img_name'><img src='users/user_posts/$img_name' style='width: 128px; height: 128px; positon:absolute; top:-300px;'/></a></figure>");
			}
		}
	}

	function update_ComNotify($user_email, $cNotify) {
		include('config/connect.php');
		if ($cNotify == 1) {
			$query = ("UPDATE `users` SET notify=1 WHERE user_email='$user_email'");
			$updt_notif = $dbh->prepare($query);
			$updt_notif->execute();
			$_SESSION['cNotify'] = 1;
			sendNotif($user_email);
		} else {
			$query = ("UPDATE `users` SET notify=0 WHERE user_email='$user_email'");
			$updt_notif = $con->prepare($query);
			$updt_notif->execute();
			$_SESSION['cNotify'] = 0;
			sendNotif($user_email);
		}
	}

?>
