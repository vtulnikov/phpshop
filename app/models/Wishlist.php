<?php
declare(strict_types = 1);

namespace app\models;

use RedBeanPHP\R;

class Wishlist extends AppModel
{
    public function getProduct(int $id):array|string|null
    {
        return R::getCell("SELECT id FROM product WHERE id = ?", [$id]);
    }
    public function addToWishlist(int $id)
    {
        $wishlist = self::getWishlistIds();
        if(!$wishlist){
            setcookie('wishlist', (string) $id, time() + 3600 * 24 * 30);
        } else{
            if(!in_array($id, $wishlist)){
                if(count($wishlist) > 5){
                    array_shift($wishlist);
                }
                $wishlist[] = $id;
                $wishlist = implode(',', $wishlist);
                setcookie('wishlist', $wishlist, time() + 3600 * 24 * 30);
            }
        }
    }
    public static function getWishlistIds():array
    {
        $wishlist = $_COOKIE['wishlist'] ?? "";
        if(!$wishlist){
            return [];
        }
        $wishlist = explode(",", $wishlist);
        return array_map('intval', array_slice($wishlist, 0, 6));
        // if($wishlist){
        //     $wishlist = explode(",", $wishlist);
        // }
        // if(is_array($wishlist)){
        //     return array_map('intval', array_slice($wishlist, 0, 6));
        // }
        // return [];
    }
}