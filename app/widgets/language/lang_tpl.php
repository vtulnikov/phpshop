<?php

use vvt\App;
?>
<div class="dropdown d-inline-block">
    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
        <img src="<?= PATH; ?>/assets/img/<?= App::$app->getProperty('language')['code'] ?>.png" alt="">
    </a>
    <ul class="dropdown-menu" id="languages">
        <?php foreach(App::$app->getProperty('languages') as $lang => $value): ?>
            <?php if($lang == App::$app->getProperty('language')['code']) continue; ?>
        <li>
            <button class="dropdown-item" data-langcode="<?= $lang; ?>">
                <img src="<?= PATH; ?>/assets/img/<?= $lang; ?>.png" alt="">
                <?= $value['title']; ?></button>
        </li>
        <?php endforeach; ?>
    </ul>
</div>