<?php
declare(strict_types = 1);

namespace app\controllers;

use app\models\Wishlist;

/**@property Wishlist $model */
class WishlistController extends AppController
{
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
        dump(($product));
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
}