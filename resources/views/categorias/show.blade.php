@extends('layouts.app')

@section('title', 'Categoria - ' . ucwords($categoria->name))
    
@section('content')
<section id="show-categorias">
<h2>{{ $categoria->name }}</h2>
    <div class="produtos-container">
        @forelse ($produtos as $produto)
            <div class="produto">
                <div class="image-produto">
                    <img src="{{ asset('assets/imagens/produtos/' . $produto->imagem) }}" alt="{{ $produto->nome }}">
                </div>

                <div class="info-produto">
                    <h3>{{ $produto->nome }} - <span>{{ $produto->quantidade }} uni.</span></h3>

                    <strong>
                        <span>{{  $produto->preco }}Kz</span>
                    </strong>
                </div>
                <a href="{{ route('produtos.show', ['produto' => $produto->produto_id]) }}">Ver</a>
            </div>
            
        @empty
            <img src="{{ asset('assets/imagens/ilustrations/void.png') }}" alt="Imagem de nada encontrado">
        @endforelse
    </div>
</section>
@endsection