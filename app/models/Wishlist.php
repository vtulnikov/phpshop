<?php

declare(strict_types=1);

namespace app\models;

use RedBeanPHP\R;
use vvt\App;

class Wishlist extends AppModel
{
    public function getProduct(int $id): array|string|null
    {
        return R::getCell("SELECT id FROM product WHERE id = ?", [$id]);
    }
    public function addToWishlist(int $id)
    {
        $wishlist = self::getWishlistIds();
        if (!$wishlist) {
            setcookie('wishlist', (string) $id, [
                'expires' => time() + 60 * 60 * 24 * 30,
                'path' => '/',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
        } else {
            if (!in_array($id, $wishlist)) {
                if (count($wishlist) > 5) {
                    array_shift($wishlist);
                }
                $wishlist[] = $id;
                $wishlist = implode(',', $wishlist);
                setcookie(
                    'wishlist',
                    $wishlist,
                    [
                        'expires' => time() + 60 * 60 * 24 * 30,
                        'path' => '/',
                        'httponly' => true,
                        'samesite' => 'Lax',
                    ]
                );
            }
        }
    }
    public static function getWishlistIds(): array
    {
        $wishlist = $_COOKIE['wishlist'] ?? "";
        if (!$wishlist) {
            return [];
        }
        $wishlist = explode(",", $wishlist);
        return array_map('intval', array_slice($wishlist, 0, 6));
    }
    public function getWishlistProducts(int $lang):array
    {
        $wishlist = self::getWishlistIds();
        
        if($wishlist){
            $wishlist = implode(',', $wishlist);
            return R::getAll("SELECT p.*, pd.* FROM product p 
                JOIN product_description pd
                ON p.id = pd.product_id 
                WHERE p.status = 1 AND p.id IN ($wishlist) AND pd.language_id = ?", [$lang]);
        }
        return [];
    }
}
