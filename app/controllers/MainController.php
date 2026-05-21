<?php

namespace app\controllers;

use app\models\Main;
use RedBeanPHP\R;

/** @property Main $model */

class MainController extends AppController
{
    public function indexAction()
    {
        $this->setMeta("Заголовок страницы", "Описание","Ключевые, слова");
        $names = $this->model->getNames();
        $this->setData($names);

        $slides = R::findAll('slider');
        $this->setData(compact('slides'));// передаем массив ['slides' => ] в контроллер, в свойство $data
    }
}