<?php
declare(strict_types = 1);

namespace app\models;

use RedBeanPHP\R;

class Wishlist extends AppModel
{
    public function getProduct(int $id):?string
    {
        return R::getCell("SELECT id FROM product WHERE id = ?", [$id]);
    }
    public function addToWishList(int $id)
    {
        $wishlist = self::getWishlist();
        if(!$wishlist){
            setcookie('wishlist', (string) $id, time() + 3600 * 24 * 30);
        } else{
            if(!in_array($id, $wishlist)){
                $wishlist[] = $id;
                $wishlist = implode(',', $wishlist);
                setcookie('wishlist', $wishlist, time() + 3600 * 24 * 30);
            }
        }
    }
    public static function getWishlist():array
    {
        $wishlist = $_COOKIE['wishlist'] ?? "";
        if(!$wishlist){
            return [];
        }
        return array_map('intval', explode(',', $wishlist));
    }
}