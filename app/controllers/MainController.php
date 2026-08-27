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

        $slides = $this->model->getSlides();
        $hits = $this->model->getProducts(1, 6);
        // передаем массив ['slides' => .. , и 'hits' => ..] в свойство $data MainController-a
        $this->setData(compact('slides', 'hits'));
    }
}