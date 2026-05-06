<?php
use vvt\View;
/** 
* @var View $this View;
*/
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->getMeta(); ?>
</head>
<body>
    <?php echo $this->content; ?>
</body>
</html>