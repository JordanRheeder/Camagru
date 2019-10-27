<?php
	include("config/database.php");

	$table = "users";

	try {
		$con = new PDO($dsn.";dbname=".$db_name, $db_user, $db_passwd);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE TABLE IF NOT EXISTS $table(
		`user_id` INT(100) AUTO_INCREMENT PRIMARY KEY,
		`user_passwd` VARCHAR(255) NOT NULL,
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
	$con = NULL;
?>
