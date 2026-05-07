<?php

namespace app\controllers;

use vvt\Controller;
use app\models\Main;
use RedBeanPHP\R;

/** @property Main $model */

class MainController extends Controller
{
    public function indexAction()
    {
        $this->setMeta("Заголовок страницы", "Описание","Ключевые, слова");
        $names = $this->model->getNames();
        $this->setData($names);
    }
}