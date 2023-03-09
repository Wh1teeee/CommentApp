
<!DOCTYPE html>
<html lang="en">
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Registracija</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="stil.css">
</head>
<body class="pozadina">
    <div class="wrapper">
    <form method="post" action="logika/registrujse.php">
        <input type="text" name="username" placeholder="Unesite username" class="login"><br>
        <input type="password" name="password" placeholder="Unesite password" class="login"><br>
        <input type="password" name="password_repeat" placeholder="Ponovite password" class="login"><br>
        <input type="email" name="email" placeholder="Unesite e-mail" class="login"><br>
        <input type="submit" value="Registruj se" class="login">
    </form>
    <a href="login.php" style="color:white;">Vec imate nalog? Prijava</a>
    </div>
</body>
</html>