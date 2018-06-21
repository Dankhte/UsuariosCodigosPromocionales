<?php

	session_start();

	function getDB() {
		$host = "localhost";
		$user = "root";
		$password = "";
		$database = "usertest";
		$connection = new PDO('mysql:host='.$host.';dbname='.$database, $user, $password);
		$connection->exec("set names utf8");
		return $connection;
	}

?>