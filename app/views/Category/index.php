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
                            <option selected>По умолчанию</option>
                            <option value="1">Название (А - Я)</option>
                            <option value="2">Название (Я - А)</option>
                            <option value="3">Цена (низкая > высокая)</option>
                            <option value="3">Цена (высокая > низкая)</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
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
                </div>
            </div>

            <div class="row">
                <?php if(!empty($products)): ?>
                    <?php $this->getTemplatePart('Templete-parts/products-loop', compact('products')); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <p><?php echo (count($products) . " ".  getTranslatedPart('category_view_total_pagination') . " " . $total) ?></p>
                        </div>
                    </div>
                    <?php else: ?>
                        <p><?= getTranslatedPart('category_view_no_products') ?></p>
                <?php endif; ?>
            </div>
            <?php if($pagination->countPages > 1) :?>
            <div class="row">
                <div class="col-md-12">
                    <?= $pagination; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>