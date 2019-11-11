<?php
	include ("config/database.php");
	try {
		$dbh = new PDO($dsn, $db_user, $db_passwd);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->exec("CREATE DATABASE IF NOT EXISTS $db_name");
	}
	catch(PDOException $e) {
		echo "ERROR: ".$e->getMessage();
		exit(2);
	}
// $dbh = NULL;
// if ($dbh)
// 	echo "success!\n";
?>
