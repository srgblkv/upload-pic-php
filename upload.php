<?php
$allowed_filetypes = array('.jpg', '.gif', '.png');
$max_file_size = 5242880;
$upload_path = 'upload/';
$max_file_uploads = 5;
$files = $_FILES['userfile'];

$err = '';

if (count($files['name']) > $max_file_uploads) {
    $err = 'Превышенно максимально допустимое количество файлов!';
} else {
    for ($i = 0; $i < count($files['name']); $i++) {
        $type = $files['type'][$i];
        $size = $files['size'][$i];

        if (!($type === 'image/jpeg' or $type === 'image/png')) {
            $err = 'Error - files wrong format';
            break;
        }
        if (!($size <= $max_file_size)) {
            $err = 'Error - files wrong size';
            break;
        }
    }
}

if ($err) {
    echo "<script>alert('$err')</script>";
} else {
    for ($i = 0; $i < count($files['tmp_name']); $i++) {
        $name = $files['name'][$i];
        $tmp_name = $files['tmp_name'][$i];

        move_uploaded_file($tmp_name, $upload_path . str_replace([' ', '_'], '-', $name));
    }

    header('Location: ' . '/');
}
?>

<body style="background: white">
<a href="/">Вернуться</a>
</body>
