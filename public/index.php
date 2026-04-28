<?php

use vvt\App;

if(phpversion() < 8.3) {
    die("Необходима версия php > 8.4");
}
require_once dirname(__DIR__) . "/config/init.php";

new App();

var_dump(App::$app->getProperties());