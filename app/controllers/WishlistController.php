<?php

declare(strict_types=1);

namespace app\controllers;

use app\models\Wishlist;
use vvt\App;
use vvt\Pagination;

/**@property Wishlist $model*/
class WishlistController extends AppController
{
    public function addAction()
    {
        $id = post('id');
        if (!$id) {
            $answer = [
                'result' => 'error',
                'text'   => getTranslatedPart('tpl_wishlist_add_error'),
            ];
            echo json_encode($answer);
            die;
        }
        $product = $this->model->getProduct($id);
        if (!$product) {
            $answer = [
                'result' => 'error',
                'text'   => getTranslatedPart('tpl_wishlist_add_error'),
            ];
            echo json_encode($answer);
            die;
        }
        $this->model->addToWishList($id);
        $answer = [
            'result' => 'success',
            'text'   => getTranslatedPart('tpl_wishlist_add_success'),
        ];
        echo json_encode($answer);
        die;
    }
    public function indexAction()
    {
        $lang = App::$app->getProperty('language');
        $ids = App::$app->getProperty('wishlist');
        $page = get('page');
        $perpage = App::$app->getProperty('pagination');
        $total = count($ids);
        $pagination = new Pagination($page, $perpage, $total);
        $offset = $pagination->getOffset();
        $products = $this->model->getWishlistProducts($ids, $lang['id'], $offset, $perpage );
        

        $this->setMeta(getTranslatedPart('wishlist_index_title'));
        $this->setData(compact('products', 'pagination', 'total'));
    }
    public function deleteAction()
    {
        $id = post('id');
        if($this->model->deleteFromWishlist($id)){
            $answer = [
            "result" => "success",
            "text"   => getTranslatedPart('tpl_wishlist_delete_success'),
        ];
        } else{
             $answer = [
                "result" => "error",
                "text"   => getTranslatedPart('tpl_wishlist_delete_error'),
            ];
        }
        echo json_encode($answer);
        die;
    }
}
