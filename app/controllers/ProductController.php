<?php
namespace app\controllers;

class ProductController extends AppController
{
    public function viewAction()
    {
        $this->setMeta("Страница продукта", "ОПисание продукта", "Ключевые слова");
    }
}