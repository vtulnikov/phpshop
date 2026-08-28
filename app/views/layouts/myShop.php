<?php

use vvt\View;

/** 
 * @var View $this View;
 */

$this->getTemplatePart('Templete-parts/header');
echo $this->content ; 
$this->getTemplatePart('Templete-parts/footer'); ?>