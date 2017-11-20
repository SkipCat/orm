<?php

require_once('index.php');

use src\Entity\Film;

/*
$film = new Film();
$result = $film->findById($argv[1]);
var_dump($result);

// php find_film.php 1
*/


$film2 = new Film();
$result2 = $film2->findAll();
var_dump($result2);

// php find_film.php


/*
if ($argv[2] !== "null") {
	$argv2 = substr($argv[2], 1, -1); // remove '[’ and ']'
	$argv2 = explode(', ', $argv2);
} else {
	$argv2 = $argv[2];
}

if ($argv[3] !== "null") {
	$argv3 = substr($argv[3], 1, -1); // remove '[’ and ']'
	$argv3 = explode(', ', $argv3);
} else {
	$argv3 = $argv[3];
}

$film3 = new Film();
$result3 = $film3->findWithParam($argv[1], $argv2, $argv3);

// php find_film.php null "[id = 1]" null
// php find_film.php " LEFT JOIN showing ON film.id = showing.filmId" "[film.id = 1] "[id DESC]"
*/

