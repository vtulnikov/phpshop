<?php

namespace app\models;

use RedBeanPHP\R;

class Main extends AppModel
{
    public function getNames():array
    {
        return R::findAll('users');
    }
}
