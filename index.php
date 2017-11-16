<?php

require_once('autoload.php');

use src\Film;

$configFile = file_get_contents('app/config/parameters.json');
$config = json_decode($configFile, true);

///////////////////////

$film = new Film();
$film->setTitle('Gladiator');
$film->setProducer('Joel Silver'); //$film->setProducer('Ridley Scott');
$film->setReleaseDate('1998-06-23'); //$film->setReleaseDate('2000-05-05');
$film->setDuration(136); // $film->setDuration(155);
$film->setGenre('syfy'); //$film->setGenre('peplum');
$film->insert('film', $film->getAllProperties());

////////////////////

$newFilm = new Film();
//$newFilm->findWithParam('film', ["title = 'Matrix'"], ['id DESC']);
