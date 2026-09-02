<?php
declare(strict_types = 1);

namespace app\controllers;

use vvt\App;
use app\models\Cart;

/**@property Cart $model */
class CartController extends AppController
{
    public function addAction()
    {
        $lang = App::$app->getProperty('language');
        $id = get('id');
        $quantity = get('quantity');

        $product = $this->model->getProduct($id, $lang);
        if(!$product) return;

        $this->model->addToCart($product, $quantity);
        if($this->isAjax()){
            var_dump($_SESSION);
        }
        die;
    }
}