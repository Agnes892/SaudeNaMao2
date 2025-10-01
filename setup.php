<?php
require_once 'app/configuracao.php';
require_once 'app/autoload.php';

// Verificar se as sessões já estão iniciadas
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Se já existe um admin logado, redireciona
if (isset($_SESSION['admin_id'])) {
    header('Location: ' . URL . '/usuarios/painelAdmin');
    exit();
}

$mensagem = '';
$erro = false;

// Processar ações
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    
    switch ($acao) {
        case 'inicializar_sistema':
            try {
                // Inicialização direta no setup
                $conexao_temp = new PDO(
                    "mysql:host=" . DB_HOST . ";charset=utf8mb4",
                    DB_USER,
                    DB_PASS,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
                
                // Verificar se o banco existe, se não, criar
                $stmt = $conexao_temp->query("SHOW DATABASES LIKE '" . DB_NAME . "'");
                if ($stmt->rowCount() == 0) {
                    $conexao_temp->exec("CREATE DATABASE `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                }
                
                // Conectar ao banco específico
                $conexao = new PDO(
                    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                    DB_USER,
                    DB_PASS,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
                
                // Criar tabelas
                $sql_conteudos = "CREATE TABLE IF NOT EXISTS conteudos (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    pagina VARCHAR(50) NOT NULL UNIQUE,
                    titulo VARCHAR(255) NOT NULL,
                    conteudo LONGTEXT NOT NULL,
                    meta_description TEXT,
                    palavras_chave TEXT,
                    ativo TINYINT(1) DEFAULT 1,
                    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    INDEX idx_pagina (pagina),
                    INDEX idx_ativo (ativo)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                
                $conexao->exec($sql_conteudos);
                
                $sql_unidades = "CREATE TABLE IF NOT EXISTS unidades_saude (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nome VARCHAR(255) NOT NULL,
                    endereco TEXT NOT NULL,
                    bairro VARCHAR(100) NOT NULL,
                    telefone VARCHAR(20),
                    email VARCHAR(100),
                    horario_funcionamento TEXT,
                    especialidades TEXT,
                    latitude DECIMAL(10, 8) DEFAULT 0,
                    longitude DECIMAL(11, 8) DEFAULT 0,
                    ativo TINYINT(1) DEFAULT 1,
                    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    INDEX idx_nome (nome),
                    INDEX idx_bairro (bairro),
                    INDEX idx_ativo (ativo),
                    INDEX idx_localizacao (latitude, longitude)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                
                $conexao->exec($sql_unidades);
                
                $sql_configuracoes = "CREATE TABLE IF NOT EXISTS configuracoes (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    chave VARCHAR(100) NOT NULL UNIQUE,
                    valor TEXT,
                    descricao TEXT,
                    tipo ENUM('texto', 'numero', 'boolean', 'email', 'url') DEFAULT 'texto',
                    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    INDEX idx_chave (chave)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                
                $conexao->exec($sql_configuracoes);
                
                // Inserir dados iniciais
                $configuracoes = [
                    ['nome_site', 'Saúde na Mão', 'Nome do site', 'texto'],
                    ['email_contato', 'contato@saudenamao.com.br', 'E-mail principal de contato', 'email'],
                    ['telefone_contato', '(11) 3333-4444', 'Telefone principal de contato', 'texto'],
                    ['endereco', 'Rua da Saúde, 123, Centro, São Paulo - SP', 'Endereço da organização', 'texto'],
                    ['meta_description', 'Portal de saúde com informações confiáveis e acessíveis para toda a família', 'Descrição meta padrão do site', 'texto'],
                    ['palavras_chave', 'saúde, medicina, portal, informações médicas, postos saúde', 'Palavras-chave padrão do site', 'texto']
                ];
                
                $stmt_config = $conexao->prepare("INSERT IGNORE INTO configuracoes (chave, valor, descricao, tipo) VALUES (?, ?, ?, ?)");
                
                foreach ($configuracoes as $config) {
                    $stmt_config->execute($config);
                }
                
                $mensagem = "Sistema inicializado com sucesso! Tabelas criadas e dados iniciais inseridos.";
            } catch (Exception $e) {
                $mensagem = "Erro ao inicializar: " . $e->getMessage();
                $erro = true;
            }
            break;
            
        case 'login_admin':
            // Login temporário como admin
            Auth::loginAsAdmin([
                'id' => 1,
                'nome' => 'Administrador do Sistema',
                'email' => 'admin@saudenamao.com.br'
            ]);
            
            header('Location: ' . URL . '/usuarios/painelAdmin');
            exit();
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup - Saúde na Mão</title>
    <link href="<?= URL ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .setup-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            padding: 3rem;
            margin: 2rem auto;
            max-width: 600px;
        }
        
        .setup-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .setup-header i {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 1rem;
        }
        
        .step-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-left: 4px solid #667eea;
        }
        
        .btn-setup {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-setup:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .alert-custom {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="setup-container">
            <div class="setup-header">
                <i class="fas fa-cogs"></i>
                <h2>Setup do Sistema Administrativo</h2>
                <p class="text-muted">Configure o sistema Saúde na Mão</p>
            </div>
            
            <?php if ($mensagem): ?>
                <div class="alert <?= $erro ? 'alert-danger' : 'alert-success' ?> alert-custom">
                    <i class="fas <?= $erro ? 'fa-exclamation-triangle' : 'fa-check-circle' ?>"></i>
                    <?= $mensagem ?>
                </div>
            <?php endif; ?>
            
            <div class="step-card">
                <h5><i class="fas fa-database text-primary"></i> Passo 1: Inicializar Banco de Dados</h5>
                <p>Cria as tabelas necessárias e insere dados iniciais do sistema.</p>
                <form method="post" style="display: inline;">
                    <input type="hidden" name="acao" value="inicializar_sistema">
                    <button type="submit" class="btn btn-setup">
                        <i class="fas fa-play"></i> Inicializar Sistema
                    </button>
                </form>
            </div>
            
            <div class="step-card">
                <h5><i class="fas fa-user-shield text-primary"></i> Passo 2: Acesso Administrativo</h5>
                <p>Fazer login como administrador para acessar o painel.</p>
                <form method="post" style="display: inline;">
                    <input type="hidden" name="acao" value="login_admin">
                    <button type="submit" class="btn btn-setup">
                        <i class="fas fa-sign-in-alt"></i> Login como Admin
                    </button>
                </form>
            </div>
            
            <hr class="my-4">
            
            <div class="text-center">
                <h6>Links Úteis:</h6>
                <a href="<?= URL ?>/" class="btn btn-outline-primary me-2">
                    <i class="fas fa-home"></i> Site Principal
                </a>
                <a href="<?= URL ?>/usuarios/loginPrincipal" class="btn btn-outline-secondary">
                    <i class="fas fa-sign-in-alt"></i> Login Normal
                </a>
            </div>
            
            <div class="mt-4 p-3 bg-light rounded">
                <h6><i class="fas fa-info-circle text-info"></i> Informações do Sistema:</h6>
                <small>
                    <strong>URL Base:</strong> <?= URL ?><br>
                    <strong>Sessão Admin:</strong> <?= isset($_SESSION['admin_id']) ? 'Ativa' : 'Inativa' ?><br>
                    <strong>PHP Version:</strong> <?= PHP_VERSION ?><br>
                    <strong>Status Sessão:</strong> <?= session_status() === PHP_SESSION_ACTIVE ? 'Ativa' : 'Inativa' ?>
                </small>
            </div>
        </div>
    </div>
    
    <script src="<?= URL ?>/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>