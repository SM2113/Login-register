<?php 
	define('DBSERVER', 'localhost');
	define('DBUSERNAME', 'root');
	define('DBPASSWORD', '');
	define('DBNAME', 'login');

	$db=mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

	if($db === false){
		die("Error: błąd połączenia" . mysqli_connect_error());
	}
?>