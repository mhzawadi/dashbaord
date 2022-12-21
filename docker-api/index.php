<?php

namespace MHorwood\Dashboard_Docker;

use MHorwood\Dashboard_Docker\docker;
require __DIR__ . '/docker.php';
header("Content-Type:application/json");
$d = new docker();

$REQUEST = \explode('?', $_SERVER['REQUEST_URI']);
$REQUEST_URI = \explode('/', $REQUEST[0]);
switch($REQUEST_URI[0]){
  case 'get_containers':
    $data = $d->get_containers();
    break;
  default:
    $data = 'no request';
    break;
}

echo $data;
