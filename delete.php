<?php
$dir = 'upload/';
foreach (array_keys($_POST) as $array_key) {
    $filename = str_replace('_', '.', $dir . $array_key);
    var_dump(unlink($filename));
}

header('Location: ' . '/');
?>
