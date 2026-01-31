@extends('layouts.app')
@section('title', config('app.name', 'StockFlow'))


@section('content')
    <section id="venda-show" class="">
        <div class="venda-container-imagem">
            <img src="{{ asset('assets/imagens/estoques/' . $venda->image) }}" alt="{{ $produto->name }}" title="Imagem da quantidade restante de {{ $produto->name }}">  
        </div>

        <div class="info-cotainer">
            <h2>{{ $produto->name }}</h2>
            

            <ul>
                <li>
                    <h3>Registrado Por</h3>
                    <span>{{ session('usuario') }}</span>
                </li>
                <li>
                    <h3>Quantidade vendida</h3>
                    <span>{{ number_format($venda->quantity_sold, 2, ',', '.') }}</span>
                </li>
                <li>
                    <h3>Valor total</h3>
                    <span>{{ number_format($produto->price * $venda->quantity_sold, 2, ',', '.') }}</span>
                </li>
            </ul>
        </div>

        <div class="venda-details">
            <details>
                <summary>Ver observações</summary>

                <p>
                    {{ $venda->note }}
                </p>
            </details>
        </div>
    </section>
@endsection