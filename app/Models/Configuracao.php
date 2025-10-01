<?php

class Configuracao {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Obter todas as configurações
    public function obterConfiguracoes() {
        $this->db->query("SELECT * FROM configuracoes");
        $resultados = $this->db->resultados();
        
        $config = [];
        foreach ($resultados as $item) {
            $config[$item->chave] = $item->valor;
        }
        
        return $config;
    }

    // Obter configuração específica
    public function obterConfiguracao($chave, $padrao = null) {
        $this->db->query("SELECT valor FROM configuracoes WHERE chave = :chave");
        $this->db->bind(':chave', $chave);
        $resultado = $this->db->resultado();
        
        return $resultado ? $resultado->valor : $padrao;
    }

    // Atualizar configuração
    public function atualizarConfiguracao($chave, $valor) {
        // Verificar se existe
        $this->db->query("SELECT id FROM configuracoes WHERE chave = :chave");
        $this->db->bind(':chave', $chave);
        $existe = $this->db->resultado();

        if ($existe) {
            $this->db->query("UPDATE configuracoes SET valor = :valor, atualizado_em = NOW() WHERE chave = :chave");
        } else {
            $this->db->query("INSERT INTO configuracoes (chave, valor, criado_em, atualizado_em) VALUES (:chave, :valor, NOW(), NOW())");
        }

        $this->db->bind(':chave', $chave);
        $this->db->bind(':valor', $valor);
        
        return $this->db->executa();
    }

    // Atualizar múltiplas configurações
    public function atualizarConfiguracoes($configuracoes) {
        $sucesso = true;
        
        foreach ($configuracoes as $chave => $valor) {
            if (!$this->atualizarConfiguracao($chave, $valor)) {
                $sucesso = false;
            }
        }
        
        return $sucesso;
    }

    // Excluir configuração
    public function excluirConfiguracao($chave) {
        $this->db->query("DELETE FROM configuracoes WHERE chave = :chave");
        $this->db->bind(':chave', $chave);
        return $this->db->executa();
    }

    // Criar tabela de configurações
    public function criarTabela() {
        $sql = "CREATE TABLE IF NOT EXISTS configuracoes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            chave VARCHAR(100) NOT NULL UNIQUE,
            valor TEXT,
            descricao TEXT,
            tipo ENUM('texto', 'numero', 'boolean', 'email', 'url') DEFAULT 'texto',
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_chave (chave)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        $this->db->query($sql);
        return $this->db->executa();
    }

    // Inserir configurações padrão
    public function inserirConfiguracoesPadrao() {
        $configuracoes = [
            [
                'chave' => 'nome_site',
                'valor' => 'Saúde na Mão',
                'descricao' => 'Nome do site',
                'tipo' => 'texto'
            ],
            [
                'chave' => 'email_contato',
                'valor' => 'contato@saudenamao.com.br',
                'descricao' => 'E-mail principal de contato',
                'tipo' => 'email'
            ],
            [
                'chave' => 'telefone_contato',
                'valor' => '(11) 3333-4444',
                'descricao' => 'Telefone principal de contato',
                'tipo' => 'texto'
            ],
            [
                'chave' => 'endereco',
                'valor' => 'Rua da Saúde, 123, Centro, São Paulo - SP',
                'descricao' => 'Endereço da organização',
                'tipo' => 'texto'
            ],
            [
                'chave' => 'meta_description',
                'valor' => 'Portal de saúde com informações confiáveis e acessíveis para toda a família',
                'descricao' => 'Descrição meta padrão do site',
                'tipo' => 'texto'
            ],
            [
                'chave' => 'palavras_chave',
                'valor' => 'saúde, medicina, portal, informações médicas, postos saúde',
                'descricao' => 'Palavras-chave padrão do site',
                'tipo' => 'texto'
            ],
            [
                'chave' => 'manutencao',
                'valor' => '0',
                'descricao' => 'Modo manutenção (0=desativado, 1=ativado)',
                'tipo' => 'boolean'
            ],
            [
                'chave' => 'registros_por_pagina',
                'valor' => '20',
                'descricao' => 'Número de registros por página nas listagens',
                'tipo' => 'numero'
            ],
            [
                'chave' => 'backup_automatico',
                'valor' => '1',
                'descricao' => 'Backup automático habilitado',
                'tipo' => 'boolean'
            ],
            [
                'chave' => 'backup_frequencia',
                'valor' => '7',
                'descricao' => 'Frequência de backup em dias',
                'tipo' => 'numero'
            ]
        ];

        foreach ($configuracoes as $config) {
            // Verificar se já existe
            $this->db->query("SELECT id FROM configuracoes WHERE chave = :chave");
            $this->db->bind(':chave', $config['chave']);
            
            if (!$this->db->resultado()) {
                $this->db->query("INSERT INTO configuracoes (chave, valor, descricao, tipo, criado_em, atualizado_em) 
                                VALUES (:chave, :valor, :descricao, :tipo, NOW(), NOW())");
                $this->db->bind(':chave', $config['chave']);
                $this->db->bind(':valor', $config['valor']);
                $this->db->bind(':descricao', $config['descricao']);
                $this->db->bind(':tipo', $config['tipo']);
                $this->db->executa();
            }
        }

        return true;
    }

    // Obter configurações por tipo
    public function obterPorTipo($tipo) {
        $this->db->query("SELECT * FROM configuracoes WHERE tipo = :tipo ORDER BY chave ASC");
        $this->db->bind(':tipo', $tipo);
        return $this->db->resultados();
    }

    // Validar configuração
    public function validarConfiguracao($chave, $valor) {
        // Obter tipo da configuração
        $this->db->query("SELECT tipo FROM configuracoes WHERE chave = :chave");
        $this->db->bind(':chave', $chave);
        $resultado = $this->db->resultado();
        
        if (!$resultado) {
            return false;
        }

        switch ($resultado->tipo) {
            case 'email':
                return filter_var($valor, FILTER_VALIDATE_EMAIL) !== false;
            case 'url':
                return filter_var($valor, FILTER_VALIDATE_URL) !== false;
            case 'numero':
                return is_numeric($valor);
            case 'boolean':
                return in_array($valor, ['0', '1', 'true', 'false']);
            case 'texto':
            default:
                return true;
        }
    }

    // Obter estatísticas das configurações
    public function obterEstatisticas() {
        $stats = [];
        
        // Total de configurações
        $this->db->query("SELECT COUNT(*) as total FROM configuracoes");
        $resultado = $this->db->resultado();
        $stats['total'] = $resultado ? $resultado->total : 0;
        
        // Por tipo
        $this->db->query("SELECT tipo, COUNT(*) as total FROM configuracoes GROUP BY tipo");
        $stats['por_tipo'] = $this->db->resultados();
        
        // Última atualização
        $this->db->query("SELECT MAX(atualizado_em) as ultima_atualizacao FROM configuracoes");
        $resultado = $this->db->resultado();
        $stats['ultima_atualizacao'] = $resultado ? $resultado->ultima_atualizacao : null;
        
        return $stats;
    }
}