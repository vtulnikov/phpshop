<?php

namespace app\models;

use RedBeanPHP\R;
use vvt\Model;

class Main extends Model
{
    public function getNames():array
    {
        return R::findAll('users');
    }
}
