<?php

namespace MHorwood\Dashboard;

use MHorwood\Dashboard\Controller\DashboardController;

require __DIR__ . '/../../vendor/autoload.php';
require_once('../config/config.php');
require_once('../classes/functions.php');

if (!isset($_SESSION)) {
    session_start();
}

$REQUEST = \explode('?', $_SERVER['REQUEST_URI']);
$REQUEST_URI = \explode('/', $REQUEST[0]);
$args = \array_merge($_GET, $_POST);
if($REQUEST_URI[0] === ''){
  array_shift($REQUEST_URI);
  $args['URL'] = $REQUEST_URI;
}
// print_pre($args);
// print_pre($_SESSION);
$DashboardController = new DashboardController($settings, $_SERVER['HTTP_USER_AGENT']);
$DashboardController->routing($args);
