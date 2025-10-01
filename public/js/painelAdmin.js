// JavaScript para Painel Administrativo - SaudeNaMao

// Funções para as ações do painel
function editarPagina(pagina) {
    // Usar rotas corretas do AdminPanel
    window.location.href = '/SaudeNaMao/adminpanel/editarPagina/' + pagina;
}

function gerenciarUnidades(acao) {
    if (acao === 'adicionar') {
        window.location.href = '/SaudeNaMao/adminpanel/unidades/adicionar';
    } else if (acao === 'listar') {
        window.location.href = '/SaudeNaMao/adminpanel/unidades/listar';
    } else {
        window.location.href = '/SaudeNaMao/adminpanel/unidades';
    }
}

function relatorioUsuarios() {
    window.location.href = '/SaudeNaMao/adminpanel/usuarios/relatorio';
}

function configuracoes(tipo) {
    if (tipo) {
        window.location.href = '/SaudeNaMao/adminpanel/configuracoes/' + tipo;
    } else {
        window.location.href = '/SaudeNaMao/adminpanel/configuracoes';
    }
}

function abrirEditor() {
    window.location.href = '/SaudeNaMao/adminpanel/listarPaginas';
}

function previsualizarSite() {
    // Abre o site principal em nova aba
    window.open('/SaudeNaMao/', '_blank');
}

function gerarBackup() {
    if (confirm('Tem certeza que deseja gerar um backup do sistema?')) {
        window.location.href = '/SaudeNaMao/adminpanel/gerarBackup';
    }
}

function acessarAPI() {
    window.location.href = '/SaudeNaMao/adminpanel/api';
}

// Adicionar animações aos cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.admin-card, .stat-card');
    
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Função para logout com confirmação
function logout() {
    if (confirm('Tem certeza que deseja sair do painel administrativo?')) {
        window.location.href = window.location.origin + window.location.pathname.replace(/\/usuarios\/painelAdmin.*/, '/usuarios/loginPrincipal');
    }
}

// Função para atualizar estatísticas (simulada)
function atualizarEstatisticas() {
    const statNumbers = document.querySelectorAll('.stat-number');
    
    statNumbers.forEach(stat => {
        const originalValue = parseInt(stat.textContent);
        const increment = Math.floor(Math.random() * 5) + 1;
        const newValue = originalValue + increment;
        
        // Animação de contagem
        let current = originalValue;
        const interval = setInterval(() => {
            current++;
            stat.textContent = current;
            if (current >= newValue) {
                clearInterval(interval);
            }
        }, 50);
    });
}

// Função para mostrar notificações
function mostrarNotificacao(mensagem, tipo = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${tipo} position-fixed`;
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    notification.innerHTML = `
        <i class="fas fa-${tipo === 'success' ? 'check' : 'info'}-circle"></i>
        ${mensagem}
        <button type="button" class="btn-close ms-2" onclick="this.parentElement.remove()"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove após 5 segundos
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}
