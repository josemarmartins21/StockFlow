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
<x-alert />
    <main>
        <div id="info">
            <h1>Inicia sessão na sua conta</h1>
            <p>Veja como está indo o seu negócio</p>
        </div>

        <div class="form-container">
            <form action="{{ route('auth.login') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', 'josemar21@outlook.pt') }}">
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" value="{{ old('password', 'josemar1234') }}">
                </div>

                <div class="keep-container">
                    <label for="keep">Permanecer logado?</label>
                    <input type="checkbox" name="keep" id="keep">
                </div>
                <p> {{ session('erro') }} </p>
                <p style="display: none">Passowrd: josemar@2005 || Email: josemar21@outlook.pt</p>
                <input type="submit" value="Entrar">
            </form>
        </div>
    </main>
</body>
</html>