<?php

namespace app\controllers;

use app\models\Main;
use RedBeanPHP\R;

/** @property Main $model */

class MainController extends AppController
{
    public function indexAction()
    {
        $this->setMeta("Главная страница", "Описание","Ключевые, слова");
        $names = $this->model->getNames();
        $this->setData($names);

        $slides = R::findAll('slider');
        $products = $this->model->getHits(1, 6);
        
        $this->setData(compact('slides', 'products'));// передаем массив ['slides' => .. , и 'products' => ..] в контроллер, в свойство $data
    }
}