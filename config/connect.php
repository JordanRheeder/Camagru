<?php
	include ("config/database.php");
	try {
		$dbh = new PDO($dsn.";dbname=db_camagru", $db_user, $db_passwd);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// $dbh->exec("CREATE DATABASE IF NOT EXISTS $db_name");
		// $quer->exec($quer);
	}
	catch(PDOException $e) {
		echo "ERROR: ".$e->getMessage();
		exit(2);
	}
?>
