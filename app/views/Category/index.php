<?php 
/** @var string $breadcrumbs
 * @var array $category
 * @var array $products
 * @var int $total
 * @var vvt\Pagination $pagination
 * @var vvt\View $this
 * */ 
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <?php //нужно хлебные крошки переделать, либо сделать отдельный метод
            //чтобы текущая категория выводилась без ссылки ?>
            <?= $breadcrumbs; ?>

        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">

        <!-- <div class="col-lg-3 sidebar">

            <div class="mb-2 sidebar-toggler">
                <button class="btn btn-light" type="button">Категории <i class="fas fa-chevron-circle-down"></i></button>
            </div>

            <div class="sidebar-toggle sticky-top">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">Компьютеры</a>
                    <a href="#" class="list-group-item list-group-item-action">Планшеты</a>
                    <a href="#" class="list-group-item list-group-item-action active">Ноутбуки</a>
                    <a href="#" class="list-group-item list-group-item-action">&nbsp;&nbsp;&nbsp;- Mac</a>
                    <a href="#" class="list-group-item list-group-item-action active">&nbsp;&nbsp;&nbsp;- Windows</a>
                    <a href="#" class="list-group-item list-group-item-action">Телефоны</a>
                    <a href="#" class="list-group-item list-group-item-action">Камеры</a>
                </div>
            </div>

        </div> -->

        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?= $category['title'] ?></h3>
            <?php if(!empty($category['content'])) :?>
                <div class="category-desc">
                    <?= $category['content'] ?>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="input-sort">Сортировка:</label>
                        <select class="form-select" id="input-sort">
                            <option value="">По умолчанию</option>
                            <option value="sort=title_asc" 
                                <?php if(isset($_GET['sort']) && $_GET['sort'] == "title_asc") echo "selected" ?>>
                                Название (А - Я)
                            </option>
                            <option value="sort=title_desc"
                                <?php if(isset($_GET['sort']) && $_GET['sort'] == "title_desc") echo "selected" ?>>
                                Название (Я - А)</option>
                            <option value="sort=price_asc"
                                <?php if(isset($_GET['sort']) && $_GET['sort'] == "price_asc") echo "selected" ?>>
                               Цена (низкая > высокая)</option>
                            <option value="sort=price_desc"
                            <?php if(isset($_GET['sort']) && $_GET['sort'] == "price_desc") echo "selected" ?>>
                                Цена (высокая > низкая)
                            </option>
                        </select>
                    </div>
                </div>

                <!-- <div class="col-sm-6">
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="input-sort">Показать:</label>
                        <select class="form-select" id="input-sort">
                            <option selected>15</option>
                            <option value="1">25</option>
                            <option value="2">50</option>
                            <option value="3">75</option>
                            <option value="3">100</option>
                        </select>
                    </div>
                </div> -->
            </div>

            <div class="row">
                <?php if(!empty($products)): ?>
                    <?php foreach ($products as $product) :?>
                    <div class="col-lg-4 col-sm-6 mb-3">
                        <div class="product-card">
                            <div class="product-tumb">
                                <a href="<?= $product['slug'] ?>"><img src="<?= $product['img'] ?>" alt=""></a>
                            </div>
                            <div class="product-details">
                                <h4><a href="<?= $product['slug'] ?>"><?= $product['title'] ?></a></h4>
                                <?php if(!empty($product['excerpt'])): ?>
                                    <p><?= $product['excerpt'] ?></p>
                                <?php endif; ?>
                                <div class="product-bottom-details d-flex justify-content-between">
                                    <div class="product-price">
                                        <?php if(!empty($product['old_price'])): ?>
                                            <small>$96.00</small>
                                        <?php endif; ?>
                                        <?= $product['price'] ?> руб.</div>
                                    <div class="product-links">
                                        <a class = "add-to-cart" href="cart/add?=<?= $product['id'] ?>" data-id=<?= $product['id'] ?>><i class="fas fa-shopping-cart"></i></a>
                                        <a href="#"><i class="far fa-heart"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <p><?= getTranslatedPart('category_view_no_products') ?></p>
                <?php endif; ?>
            </div>

            <?php if($total > $pagination->perPage) :?>
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
            <?php ?>
        </div>

    </div>
</div>