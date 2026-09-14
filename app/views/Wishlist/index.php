<?php 
/** 
 * @var array $products
 * @var int $total
 * @var vvt\View $this
 * */ 
?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="<?= getBaseURl() ?>"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= getTranslatedPart('wishlist_index_title') ?></li>
        </ol>
    </nav>
</div>
<div class="container py-3">
    <h3 class="section-title"><?= getTranslatedPart('wishlist_index_title') ?>:</h3>
    <p> </p>
    <div class="row">
        <div class="col-lg-12 category-content">
            <div class="row">
                <?php if(!empty($products)): ?>
                    <?php $this->getTemplatePart('Templete-parts/products-loop', compact('products')); ?>
                    <?php else: ?>
                        <p><?= getTranslatedPart('wishlist_index_not_found') ?></p>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>