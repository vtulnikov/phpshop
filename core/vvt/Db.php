<?php

namespace vvt;

use vvt\TSingleton;
use RedBeanPHP\R;

class Db
{
    use TSingleton;

    public function __construct()
    {
        $config = require CONFIG . "/config-db.php";
        $dsn = "mysql:host={$config['host']};dbname={$config['db_name']};charset={$config['charset']}";
        R::setup($dsn, $config['db_user'], $config['password']);
        if (!R::testConnection()) {
            throw new \Exception("No connection to DB", 500);
        }
        R::freeze(true);
        if (DEBUG) {
            R::debug(true, 3);
        }
    }
}
