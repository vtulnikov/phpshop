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
        $quantity = get('qauntity');
        
        if(!$id) return false;
        
        $product = $this->model->getProduct($id, $lang['id']);
        if(!$product) return false;

        $this->model->addToCart($product, $quantity);
        if($this->isAjax()){
            $this->loadView('modal');
        }
        die;
    }
}