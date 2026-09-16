<?php
/**
 * @var array $page
 */
?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="<?= getBaseURl() ?>"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page"> <?= $page['title'] ?></li>
        </ol>
    </nav>
</div>

<div class="container py-3">
    <div class="row">
        <div class="col-md-12">
            <h1 class="section-title"><?= $page['title'] ?></h1>
        </div>
    
        <div class="col-md-12">
            <?= $page['content'] ?>
        </div>
    </div>
</div>

