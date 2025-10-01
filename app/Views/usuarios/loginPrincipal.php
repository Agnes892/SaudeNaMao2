<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saúde na Mão - Login</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?=URL?>/public/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=URL?>/public/img/logo.png">
    
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS do Login Principal -->
    <link rel="stylesheet" href="<?=URL?>/public/css/loginPrincipal.css">
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
                <button class="tab-btn active" id="btn-paciente" data-type="paciente" onclick="selecionarTipo('paciente')">
                    <i class="fas fa-user"></i>
                    <span>Paciente</span>
                </button>
                <button class="tab-btn" id="btn-admin" data-type="admin" onclick="selecionarTipo('admin')">
                    <i class="fas fa-shield-alt"></i>
                    <span>Administrador</span>
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
            <strong>Desenvolvido pela equipe do Saúde na Mão</strong><br>
            Versão 1.0.0
        </div>
    </div>

    <!-- JavaScript do Login Principal -->
    <script src="<?=URL?>/public/js/loginPrincipal.js"></script>
</body>
</html>
