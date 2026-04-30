<?php

define("DEBUG", 1);
define("ROOT", dirname(__DIR__));
define("WWW", ROOT . "/public");
define("APP", ROOT . "/app");
define("CORE", ROOT . "/core");
define("HELPERS", CORE . "/helpers");
define("CACHE", ROOT . "/tmp/cache");
define("LOGS", ROOT . "/tmp/logs");
define("CONFIG", ROOT . "/config"); // или ROOT . "/config" можно было написать
define("LAYOUT", "myShop");
define("PATH", "http://shop.loc");
define("ADMIN", "http://shop.loc/admin");
define("NO_IMAGE", "uploads/no-image.jpg");

//подгружаем автозагрузчик классов Composer-a
require_once ROOT . "/vendor/autoload.php";