<?php

define("DEBUG", 0);
define("ROOT", dirname(__DIR__));
define("WWW", ROOT . "/public");
define("APP", ROOT . "/app");
define("CORE", ROOT . "/vendor/vvt");
define("HELPERS", CORE . "/helpers");
define("CACHE", ROOT . "/tmp/cache");
define("LOGS", ROOT . "/tmp/logs");
define("CONFIG", __DIR__); // или ROOT . "/config" можно было написать
define("LAYOUT", "myShop");
define("PATH", "http://shop.loc");
define("ADMIN", "http://shop.loc/admin");
define("NO_IMAGE", "uploads/no-image.jpg");

//подгружаем автозагрузчик классов Composer-a
require_once ROOT . "/vendor/autoload.php";