<?php

namespace MHorwood\Dashboard;

use MHorwood\Dashboard\Controller\DashboardController;

require __DIR__ . '/../../vendor/autoload.php';
require_once('../config/config.php');

$REQUEST = \explode('?', $_SERVER['REQUEST_URI']);
$REQUEST_URI = \explode('/', $REQUEST[0]);
if($REQUEST_URI[0] === ''){
  array_shift($REQUEST_URI);
  $args = \array_merge($REQUEST_URI, $_GET, $_POST);
}else{
  $args = \array_merge($_GET, $_POST);
}
$html = '';
$DashboardController = new DashboardController($settings, $_SERVER['HTTP_USER_AGENT']);

$DashboardController->process_action($args);
// $html = $DashboardController->getHTML();

echo $html;
