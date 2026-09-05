<?php
declare(strict_types = 1);

namespace app\models;

use RedBeanPHP\R;

class Cart extends AppModel
{
    public function getProduct(int $id, string $lang):array
    {
        return R::getRow("SELECT p.*, pd.* FROM product as p 
        JOIN product_description as pd on p.id = pd.product_id 
        WHERE p.status = 1 AND p.id = ? AND pd.language_id = ?", [$id, $lang]);
    }
    public function addToCart(array $product, int $quantity = 1)
    {
        $quantity = abs($quantity);
        //если цифровой товар уже в корзине, больше его не добавляем
        if($product['is_download'] && isset($_SESSION['cart'][$product['id']])){
            return false;
        }
        //если товар уже в корзине (и он не цифровой, т.к. его отсеяли в пред. условии)
        if(isset($_SESSION['cart'][$product['id']])){
            $_SESSION['cart'][$product['id']]['quantity'] += $quantity;
        } else{//товара нет в корзине
            if($product['is_download']){ //если цифровой товар, то кол-во его ставим 1
                $quantity = 1;
            }
            $_SESSION['cart'][$product['id']] = [
                'title'       => $product['title'],
                'slug'        => $product['slug'],
                'price'       => $product['price'],
                'img'         => $product['img'],
                'quantity'    => $quantity,
                'is_download' => $product['is_download']
            ];
        }
        // $_SESSION['cart.quantity'] = !empty($_SESSION['cart.quantity']) ? $_SESSION['cart.quantity'] + $quantity : 1;
        
        $_SESSION['cart.quantity'] = ($_SESSION['cart.quantity'] ?? 0) + $quantity;
        $_SESSION['cart.sum'] = ($_SESSION['cart.sum'] ?? 0) + $product['price'] * $quantity;
        return true;
    }
    public function delItemFromCart(int $id)
    {
        $_SESSION['cart.quantity'] -= $_SESSION['cart'][$id]['quantity'];;
        $_SESSION['cart.sum'] -= ($_SESSION['cart'][$id]['quantity'] * $_SESSION['cart'][$id]['price']);
        unset($_SESSION['cart'][$id]);
    }
    public static function translateCart(int $lang):void
    {
        if(empty($_SESSION['cart'])) return;

        $ids = array_filter(array_keys($_SESSION['cart']), fn($elem) => is_numeric($elem) && intval($elem) > 0 );
        $ids = implode(",", array_map(fn($elem) => intval($elem), $ids));

        $products = R::getAssoc("SELECT product_id,language_id,title 
                    FROM product_description 
                    WHERE product_id IN ($ids) AND language_id = ?", [$lang]);
            /**@var array $data */ //что IDE не ругалась, хз почему ругается
        foreach($products as $id => $data){
            $_SESSION['cart'][$id]['title'] = $data['title'];
        }
    }
}