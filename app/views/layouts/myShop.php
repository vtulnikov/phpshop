<?php

use vvt\View;

/** 
 * @var View $this View;
 */

$this->getTemplatePart('header');
echo $this->content ; 
$this->getTemplatePart('footer'); ?>