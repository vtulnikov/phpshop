<?php

/**   @var array $hits */

?>
<?php foreach ($hits as $hit):; ?>
    <div class="col-lg-4 col-sm-6 mb-3">
        <div class="product-card">
            <div class="product-tumb">
                <a href="product/<?= $hit['slug'] ?>"><img src="<?= $hit['img']; ?>" alt="<?= $hit['title']; ?>"></a>
            </div>
            <div class="product-details">
                <h4><a href="product/<?= $hit['slug'] ?>"><?= $hit['title']; ?></a></h4>
                <p><?= $hit['excerpt']; ?></p>
                <div class="product-bottom-details d-flex justify-content-between">
                    <div class="product-price">
                        <?php if ($hit['old_price']) : ?>
                            <small><?= $hit['old_price'] . " руб."; ?></small>
                        <?php endif; ?>
                        <?= $hit['price'] . " руб."; ?>
                    </div>
                    <div class="product-links">
                        <a class="add-to-cart" href="cart/add?id=<?= $hit['id'] ?>" data-id=<?= $hit['id'] ?>><i class="fas fa-shopping-cart"></i></a>
                        <a href="#"><i class="far fa-heart"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>