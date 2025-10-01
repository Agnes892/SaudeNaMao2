<?php

class Conteudo {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Buscar conteúdo de uma página específica
    public function buscarPorPagina($pagina) {
        $this->db->query("SELECT * FROM conteudos WHERE pagina = :pagina");
        $this->db->bind(':pagina', $pagina);
        
        $resultado = $this->db->resultado();
        return $resultado ? $resultado : $this->criarPaginaPadrao($pagina);
    }

    // Listar todas as páginas
    public function listarTodas() {
        $this->db->query("SELECT * FROM conteudos ORDER BY pagina ASC");
        return $this->db->resultados();
    }

    // Atualizar conteúdo de uma página
    public function atualizarPagina($dados) {
        // Verificar se a página já existe
        $this->db->query("SELECT id FROM conteudos WHERE pagina = :pagina");
        $this->db->bind(':pagina', $dados['pagina']);
        $existe = $this->db->resultado();

        if ($existe) {
            // Atualizar página existente
            $this->db->query("UPDATE conteudos SET 
                titulo = :titulo, 
                conteudo = :conteudo, 
                meta_description = :meta_description, 
                palavras_chave = :palavras_chave,
                ativo = :ativo,
                atualizado_em = NOW()
                WHERE pagina = :pagina");
        } else {
            // Criar nova página
            $this->db->query("INSERT INTO conteudos (
                pagina, titulo, conteudo, meta_description, 
                palavras_chave, ativo, criado_em, atualizado_em
            ) VALUES (
                :pagina, :titulo, :conteudo, :meta_description, 
                :palavras_chave, :ativo, NOW(), NOW()
            )");
        }

        $this->db->bind(':pagina', $dados['pagina']);
        $this->db->bind(':titulo', $dados['titulo']);
        $this->db->bind(':conteudo', $dados['conteudo']);
        $this->db->bind(':meta_description', $dados['meta_description']);
        $this->db->bind(':palavras_chave', $dados['palavras_chave']);
        $this->db->bind(':ativo', $dados['ativo']);

        return $this->db->executa();
    }

    // Criar página padrão caso não exista
    private function criarPaginaPadrao($pagina) {
        $conteudos_padrao = [
            'home' => [
                'titulo' => 'Bem-vindo ao Saúde na Mão',
                'conteudo' => '<h1>Saúde na Mão</h1><p>Informações de saúde acessíveis e confiáveis para toda a família.</p>',
                'meta_description' => 'Portal de saúde com informações confiáveis e acessíveis',
                'palavras_chave' => 'saúde, medicina, portal, informações médicas'
            ],
            'sobre' => [
                'titulo' => 'Sobre o Saúde na Mão',
                'conteudo' => '<h1>Sobre Nós</h1><p>O Saúde na Mão é um portal dedicado a fornecer informações de saúde de qualidade.</p>',
                'meta_description' => 'Conheça a missão e história do portal Saúde na Mão',
                'palavras_chave' => 'sobre, missão, portal saúde, equipe médica'
            ],
            'saude' => [
                'titulo' => 'Informações de Saúde',
                'conteudo' => '<h1>Informações de Saúde</h1><p>Encontre informações confiáveis sobre doenças, tratamentos e prevenção.</p>',
                'meta_description' => 'Informações médicas confiáveis sobre doenças e tratamentos',
                'palavras_chave' => 'doenças, tratamentos, prevenção, medicina'
            ],
            'postos' => [
                'titulo' => 'Postos de Saúde',
                'conteudo' => '<h1>Postos de Saúde</h1><p>Encontre unidades de saúde próximas a você.</p>',
                'meta_description' => 'Localize postos de saúde, hospitais e clínicas na sua região',
                'palavras_chave' => 'postos saúde, hospitais, clínicas, unidades básicas'
            ],
            'emergencia' => [
                'titulo' => 'Emergências Médicas',
                'conteudo' => '<h1>Emergências</h1><p>Informações importantes sobre como agir em emergências médicas.</p>',
                'meta_description' => 'Orientações para emergências médicas e primeiros socorros',
                'palavras_chave' => 'emergência, primeiros socorros, urgência médica'
            ]
        ];

        if (isset($conteudos_padrao[$pagina])) {
            $padrao = $conteudos_padrao[$pagina];
            $padrao['pagina'] = $pagina;
            $padrao['ativo'] = 1;
            return (object) $padrao;
        }

        // Página não encontrada, criar vazia
        return (object) [
            'pagina' => $pagina,
            'titulo' => ucfirst($pagina),
            'conteudo' => '<h1>' . ucfirst($pagina) . '</h1><p>Conteúdo da página.</p>',
            'meta_description' => '',
            'palavras_chave' => '',
            'ativo' => 1
        ];
    }

    // Excluir página
    public function excluirPagina($pagina) {
        $this->db->query("DELETE FROM conteudos WHERE pagina = :pagina");
        $this->db->bind(':pagina', $pagina);
        return $this->db->executa();
    }

    // Buscar páginas ativas
    public function buscarPaginasAtivas() {
        $this->db->query("SELECT * FROM conteudos WHERE ativo = 1 ORDER BY pagina ASC");
        return $this->db->resultados();
    }

    // Contar total de páginas
    public function contarTotal() {
        $this->db->query("SELECT COUNT(*) as total FROM conteudos");
        $resultado = $this->db->resultado();
        return $resultado ? $resultado->total : 0;
    }

    // Buscar páginas por termo
    public function buscarPorTermo($termo) {
        $this->db->query("SELECT * FROM conteudos 
                         WHERE titulo LIKE :termo 
                         OR conteudo LIKE :termo 
                         OR palavras_chave LIKE :termo
                         ORDER BY pagina ASC");
        $this->db->bind(':termo', '%' . $termo . '%');
        return $this->db->resultados();
    }

    // Criar estrutura da tabela se não existir
    public function criarTabela() {
        $sql = "CREATE TABLE IF NOT EXISTS conteudos (
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

        $this->db->query($sql);
        return $this->db->executa();
    }

    // Inserir conteúdos padrão
    public function inserirConteudosPadrao() {
        $paginas = ['home', 'sobre', 'saude', 'postos', 'emergencia'];
        
        foreach ($paginas as $pagina) {
            // Verificar se já existe
            $this->db->query("SELECT id FROM conteudos WHERE pagina = :pagina");
            $this->db->bind(':pagina', $pagina);
            
            if (!$this->db->resultado()) {
                // Criar conteúdo padrão
                $dados = $this->criarPaginaPadrao($pagina);
                $this->atualizarPagina((array) $dados);
            }
        }
        
        return true;
    }
}