@extends('layouts.app')
@section('title', config('app.name', 'StockFlow'))

@section('content')
    <x-alert/>
      <section id="vendas-container">
        <h1>Registre as vendas de hoje</h1>
          <div id="form-conatiner">
            <form action="{{ route('vendas.store') }}" method="post">
                @csrf

                <div id="produtos-data">
                    <div class="form-group" id="produto-container">
                        <label for="produto_id">Produto</label>
                        <select name="produto_id" id="produto_id">
                            <option value="" select>Selecione um produto</option>
                            @forelse ($produtos as $produto)
                                <option value="{{ $produto->id }}"> {{ $produto->name }} </option>
                                @empty
                                <option value="" selected>Nenhum produto registrado!</option>
                            @endforelse
                        </select>
                    </div>
          
                    <div class="form-group" id="qtd_vendida-container">
                        <label for="quantity_sold">Quantidade Vendida</label>
                        <input type="number" name="quantity_sold" id="quantity_sold" placeholder="Unidades vendidas" min="0" max="200">
                    </div>
                    <div class="form-group" id="preco-container">
                        <label for="note">Observações (opcional)</label>
                        <textarea name="" id="" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-submit-vendas">
                    <button type="submit">Registrar</button>
                </div>
            </form>
          </div>
      </section>
@endsection