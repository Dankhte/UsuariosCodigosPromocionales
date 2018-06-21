<?php

class promocode {

// Creación aleatorio de código
public function generate($username) {
	try{
		$db = getDB();
		do {
			/* Comprobación muy básica y poco óptima de si es único, aun que debería serlo
			   teniendo en cuenta como se genera.*/
			$uniquePromoCode = $username . md5(time() . rand());
		    $queryCheck = $db->prepare("SELECT code FROM promocodes WHERE code = :code"); 
			$queryCheck->bindParam("code", $uniquePromoCode, PDO::PARAM_STR);
			$queryCheck->execute();
			$count = $queryCheck->rowCount();
		} while ($count > 0);
		$query = $db->prepare("INSERT INTO promocodes(code, username) VALUES (:code, :username)");
		$query->bindParam("code", $uniquePromoCode, PDO::PARAM_STR);
		$query->bindParam("username", $username, PDO::PARAM_STR);
		$query->execute();
		$db = null;
		return true;
	} catch(PDOException $e) {
		echo 'Error al generar código promocional único: '. $e->getMessage();
	}
}

public function showPromoCodes($username) {
	try{
		$db = getDB();
	    $query = $db->prepare("SELECT code, redeemed FROM promocodes WHERE username = :username"); 
		$query->bindParam("username", $username, PDO::PARAM_STR);
		$query->execute();
		$data = $query->fetchAll();
		$db = null;
		return $data;
	} catch(PDOException $e) {
		echo 'Error al generar código promocional único: '. $e->getMessage();
	}
}

public function redeem($code) {
	try{
		$db = getDB();
		$queryCheck = $db->prepare("SELECT code FROM promocodes WHERE code = :code"); 
		$queryCheck->bindParam("code", $code, PDO::PARAM_STR);
		$queryCheck->execute();
		$count = $queryCheck->rowCount();
		if($count > 0) {
			$query = $db->prepare("UPDATE promocodes SET redeemed = 1 WHERE code = :code");
			$query->bindParam("code", $code, PDO::PARAM_STR);
			$query->execute();
			$db = null;
			return true;
		} else {
			$db = null;
			return false;
		}
	} catch(PDOException $e) {
		echo 'Error al canejar código promocional único: '. $e->getMessage();
	}
}

}

?>