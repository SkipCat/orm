<?php

namespace src;

use PDO;
use PDOException;
use src\Log;

class Connection
{
	private $dbh;
	
	private function connectToDb()
	{
		global $config;
		$db_config = $config['db_config'];
		$dsn = 'mysql:dbname=' . $db_config['name'] . ';host=' . $db_config['host'];
		
		try {
			$dbh = new PDO($dsn, $db_config['user'], $db_config['password']);
		} catch (PDOException $e) {
			echo 'Connexion échouée : ' . $e->getMessage();
			$log = new Log();
			$log->writeErrorLog('Database connection', null, $e->getMessage());
		}
		
		return $dbh;
	}
	
	public function getDbh()
	{
		if ($this->dbh === null)
			$this->dbh = $this->connectToDb();
		return $this->dbh;
	}
	
}
