<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fatura</title>
</head>
<style>
    .btn {
        background: tomato;   
        color: #fff;
        font-weight: bold;
        padding: 10px;
        border-radius: 10px;
        text-decoration: none;
    }
</style>
<body>
    <main>
        <h2>Fatura de {{ date('d/m/Y') }}</h2>
        <p>Gerada Por {{ $nome_user }}</p>
        <h2>Faça o download a baixo</h2>
        <a href="{{ Storage::url($fatura->path) }}"  download="{{ $fatura->path }}" class="btn">Baixar</a>
    </main>
</body>
</html>