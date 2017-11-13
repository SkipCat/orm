<?php

namespace src\Model;

use src\Model\Connection;

class Crud extends Connection
{
	private $Connection;
	private static $instance = null;
	
	public static function getInstance()
	{
		if (self::$instance === null)
			self::$instance = new Crud();
		return self::$instance;
	}
	
	private function __construct()
	{
		$this->Connection = Connection::getInstance();
	}
	
	public function insert($table, $data = [])
	{
		echo 'insert';
		
		$dbh = $this->Connection->getDbh();
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
		
		return true;
	}
}