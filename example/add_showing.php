<?php

require_once('index.php');

use src\Entity\Showing;

$film = new Showing();
$film->setFilmId($argv[1]);
$film->setShowtime($argv[2]); // 'Y-m-d H:i:s' format here

$film->insert();

// php add_showing.php 1 "2010-12-25 23:59:00"
