<?php

require_once('index.php');

use src\Entity\Showing;

$show = new Showing();
$result = $show->findById($argv[1]);
var_dump($result);

$result->setShowtime('2017-12-12 17:57:06');
$result->update();

// php update_showing.php 13