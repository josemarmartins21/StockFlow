@extends('layouts.app')
@section('title', config('app.name', 'StockFlow'))

@section('content')
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
            </div>

            <div class="tabela">

            </div>
@endsection
