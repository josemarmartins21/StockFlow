@extends('layouts.app')

@section('title', 'Categoria - ' . ucwords($categoria->name))
    
@section('content')
<section id="show-categorias">
<h2>{{ $categoria->name }}</h2>
    <div class="produtos-container">
        @forelse ($produtos as $produto)
            <div class="produto">
                <div class="image-produto">
                    <img src="{{ asset('assets/imagens/produtos/' . $produto->image . '.jpg') }}" alt="{{ $produto->name }}">
                </div>

                <div class="info-produto">
                    <h3>{{ $produto->name }} - <span>12 uni.</span></h3>

                    <strong>
                        <span>{{  $produto->price}}</span>
                    </strong>
                </div>
                <a href="{{ route('produtos.show', ['produto' => $produto->id]) }}">Ver</a>
            </div>
            
        @empty
            <img src="{{ asset('assets/imagens/ilustrations/void.png') }}" alt="Imagem de nada encontrado">
        @endforelse
    </div>
</section>
@endsection