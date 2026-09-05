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
    public function deleteProduct(int $id)
    {
        if(empty($_SESSION['cart'][$id])) return;

        $_SESSION['cart.quantity'] -= $_SESSION['cart'][$id]['quantity'];
        $_SESSION['cart.sum'] -= $_SESSION['cart'][$id]['quantity'] * $_SESSION['cart'][$id]['price'];
        unset($_SESSION['cart'][$id]);
    }
    public function clearCart()
    {
        if(!empty($_SESSION['cart'])){
            unset($_SESSION['cart.quantity']);
            unset($_SESSION['cart.sum']);
            unset($_SESSION['cart']);
        }
    }
    public static function translateCart(int $lang)
    {
        if(empty($_SESSION['cart'])) return;

        $ids = array_filter(array_keys($_SESSION['cart']), fn($val) => is_numeric($val) && intval($val) > 0);
        $ids = implode(',', array_map(fn($val) => intval($val), $ids));

        $products = R::getAssoc("SELECT product_id, language_id, title 
            FROM product_description 
            WHERE product_id IN ($ids) AND language_id = ?",[$lang]);

            /**@var array $data */  //чтоб не ругалась IDE, хз почему подчеркивае
        foreach($products as $id => $data){
            $_SESSION['cart'][$id]['title'] = $data['title'];
        }
    }
}