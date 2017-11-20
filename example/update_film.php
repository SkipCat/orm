<?php

require_once('index.php');

use src\Entity\Film;

$film = new Film();
$result = $film->findById($argv[1]);

$result->setTitle('Pink fluffy unicorn dancing on rainbows');
$result->setGenre('fairy tale');
$result->update();

// php update_film.php 1