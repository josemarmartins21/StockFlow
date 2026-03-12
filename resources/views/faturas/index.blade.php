@extends('layouts.app')

@section('title', 'Stock Flow - Faturas')
    
@section('content')
  <!-- Conteúdo principal -->
  <div class="content">

    <!-- Resumo: 3 cards com estatísticas -->
    <div class="summary-cards">
      <div class="summary-card">
        <div class="label">Total de Faturas</div>
        <!-- NOTA: Este valor deve ser atualizado pelo backend ou JS ao carregar -->
        <div class="value" id="total-faturas">6</div>
      </div>
      <div class="summary-card">
        <div class="label">Valor Total das Faturas</div>
        <!-- NOTA: Este valor deve ser calculado pelo backend -->
        <div class="value green" id="valor-total">45.800,00Kz</div>
      </div>
      <div class="summary-card">
        <div class="label">Fatura Mais Recente</div>
        <!-- NOTA: Este valor deve vir do backend -->
        <div class="value" id="fatura-recente" style="font-size:1.1rem; color:var(--blue-primary);">FAT-2026-006</div>
      </div>
    </div>

    <!-- Toolbar: título + controles -->
    <div class="toolbar">
      <h2>Todas as Faturas</h2>
      <div class="toolbar-right">
        <!-- Botão para adicionar uma nova fatura (importar PDF) -->
        <button class="btn-add-fatura" onclick="document.getElementById('input-pdf').click()">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
          Adicionar Fatura
        </button>

        <!-- Toggle modo lista / grid -->
        <div class="view-toggle">
          <button class="active" id="btn-vertical" onclick="setMode('vertical')" title="Modo Lista">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
          </button>
          <button id="btn-grid" onclick="setMode('grid')" title="Modo Grid">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
          </button>
        </div>

        <!-- Busca de faturas -->
        <input type="text" class="search-invoice" id="search-invoice" placeholder="Busque por uma fatura" oninput="filtrarFaturas()" />
      </div>
    </div>

    <!-- Input oculto que recebe o arquivo PDF selecionado pelo usuário -->
    <input type="file" id="input-pdf" accept=".pdf" onchange="importarPDF(event)" />

    <!-- ============================================================
         CARDS ESTÁTICOS DE FATURAS
         Agora os cards são escritos diretamente no HTML.
         
         INTEGRAÇÃO COM BACKEND:
         - Em PHP: use um loop foreach para gerar cada card
         - Em Node/Express: use template engine (EJS, Handlebars)
         - Cada card precisa de:
           * data-id       → ID único da fatura no banco
           * data-numero   → Número da fatura (para busca)
           * data-cliente  → Nome do cliente (para busca)
           * data-valor    → Valor numérico (para cálculos)
           * data-data     → Data em formato ISO (para cálculos)
         
         EXEMPLO PHP:
         <?php foreach($faturas as $fatura): ?>
           <div class="invoice-card" 
                data-id="<?= $fatura['id'] ?>"
                data-numero="<?= $fatura['numero'] ?>"
                data-cliente="<?= $fatura['cliente'] ?>"
                data-valor="<?= $fatura['valor'] ?>"
                data-data="<?= $fatura['data'] ?>"
                onclick="abrirModal(<?= $fatura['id'] ?>)">
             ...conteúdo do card...
           </div>
         <?php endforeach; ?>
         ============================================================ -->
    <div class="invoices-container" id="invoices-container">

      @forelse ($faturas as $fatura)
        <!-- CARD 1: FAT-2026-006 -->
        <div class="invoice-card" 
            data-id="1"
            data-numero="FAT-2026-006"
            data-cliente="Empresa ABC"
            data-valor="12500"
            data-data="2026-01-30"
            onclick="abrirModal(1)">
          
          <!-- Preview PDF (modo grid) -->
          <div class="pdf-preview-wrap">
            <div class="no-preview">
              <div class="pdf-stamp">PDF</div>
            </div>
            <canvas id="canvas-preview-1" style="display:none;"></canvas>
          </div>

          <!-- Ícone PDF (modo vertical) -->
          <div class="pdf-icon-small">PDF</div>

          <!-- Informações (modo vertical) -->
          <div class="info">
            <div class="invoice-number">{{ $fatura->numero }}</div>
            <div class="invoice-date">📅 {{ $fatura->created_at }} — Desconhecido</div>
            <span class="relative-msg recent">criada há {{ $fatura->created_at->diffForHumans() }}</span>
          </div>

          <!-- Corpo inferior (modo grid) -->
          <div class="card-body" style="display:none;">
            <div class="invoice-number">{{ $fatura->numero }}</div>
            <div class="invoice-date">📅 {{ $fatura->created_at->format('d/m/Y') }} — StockFlow</div>
            <span class="relative-msg recent">criada há {{ $fatura->created_at->diffForHumans() }}</span>
            <div class="card-footer-row">
              {{-- <span class="amount">12.500,00Kz</span> --}}
              <div style="display:flex;gap:6px;align-items:center;">
                <a href="{{ Storage::url($fatura->path) }}" target="_blank" class="btn-visualizar" onclick="event.stopPropagation(); abrirModal({{ $fatura->id }})">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                  </svg>
                </a>
                <a href="#" class="btn-delete" onclick="event.stopPropagation(); abrirConfirm({{ $fatura->id }})">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </a>
              </div>
            </div>
          </div>

          <!-- Valor (modo vertical) -->
         {{--  <div class="amount amount-vertical">12.500,00Kz</div> --}}

          <!-- Botão apagar (modo vertical) -->
          <a href="#" class="btn-delete btn-delete-vertical" onclick="event.stopPropagation(); abrirConfirm({{ $fatura->id }})">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
          </a>
        </div>
          
      @empty
        <!-- Mensagem de estado vazio (aparece quando nenhuma fatura é encontrada após filtro) -->
        <div class="empty-state" id="empty-state">
          <div class="empty-icon">📄</div>
          <h3>Sem faturas encontradas</h3>
          <p>Não há faturas correspondentes à sua busca.</p>
        </div>
          
      @endforelse

      


    </div>
  </div>
@endsection