<?php

require_once('index.php');

use src\Entity\Showing;

$show = new Showing();
$show->delete($argv[1]);

// php delete_showing.php 1