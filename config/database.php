<?php
function create_db($db_name) {
	$db_host = "localhost";
	$db_user = "root";
	$db_passwd = "qwerqwer";
	$dsn = "mysql:host=".$db_host;
	// $db_name = "db_camagru";

	try {
		$dbh = new PDO($dsn, $db_user, $db_passwd);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->query("CREATE DATABASE IF NOT EXISTS $db_name");
		$dbh->query("use $db_name");
	}
	catch(PDOException $e) {
		echo "ERROR: ".$e->getMessage();
	}
	return ($dbh);
}
// if ($dbh)
// 	echo "success!\n";
?>
