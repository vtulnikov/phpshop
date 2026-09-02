<?php
declare(strict_types = 1);

namespace app\models;

use RedBeanPHP\R;

class Cart extends AppModel
{
    public function getProduct(int $id, array $lang):array
    {
        return R::getRow("SELECT p.*, pd.* FROM product as p 
            JOIN product_description as pd on p.id = pd.product_id 
            WHERE p.status = 1 AND p.id = ? AND pd.language_id = ?",[$id, $lang['id']] );
    }
    public function addToCart(array $product, int $quantity)
    {
        $quantity = abs($quantity);

        //если цифровой товар и он добавлен в корзину
        if($product['is_download'] && isset($_SESSION['cart'][$product['id']])){
            return false;
        } elseif(isset($_SESSION['cart'][$product['id']])){ //если товар в корзине (не цифровой), увеличиваем его кол-во
            $_SESSION['cart'][$product['id']]['quantity'] += $quantity;
        } else{
            if($product['is_download']){
                $quantity = 1;
            }
            $_SESSION['cart'][$product['id']] = [
                'slug'        => $product['slug'],
                'price'       => $product['price'],
                'img'         => $product['img'],
                'is_download' => $product['is_download'],
                'title'       => $product['title'],
                'quantity'    => $quantity,
            ];
        }
        $_SESSION['cart.quantity'] = ($_SESSION['cart.quantity'] ?? 0) + $quantity;
        $_SESSION['cart.sum'] = ($_SESSION['cart.sum'] ?? 0) + $product['price'] * $quantity;
    }
}