@extends('layouts.app')
@section('title', config('app.name', 'StockFlow'))
@section('boasvindas')
    <h1 id="nome-hora">Olá, <span id="nome-hora"></span></h1>   
@endsection
@section('pesquisa')
<div id="form-search">
        <form action="" method="get">
            <input type="search" name="" id="" placeholder="Pesquise qualquer coisa..">
            <a href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
        </form>
    </div>
@endsection
@section('content')
{{-- Componet de mensagens de erro e sucesso --}}
<x-alert />
     <div id="relatorios-container">
                <div class="relatorio">
                    <div class="info-container">
                        <span>Produto abaixo do estoque</span>
                        <h3>{{ ucfirst($menor_estoque->name) }} <span style="color: red"> {{ $menor_estoque->quantidade }}  </span></h3>
                    </div>
                </div>
                <div class="relatorio">
                    <div class="info-container">
                        <span>Estoque actual</span>
                        <h3>{{ $total_em_estoque }}</h3>
                    </div>
                </div>

                <div class="relatorio">
                    <div class="info-container">
                        <span>Maior valor de estoque <span>{{ ucwords($maior_valor_estoque->nome) }}</span></span>
                        <h3 style="color: green;">{{ number_format($maior_valor_estoque->maximo_valor_estoque, 2, ',', '.')  }}</h3>
                    </div>
                </div>
            </div> {{-- Fim dos relatórios --}}

            <div class="tabela">
                <div id="table-extras">
                    <h2>Todos os produtos</h2>

                    <div id="acoes-container">
                        <a href="{{ route('produto.pdf.downlod') }}" class="baixar-pdf">Baixar Pdf <i class="fa-solid fa-download"></i></a>
                    </div>

                    <form action="" method="get">
                        <input type="search" name="busca" id="busca" placeholder="Busque por um produto">
                    </form>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Quantidade Actual</th>
                            <th>Valor do estoque</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produtos as $produto)
                            <tr>
                                <td> {{ $loop->index + 1 }} </td>
                                <td> {{ $produto->nome_produto }} </td>
                                <td> {{ $produto->price }}Kz </td>
                                <td> {{ $produto->current_quantity }} </td>
                                <td> {{ number_format($produto->total_stock_value, 2, ',', '.') }}Kz </td> 
                                <td> 
                                    <a href="{{ route('produtos.show', ['produto' => $produto->id]) }}" class="eye"><i class="fa-solid fa-eye"></i></a>

                                    <form action="{{ route('produtos.destroy', ['produto' => $produto->id]) }}" method="POST" id="form-delete">
                                        @csrf
                                        @method("Delete")
                                        
                                        <button type="submit" class="btn-delete" onclick="return confirm('Tem a certeza que pretende eliminar?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('produtos.edit', ['produto' => $produto->id]) }}" class="edit"> <i class="fa-solid fa-pen-to-square"></i></a> 
                                </td>  
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              
                   {{ $produtos->links() }}

            </div>
@endsection

@section('footer')
    <footer>
      <p>&copy;Todos os direitos reservados {{ date('Y') }}</p>
    </footer>
@endsection
