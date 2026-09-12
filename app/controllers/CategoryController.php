<?php
declare(strict_types = 1);

namespace app\controllers;

use vvt\App;
use app\models\Category;
use app\models\Breadcrumbs;
use vvt\Pagination;

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

        $page = get('page');
        $perpage = (int) App::$app->getProperty('pagination');
        $total = $this->model->getTotalProducts($catIds);
        $pagination = new Pagination($page, $perpage, $total);
        $offset = $pagination->getStart();

        $products = $this->model->getProducts($catIds, $lang['id'], $offset, $perpage);

        $this->setMeta($category['title'], $category['keywords'], $category['description']);
        $this->setData(compact('category', 'breadcrumbs', 'products', 'total', 'pagination'));
    }
}