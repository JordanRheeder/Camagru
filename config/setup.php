<?php
include ("database.php");

$dbh = create_db("db_camagru");

$table = "users";
// $sql = "DROP DATABASE IF EXISTS db_camagru";
// $dbh->exec($sql);
$sql = "CREATE TABLE IF NOT EXISTS $table(
	`ID` INT(100) AUTO_INCREMENT PRIMARY KEY,
	`user_name` varchar(255) NOT NULL,
	`user_passwd` varchar(100) NOT NULL,
	`user_email` varchar(255) NOT NULL,
	`user_contact` varchar(100) NOT NULL,
	`user_image` varchar(255));";
$dbh->exec($sql);
?>
