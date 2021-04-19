<?php
require 'config.php';

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

function loadFilesFromDir($dir): array
{
    $filesFromDir = scandir($dir);

    $filesForRes = [];

    foreach ($filesFromDir as $key => $value) {
        if ($value !== '.' && $value !== '..') {
            $path = $dir . $value;
            $src = './upload/' . $value;

            array_push($filesForRes, [
                'name' => $value,
                'path' => $path,
                'src' => $src,
                'size' => size_format(filesize($path)),
                'uploadDate' => date('d.m.Y', filectime($path))
            ]);
        }
    }

    return $filesForRes;
}

if (isset($_GET)) {
    echo(json_encode(loadFilesFromDir($UPLOAD_PATH)));
}
