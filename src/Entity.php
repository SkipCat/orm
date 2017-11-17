<?php

namespace src;

use PDO;
use src\Connection;

class Entity
{
	public function insert($table, $data = [])
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		$query = 'INSERT INTO `' . $table . '` VALUES (NULL, ';
		$first = true;
		
		unset($data['id']);
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
	
	public function findById($table, $id)
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		$id = (int)$id;
		$data = $dbh->query("SELECT * FROM " . $table . " WHERE id = " . $id, PDO::FETCH_ASSOC);
		$result = $data->fetch();
		
		$object = $this->setObject($result);
		//$object = $data->fetchObject(get_called_class());
		
		return $object;
	}
	
	public function findAll($table)
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		$data = $dbh->query("SELECT * FROM " . $table, PDO::FETCH_ASSOC);
		$result = $data->fetchAll();
		$objectsArray = $this->setAllObjects($result);
		
		return $objectsArray;
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
		$objectsArray = $this->setAllObjects($result);
		
		var_dump($data);
		var_dump($result);
		
		return $objectsArray;
		
	}
	
	public function where($data = [])
	{
		$paramWhere = '';
		foreach ($data as $value) {
			$paramWhere .= $value . ' AND ';
		}
		$paramWhere = substr($paramWhere, 0, -5); 	// remove last 'AND'
		
		return $paramWhere;
	}
	
	private function orderBy($data = [])
	{
		$paramOrderBy = '';
		foreach ($data as $value) {
			$paramOrderBy .= $value . ', ';
		}
		$paramOrderBy = substr($paramOrderBy, 0, -2); // remove last ','
		
		return $paramOrderBy;
	}
	
	public function getAllProperties()
	{
		return get_object_vars($this);
	}
	
	public function delete($table, $id)
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		$query = $dbh->query("DELETE FROM " . $table . " WHERE id = " . $id);
		var_dump($query);
		$sth = $dbh->prepare($query);
		$sth->execute();
		
		return true;
	}
	
	public function update($table, $id, $data = [])
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		$newValues = '';
		foreach ($data as $key => $value) {
			if ($key !== 'id') {
				$newValues .= $key . ' = "' . $value . '", ';
			}
		}
		$newValues = substr($newValues, 0, -2); // remove last ','
		
		$query = $dbh->query("UPDATE " . $table . " SET " . $newValues . " WHERE id = " . $id);
		var_dump($query);
		$sth = $dbh->prepare($query);
		$sth->execute();
		
		return true;
	}
	
	public function setObject($array = [])
	{
		$object = new static();
		foreach ($array as $key => $value) {
			$object->setProperty($key, $value);
		}
		
		return $object;
	}
	
	public function setAllObjects($data)
	{
		$objectsArray = [];
		foreach ($data as $key => $array) {
			$object = $this->setObject($array);
			$objectsArray[$key] = $object;
		}
		
		return $objectsArray;
	}
	
	public function setProperty($name, $value)
	{
		$name = ucfirst($name);
		$setFunction = 'set' . $name;
		$this->$setFunction($value);
	}
	
	public function isExist($table, $id)
	{
		$result = $this->findById($table, $id);
		if (!$result) {
			return false;
		} else {
			return true;
		}
	}

}