function comprimentar(nome) {
    let hora = new Date().getHours() // hora actual (0–23)
    let nomeHora = document.getElementById('nome-hora')

    // Saudação da manhã
    if (hora >= 0 && hora < 12) {   
        nomeHora.innerText = `Bom dia, ${nome}`   
    }

    // Saudação da tarde
    if (hora >= 12 && hora < 18 ) {
        nomeHora.innerText = `Boa tarde, ${nome}` 
    }

    // Saudação da noite
    if (hora >= 18 && hora <= 23) {
        nomeHora.innerText = `Boa noite, ${nome}`
    }
}
/* 
function previewImagem(event) {
    const img = document.getElementById('preview');
    
    img.src = URL.createObjectURL(event.target.files[0]);
} */

    // ============================================================
    // CONFIGURAÇÃO DO PDF.JS
    // Define o caminho do worker que processa PDFs em background
    // ============================================================
    const pdfjsLib = window['pdfjs-dist/build/pdf'];
    pdfjsLib.GlobalWorkerOptions.workerSrc =
    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js'; 

    // ============================================================
    // ESTADO GLOBAL
    // Guarda referências importantes para a aplicação
    // ============================================================
    let fatura_para_apagar = null;  // ID da fatura que será excluída (usado no modal de confirmação)
    let modalPdfBlob       = null;  // Blob do PDF atualmente aberto no modal

    // ============================================================
    // ALTERNAR MODO VERTICAL ↔ GRID
    // Manipula o CSS dos cards existentes para mudar layout
    // ============================================================
    function setMode(mode) {
    const container = document.getElementById('invoices-container');
    const btnV      = document.getElementById('btn-vertical');
    const btnG      = document.getElementById('btn-grid');

    if (mode === 'vertical') {
        // MODO LISTA (vertical)
        container.classList.remove('mode-grid');
        btnV.classList.add('active');
        btnG.classList.remove('active');

        // Para cada card, ajusta o layout para vertical
        container.querySelectorAll('.invoice-card').forEach(card => {
        card.style.flexDirection = '';
        card.style.padding       = '16px 18px';
        card.style.cursor        = 'pointer';

        // Mostra elementos do modo vertical
        const iconSmall = card.querySelector('.pdf-icon-small');
        const info      = card.querySelector('.info');
        const amountV   = card.querySelector('.amount-vertical');
        const deleteV   = card.querySelector('.btn-delete-vertical');
        
        if (iconSmall) iconSmall.style.display = 'flex';
        if (info)      info.style.display      = 'flex';
        if (amountV)   amountV.style.display   = 'block';
        if (deleteV)   deleteV.style.display   = 'flex';

        // Esconde elementos do modo grid
        const preview  = card.querySelector('.pdf-preview-wrap');
        const cardBody = card.querySelector('.card-body');
        
        if (preview)  preview.style.display  = 'none';
        if (cardBody) cardBody.style.display = 'none';
        });

    } else {
        // MODO GRID
        container.classList.add('mode-grid');
        btnV.classList.remove('active');
        btnG.classList.add('active');

        // Para cada card, ajusta o layout para grid
        container.querySelectorAll('.invoice-card').forEach(card => {
        card.style.flexDirection = 'column';
        card.style.padding       = '0';
        card.style.cursor        = 'default';

        // Esconde elementos do modo vertical
        const iconSmall = card.querySelector('.pdf-icon-small');
        const info      = card.querySelector('.info');
        const amountV   = card.querySelector('.amount-vertical');
        const deleteV   = card.querySelector('.btn-delete-vertical');
        
        if (iconSmall) iconSmall.style.display = 'none';
        if (info)      info.style.display      = 'none';
        if (amountV)   amountV.style.display   = 'none';
        if (deleteV)   deleteV.style.display   = 'none';

        // Mostra elementos do modo grid
        const preview  = card.querySelector('.pdf-preview-wrap');
        const cardBody = card.querySelector('.card-body');
        
        if (preview)  preview.style.display  = 'block';
        if (cardBody) cardBody.style.display = 'flex';
        });
    }
    }

    // ============================================================
    // FILTRAR FATURAS
    // Filtra cards existentes baseado na busca do usuário
    // ============================================================
    function filtrarFaturas() {
    const query = document.getElementById('search-invoice').value.toLowerCase().trim();
    const cards = document.querySelectorAll('.invoice-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const numero  = card.getAttribute('data-numero') || '';
        const cliente = card.getAttribute('data-cliente') || '';

        // Verifica se o card corresponde à busca
        const matches = numero.toLowerCase().includes(query) || 
                        cliente.toLowerCase().includes(query);

        if (query === '' || matches) {
        card.classList.remove('hidden');
        visibleCount++;
        } else {
        card.classList.add('hidden');
        }
    });

    // Mostra/esconde mensagem de estado vazio
    const emptyState = document.getElementById('empty-state');
    if (visibleCount === 0) {
        emptyState.style.display = 'block';
    } else {
        emptyState.style.display = 'none';
    }

    // Atualiza resumo com base nos cards visíveis
    atualizarResumo();
    }

    // ============================================================
    // ATUALIZAR CARDS DE RESUMO
    // Calcula estatísticas baseadas nos cards visíveis
    // ============================================================
    function atualizarResumo() {
    const cards = document.querySelectorAll('.invoice-card:not(.hidden)');
    
    // Total de faturas visíveis
    const total = cards.length;
    document.getElementById('total-faturas').textContent = total;

    // Soma dos valores
    let valorTotal = 0;
    let maisRecenteData = null;
    let maisRecenteNumero = '—';

    cards.forEach(card => {
        // Soma valor
        const valor = parseFloat(card.getAttribute('data-valor')) || 0;
        valorTotal += valor;

        // Encontra fatura mais recente
        const dataStr = card.getAttribute('data-data');
        if (dataStr) {
        const data = new Date(dataStr);
        if (!maisRecenteData || data > maisRecenteData) {
            maisRecenteData = data;
            maisRecenteNumero = card.getAttribute('data-numero');
        }
        }
    });

    // Atualiza valores no DOM
    document.getElementById('valor-total').textContent = 
        valorTotal.toLocaleString('pt-PT', {minimumFractionDigits:2, maximumFractionDigits:2}) + 'Kz';
    
    document.getElementById('fatura-recente').textContent = maisRecenteNumero;
    }

    // ============================================================
    // ABRIR MODAL DE VISUALIZAÇÃO
    // Abre o modal mostrando o preview do PDF
    // Busca o blob do PDF se foi importado dinamicamente
    // NOTA: Para integração com backend, você precisará:
    // 1. Ter o caminho do PDF no servidor (ex: data-pdf-url="/pdfs/fatura-123.pdf")
    // 2. Fazer fetch do PDF e criar um Blob para renderizar
    // ============================================================
    function abrirModal(id) {
    // Encontra o card correspondente
    const card = document.querySelector(`.invoice-card[data-id="${id}"]`);
    if (!card) return;

    // Pega o número da fatura para exibir no título
    const numero = card.getAttribute('data-numero') || 'Fatura';
    document.getElementById('modal-title').textContent = numero;

    // Verifica se o card tem um blob armazenado (faturas importadas)
    if (card._pdfBlob) {
        modalPdfBlob = card._pdfBlob;
        renderPdfModal(card._pdfBlob);
    } else {
        // IMPORTANTE: Em produção com backend, você faria algo como:
        // const pdfUrl = card.getAttribute('data-pdf-url');
        // fetch(pdfUrl).then(r => r.blob()).then(blob => {
        //   modalPdfBlob = blob;
        //   renderPdfModal(blob);
        // });

        // Cards estáticos sem PDF: mostra mensagem
        modalPdfBlob = null;
        renderPdfModal(null);
    }

    // Mostra o modal
    document.getElementById('modal-overlay').classList.add('show');
    }

    // ============================================================
    // FECHAR MODAL
    // ============================================================
    function closeModal() {
    document.getElementById('modal-overlay').classList.remove('show');
    modalPdfBlob = null;
    }

    // ============================================================
    // RENDERIZAR PDF NO MODAL
    // Usa pdf.js para desenhar a página 1 do PDF em um canvas
    // ============================================================
    async function renderPdfModal(pdfBlob) {
    const wrap = document.getElementById('modal-canvas-wrap');
    wrap.innerHTML = '';

    if (!pdfBlob) {
        wrap.innerHTML = '<p style="color:#aaa;">Sem prévia disponível.</p>';
        return;
    }

    const canvas = document.createElement('canvas');
    wrap.appendChild(canvas);

    try {
        const arrayBuffer = await pdfBlob.arrayBuffer();
        const pdfDoc      = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
        const page        = await pdfDoc.getPage(1);

        const vp0   = page.getViewport({ scale: 1 });
        const scale = Math.min(580 / vp0.width, 460 / vp0.height);
        const vp    = page.getViewport({ scale });

        canvas.width  = vp.width;
        canvas.height = vp.height;

        await page.render({ canvasContext: canvas.getContext('2d'), viewport: vp }).promise;
        await pdfDoc.destroy();

    } catch (err) {
        wrap.innerHTML = '<p style="color:#aaa;">Erro ao carregar prévia.</p>';
        console.warn(err);
    }
    }

    // ============================================================
    // BAIXAR PDF
    // Cria um link temporário e faz download do blob
    // ============================================================
    document.getElementById('btn-download-modal').addEventListener('click', () => {
    if (!modalPdfBlob) {
        mostrarAviso('Nenhum PDF disponível para download.');
        return;
    }
    
    const url = URL.createObjectURL(modalPdfBlob);
    const a   = document.createElement('a');
    a.href     = url;
    a.download = 'fatura.pdf';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    });

    // ============================================================
    // ABRIR NO NAVEGADOR
    // Abre o PDF em uma nova aba do navegador
    // ============================================================
    document.getElementById('btn-open-browser-modal').addEventListener('click', () => {
    if (!modalPdfBlob) {
        mostrarAviso('Nenhum PDF disponível para abrir.');
        return;
    }
    
    const url = URL.createObjectURL(modalPdfBlob);
    window.open(url, '_blank');
    });

    // ============================================================
    // MODAL DE AVISO (substitui alerts)
    // Mostra uma mensagem elegante ao invés de alert()
    // ============================================================
    function mostrarAviso(mensagem) {
    // Cria o overlay se não existir
    let avisoOverlay = document.getElementById('aviso-overlay');
    
    if (!avisoOverlay) {
        avisoOverlay = document.createElement('div');
        avisoOverlay.id = 'aviso-overlay';
        avisoOverlay.style.cssText = `
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 700;
        align-items: center;
        justify-content: center;
        `;
        
        avisoOverlay.innerHTML = `
        <div style="
            background: #fff;
            border-radius: 14px;
            padding: 30px 28px;
            width: 90%;
            max-width: 360px;
            text-align: center;
            box-shadow: 0 16px 48px rgba(0,0,0,0.22);
            animation: scaleUp 0.2s ease;
        ">
            <div style="font-size: 2.4rem; margin-bottom: 10px;">ℹ️</div>
            <h4 style="font-family: 'Poppins', sans-serif; margin-bottom: 8px; color: #1e293b;">Aviso</h4>
            <p id="aviso-mensagem" style="font-size: 0.88rem; color: #64748b; margin-bottom: 20px;"></p>
            <button onclick="fecharAviso()" style="
            background: #1a6dd4;
            color: #fff;
            border: none;
            padding: 9px 28px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Nunito', sans-serif;
            transition: background 0.2s;
            " onmouseover="this.style.background='#145aaf'" onmouseout="this.style.background='#1a6dd4'">
            OK
            </button>
        </div>
        `;
        
        document.body.appendChild(avisoOverlay);
        
        // Fecha ao clicar no fundo
        avisoOverlay.addEventListener('click', function(e) {
        if (e.target === this) fecharAviso();
        });
    }
    
    // Atualiza mensagem e mostra
    document.getElementById('aviso-mensagem').textContent = mensagem;
    avisoOverlay.style.display = 'flex';
    }

    function fecharAviso() {
    const avisoOverlay = document.getElementById('aviso-overlay');
    if (avisoOverlay) {
        avisoOverlay.style.display = 'none';
    }
    }

    // ============================================================
    // IMPORTAR PDF (adicionar fatura dinamicamente)
    // Quando o usuário seleciona um PDF, cria um novo card
    // ============================================================
    async function importarPDF(event) {
    const file = event.target.files[0];
    if (!file || file.type !== 'application/pdf') return;

    // Gera ID único (timestamp)
    const id = Date.now();
    const numero = `FAT-IMP-${id}`;
    
    // Cria o card dinamicamente
    const container = document.getElementById('invoices-container');
    const card = document.createElement('div');
    card.className = 'invoice-card';
    card.setAttribute('data-id', id);
    card.setAttribute('data-numero', numero);
    card.setAttribute('data-cliente', 'Importado');
    card.setAttribute('data-valor', '0');
    card.setAttribute('data-data', new Date().toISOString().split('T')[0]);
    card.onclick = () => abrirModal(id);

    // Estrutura completa do card (igual aos outros)
    card.innerHTML = `
        <div class="pdf-preview-wrap">
        <div class="no-preview"><div class="pdf-stamp">PDF</div></div>
        <canvas id="canvas-preview-${id}" style="display:none;"></canvas>
        </div>
        <div class="pdf-icon-small">PDF</div>
        <div class="info">
        <div class="invoice-number">${numero}</div>
        <div class="invoice-date">📅 ${new Date().toLocaleDateString('pt-PT')} — Importado</div>
        <span class="relative-msg recent">criada hoje</span>
        </div>
        <div class="card-body" style="display:none;">
        <div class="invoice-number">${numero}</div>
        <div class="invoice-date">📅 ${new Date().toLocaleDateString('pt-PT')} — Importado</div>
        <span class="relative-msg recent">criada hoje</span>
        <div class="card-footer-row">
            <span class="amount">0,00Kz</span>
            <div style="display:flex;gap:6px;align-items:center;">
            <button class="btn-visualizar" onclick="event.stopPropagation(); abrirModal(${id})">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
                </svg>
            </button>
            <button class="btn-delete" onclick="event.stopPropagation(); abrirConfirm(${id})">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            </button>
            </div>
        </div>
        </div>
        <div class="amount amount-vertical">0,00Kz</div>
        <button class="btn-delete btn-delete-vertical" onclick="event.stopPropagation(); abrirConfirm(${id})">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
        </button>
    `;

    // Insere no início da lista (antes do empty-state)
    container.insertBefore(card, container.firstChild);

    // Guarda o blob do PDF no card (via data attribute não funciona com blobs)
    // Por isso usamos uma WeakMap ou simplesmente guardamos no elemento
    card._pdfBlob = file;

    // Renderiza preview do PDF no canvas
    setTimeout(async () => {
        const canvas = document.getElementById(`canvas-preview-${id}`);
        const placeholder = card.querySelector('.no-preview');
        
        try {
        const arrayBuffer = await file.arrayBuffer();
        const pdfDoc = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
        const page = await pdfDoc.getPage(1);
        
        const vp0 = page.getViewport({ scale: 1 });
        const desiredWidth = canvas.offsetWidth || 280;
        const scale = desiredWidth / vp0.width;
        const viewport = page.getViewport({ scale });
        
        canvas.width  = viewport.width;
        canvas.height = viewport.height;
        
        const ctx = canvas.getContext('2d');
        await page.render({ canvasContext: ctx, viewport }).promise;
        await pdfDoc.destroy();
        
        canvas.style.display = 'block';
        if (placeholder) placeholder.style.display = 'none';
        } catch (err) {
        console.warn('Erro ao renderizar preview:', err);
        }
    }, 100);

    // Atualiza resumo
    atualizarResumo();

    // Limpa input
    event.target.value = '';
    }

    // ============================================================
    // MODAL DE CONFIRMAÇÃO – APAGAR
    // ============================================================
    function abrirConfirm(id) {
    fatura_para_apagar = id;
    document.getElementById('confirm-overlay').classList.add('show');
    }

    function closeConfirm() {
    fatura_para_apagar = null;
    document.getElementById('confirm-overlay').classList.remove('show');
    }

    function confirmarExclusao() {
    if (fatura_para_apagar !== null) {
        // Remove o card do DOM
        const card = document.querySelector(`.invoice-card[data-id="${fatura_para_apagar}"]`);
        if (card) card.remove();
        
        // Atualiza resumo
        atualizarResumo();
        
        // Verifica se deve mostrar estado vazio
        const remainingCards = document.querySelectorAll('.invoice-card:not(.hidden)');
        const emptyState = document.getElementById('empty-state');
        if (remainingCards.length === 0) {
        emptyState.style.display = 'block';
        }
    }
    closeConfirm();
    }

    // ============================================================
    // FECHAR MODALS AO CLICAR NO FUNDO
    // ============================================================
    document.getElementById('modal-overlay').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
    });

    document.getElementById('confirm-overlay').addEventListener('click', function(e) {
    if (e.target === this) closeConfirm();
    });

    // ============================================================
    // INICIALIZAÇÃO
    // Quando a página carrega, calcula o resumo inicial
    // ============================================================
    window.addEventListener('DOMContentLoaded', () => {
    atualizarResumo();
    });