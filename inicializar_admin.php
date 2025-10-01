<?php
// Script de inicialização das tabelas do sistema administrativo

require_once 'app/configuracao.php';
require_once 'app/Libraries/Database.php';

echo "Iniciando criação das tabelas...\n";

try {
    // Primeiro conectar sem especificar banco para criar se necessário
    echo "Conectando ao MySQL...\n";
    $conexao_temp = new PDO(
        "mysql:host=" . DB_HOST . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    // Verificar se o banco existe, se não, criar
    echo "Verificando se o banco '" . DB_NAME . "' existe...\n";
    $stmt = $conexao_temp->query("SHOW DATABASES LIKE '" . DB_NAME . "'");
    if ($stmt->rowCount() == 0) {
        echo "Criando banco de dados '" . DB_NAME . "'...\n";
        $conexao_temp->exec("CREATE DATABASE `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "✓ Banco criado com sucesso!\n";
    } else {
        echo "✓ Banco já existe!\n";
    }
    
    // Agora conectar ao banco específico
    $conexao = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    // Criar tabela de conteúdos
    echo "Criando tabela 'conteudos'...\n";
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
    echo "✓ Tabela 'conteudos' criada com sucesso!\n";
    
    // Criar tabela de unidades de saúde
    echo "Criando tabela 'unidades_saude'...\n";
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
    echo "✓ Tabela 'unidades_saude' criada com sucesso!\n";
    
    // Criar tabela de configurações
    echo "Criando tabela 'configuracoes'...\n";
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
    echo "✓ Tabela 'configuracoes' criada com sucesso!\n";
    
    // Inserir dados iniciais
    echo "\nInserindo dados iniciais...\n";
    
    // Configurações padrão
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
    
    echo "✓ Configurações padrão inseridas!\n";
    
    // Conteúdos padrão das páginas
    $conteudos = [
        [
            'home',
            'Bem-vindo ao Saúde na Mão',
            '<h1>Saúde na Mão</h1><p>Informações de saúde acessíveis e confiáveis para toda a família.</p><p>Nosso portal oferece informações médicas de qualidade, localização de unidades de saúde e orientações para emergências.</p>',
            'Portal de saúde com informações confiáveis e acessíveis',
            'saúde, medicina, portal, informações médicas'
        ],
        [
            'sobre',
            'Sobre o Saúde na Mão',
            '<h1>Sobre Nós</h1><p>O Saúde na Mão é um portal dedicado a fornecer informações de saúde de qualidade para a população.</p><p>Nossa missão é democratizar o acesso à informação médica confiável.</p>',
            'Conheça a missão e história do portal Saúde na Mão',
            'sobre, missão, portal saúde, equipe médica'
        ],
        [
            'saude',
            'Informações de Saúde',
            '<h1>Informações de Saúde</h1><p>Encontre informações confiáveis sobre doenças, tratamentos e prevenção.</p>',
            'Informações médicas confiáveis sobre doenças e tratamentos',
            'doenças, tratamentos, prevenção, medicina'
        ],
        [
            'postos',
            'Postos de Saúde',
            '<h1>Postos de Saúde</h1><p>Encontre unidades de saúde próximas a você.</p>',
            'Localize postos de saúde, hospitais e clínicas na sua região',
            'postos saúde, hospitais, clínicas, unidades básicas'
        ],
        [
            'emergencia',
            'Emergências Médicas',
            '<h1>Emergências</h1><p>Informações importantes sobre como agir em emergências médicas.</p>',
            'Orientações para emergências médicas e primeiros socorros',
            'emergência, primeiros socorros, urgência médica'
        ]
    ];
    
    $stmt_conteudo = $conexao->prepare("INSERT IGNORE INTO conteudos (pagina, titulo, conteudo, meta_description, palavras_chave, ativo) VALUES (?, ?, ?, ?, ?, 1)");
    
    foreach ($conteudos as $conteudo) {
        $stmt_conteudo->execute($conteudo);
    }
    
    echo "✓ Conteúdos padrão das páginas inseridos!\n";
    
    // Unidades de saúde exemplo
    $unidades = [
        [
            'UBS Centro',
            'Rua Principal, 123, Centro',
            'Centro',
            '(11) 3333-1111',
            'ubscentro@saude.gov.br',
            'Segunda a Sexta: 7h às 17h',
            'Clínica Geral, Pediatria, Ginecologia',
            -23.550520,
            -46.633308
        ],
        [
            'Hospital Municipal',
            'Av. Saúde, 456, Jardim das Flores',
            'Jardim das Flores',
            '(11) 3333-2222',
            'hospital@saude.gov.br',
            '24 horas',
            'Emergência, Clínica Geral, Cardiologia, Neurologia',
            -23.560520,
            -46.643308
        ],
        [
            'Clínica da Família Vila Nova',
            'Rua das Palmeiras, 789, Vila Nova',
            'Vila Nova',
            '(11) 3333-3333',
            'cfvilanova@saude.gov.br',
            'Segunda a Sábado: 6h às 22h',
            'Clínica Geral, Pediatria, Enfermagem',
            -23.540520,
            -46.623308
        ]
    ];
    
    $stmt_unidade = $conexao->prepare("INSERT IGNORE INTO unidades_saude (nome, endereco, bairro, telefone, email, horario_funcionamento, especialidades, latitude, longitude, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
    
    foreach ($unidades as $unidade) {
        $stmt_unidade->execute($unidade);
    }
    
    echo "✓ Unidades de saúde exemplo inseridas!\n";
    
    echo "\n🎉 Inicialização concluída com sucesso!\n";
    echo "Todas as tabelas foram criadas e os dados iniciais inseridos.\n";
    echo "O sistema administrativo está pronto para uso.\n";
    
} catch (Exception $e) {
    echo "❌ Erro durante a inicialização: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
?>