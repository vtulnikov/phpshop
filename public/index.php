<?php

use vvt\App;
use vvt\Router;

if(phpversion() < 8.3) {
    die("Необходима версия php > 8.4");
}
require_once dirname(__DIR__) . "/config/init.php";
require_once HELPERS . "/functions.php";
require_once CONFIG . "/routes.php";

new App();

echo "Все ОК";