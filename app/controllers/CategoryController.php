<?php
declare(strict_types = 1);

namespace app\controllers;

use vvt\App;
use app\models\Category;
use app\models\Breadcrumbs;

/**@property Category $model */
class CategoryController extends AppController
{
    public function indexAction()
    {
        $lang = App::$app->getProperty('language');
        $category = $this->model->getCategory($this->route['slug'], $lang['id']);
        if(!$category){
            $this->error_404();
            return;
        }
        $breadcrumbs = Breadcrumbs::getBreadcrumbs((int)$category['id']);
        $cats = App::$app->getProperty('categories_' . $lang['code']);
        $catIds = $this->model->getIds($cats, (int) $category['id']);
        $catIds .= $category['id'];

        $products = $this->model->getProducts($catIds, $lang['id']);
        dump($products);
        $this->setMeta($category['title'], $category['keywords'], $category['description']);
        $this->setData(compact('category', 'breadcrumbs', 'products'));
    }
}