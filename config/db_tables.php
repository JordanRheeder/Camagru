<?php
	include("config/database.php");

	$table = "users";

	try {
		$con = new PDO($dsn.";dbname=".$db_name, $db_user, $db_passwd);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE TABLE IF NOT EXISTS $table (
		`user_id` INT(100) AUTO_INCREMENT PRIMARY KEY,
		`user_passwd` VARCHAR(255) NOT NULL,
		`username` VARCHAR(255) NOT NULL,
		`user_firstname` VARCHAR(255) NOT NULL,
		`user_surname` VARCHAR(255) NOT NULL,
		`user_email` VARCHAR(255) NOT NULL,
		`user_contact` VARCHAR(100) NOT NULL,
		`user_image` VARCHAR(255),
		`token` VARCHAR(255) NOT NULL,
		`verified` INT(100) DEFAULT 0 NOT NULL)";
		// -- `user_name` VARCHAR(255) NOT NULL,
		$con->exec($sql);
	}
	catch(PDOException $e) {
		echo "ERROR: ".$e->getMessage();
		exit(2);
	}

	try {
		$table = "comment";
		$con = new PDO($dsn.";dbname=".$db_name, $db_user, $db_passwd);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE TABLE IF NOT EXISTS $table (
			`comment_id` INT(100) AUTO_INCREMENT PRIMARY KEY,
			`post_id` INT(128) DEFAULT NULL,
			`user_email` VARCHAR(128) NOT NULL,
			`content` VARCHAR(500) NOT NULL,
			`date_posted` TIMESTAMP(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
			`image_name` VARCHAR(256) DEFAULT NULL)";
		$con->exec($sql);
	}
	catch(PDOException $e) {
		echo "ERROR: ".$e->getMessage();
		exit(2);
	}

	try {
		$table = "likes";
		$con = new PDO($dsn.";dbname=".$db_name, $db_user, $db_passwd);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE TABLE IF NOT EXISTS $table (
		`like_id` int(128) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`post_id` int(128) NOT NULL,
		`user_email` varchar(256) NOT NULL,
		`image_name` varchar(256) NOT NULL)";
		$con->exec($sql);
	}
	catch(PDOException $e) {
		echo "ERROR: ".$e->getMessage();
		exit(2);
	}

	try {
		$table = "images";
		$con = new PDO($dsn.";dbname=".$db_name, $db_user, $db_passwd);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE TABLE IF NOT EXISTS $table (
		`UID` int(128) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`img_name` varchar(256) NOT NULL,
		`post_date` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
		`post_byEmail` varchar(256) NOT NULL,
		`user-PK` int(255) NOT NULL)";
		$con->exec($sql);
	}
	catch(PDOException $e) {
		echo "ERROR: ".$e->getMessage();
		exit(2);
	}



	$con = NULL;
?>
