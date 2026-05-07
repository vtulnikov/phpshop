<?php 
use vvt\View;
/** 
* @var View $this View;
*/
$this->getTemplatePart("Template-parts/header");
echo $this->content; 
$this->getTemplatePart("Template-parts/footer");
?>