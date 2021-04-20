<?php include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php'; ?>
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
    <link href="/styles/style.css" rel="stylesheet">
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
        <p id="status-message"></p>
        <div class="uploader-modal-wrapper">
            <div class="uploader-modal">
                <span class="close-modal-btn">x</span>
                <h3>Загрузка изображений</h3>
                <div class="ps">
                    <span>! допускается изображения форматов: *.jpeg, *.png</span>
                    <span>! файл не должен превышать 5 Мб.</span>
                    <span>! максимальное количество файлов - 5</span>
                </div>
                <form id="upload-files" enctype="multipart/form-data" method="post">
                    <input class="file-input" id="file-field" name="file" type="file" multiple
                           accept="<?= implode(', ', $VALID_IMAGE_MIME_TYPES) ?>">
                    <progress id="progress-bar" value="0" max="100"></progress>
                    <button type="submit" disabled>Загрузить</button>
                </form>
            </div>
        </div>

        <div class="pictures-view">
            <form id="delete-files" method="post">
                <header class="header-pictures-view">
                    <h2>Галерея изображений:</h2>
                    <button class="btn-remove" type="submit" disabled>&#128465; Удалить выбранные изображения</button>
                </header>
                <div class="pictures-view-items"></div>
            </form>
        </div>
    </main>
</div>
<div class="container-footer">
    <footer class="footer-page">
        <a target="_blank" href="https://github.com/srgblkv">@srgblkv</a> 2021
    </footer>
</div>
<script src="/js/main.js"></script>
</body>
</html>