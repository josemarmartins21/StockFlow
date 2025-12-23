@extends('layouts.app')

@section('title', 'Categorias - StockFlow')
    
@section('content')
<section id="categorias-container">

    <x-alert />

    <h2>Categorias</h2>
    <div id="categorias-menu">
        <form action="" method="get">
            <div class="form-search">
                <input type="search" name="pesquisa" id="pesquisa" placeholder="Busque por uma categoria" class="pesquisa">
            </div>
        </form>

        <div id="categoria-aco">
            <a href="{{ route('categorias.create') }}">Nova categoria <i class="fa-solid fa-square-plus"></i></a>
        </div>
    </div>

    <div id="categorias-index">
        @forelse ($categorias as $categoria)
        <a href="#" class="categoria" rel="next">
            <div class="categoria-info">
                <h3>
                    <span class="categoria-icon"><i class="fa-solid fa-bottle-droplet"></i></span>

                    {{ $categoria->name }}
                </h3>

                <p>
                    {{ substr($categoria->desc, 0, 75) }}
                </p>
            </div>
            <div class="barra"></div>
            <div class="categoria-details">
                <strong>Total de {{ $categoria->name }}: <span style="color: green">20</span></strong>
            </div>
        </a>
            
        @empty
            <img src="{{ asset('assets/imagens/ilustrations/void.png') }}" alt="Nada encontrado">
        @endforelse
        
    </div>
</section>
@endsection