<?php
/**
 * Created by Zhufyak V.V.
 * User: zhufy
 * E-mai: zhufyakvv@gmail.com
 * Git: https://github.com/zhufyakvv
 * Date: 15.05.2017
 * Time: 8:00
 */


    if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $uploaddir = __DIR__.'\img\\';
    $image_path = $uploaddir . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

    $image = imagecreatefrompng($image_path);
    $croped = imagecrop($image, ['x' => $_POST['x'], 'y' =>  $_POST['y'], 'width' =>  $_POST['w'], 'height' => $_POST['h']]);
    if ($croped !== FALSE) {
    $croped_path = $uploaddir."\croped\\".basename($_FILES['image']['name']);
    imagepng($croped, $croped_path);
    header('Content-type: image/png');
    echo file_get_contents($croped_path);
    //header('Content-Disposition: attachment; filename="croper.png"');
    }
    }else{
    ?>
    <html>
    <head>
        <title>Image crop</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style/form-style.css">
</head>
<body>
    <div class="form_holder">
    <div class="form">
            <form enctype="multipart/form-data" method="post" >
                <input name = "image" type="file" accept="image/png">
                <input name = "x" type="number" placeholder="x">
                <input name = "y" type="number" placeholder="y">
                <input name = "w" type="number" placeholder="w">
                <input name = "h" type="number" placeholder="h">
                <input type="submit">
            </form>
        </div>
    </div>
</body>
</html>
<?php } ?>