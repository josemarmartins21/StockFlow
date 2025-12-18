<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pdf Produtos</title>
</head>
<style>
.tabela {
    max-width: 1000px;
    margin: auto;
    margin-top: 50px;
    background-color: #ffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 1px 1px 14px rgba(0, 0, 0, 0.123);
    
}
table {
    width: 100%;
    border-collapse: collapse;
    text-align: center;
    margin-bottom: 10px;
}
thead tr th {
    border-bottom: 1px solid #00000036;
    padding: 6px;
}
tbody tr td {
    border-bottom: 1px solid #00000036;
    padding: 6px;
}
nav {
        div:last-child {
            span {
                svg {
                    display: none;
                }
            }
        }
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
                    <h2>Todos os produtos</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Quantidade Actual</th>
                            <th>Categoria</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produtos as $produto)
                            <tr>
                                <td> {{ $loop->index + 1 }} </td>
                                <td> {{ $produto->nome_produto }} </td>
                                <td> {{$produto->price }} </td>
                                <td> {{ $produto->current_quantity }} </td>
                                <td> {{ $produto->name }} </td>  
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
</body>
</html>
