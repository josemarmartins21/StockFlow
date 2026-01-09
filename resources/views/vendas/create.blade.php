@extends('layouts.app')
@section('title', config('app.name', 'StockFlow'))
@section('message')
    <x-alert/>
@endsection
@section('content')
     <div class="tabela">
                <div id="table-extras">
                    <h2>Vendas de {{ date('M') }}.</h2>

                    <div id="pdf-acoes">
                        <a href="{{ route('venda.pdf.download') }}" class="baixar-pdf">Baixar Pdf <i class="fa-solid fa-download"></i></a>
                        <a href="{{ route('venda.pdf.stream') }}" class="ver-pdf">Ver Pdf <i class="fa-solid fa-file-pdf"></i></a>
                    </div>

                    <form action="" method="get">
                        <input type="search" name="busca" id="busca" placeholder="Busque por um venda">
                    </form>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Quantidade</th>
                            <th>Valor Total</th>
                            <th>Data</th>
                            <th>Valor do Estoque</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendas as $venda)
                            <tr>
                                <td> {{ $venda->nome }} </td>
                                <td> {{number_format($venda->quantidade_vendida, 2, ',', '.') }} </td>
                                <td> {{ number_format($venda->quantidade_vendida * $venda->preco, 2, ',', '.') }}Kz </td>  
                                <td> {{ $venda->dia_venda }} </td>
                                <td> {{ number_format($venda->valor_total_do_estoque,2, ',', '.') }}Kz </td> 
                                  <td class="acoes"> 
                                    <a href="{{ route('vendas.show', ['venda' => $venda->venda_id]) }}" class="eye"><i class="fa-solid fa-eye"></i></a>

                                    <a href="#" class="edit"> <i class="fa-solid fa-pen-to-square"></i></a>
                                    
                                    <form action="{{ route('vendas.destroy', ['venda' => $venda->venda_id]) }}" method="POST" class="delete-venda">
                                        @csrf
                                        @method("Delete")
                                        
                                        <input type="hidden" name="produto_id" value="{{ $venda->produto_id }}">
                                        
                                        <button type="submit" class="btn-delete" onclick="return confirm('Tem a certeza que pretende eliminar?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>  
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              
                   {{ $vendas->links() }}

            </div> {{-- Fim da tabela de vendas --}}
      <section id="vendas-container">
        <h1>Registre as vendas de hoje</h1>
          <div id="form-conatiner">
            <form action="{{ route('vendas.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div id="produtos-data">
                    <div class="form-group" id="venda-container">
                        <label for="venda_id">Venda</label>
                        <select name="produto_id" id="venda_id">
                            <option value="" select>Selecione um prouduto</option>
                            @forelse ($produtos as $produto)
                                <option value="{{ $produto->id }}"> {{ $produto->name }} </option>
                                @empty
                                <option value="" selected>Nenhum venda registrado!</option>
                            @endforelse
                        </select>
                    </div>
          
                    <div class="form-group" id="qtd_vendida-container">
                        <label for="quantity_sold">Quntas sobraram?</label>
                        <input type="number" name="quanto_sobrou" id="quantity_sold" placeholder="Unidades vendidas *" min="0" max="200">
                    </div>
                    <div class="form-group" id="preco-container">
                        <label for="image">Imagem dos produtos restante</label>
                        <input type="file" name="image" id="image">
                    </div>
                    <div class="form-group" id="preco-container">
                        <label for="note">Observações (opcional)</label>
                        <textarea name="note" id="" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="form-submit-vendas">
                    <button type="submit">Registrar</button>
                </div>
            </form>
          </div>
      </section> {{-- Fim do formulário de vendas --}}
@endsection