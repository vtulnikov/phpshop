<?php

if(phpversion() < 8.3) {
    die("Необходима версия php > 8.4");
}
require_once dirname(__DIR__) . "/config/init.php";

echo "TEST";