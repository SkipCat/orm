<?php

require_once('autoload.php');

use src\Model\DBManager;

$configFile = file_get_contents('app/config/parameters.json');
$config = json_decode($configFile, true);
