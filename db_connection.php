<?php
$servername = "localhost";
$sqluser = "user";
$sqlpassword = "password";
$sqldatabase = "login";
try {
	$pdo = new PDO("mysql:host=localhost;dbname=".$sqldatabase,$sqluser,$sqlpassword);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	exit($e->getMessage());
}
?>