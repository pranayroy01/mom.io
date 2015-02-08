<?php
	$host = "localhost";
	$username = "root";
	$password = "";
	$db = "momhack";
	
	try {
		$link = new PDO("mysql:host=$host;dbname=$db", $username, $password);
	}
	catch (PDOexception $e) {
		die('Could not connect to database.');
	}
?>