<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/login.css')}}">
</head>
<body>
    <main>
        <div id="info">
            <h1>Inicia sessão na sua conta</h1>
            <p>Veja como está indo o seu negócio</p>
        </div>

        <div class="form-container">
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="passwrod">Senha</label>
                    <input type="password" name="password" id="password">
                </div>
                <input type="submit" value="Entrar">
            </form>
        </div>
    </main>
</body>
</html>