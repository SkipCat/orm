<?php

namespace src;

use PDO;
use src\Connection;
use src\Log;

class Entity
{
	public function insert()
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		$query = 'INSERT INTO `' . $this->getTable() . '` VALUES (NULL, ';
		$first = true;
		
		$data = $this->getAllProperties();
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
		$exec = $sth->execute($data);
		
		$log = new Log();
		if ($exec) {
			$log->writeRequestLog($query);
			return true;
		} else {
			$log->writeErrorLog($query, $data, $sth->errorInfo());
			return false;
		}
	}
	
	public function findById($id)
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		$id = (int)$id;
		$data = $dbh->query("SELECT * FROM " . $this->getTable() . " WHERE id = " . $id, PDO::FETCH_ASSOC);
		$result = $data->fetch();
		var_dump($result);
		
		$log = new Log();
		if ($result) {
			$log->writeRequestLog($data->queryString);
			return $this->setObject($result);
		} else {
			$log->writeErrorLog($data->queryString, null, $data->errorInfo());
			return false;
		}
	}
	
	public function findAll()
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		$data = $dbh->query("SELECT * FROM " . $this->getTable(), PDO::FETCH_ASSOC);
		$result = $data->fetchAll();
		
		$log = new Log();
		if ($result) {
			$log->writeRequestLog($data->queryString);
			return $this->setAllObjects($result);
		} else {
			$log->writeErrorLog($data->queryString, null, $data->errorInfo());
			return false;
		}
	}
	
	public function findWithParam($where = null, $orderBy = null, $join = null)
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		if (null !== $where) {
			if (null !== $orderBy) {
				if (null !== $join) {
					// where + join + orderBY
				} else {
					$paramWhere = $this->where($where);
					$query = "SELECT * FROM " . $this->getTable() . " WHERE " . $paramWhere;
					
					$paramOrderBy = $this->orderBy($orderBy);
					$query = $query . " ORDER BY " . $paramOrderBy;
				}
			} else {
				if (null !== $join) {
					// where + join
				} else {
					$paramWhere = $this->where($where);
					$query = "SELECT * FROM " . $this->getTable() . " WHERE " . $paramWhere;
				}
			}
		} else {
			if (null !== $orderBy) {
				if (null !== $join) {
					// join + orderBy
				} else {
					$paramOrderBy = $this->orderBy($orderBy);
					$query = "SELECT * FROM " . $this->getTable() . " ORDER BY " . $paramOrderBy;
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
		
		$log = new Log();
		if ($result) {
			$log->writeRequestLog($query);
			return $this->setAllObjects($result);
		} else {
			$log->writeErrorLog($query, $where, $data->errorInfo());
			return false;
		}
	}
	
	public function delete($id)
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		$query = $dbh->query("DELETE FROM " . $this->getTable() . " WHERE id = " . $id);
		var_dump($query->queryString);
		
		$log = new Log();
		if ($query) {
			$log->writeRequestLog($query->queryString);
			return true;
		} else {
			$log->writeErrorLog($query->queryString, null, $query->errorInfo());
			return false;
		}
	}
	
	public function update()
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		$newValues = '';
		foreach ($this->getAllProperties() as $key => $value) {
			if ($key !== 'id') {
				$newValues .= $key . ' = "' . $value . '", ';
			}
		}
		$newValues = substr($newValues, 0, -2); // remove last ','
		
		$query = $dbh->query("UPDATE " . $this->getTable()
			. " SET " . $newValues . " WHERE id = " . $this->getId());
		var_dump($query->queryString);
		
		$log = new Log();
		if ($query) {
			$log->writeRequestLog($query->queryString, $newValues);
			return true;
		} else {
			$log->writeErrorLog($query->queryString, $this->getAllProperties(), $query->errorInfo());
			return false;
		}
	}
	
	public function isExist($id)
	{
		$result = $this->findById($id);
		if (!$result) {
			return false;
		} else {
			return true;
		}
	}
	
	public function count($where = null)
	{
		$conn = new Connection();
		$dbh = $conn->getDbh();
		
		if (null == $where) {
			$query = "SELECT COUNT(*) FROM " . $this->getTable();
		} else {
			$paramWhere = $this->where($where);
			$query = "SELECT COUNT(*) FROM " . $this->getTable() . " WHERE " . $paramWhere;
		}
		
		$query = $dbh->query($query, PDO::FETCH_ASSOC);
		$count = $query->fetch();
		
		$log = new Log();
		if ($count) {
			$log->writeRequestLog($query->queryString, $where);
			$count = array_shift(array_values($count));
			return intval($count);
		} else {
			$log->writeErrorLog($query->queryString, $where, $query->errorInfo());
			return false;
		}
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
	
	public function getAllProperties()
	{
		$properties = get_object_vars($this);
		unset($properties['table']);
		unset($properties['id']);
		
		return $properties;
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
	
	public function orderBy($data = [])
	{
		$paramOrderBy = '';
		foreach ($data as $value) {
			$paramOrderBy .= $value . ', ';
		}
		$paramOrderBy = substr($paramOrderBy, 0, -2); // remove last ','
		
		return $paramOrderBy;
	}
	
}