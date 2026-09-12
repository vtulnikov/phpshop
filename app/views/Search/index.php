<?php 
/** 
 * @var array $products
 * @var int $total
 * @var vvt\Pagination $pagination
 * @var vvt\View $this
 * */ 
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="<?= getBaseURl() ?>"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page"> Результаты поиска</li>
        </ol>
    </nav>
</div>
<div class="container py-3">
    <h3 class="section-title">Результаты поиска:</h3>
    <p><?= getTranslatedPart('tpl_search_query') ?> <em><?= h($s) ?></em> найдено <?= $total ?> товаров. </p>
    <div class="row">
        <div class="col-lg-12 category-content">
            <div class="row">
                <?php if(!empty($products)): ?>
                    <?php $this->getTemplatePart('Templete-parts/products-loop', compact('products')); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <p>Найдено товаров: <?= $total ?></p>
                        </div>
                    </div>
                    <?php else: ?>
                        <p><?= getTranslatedPart('tpl_search_no_result') ?></p>
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