<?php

namespace src;

use PDO;
use src\Connection;
use src\Translator;

class Entity
{
	public function insert($table, $data = [])
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		//$data = $this->getAllProperties();
		unset($data['id']);
		
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
		var_dump($query);
		
		$sth = $dbh->prepare($query);
		$sth->execute($data);
		
		return true;
	}
	
	public function findOne($query)
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		$data = $dbh->query($query, PDO::FETCH_ASSOC);
		$result = $data->fetch();
		
		return $result;
	}
	
	public function findById($table, $id)
	{
		$id = (int)$id;
		$data = $this->findOne("SELECT * FROM " . $table . " WHERE id = " . $id);
		
		return $data;
	}
	
	public function findAll($table)
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		$data = $dbh->query("SELECT * FROM " . $table, PDO::FETCH_ASSOC);
		$result = $data->fetchAll();
		
		return $result;
	}
	
	public function findWithParam($table, $where = null, $orderBy = null, $join = null)
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
	
		if (null !== $where) {
			if (null !== $orderBy) {
				if (null !== $join) {
					// where + join + orderBY
				} else {
					$paramWhere = $this->where($where);
					$query = "SELECT * FROM " . $table . " WHERE " . $paramWhere;
					
					$paramOrderBy = $this->orderBy($orderBy);
					$query = $query . " ORDER BY " . $paramOrderBy;
				}
			} else {
				if (null !== $join) {
					// where + join
				} else {
					$paramWhere = $this->where($where);
					$query = "SELECT * FROM " . $table . " WHERE " . $paramWhere;
				}
			}
		} else {
			if (null !== $orderBy) {
				if (null !== $join) {
					// join + orderBy
				} else {
					$paramOrderBy = $this->orderBy($orderBy);
					$query = "SELECT * FROM " . $table . " ORDER BY " . $paramOrderBy;
				}
			} else {
				if (null !== $join) {
					// join only
				} else {
					echo 'No parameter indicated.';
					return false;
				}
			}
		}
		
		$data = $dbh->query($query, PDO::FETCH_ASSOC);
		$result = $data->fetchAll();
		var_dump($data);
		var_dump($result);
		
		return true;
		
	}
	
	public function where($data = []) {
		$paramWhere = '';
		foreach ($data as $value) {
			$paramWhere .= $value . ' AND ';
		}
		$paramWhere = substr($paramWhere, 0, -5); 	// remove last 'AND'
		
		return $paramWhere;
	}
	
	private function orderBy($data = []) {
		$paramOrderBy = '';
		foreach ($data as $value) {
			$paramOrderBy .= $value . ', ';
		}
		$paramOrderBy = substr($paramOrderBy, 0, -2); // remove last ','
		
		return $paramOrderBy;
	}
	
	public function getAllProperties() {
		return get_object_vars($this);
	}
	
}