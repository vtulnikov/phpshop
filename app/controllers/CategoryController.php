<?php
declare(strict_types = 1);

namespace app\controllers;

use app\models\Breadcrumbs;
use vvt\App;
use app\models\Category;
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
        $cats = App::$app->getProperty('categories');
        $catIds = $this->model->getIds($cats, (int) $category['id']);
        $catIds .= $category['id'];

        $page = get('page');
        $perpage = App::$app->getProperty('pagination');
        $total = $this->model->getTotalPosts((int) $category['id']);

        $pagination = new Pagination($page, $perpage, $total);
        $offset = $pagination->getOffset();

        $sort = get('sort', 's');

        $products = $this->model->getProducts($catIds, $lang['id'], $offset, $perpage, $sort);

        $this->setMeta($category['title'], $category['keywords'], $category['description']);
        $this->setData(compact('category', 'breadcrumbs', 'products', 'pagination', 'total'));
    }
}