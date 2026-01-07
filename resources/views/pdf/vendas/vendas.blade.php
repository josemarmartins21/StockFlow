<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pdf Vendas</title>
</head>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        
    }

    header {
        padding: 20px 0;
    }

    main {
        padding: 20px;
        width: 80%;
        margin: auto;
    }

    .data-hora {margin: 10px 0;}
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
       
    }

    th, td {
        border: 1px solid black;
        padding: 5px;
        text-align: center;
    }

    th.table-foot {text-align: left;}
</style>


<body>
<main>
    <header>
        <h1>Hamburgaria G. Wey Carter</h1>
        <address>Luanda, Camama</address>
    </header>

    <h2>Fatura Recibo</h2>
    <div class="data-hora">
        <h3>Data: {{ $vendas[0]->dia_venda}} </h3>
{{--         <h3>Hora: }}</h3> --}}
    </div>

    <h3>Vendido por: {{  session('usuario') }}</h3>
    

    <table>
        <thead>
            <tr>
                <th>Produto - Quantidade</th>
                <th>Preço</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vendas as $venda)
            <tr>
                    <td>{{ ucwords($venda->nome) }} <strong>{{ $venda->quantidade_vendida }}</strong></td>
                    <td>{{ $venda->preco }}</td>
                    <td>{{  number_format($venda->preco * $venda->quantidade_vendida, 2, ',', '.') }}Kz</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="table-foot">Total</th>
                <td>{{ $total_vendido }}Kz</td>
            </tr>
        </tfoot>
    </table>
</main>
</body>
</html>
