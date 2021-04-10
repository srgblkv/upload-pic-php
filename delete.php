<?php
require 'config.php';

foreach ($_POST['files'] as $file_name) {
    $filename = $UPLOAD_PATH . $file_name;

    if (!unlink($filename)) {
        echo 'Произошла непредвиденная ошибка!';
        break;
    }
}

echo 'Выбранные файлы успешно удалены.';





