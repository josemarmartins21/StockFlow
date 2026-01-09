@extends('layouts.app')

@section('title', 'Stock Flow - Adicionar Mais Produtos')
    
@section('content')
    <section id="produto-container">
        <div id="produto-image-container">
            <img src="{{ asset('assets/imagens/produtos/' . $artigo->imagem) }}" alt="{{ $artigo->nome }}">
        </div>
    
        <div id="produto-info-container">
            <div class="top-info">
                <h2>{{ $artigo->nome }}</h2>

                <h3>Quantidade: {{ $artigo->quantidade }}</h3>
            </div>  

            <div class="center-info">
                <ul>
                    <li> 
                        <span>Preço</span><br>
                        <strong>{{ $artigo->preco }}Kz</strong> 
                    </li>

                    <li> 
                        <span>Estoque Máximo</span><br>
                        <strong>{{ $artigo->estoque_maximo }}</strong> 
                    </li>

                    <li> 
                        <span>Estoque Mínimo</span><br>
                        <strong>{{ $artigo->estoque_minimo }}</strong> 
                    </li>
                </ul>
            </div>

            <div class="bottom-info">
                <div class="produtos-acoes">
                    <form action="" method="post">
                        <select name="" id="">
                            <option value="" selected>Adicionar ao estoque</option>
                            @for ($i = 6; $i < 100; $i+=6)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <button type="submit"><i class="fas fa-minus"></i></button>
                        
                        <button type="submit"><i class="fas fa-plus"></i></button>

                        <button type="submit" id="adicionar">Adicionar</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection