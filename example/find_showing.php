<?php

require_once('index.php');

use src\Entity\Showing;

/*
$show = new Showing();
$result = $show->findById($argv[1]);
var_dump($result);

// php find_showing.php 1
*/


$show2 = new Showing();
$result2 = $show2->findAll();
var_dump($result2);

// php find_showing.php


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

$show3 = new Showing();
$result3 = $show3->findWithParam($argv[1], $argv2, $argv3);
var_dump($result3);

// php find_showing.php null "[id = 1]" "[id ASC]"
// php find_showing.php " LEFT JOIN film ON showing.filmId = film.id" "[showing.id = 13]" null

*/