<?php
global $dsn;
$db_host = "localhost";
$db_user = "root";
$db_passwd = "qwerqwer";
$db_name = "db_camagru";
$dsn = "mysql:host=".$db_host.";dbname=".$db_name;
try {
	$dbh = new PDO($dsn, $db_user, $db_passwd);
	$dbh->setAttribute(PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
	echo "ERROR: ".$e->getMessage();
}
if ($dbh)
	echo "success!\n";
?>
