<?php

use vvt\View;

/** 
 * @var View $this View;
 */

$this->getTemplatePart('default/header');
echo $this->content ; 
$this->getTemplatePart('default/footer'); ?>