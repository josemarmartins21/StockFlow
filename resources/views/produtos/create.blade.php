@extends('layouts.app')

@section('title', 'Stock Flow - Adicionar Mais Produtos')
    
@section('content')
<section id="create-container">
    <x-alert />
    <h1>Cadastrar produto</h1>

    <div id="form-conatiner">
        <form action="{{ route('produtos.store') }}" method="post">
            @csrf

            <div id="produtos-data">
                <div class="form-group" id="nome-container">
                    <label for="name">Nome do produto</label>
                    <input type="text" name="name" id="name" placeholder="Digite o nome do produto *" value="{{ old('name') }}">
                </div>

                <div class="form-group" id="preco-container">
                    <label for="price">Preço</label>
                    <input type="number" name="price" id="price" placeholder="Quanto custa? *" min="50" value="{{ old('price') }}">
                </div>

                <div class="form-group" id="frete-container">
                    <label for="shipping">Frete</label>
                    <input type="number" name="shipping" id="shippng" placeholder="Valor do frete *" min="50" value="{{ old('shipping') }}">
                </div>

                <div class="form-group" id="categoria-container">
                    <label for="category">Categoria</label>
                    <select name="categoria_id" id="category" value="{{ old('categoria_id') }}">
                        <option value="" selected>Selecione uma categoria</option>
                        @forelse ($categorias as $categoria)
                            <option value="{{ $categoria->id }}"> {{ $categoria->name }} </option>
                        @empty
                            <option value="" selected>Nenhuma categoria disponivel</option>
                        @endforelse
                    </select>
                </div>
            </div> {{--  Dados do produto --}}

            <h2>Estoque</h2>

            <div id="estoque-data">
                <div class="form-group">
                    <label for="current_quantity" id="quantidade-container">Estoque actual</label>
                    <input type="number" name="current_quantity" id="current_quantity" placeholder="Estoque actual em unidades *" min="0" value="{{ old('current_quantity') }}">
                </div>

                <div class="form-group" id="min-conatiner">
                    <label for="minimum_quantity">Estoque mínimo</label>
                    <input type="number" name="minimum_quantity" id="minimum_quantity" placeholder="Estoque mínimo em unidades *" min="5" value="{{ old('minimum_quantity') }}">
                </div>

                <div class="form-group" id="max-container">
                    <label for="max_quantity">Estoque máximo</label>
                    <input type="number" name="max_quantity" id="max_quantity" placeholder="Estoque máximo em unidades *" max="400" value="{{ old('max_quantity') }}">
                </div>
            </div> {{-- Estoque actual do pruduto --}}
            <div class="form-submit">
                <button type="submit">Atualizar</button>
            </div>
        </form>
    </div>
</section>
@endsection