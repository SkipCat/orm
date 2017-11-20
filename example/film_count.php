<?php

require_once('index.php');

use src\Entity\Film;

$film = new Film();
var_dump($film->count());

// php film_count.php
