<?php
	define ('MYSQLHOST', 'localhost');
	define ('MYSQLUSER', 'Grisouille');
	define ('MYSQLPSW', 'MFG789pogi');
	define ('MYSQLDB', 'tpbenoit28');
	
	try {
		$PDO = new PDO('mysql:host=' . MYSQLHOST . ';dbname=' . MYSQLDB, MYSQLUSER, MYSQLPSW);
		$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		$PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	} catch (PDOException $e) {
		$e->getMessage();
	}
?>
