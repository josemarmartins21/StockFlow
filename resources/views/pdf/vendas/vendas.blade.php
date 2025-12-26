<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pdf Vendas</title>
</head>
<style>
    * {
        padding: 0;
        margin: 0;
    }
    body {
        height: 100vh;
    }
.tabela {
    width: 95%;
    margin: auto;
    margin-top: 50px;
    background-color: #ffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 1px 1px 14px rgba(0, 0, 0, 0.123);
    font-family: Arial, Helvetica, sans-serif
    
}
table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
    margin-bottom: 10px;
}
thead {
    background-color: #000000;
    color: #ffff;
}
thead tr th {
    padding: 6px;
}

tbody tr td {
    padding: 6px;
}

tbody tr:nth-child(even) {
    background-color: rgba(0, 0, 0, 0.145);
}
#table-extras {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
    
}

form input {
    padding: 10px;
    border-radius: 10px;
    outline: none;
    border: 1px solid rgba(0, 0, 0, 0.33);
    width: 220px;
}
</style>
<body>
    <div class="tabela">
                <div id="table-extras">
                    <h2>Todas a vendas de {{ date('m/d/Y')}} </h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade Vendida</th>
                            <th>Valor total</th>
                            <th>Data da venda</th>
                            <th>Valor do estoque actual</th>
                            <th>Vendedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendas as $venda)
                            <tr>
                                <td> {{ $venda->nome  }} </td>
                                <td> {{$venda->quantidade_vendida }} </td>
                                <td> {{ number_format($venda->quantidade_vendida * $venda->preco, 2, ',', '.') }} </td>
                                <td> {{ substr($venda->dia_venda, 0, 10) }} </td>
                                <td> {{ number_format($venda->valor_total_do_estoque,2, ',', '.') }} </td>  
                                <td> {{ $venda->nome_user  }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
</body>
</html>
