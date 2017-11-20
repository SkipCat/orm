<?php

require_once('index.php');

use src\Entity\Film;

$film = new Film();
var_dump($film->isExist($argv[1]));

// php film_is_exist.php 1