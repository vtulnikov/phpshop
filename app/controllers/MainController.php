<?php

namespace app\controllers;

use app\models\Main;
use RedBeanPHP\R;

/** @property Main $model */

class MainController extends AppController
{
    public function indexAction()
    {
        $this->setMeta("Главная страница", "Описание", "Ключевые, слова");

        $slides = $this->model->getSlides();
        $products = $this->model->getHits(1, 6);

        // передаем массив ['slides' => .. , и 'products' => ..] в контроллер (в текущий), в свойство $data
        $this->setData(compact('slides', 'products'));
    }
}