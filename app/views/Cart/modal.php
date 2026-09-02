<div class="modal-body">
    <?php if(isset($_SESSION['cart'])): ?>
    <div class="table-responsive cart-table">
        <table class="table text-start">
            <thead>
                <tr>
                    <th scope="col">Фото</th>
                    <th scope="col">Товар</th>
                    <th scope="col">Кол-во</th>
                    <th scope="col">Цена</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($_SESSION['cart'] as $id => $product): ?>
                <tr>
                    <td>
                        <a href="<?= $product['slug'] ?>"><img src="<?= PATH . $product['img'] ?>" alt=""></a>
                    </td>
                    <td><a href="<?= $product['slug'] ?>"><?= $product['title'] ?></a></td>
                    <td><?= $product['quantity'] ?></td>
                    <td><?= $product['price'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <h4 class="text-start">Корзина пуста</h4>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Продолжить покупки</button>
    <?php if(isset($_SESSION['cart'])): ?>
    <button type="button" class="btn btn-success">Оформить заказ</button>
    <button type="button" class="btn btn-danger">Очистить корзину</button>
    <?php endif; ?>
</div>