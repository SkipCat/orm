<?php

require_once('index.php');

use src\Entity\Film;

$film = new Film();
$film->delete($argv[1]);

// php delete_film.php 1