<?php
include $_SERVER['DOCUMENT_ROOT'] . '/include/config.php';

function size_format($b): string
{
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

function load_files_from_dir($dir): array
{
    $files_from_dir = array_diff(scandir($dir), ['.', '..']);

    $files_for_res = [];

    foreach ($files_from_dir as $key => $value) {
        $path = $dir . $value;
        $src = '/upload/' . $value;

        array_push($files_for_res, [
            'name' => $value,
            'src' => rawurlencode($src),
            'size' => size_format(filesize($path)),
            'uploadDate' => date('d.m.Y', filectime($path))
        ]);
    }

    return $files_for_res;
}

if (isset($_GET)) {
    echo(json_encode(load_files_from_dir($UPLOAD_PATH)));
}
