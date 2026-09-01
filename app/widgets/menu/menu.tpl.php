<?php if(isset($category['children'])): ?>
<li class="nav-item <?php if(isset($category['children'])) echo 'dropdown' ; ?>">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <?= $category['title'] ?>
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <?= $this->getHtml($category['children']) ?>
    </ul>
</li>
<?php else: ?>
<li class="nav-item">
    <a class="nav-link" href="<?= $category['slug'] ?>"><?= $category['title'] ?></a>
</li>
<?php endif; ?>