<?php

require_once('index.php');

use src\Entity\Film;

$film = new Film();
$film->setTitle($argv[1]);
$film->setProducer($argv[2]);
$film->setReleaseDate($argv[3]);
$film->setDuration($argv[4]);
$film->setGenre($argv[5]);

$film->insert();

// php add_film.php "Inception" "Christopher Nolan" "2010-07-16" 148 "syfy"
