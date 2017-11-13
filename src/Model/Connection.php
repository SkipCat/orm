<?php

namespace src\Model;

use PDO;
use PDOException;

class Connection
{
	private $dbh;
	private static $instance = null;
	
	public static function getInstance()
	{
		if (self::$instance === null)
			self::$instance = new Connection();
		return self::$instance;
	}
	
	private function connectToDb()
	{
		global $config;
		$db_config = $config['db_config'];
		$dsn = 'mysql:dbname=' . $db_config['name'] . ';host=' . $db_config['host'];
		
		try {
			$dbh = new PDO($dsn, $db_config['user'], $db_config['password']);
		} catch (PDOException $e) {
			echo 'Connexion échouée : ' . $e->getMessage();
		}
		
		return $dbh;
	}
	
	protected function getDbh()
	{
		if ($this->dbh === null)
			$this->dbh = $this->connectToDb();
		return $this->dbh;
	}
	
}