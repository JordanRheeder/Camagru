<?php
	include ("config/database.php");
	try {
		$dbh = new PDO($dsn.";dbname=db_camagru", $db_user, $db_passwd);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e) {
		echo "ERROR: ".$e->getMessage();
		exit(2);
	}
?>
