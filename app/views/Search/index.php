<?php

/** @var string $s
 * @var array $products
 * @var int $total
 * @var vvt\Pagination $pagination
 * @var vvt\View $this
 * */
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="<?= getBaseUrl() ?>"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= getTranslatedPart('tpl_search_title') ?></li>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">
        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?= getTranslatedPart('tpl_search_title') ?></h3>
            <div class="category-desc">
                <p>По запросу <em><?= h($s) ?></em> найдено <?= $total ?> товаров.</p>
            </div>

            <div class="row">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product) : ?>
                        <div class="col-lg-4 col-sm-6 mb-3">
                            <div class="product-card">
                                <div class="product-tumb">
                                    <a href="<?= $product['slug'] ?>"><img src="<?= $product['img'] ?>" alt=""></a>
                                </div>
                                <div class="product-details">
                                    <h4><a href="<?= $product['slug'] ?>"><?= $product['title'] ?></a></h4>
                                    <?php if (!empty($product['excerpt'])): ?>
                                        <p><?= $product['excerpt'] ?></p>
                                    <?php endif; ?>
                                    <div class="product-bottom-details d-flex justify-content-between">
                                        <div class="product-price">
                                            <?php if (!empty($product['old_price'])): ?>
                                                <small>$96.00</small>
                                            <?php endif; ?>
                                            <?= $product['price'] ?> руб.
                                        </div>
                                        <div class="product-links">
                                            <a class="add-to-cart" href="cart/add?id=<?= $product['id'] ?>" data-id=<?= $product['id'] ?>><?= getCartIcon($product['id']) ?></i></a>
                                            <?php if (in_array($product['id'], vvt\App::$app->getProperty('wishlist'))): ?>
                                                <a class="delete-from-wishlist" href="wishlist/delete?id=<?= $product['id'] ?>" data-id=<?= $product['id'] ?>><i class="fas fa-hand-holding-heart"></i></a>
                                            <?php else: ?>
                                                <a class="add-to-wishlist" href="wishlist/add?id=<?= $product['id'] ?>" data-id=<?= $product['id'] ?>><i class="far fa-heart"></i></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?php if ($total > $pagination->perPage) : ?>
                <div class="row">
                    <div class="col-md-12">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?= $pagination; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>