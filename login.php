<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="stil.css">
</head>
<body class="pozadina">
    <div class="wrapper">
        <form method="post" action="logika/prijavise.php">
            <input type="text" name="username" placeholder="Unesite username" class="login"><br>
            <input type="password" name="password" placeholder="Unesite password" class="login"><br>
            <input type="submit" value="Prijavi se" class="login">
        </form>
        <a style="color:white" href="registracija.php">Nemate nalog? Registrujte se</a>
    </div>
</body>
</html>
