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
                <p>Lorem ipsum dolor sit amet consectetur.</p>
            </div>
            
            {{-- Cabeçalho direita --}}
            <div class="header-right">
                <div class="table-controller">
                    {{-- Select de Periodos de Vendas --}}
                    <div class="select-periodo-dashboard">
                        <select name="" id="">
                            <option value="" selected>Selecione o Periódo</option>
                            <option value="hoje">Hoje</option>
                            <option value="semana">Última Semana</option>
                            <option value="ultimo_mes">Último Mês</option>
                            <option value="ultimo_mes">Último Trimestre</option>
                            <option value="ultimo_ano">Último Ano</option>
                        </select>
                    </div>
            
                    {{-- Ações de gerar Relatórios  --}}
                    <form action="" method="post">
                        <button id="btn-generate-relatorios" type="submit">
                            Atualizar
                        </button>
                    </form>
            
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
                <h3>10</h3>

                <p>Lorem ipsum</p>
            </div> {{-- Fim do Card de Relatório --}}
            
            {{-- Card de Relatório --}}
            <div class="metrica-card">
                <h3>10</h3>

                <p>Lorem ipsum</p>
            </div> {{-- Fim do Card de Relatório --}}
            
            {{-- Card de Relatório --}}
            <div class="metrica-card">
                <h3>10</h3>

                <p>Lorem ipsum</p>
            </div> {{-- Fim do Card de Relatório --}}

            {{-- Card de Relatório --}}
            <div class="metrica-card">
                <h3>10</h3>

                <p>Lorem ipsum</p>
            </div> {{-- Fim do Card de Relatório --}}
        </div>

        {{-- Resumo de Vendas Por Periodo  --}}
        <div id="grafico-dashboard">
            <h2>Produtos Mais Vendidos</h2>

            <div id="resumo-container">
                {{-- Lista de Produtos Mais Vendidos Por Época --}}
                <div id="produto-vendido-item">
                    {{-- Card de Produto Vendido em Detereminado periodo --}}
                    <div class="produto-info">
                        <h3>1</h3>

                        <div class="info">
                            <strong>Cuca</strong>
                            <small>14 Quantidade</small>
                        </div>
                    </div> {{-- Fim Card --}}

                    {{-- Card de Produto Vendido em Detereminado periodo --}}
                    <div class="produto-info">
                        <h3>1</h3>

                        <div class="info">
                            <strong>Cuca</strong>
                            <small>14 Quantidade</small>
                        </div>
                    </div> {{-- Fim Card --}}

                    {{-- Card de Produto Vendido em Detereminado periodo --}}
                    <div class="produto-info">
                        <h3>1</h3>

                        <div class="info">
                            <strong>Cuca</strong>
                            <small>14 Quantidade</small>
                        </div>
                    </div> {{-- Fim Card --}}

                    {{-- Card de Produto Vendido em Detereminado periodo --}}
                    <div class="produto-info">
                        <h3>1</h3>

                        <div class="info">
                            <strong>Cuca</strong>
                            <small>14 Quantidade</small>
                        </div>
                    </div> {{-- Fim Card --}}
                </div>

                {{-- Vendas Por Categorias --}}
                <div id="vendas-por-categoria-container">
                    <h3>{{-- icone --}} Vendas Por Categoria</h3>

                    {{-- Container Venda --}}
                    <div class="lista-categorias-vendas">
                        {{-- Card de Produto Vendido Por Categoria --}}
                        <div class="categoria-venda-item">
                            <div class="categoria-info">
                                <strong>Cerveja</strong>
                                <small>KZ 350.00</small>
                            </div>

                            <div class="categoria-porcentagem">
                                <span>23%</span>
                            </div>
                        </div> {{-- Fim Card --}}

                        {{-- Card de Produto Vendido Por Categoria --}}
                        <div class="categoria-venda-item">
                            <div class="categoria-info">
                                <strong>Cerveja</strong>
                                <small>KZ 350.00</small>
                            </div>

                            <div class="categoria-porcentagem">
                                <span>23%</span>
                            </div>
                        </div> {{-- Fim Card --}}
                        
                        {{-- Card de Produto Vendido Por Categoria --}}
                        <div class="categoria-venda-item">
                            <div class="categoria-info">
                                <strong>Cerveja</strong>
                                <small>KZ 350.00</small>
                            </div>

                            <div class="categoria-porcentagem">
                                <span>23%</span>
                            </div>
                        </div> {{-- Fim Card --}}
                        
                        {{-- Card de Produto Vendido Por Categoria --}}
                        <div class="categoria-venda-item">
                            <div class="categoria-info">
                                <strong>Cerveja</strong>
                                <small>KZ 350.00</small>
                            </div>

                            <div class="categoria-porcentagem">
                                <span>23%</span>
                            </div>
                        </div> {{-- Fim Card --}}

                        {{-- Card de Produto Vendido Por Categoria --}}
                        <div class="categoria-venda-item">
                            <div class="categoria-info">
                                <strong>Cerveja</strong>
                                <small>KZ 350.00</small>
                            </div>

                            <div class="categoria-porcentagem">
                                <span>23%</span>
                            </div>
                        </div> {{-- Fim Card --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabela de Vendas Por Categoria --}}
        <div id="tabela-conatainer-c">
            <h3>{{-- ICONE --}} Histórico Por Vendas</h3>
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
        </div>
    </section>
@endsection