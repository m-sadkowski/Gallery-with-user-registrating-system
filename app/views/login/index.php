<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/mvc/app/views/upload/uploadstyle.css">
        <script src="/mvc/app/views/upload/script.js"></script>
        <title>Logowanie</title>
    </head>

    <body>
        <h2>Logowanie</h2>
            <form action="login_process" method="post" enctype="multipart/form-data">
                <label for="login">Login:</label>
                <input type="text" id="login" name="login" required><br><br>

                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required><br><br>

                <input type="submit" value="Zaloguj">
            </form>

        <br><br><a href="/./mvc/public/upload/index"><button class="button1">POWRÓT DO STRONY GŁÓWNEJ</button></a>
    </body>

</html>
        
        