<?php
namespace app\controllers;

use vvt\App;
use app\models\Product;
use app\models\Breadcrumbs;

/**@property Product  $model */
class ProductController extends AppController
{
    public function viewAction()
    {
        $lang = App::$app->getProperty('language');
        $product = $this->model->getProduct($this->route['slug'], $lang['id']);
        $gallery = $this->model->getGallery($product['id']);

        $this->setMeta($product['title'], $product['description'], $product['keywords']);

        $breadcrumbs = Breadcrumbs::getBreadcrumbs($product['category_id'], $product['title']);
        $this->setData(compact('product', 'gallery' , 'breadcrumbs'));
    }
}