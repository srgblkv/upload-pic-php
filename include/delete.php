<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';

$err = '';

if (isset($_POST['files'])) {
    foreach ($_POST['files'] as $file_name) {
        $file_path = $UPLOAD_PATH . $file_name;

        if (strpos(realpath($file_path), realpath($UPLOAD_PATH . $file_name)) === 0) {
            if (!unlink($file_path)) {
                $err = 'Не удалось удалить файл!';
                break;
            }
        } else {
            $err = 'Путь к файлу указан неверно';
            break;
        }
    }
} else {
    $err = 'Нет файлов для удаления!';
}

if ($err) {
    echo $err;
} else {
    echo 'Выбранные файлы успешно удалены.';
}

