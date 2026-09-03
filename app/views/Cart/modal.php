<div class="modal-body">
    <?php if(!empty($_SESSION['cart'])): ?>
    <div class="table-responsive cart-table">
        <table class="table text-start">
            <thead>
                <tr>
                    <th scope="col">Фото</th>
                    <th scope="col">Товар</th>
                    <th scope="col">Кол-во</th>
                    <th scope="col">Цена</th>
                    <th scope="col"><i class="far fa-trash-alt"></i></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($_SESSION['cart'] as $id => $item): ?>
                <tr>
                    <td>
                        <a href="product/<?= $item['slug'] ?>"><img src="<?= PATH . $item['img'] ?>" alt=""></a>
                    </td>
                    <td><a href="product/<?= $item['slug'] ?>"><?= $item['title'] ?></a></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= $item['price'] ?></td>
                    <td><a class="del-item" href="cart/delete=?id=<?= $id ?>" data-id=<?= $id ?>><i class="far fa-trash-alt"></i></a></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" class="text-end"><?= getTranslatedPart('tpl_cart_total_qty') ?></td>
                    <td class="cart-qty"><?=$_SESSION['cart.quantity'] ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end"><?= getTranslatedPart('tpl_cart_sum') ?></td>
                    <td class="cart-sum"><?=$_SESSION['cart.sum'] ?> </td>
                </tr>
            </tbody>
        </table>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary ripple" data-bs-dismiss="modal">Продолжить покупки</button>
            <button type="button" class="btn btn-success">Оформить заказ</button>
            <button type="button" id="cart-clear" class="btn btn-danger">Очистить корзину</button>
        </div>            
    </div>
    <?php else: ?>
        <h6 class="text-start">Корзина пуста</h6>
    <?php endif; ?>
</div>
