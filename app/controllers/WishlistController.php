<?php
declare(strict_types = 1);

namespace app\controllers;

use app\models\Wishlist;
use vvt\App;

/**@property Wishlist $model */
class WishlistController extends AppController
{
    public function indexAction()
    {
        $lang = App::$app->getProperty('language');
        $products = $this->model->getWishlistProducts($lang['id']);
        $this->setMeta(getTranslatedPart('wishlist_index_title'));
        $this->setData(compact('products'));
    }
    public function addAction()
    {
        $id = get('id');
        if(!$id){
            $answer = [
                "result" => "error",
                "text"   => getTranslatedPart('tpl_wishlist_add_error'),
            ];
            echo json_encode($answer);
            die;
        }
        $product = $this->model->getProduct($id);
        if(!$product){
            $answer = [
                "result" => "error",
                "text"   => getTranslatedPart('tpl_wishlist_add_error'),
            ];
            echo json_encode($answer);
            die;
        }
        $this->model->addToWishlist($id);
        $answer = [
            "result" => "success",
            "text"   => getTranslatedPart('tpl_wishlist_add_success'),
        ];
        echo json_encode($answer);
        die;
    }

    public function deleteAction()
    {
        $id = get('id');
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