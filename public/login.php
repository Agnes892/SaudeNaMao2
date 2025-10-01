<?php
// Configurações do sistema
require_once '../app/configuracao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= APP_NOME ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?=URL?>/public/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=URL?>/public/img/logo.png">
    
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS da página de login -->
    <link rel="stylesheet" href="<?= URL ?>/public/css/loginPrincipal.css">
    
    <script>
        // Função para alternar entre tipos de usuário
        function switchUserType(type) {
            // Remove active de todos os botões
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Adiciona active no botão clicado
            document.querySelector(`[data-type="${type}"]`).classList.add('active');
            
            // Atualiza o valor do input hidden
            document.getElementById('tipoUsuario').value = type;
            
            // Atualiza o gradiente do botão de submit baseado no tipo
            const submitBtn = document.querySelector('.login-submit-btn');
            if (type === 'admin') {
                submitBtn.style.background = 'linear-gradient(135deg, #27ae60, #229954)';
            } else {
                submitBtn.style.background = 'linear-gradient(135deg, #3498db, #2980b9)';
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
        });
    </script>
</head>
<body>
    <div class="container">
        <!-- Ícone do Logo -->
        <div class="logo-icon">
            <i class="fas fa-heart"></i>
        </div>
        
        <!-- Título Principal -->
        <h1 class="title">Saúde na Mão</h1>
        
        <!-- Subtítulo -->
        <p class="subtitle">Informações de saúde acessíveis e confiáveis</p>
        
        <!-- Seleção de Tipo de Usuário -->
        <div class="user-type-selection">
            <div class="tabs">
                <button class="tab-btn active" data-type="paciente">
                    <i class="fas fa-user"></i>
                    Paciente
                </button>
                <button class="tab-btn" data-type="admin">
                    <i class="fas fa-shield-alt"></i>
                    Administrador
                </button>
            </div>
        </div>

        <!-- Formulário de Login -->
        <form id="loginForm" method="POST" action="<?= URL ?>/usuarios/login" class="login-form">
            <input type="hidden" id="tipoUsuario" name="tipo" value="paciente">
            
            <div class="input-group">
                <div class="input-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <input type="email" name="email" placeholder="Seu e-mail" required>
            </div>
            
            <div class="input-group">
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <input type="password" name="senha" placeholder="Sua senha" required>
                <div class="password-toggle" onclick="togglePassword(this)">
                    <i class="fas fa-eye"></i>
                </div>
            </div>
            
            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="lembrar">
                    <span class="checkmark"></span>
                    Lembrar-me
                </label>
                <a href="<?= URL ?>/usuarios/recuperar-senha" class="forgot-password">
                    Esqueceu a senha?
                </a>
            </div>
            
            <button type="submit" class="login-submit-btn">
                <i class="fas fa-sign-in-alt"></i>
                Entrar
            </button>
            
            <div class="register-link">
                <p>Não tem uma conta? 
                    <a href="<?= URL ?>/usuarios/cadastrar">Cadastre-se aqui</a>
                </p>
            </div>
        </form>
        
        <!-- Rodapé -->
        <div class="footer">
            <strong>Desenvolvido pela Prefeitura de Guajará-Mirim</strong>
            Versão 1.0.0
        </div>
    </div>
</body>
</html>