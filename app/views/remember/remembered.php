<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/mvc/app/views/upload/uploadstyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zapamiętane</title>
</head>
<body>

    <h1>ZAPAMIĘTANE</h1>

    <?php
        echo '<br>';
        include_once __DIR__ . '/../../galleries/gallery2.php';
        gallery2();
    ?>

    <br><br><a href="/./mvc/public/upload/index"><button class="button1">POWRÓT DO STRONY GŁÓWNEJ</button></a>
</body>
</html>