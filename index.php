<?php
ob_start();
//error_reporting(-1);
//ini_set('display_errors','1');

use core\Utility as U;
use core\Router;

require_once './core/Utility.php';
U::init();

require_once U::$APP . 'routes.php';
Router::execute($_GET['route'], $_POST);

exit();
