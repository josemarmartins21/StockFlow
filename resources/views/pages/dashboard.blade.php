@extends('layouts.app')
@section('title', 'Dashboard')
@section('message')
    <x-alert/>
@endsection
@section('content')
    <section id="dashboard-container">
        <div id="header-manager">
            {{-- Cabeçalho esquerda --}}
            <div class="header-left">
                <h2>Relatório de Vendas</h2>
                <p>Avalie as suas vendas ao longo do tempo</p>
            </div>
            {{-- Cabeçalho direita --}}
            <div class="header-right">
                <div class="table-controller">
                    {{-- Select de Periodos de Vendas --}}
                    <div class="select-periodo-dashboard">
                        <form action="{{ route('pages.dashboard') }}" method="GET">
                            @csrf

                            {{-- Seletor de Periodos --}}
                            <select name="periodo" id="periodo">
                                <option value="" selected>Selecione o Periódo</option>
                                <option value="hoje">Hoje</option>
                                <option value="ultima_semana">Última Semana</option>
                                <option value="ultimo_mes">Último Mês</option>
                                <option value="ultimo_ano">Último Ano</option>
                            </select>
                            
                            {{-- Botão de Aplicar a Seleção --}}
                            <button id="btn-generate-relatorios" type="submit">
                                Aplicar
                            </button>
                        </form>
                    </div>
                    
                    
                    {{-- Ação de gerar Relatórios  --}}
                    <form action="" method="post">
                        <button id="btn-export-relatorios" type="submit">
                            Exportar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Container de Relátorios Rápidos --}}
        <div class="grid-metrica">
            {{-- Card de Relatório --}}
            <div class="metrica-card">
                <h3>{{ $querys['totalVendasDia']??0 }}</h3>

                <p>Total de Vendas</p>
            </div> {{-- Fim do Card de Relatório --}}
            
            {{-- Card de Relatório --}}
            <div class="metrica-card">
                <h3>{{ $querys['totalVendaProdutoMaisVendido']?->quantidade_vendida }}</h3>

                <p>Produto Mais Vendido <strong>{{ ucwords($querys['totalVendaProdutoMaisVendido']?->nome) }}</strong></p>
            </div> {{-- Fim do Card de Relatório --}}
            
            {{-- Card de Relatório --}}
            <div class="metrica-card">
                <h3>{{ $querys['totalProdutoVendido']??0 }}</h3>

                <p>Total de Produtos Vendidos</p>
            </div> {{-- Fim do Card de Relatório --}}
        </div>

        {{-- Resumo de Vendas Por Periodo  --}}
        <div id="grafico-dashboard">
            <h2>Produtos Mais Vendidos <span style="text-transform: lowercase">no(a)</span> {{ $periodoEscolhido }}</h2>

            <div id="resumo-container">
                {{-- Lista de Produtos Mais Vendidos Por Época --}}
                <div id="produto-vendido-item">
                    
                    @forelse ($querys['produtos_mais_vendidos'] as $produto)
                        {{-- Card de Produto Vendido em Detereminado periodo --}}
                        <div class="produto-info">
                            <h3>{{ $loop->index + 1 }}ª</h3>

                            <div class="info">
                                <strong>{{ $produto->nome }}</strong>
                                <small>{{ $produto->quantidade_vendida }} Quantidade</small>
                            </div>
                        </div> {{-- Fim Card --}}
                        
                    @empty
                        <h2>Nenhum Registro Encontrado</h2>
                    @endforelse
                </div>

                {{-- Vendas Por Categorias --}}
                <div id="vendas-por-categoria-container">
                    <h3>{{-- icone --}} Vendas Por Categoria</h3>

                    {{-- Container Venda --}}
                    <div class="lista-categorias-vendas">
                        @forelse ($querys['categorias_mais_vendidas'] as $categoria)
                            {{-- Card de Produto Vendido Por Categoria --}}
                            <div class="categoria-venda-item">
                                <div class="categoria-info">
                                    <strong>{{ $categoria->nome }}</strong>
                                    @if ($categoria->valor_total > 10000)
                                        <small style="color: green">KZ {{ number_format($categoria->valor_total, 2, ',', '.') }}</small>    

                                    @else
                                        <small style="color: red">KZ {{ number_format($categoria->valor_total, 2, ',', '.') }}</small>
                                    @endif
                                </div>

                                <div class="categoria-porcentagem">
                                    <span> {{ number_format(($categoria->valor_total / $querys['valorTotalVendido']) * 100, 0) }}% </span>
                                </div>
                            </div> {{-- Fim Card --}}
                        @empty
                            
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabela de Vendas Por Categoria --}}
        {{--<div id="tabela-conatainer-c">
            <h3> ICONE Histórico Por Vendas</h3>
            <table>
                <thead>
                    <tr>
                        <th>Periodo</th>
                        <th>Total de Vendas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Janeiro</td>
                        <td>5.000,00KZ</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Valor Total</th>
                        <td>5.000,00KZ</td>
                    </tr>
                </tfoot>
            </table>
        </div>--}} 
    </section>
@endsection