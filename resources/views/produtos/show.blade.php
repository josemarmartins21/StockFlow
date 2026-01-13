@extends('layouts.app')

@section('title', ucwords($artigo->nome))
    
@section('content')
<x-alert />
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
                    <form action="{{ route('estoques.atualizar-estoque', ['produto' => $artigo->produto_id]) }}" method="POST">
                        @csrf

                        <select name="quantity" id="quantity">
                            <option value="" selected>Adicionar ao estoque</option>
                            @for ($i = 6; $i < 100; $i+=6)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>

                        <button type="submit" id="adicionar">Adicionar</button>
                    </form> 

                    <div id="increment-container">
                        <form action="{{ route('estoques.incrementar-estoque', ['produto' => $artigo->produto_id]) }}" method="POST">
                            @csrf

                            <button type="submit" id="incrementar"><i class="fas fa-plus"></i></button>
                        </form>
                        
                        <form action="{{ route('estoques.decrementar-estoque', ['produto' => $artigo->produto_id]) }}" method="POST">
                            @csrf

                            <button type="submit" id="decrementar"><i class="fas fa-minus"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection