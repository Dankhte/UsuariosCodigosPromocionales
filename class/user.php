<?php

class user {

// Login de usuario
public function login($username, $password) {
	try{
		$db = getDB();
		$hashPassword= hash('sha256', $password); 
		$query = $db->prepare("SELECT username FROM users WHERE username = :username AND password = :password"); 
		$query->bindParam("username", $username, PDO::PARAM_STR);
		$query->bindParam("password", $hashPassword, PDO::PARAM_STR);
		$query->execute();
		$count = $query->rowCount();
		$data = $query->fetch(PDO::FETCH_OBJ);
		$db = null;
		if($count) {
			$_SESSION['username'] = $data->username;
			return true;
		} else {
			return false;
		} 
	} catch(PDOException $e) {
		echo 'Error al hacer login: ' . $e->getMessage();
	}
}

// Registro de usuario
public function registration($username, $password) {
	try{
		$db = getDB();
		$queryCheck = $db->prepare("SELECT username FROM users WHERE username = :username"); 
		$queryCheck->bindParam("username", $username, PDO::PARAM_STR);
		$queryCheck->execute();
		$count = $queryCheck->rowCount();
		if($count < 1) {
			$query = $db->prepare("INSERT INTO users(username, password) VALUES (:username, :password)");
			$query->bindParam("username", $username, PDO::PARAM_STR);
			$hashPassword = hash('sha256', $password);
			$query->bindParam("password", $hashPassword, PDO::PARAM_STR);
			$query->execute();
			$db = null;
			$_SESSION['username'] = $username;
			return true;
		} else {
			$db = null;
			return false;
		}
	} catch(PDOException $e) {
		echo 'Error al registrar al usuario: ' . $e->getMessage(); 
	}
}

}

?>