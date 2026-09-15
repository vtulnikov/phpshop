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
        $wishlist = self::getWishlistIds();
        if(!$wishlist){
            setcookie('wishlist', (string) $id, [
                    'expires' => time() + 3600 * 24 * 30,
                    'path' => '/',
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
        } else{
            if(!in_array($id, $wishlist)){
                $wishlist[] = $id;
                $wishlist = implode(',', $wishlist);
                setcookie('wishlist', $wishlist, [
                    'expires' => time() + 3600 * 24 * 30,
                    'path' => '/',
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
            }
        }
    }
    public static function getWishlistIds():array
    {
        $wishlist = $_COOKIE['wishlist'] ?? "";
        if(!$wishlist){
            return [];
        }
        return array_map('intval', explode(',', $wishlist));
    }
    public function getWishlistProducts(array $wishlist, int $lang, int $offset, int $perpage):array
    {
        if($wishlist){
            $placeholders = implode(',', array_fill(0, count($wishlist), "?"));
            return R::getAll("SELECT p.*, pd.* FROM product p JOIN product_description pd
                        ON p.id = pd.product_id
                        WHERE p.id IN ($placeholders) AND pd.language_id = ? LIMIT $offset, $perpage", [...$wishlist, $lang]);
        }
        return [];
    }
    public function deleteFromWishlist(int $id)
    {
        $wishlist = self::getWishlistIds();
        $key = array_search($id, $wishlist);
        if(false !== $key){
            unset($wishlist[$key]);
            $wishlist = implode(',', $wishlist);
            if($wishlist){
                setcookie('wishlist', $wishlist,
                    [
                    'expires' => time() + 3600 * 60 * 24* 30,
                    'path' => '/',
                    'httponly' => true,
                    'samesite' => 'Lax',
                    ]
                );
            } else{
                setcookie('wishlist', "",
                [
                    'expires' => time() - 3600,
                    'path' => '/',
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]
                );
            }
            return true;
        }
        return false;
    }
}