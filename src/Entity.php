<?php

namespace src;

use PDO;
use src\Connection;

class Entity extends Connection
{
	public function insert($table, $data = [])
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		$query = 'INSERT INTO `' . $table . '` VALUES (NULL, ';
		$first = true;
		
		foreach ($data AS $k => $value) {
			if (!$first) {
				$query .= ', ';
			} else {
				$first = false;
			}
			$query .= ':' . $k;
		}
		
		$query .= ')';
		$sth = $dbh->prepare($query);
		$sth->execute($data);
		
		var_dump($sth);
		return true;
	}
	
	function findOne($query)
	{
		$dbh = $this->getDbh();
		$data = $dbh->query($query, PDO::FETCH_ASSOC);
		$result = $data->fetch();
		return $result;
	}
	
	function findOneSecure($query, $data = [])
	{
		$dbh = $this->getDbh();
		$sth = $dbh->prepare($query);
		$sth->execute($data);
		$result = $sth->fetch(PDO::FETCH_ASSOC);
		return $result;
	}
	
	public function findById($table, $id)
	{
		$id = (int)$id;
		$data = $this->findOne("SELECT * FROM " . $table . " WHERE id = " . $id);
		return $data;
	}
}