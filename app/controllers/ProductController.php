<?php
declare(strict_types = 1);

namespace app\controllers;

use vvt\App;
use app\models\Product;
use app\models\Breadcrumbs;

/**@property Product $model */
class ProductController extends AppController
{
    public function viewAction()
    {
        $lang = App::$app->getProperty('language');
        $product = $this->model->getProduct($this->route['slug'], $lang);
        if(!$product){
            // throw new \Exception("Товар с адресом {$this->route['slug']} не найден", 404);
            $this->error_404();
            return;
        }
        $this->setMeta($product['title'], $product['description'], $product['keywords']);
        $gallery = $this->model->getGallery((int) $product['id']);
        $breadcrumbs = Breadcrumbs::getBreadCrumbs((int) $product['category_id'], $product['title']);

        $this->setData(compact('product', 'gallery', 'breadcrumbs'));

    }
}