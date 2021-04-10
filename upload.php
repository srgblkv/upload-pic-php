<?php
require 'config.php';

$err = '';

function validType($file)
{
    $validImageMimeTypes = ["image/jpeg", "image/png"];

    $finfo = finfo_open(FILEINFO_MIME_TYPE, null);
    $ext = finfo_file($finfo, $file);
    finfo_close($finfo);

    return in_array($ext, $validImageMimeTypes);
}

if (isset($_FILES['files'])) {
    $files = $_FILES['files'];

    if (count($files['name']) > $MAX_FILE_UPLOADS) {
        $err = 'Превышенно максимально допустимое количество файлов!';
    } else {
        for ($i = 0; $i < count($files['name']); $i++) {
            $size = $files['size'][$i];

            if (!(validType($files['tmp_name'][$i]))) {
                $err = 'Неверный формат файла';
            }

            if (!($size <= $MAX_FILE_SIZE)) {
                $err = 'Превышен максимально допустимый размер файла';
            }
        }
    }

    if ($err) {
        echo $err;
    } else {
        for ($i = 0; $i < count($files['tmp_name']); $i++) {
            $name = $files['name'][$i];
            $tmp_name = $files['tmp_name'][$i];

            if (!move_uploaded_file($tmp_name, $UPLOAD_PATH . str_replace([' ', '_'], '-', $name))) {
                echo 'Произошла непредвиденная ошибка';
                break;
            }
        }
        echo 'Загрузка прошла успешна.';
    }
} else {
    echo 'Необходимо выбрать файл.';
}
