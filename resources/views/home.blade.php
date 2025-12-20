@extends('layouts.app')
@section('title', config('app.name', 'StockFlow'))
@section('boasvindas')
<h1>Olá, <span> {{ $user[0]->name }} </span></h1>
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
                    <div class="image-container">
                        <img src="{{ asset('assets/imagens/icones/icons8-produtos-100.png') }}" alt="">
                    </div>

                    <div class="info-container">
                        <span>Total de Produtos</span>
                        <h3>25</h3>
                    </div>
                </div>
                <div class="relatorio">
                    <div class="image-container">
                        <img src="{{ asset('assets/imagens/icones/icons8-tópico-popular-96 (1).png') }}" alt="">
                    </div>

                    <div class="info-container">
                        <span>Produto mais vendido</span>
                        <h3>Cuca</h3>
                    </div>
                </div>

                <div class="relatorio">
                    <div class="image-container">
                        <img src="{{ asset('assets/imagens/icones/icons8-categoria-100.png') }}" alt="">
                    </div>

                    <div class="info-container">
                        <span>Categoria em Destaque</span>
                        <h3>Cerveja</h3>
                    </div>
                </div>
            </div> {{-- Fim dos relatórios --}}

            <div class="tabela">
                <div id="table-extras">
                    <h2>Todos os produtos</h2>

                    <div id="acoes-container">
                        <a href="{{ route('produto.pdf.downlod') }}">Baixar Pdf</a>
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
                            <th>Categoria</th>
                            <th>Ações</th>
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
                                <td> <a href="{{ route('produtos.edit', ['produto' => $produto->id]) }}">Editar</a> <a href="#">Eliminar</a> </td>  
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              
                   {{ $produtos->links() }}

            </div>
@endsection
