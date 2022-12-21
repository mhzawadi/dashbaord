<?php

namespace MHorwood\Dashboard_Docker;

use MHorwood\Dashboard_Docker\docker;
require __DIR__ . '/docker.php';
header("Content-Type:application/json");
$d = new docker();

$REQUEST_URI = \explode('/', $_SERVER['REQUEST_URI']);
switch($REQUEST_URI[1]){
  case 'get_containers':
    $data = $d->get_containers();
    break;
  default:
    $data = 'no request';
    break;
}

echo $data;
