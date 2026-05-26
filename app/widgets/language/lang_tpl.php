<div class="dropdown d-inline-block">
    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
        <img src="<?= PATH; ?>/assets/img/lang/<?= $this->lang['code'] ?>.png" alt="">
    </a>
    <ul class="dropdown-menu" id="languages">
        <?php foreach($this->langs as $lang => $value) : ?>
            
            <?php 
            //убираем из выпадающего списка активный язык 
            if($this->lang['code'] == $lang) continue; 
            ?>
        <li>
            <button class="dropdown-item" data-langcode="<?= $lang ?>">
                <img src="<?= PATH; ?>/assets/img/lang/<?= $lang ?>.png" alt="">
                <?= $value['title'] ?></button>
        </li>
        <?php endforeach; ?>
    </ul>
</div>