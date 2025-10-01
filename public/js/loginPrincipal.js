// Login Principal JavaScript - SaudeNaMao

// Função para alternar entre tipos de usuário
function switchUserType(type) {
    console.log('Alternando para tipo:', type);
    
    // Remove active de todos os botões
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Adiciona active no botão clicado
    const selectedTab = document.querySelector(`[data-type="${type}"]`);
    if (selectedTab) {
        selectedTab.classList.add('active');
        console.log('Aba ativada:', selectedTab);
    }
    
    // Atualiza o valor do input hidden
    document.getElementById('tipoUsuario').value = type;
    
    // Atualiza o gradiente do botão de submit baseado no tipo
    const submitBtn = document.querySelector('.login-submit-btn');
    if (submitBtn) {
        if (type === 'admin') {
            submitBtn.style.background = 'linear-gradient(135deg, #27ae60, #229954)';
        } else {
            submitBtn.style.background = 'linear-gradient(135deg, #3498db, #2980b9)';
        }
    }
}

// Função para seleção de tipo (compatibilidade com onclick)
function selecionarTipo(tipo) {
    // Remove active de todos os botões
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Adiciona active no botão clicado
    const selectedTab = document.querySelector(`[data-type="${tipo}"]`);
    if (selectedTab) {
        selectedTab.classList.add('active');
    }
    
    // Atualiza o input hidden
    const tipoUsuarioInput = document.getElementById('tipoUsuario');
    if (tipoUsuarioInput) {
        tipoUsuarioInput.value = tipo;
    }
    
    // Atualiza visual e campos baseado no tipo
    const submitBtn = document.querySelector('.login-submit-btn');
    const emailInput = document.querySelector('input[name="email"]');
    const senhaInput = document.querySelector('input[name="senha"]');
    
    if (submitBtn) {
        if (tipo === 'admin') {
            // Estilo admin: verde
            submitBtn.style.background = 'linear-gradient(135deg, #27ae60, #229954)';
            submitBtn.style.boxShadow = '0 8px 25px rgba(39, 174, 96, 0.4)';
            
            // Preencher credenciais automaticamente
            if (emailInput) emailInput.value = 'admin@saudenamao.com';
            if (senhaInput) senhaInput.value = 'admin123';
        } else {
            // Estilo paciente: azul
            submitBtn.style.background = 'linear-gradient(135deg, #3498db, #2980b9)';
            submitBtn.style.boxShadow = '0 8px 25px rgba(52, 152, 219, 0.4)';
            
            // Limpar campos
            if (emailInput) emailInput.value = '';
            if (senhaInput) senhaInput.value = '';
        }
    }
}

// Função para mostrar/ocultar senha
function togglePassword(element) {
    const passwordInput = element.parentElement.querySelector('input[type="password"], input[type="text"]');
    const icon = element.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Event listeners quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    // Adiciona event listeners aos botões de tab
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            switchUserType(type);
        });
    });
    
    // Inicializa o tipo padrão como paciente
    switchUserType('paciente');
});
