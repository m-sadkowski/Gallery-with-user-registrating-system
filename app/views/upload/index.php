<?php if (session_status() != PHP_SESSION_ACTIVE) {session_start();}?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/mvc/app/views/upload/uploadstyle.css">
        <script src="/mvc/app/views/upload/script.js"></script>
        <title>Przesyłanie Zdjęcia</title>
    </head>

    <body>
        <h1>PRZESYŁANIE ZDJĘCIA</h1>
        <form action="process" method="post" enctype="multipart/form-data">
            <label>WYBIERZ ZDJĘCIE DO PRZESŁANIA:</label><br><br>
            <input type="file" class="button1" name="photo" accept="image/*">
            <br><br>
            <label for="title">TYTUŁ:</label><br><br>
            <input type="text" name="title" id="title" required>
            <br><br>
            <label for="author">AUTOR:</label><br><br>
            <input type="text" name="author" id="author" value="<?php if(isset($_SESSION['user_id'])) { echo $_SESSION['user_login']; } ?>" required>
            <br><br>
            <label for="watermark">ZNAK WODNY:</label><br><br>
            <input type="text" name="watermark" id="watermark" required>
            <br><br>
            <button type="submit" class="button1">PRZEŚLIJ ZDJĘCIE</button>
            <br><br>
        </form>

        <div id="lightbox" onclick="closeLightbox()">
            <span id="close">×</span>
            <img id="lightbox-image" src="" alt="Oryginalne Zdjęcie">
        </div>
        
        <?php
            include_once __DIR__ . '/../../galleries/gallery1.php'; 
            gallery1();
        ?>

    </body>
    
</html>