<div class="modal-body">
    <?php if(isset($_SESSION['cart'])): ?>
    <div class="table-responsive cart-table">
        <table class="table text-start">
            <thead>
                <tr>
                    <th scope="col"><?= getTranslatedPart('tpl_cart_photo') ?></th>
                    <th scope="col"><?= getTranslatedPart('tpl_cart_product') ?></th>
                    <th scope="col"><?= getTranslatedPart('tpl_cart_qty') ?></th>
                    <th scope="col"><?= getTranslatedPart('tpl_cart_price') ?></th>
                    <th scope="col"><i class="far fa-trash-alt"></i></th>
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
                    <td><a class="del-item" href="cart/delete?id=<?= $id ?>"><i class="far fa-trash-alt"></i></a></td>
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
    </div>
    <?php else: ?>
        <h4 class="text-start">Корзина пуста</h4>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><?= getTranslatedPart('tpl_cart_btn_continue') ?></button>
    <?php if(isset($_SESSION['cart'])): ?>
    <button type="button" class="btn btn-success"><?= getTranslatedPart('tpl_cart_btn_order') ?></button>
    <button type="button" class="btn btn-danger"><?= getTranslatedPart('tpl_cart_btn_clear') ?></button>
    <?php endif; ?>
</div>