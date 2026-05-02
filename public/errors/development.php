<?php

/**
 * @var int $errno    Код ошибки
 * @var string $errstr Текст ошибки
 * @var string $errfile Путь к файлу, где возникла ошибка
 * @var int $errline   Номер строки с ошибкой
 */

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ошибка</title>
</head>
<body>

<h1>Произошла ошибка</h1>
<p><b>Код ошибки:</b> <?= htmlspecialchars($errno); ?></p>
<p><b>Текст ошибки:</b> <?= htmlspecialchars($errstr); ?></p>
<p><b>Файл, в котором произошла ошибка:</b> <?= htmlspecialchars($errfile); ?></p>
<p><b>Строка, в которой произошла ошибка:</b> <?= htmlspecialchars($errline); ?></p>

</body>
</html>
