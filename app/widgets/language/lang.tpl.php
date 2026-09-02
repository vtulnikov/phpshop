<?php
/**
 *@var app\widgets\language\Language $this
 */
?>
<div class="dropdown d-inline-block">
    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
        <img src="<?= PATH; ?>/assets/img/<?= $this->language['code'] ?>.png" alt="">
    </a>
    <ul class="dropdown-menu" id="languages">
        <?php foreach($this->languages as $lang => $value): ?>
            <?php if($lang === $this->language['code']) continue; ?>
        <li>
            <button class="dropdown-item" data-langcode="<?= $lang ?>">
                <img src="<?= PATH; ?>/assets/img/<?= $lang ?>.png" alt="">
                <?= $value['title'] ?></button>
        </li>
        <?php endforeach; ?>
    </ul>
</div>