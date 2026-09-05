<?php
namespace app\controllers;

use vvt\App;
use app\models\Product;

/**@property Product $model */
class ProductController extends AppController
{
    public function viewAction()
    {
        $lang = App::$app->getProperty('language');
        $product = $this->model->getProduct($this->route['slug'], $lang);
        if(!$product){
            throw new \Exception("Товар с адресом {$this->route['slug']} не найден", 404);
        }
        $this->setMeta($product['title'], $product['description'], $product['keywords']);
        $gallery = $this->model->getGallery($product['id']);
        $this->setData(compact('product', 'gallery'));
    }
}