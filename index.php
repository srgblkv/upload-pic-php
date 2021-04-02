<?php
$dir = 'upload/';
$files = scandir($dir);

function size_format($b) {
    $kb = 1024;
    $mb = $kb * 1024;
    if ($b < 10 * $kb) {
        return $b . ' b.';
    }
    if ($b < $mb) {
        return round(floatval($b / $kb), 1) . ' Kb.';
    }
    if ($b >= $mb) {
        return round(floatval($b / $mb), 1) . ' Mb.';
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;500;700&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Condensed&display=swap" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
    <title>Image Store</title>
</head>
<body>
<div class="container-header">
    <header class="header-page">
        <a href="/"><h1>ImgStore</h1></a>
        <button class="open-upload-modal" type="button">Загрузить изображение</button>
    </header>
</div>
<div class="container-app">
    <main>

        <div class="uploader-modal-wrapper">
            <div class="uploader-modal">
                <span class="close-modal-btn">x</span>
                <h3>Загрузка изображений</h3>
                Для загрузки выберите одно или несколько изображений
                <form enctype="multipart/form-data" action="./upload.php" method="post">
                    <input class="file-input" name="userfile[]" type="file" multiple>
                    <div class="ps">
                        <span>! допускается изображения форматов: jpeg, png, jpg</span>
                        <span>! файл не должен превышать 5 Мб.</span>
                        <span>! максимальное количество файлов - 5</span>
                    </div>
                    <button type="submit" disabled>Загрузить</button>
                </form>
            </div>
        </div>

        <div class="pictures-view">
            <form action="/delete.php" method="post">
                <header class="header-pictures-view">
                    <h2>Галерея изображений:</h2>
                    <button class="btn-remove" type="submit" disabled>&#128465; Удалить выбранные изображения</button>
                </header>
                <?php foreach ($files as $file) : ?>
                    <?php if ($file !== '.' && $file !== '..'): ?>
                        <?php $path = $dir . $file ?>
                        <div class="picture-item">
                            <div class="picture-img">
                                <a href="<?= $path ?>"><img src="<?= $path ?>" alt="<?= $file ?>"/></a>
                            </div>
                            <div class="picture-info">
                                <ul>
                                    <li>Название: <b><?= $file ?></b></li>
                                    <li>Размер файла: <b><?= size_format(filesize($path)) ?></b></li>
                                    <li>
                                        <label>
                                            Выбрать:
                                            <input class="picture-checker" name="<?= trim($file) ?>" type="checkbox"/>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </form>
            <div class="pictures-pagination"><<[1]>></div>
        </div>
    </main>
</div>
<div class="container-footer">
    <footer class="footer-page">
        <a target="_blank" href="https://github.com/srgblkv">@srgblkv</a> 2021
    </footer>
</div>

<script src="js/main.js"></script>
</body>
</html>