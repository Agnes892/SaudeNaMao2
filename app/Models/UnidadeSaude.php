<?php

class UnidadeSaude {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Listar todas as unidades
    public function listarTodas() {
        $this->db->query("SELECT * FROM unidades_saude ORDER BY nome ASC");
        return $this->db->resultados();
    }

    // Buscar unidade por ID
    public function buscarPorId($id) {
        $this->db->query("SELECT * FROM unidades_saude WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->resultado();
    }

    // Adicionar nova unidade
    public function adicionar($dados) {
        $this->db->query("INSERT INTO unidades_saude (
            nome, endereco, bairro, telefone, email, 
            horario_funcionamento, especialidades, latitude, 
            longitude, ativo, criado_em
        ) VALUES (
            :nome, :endereco, :bairro, :telefone, :email,
            :horario_funcionamento, :especialidades, :latitude,
            :longitude, :ativo, NOW()
        )");

        $this->db->bind(':nome', $dados['nome']);
        $this->db->bind(':endereco', $dados['endereco']);
        $this->db->bind(':bairro', $dados['bairro']);
        $this->db->bind(':telefone', $dados['telefone']);
        $this->db->bind(':email', $dados['email']);
        $this->db->bind(':horario_funcionamento', $dados['horario_funcionamento']);
        $this->db->bind(':especialidades', $dados['especialidades']);
        $this->db->bind(':latitude', $dados['latitude']);
        $this->db->bind(':longitude', $dados['longitude']);
        $this->db->bind(':ativo', $dados['ativo']);

        return $this->db->executa();
    }

    // Atualizar unidade
    public function atualizar($dados) {
        $this->db->query("UPDATE unidades_saude SET
            nome = :nome,
            endereco = :endereco,
            bairro = :bairro,
            telefone = :telefone,
            email = :email,
            horario_funcionamento = :horario_funcionamento,
            especialidades = :especialidades,
            latitude = :latitude,
            longitude = :longitude,
            ativo = :ativo,
            atualizado_em = NOW()
            WHERE id = :id");

        $this->db->bind(':id', $dados['id']);
        $this->db->bind(':nome', $dados['nome']);
        $this->db->bind(':endereco', $dados['endereco']);
        $this->db->bind(':bairro', $dados['bairro']);
        $this->db->bind(':telefone', $dados['telefone']);
        $this->db->bind(':email', $dados['email']);
        $this->db->bind(':horario_funcionamento', $dados['horario_funcionamento']);
        $this->db->bind(':especialidades', $dados['especialidades']);
        $this->db->bind(':latitude', $dados['latitude']);
        $this->db->bind(':longitude', $dados['longitude']);
        $this->db->bind(':ativo', $dados['ativo']);

        return $this->db->executa();
    }

    // Excluir unidade
    public function excluir($id) {
        $this->db->query("DELETE FROM unidades_saude WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->executa();
    }

    // Listar unidades ativas
    public function listarAtivas() {
        $this->db->query("SELECT * FROM unidades_saude WHERE ativo = 1 ORDER BY nome ASC");
        return $this->db->resultados();
    }

    // Buscar por bairro
    public function buscarPorBairro($bairro) {
        $this->db->query("SELECT * FROM unidades_saude 
                         WHERE bairro LIKE :bairro AND ativo = 1 
                         ORDER BY nome ASC");
        $this->db->bind(':bairro', '%' . $bairro . '%');
        return $this->db->resultados();
    }

    // Buscar por especialidade
    public function buscarPorEspecialidade($especialidade) {
        $this->db->query("SELECT * FROM unidades_saude 
                         WHERE especialidades LIKE :especialidade AND ativo = 1 
                         ORDER BY nome ASC");
        $this->db->bind(':especialidade', '%' . $especialidade . '%');
        return $this->db->resultados();
    }

    // Contar total de unidades
    public function contarTotal() {
        $this->db->query("SELECT COUNT(*) as total FROM unidades_saude");
        $resultado = $this->db->resultado();
        return $resultado ? $resultado->total : 0;
    }

    // Contar unidades ativas
    public function contarAtivas() {
        $this->db->query("SELECT COUNT(*) as total FROM unidades_saude WHERE ativo = 1");
        $resultado = $this->db->resultado();
        return $resultado ? $resultado->total : 0;
    }

    // Buscar unidades próximas (por coordenadas)
    public function buscarProximas($latitude, $longitude, $raio = 10) {
        // Fórmula de Haversine para calcular distância
        $this->db->query("SELECT *, 
            (6371 * acos(cos(radians(:lat)) * cos(radians(latitude)) * 
            cos(radians(longitude) - radians(:lng)) + sin(radians(:lat)) * 
            sin(radians(latitude)))) AS distancia
            FROM unidades_saude 
            WHERE ativo = 1
            HAVING distancia < :raio 
            ORDER BY distancia ASC");

        $this->db->bind(':lat', $latitude);
        $this->db->bind(':lng', $longitude);
        $this->db->bind(':raio', $raio);
        
        return $this->db->resultados();
    }

    // Obter estatísticas
    public function obterEstatisticas() {
        $stats = [];
        
        // Total de unidades
        $stats['total'] = $this->contarTotal();
        $stats['ativas'] = $this->contarAtivas();
        $stats['inativas'] = $stats['total'] - $stats['ativas'];
        
        // Por bairro
        $this->db->query("SELECT bairro, COUNT(*) as total 
                         FROM unidades_saude 
                         WHERE ativo = 1 
                         GROUP BY bairro 
                         ORDER BY total DESC 
                         LIMIT 10");
        $stats['por_bairro'] = $this->db->resultados();
        
        // Especialidades mais comuns
        $this->db->query("SELECT especialidades, COUNT(*) as total 
                         FROM unidades_saude 
                         WHERE ativo = 1 AND especialidades != '' 
                         GROUP BY especialidades 
                         ORDER BY total DESC 
                         LIMIT 10");
        $stats['especialidades'] = $this->db->resultados();
        
        return $stats;
    }

    // Criar tabela se não existir
    public function criarTabela() {
        $sql = "CREATE TABLE IF NOT EXISTS unidades_saude (
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

        $this->db->query($sql);
        return $this->db->executa();
    }

    // Inserir dados exemplo
    public function inserirDadosExemplo() {
        $unidades = [
            [
                'nome' => 'UBS Centro',
                'endereco' => 'Rua Principal, 123, Centro',
                'bairro' => 'Centro',
                'telefone' => '(11) 3333-1111',
                'email' => 'ubscentro@saude.gov.br',
                'horario_funcionamento' => 'Segunda a Sexta: 7h às 17h',
                'especialidades' => 'Clínica Geral, Pediatria, Ginecologia',
                'latitude' => -23.550520,
                'longitude' => -46.633308,
                'ativo' => 1
            ],
            [
                'nome' => 'Hospital Municipal',
                'endereco' => 'Av. Saúde, 456, Jardim das Flores',
                'bairro' => 'Jardim das Flores',
                'telefone' => '(11) 3333-2222',
                'email' => 'hospital@saude.gov.br',
                'horario_funcionamento' => '24 horas',
                'especialidades' => 'Emergência, Clínica Geral, Cardiologia, Neurologia',
                'latitude' => -23.560520,
                'longitude' => -46.643308,
                'ativo' => 1
            ],
            [
                'nome' => 'Clínica da Família Vila Nova',
                'endereco' => 'Rua das Palmeiras, 789, Vila Nova',
                'bairro' => 'Vila Nova',
                'telefone' => '(11) 3333-3333',
                'email' => 'cfvilanova@saude.gov.br',
                'horario_funcionamento' => 'Segunda a Sábado: 6h às 22h',
                'especialidades' => 'Clínica Geral, Pediatria, Enfermagem',
                'latitude' => -23.540520,
                'longitude' => -46.623308,
                'ativo' => 1
            ]
        ];

        foreach ($unidades as $unidade) {
            // Verificar se já existe
            $this->db->query("SELECT id FROM unidades_saude WHERE nome = :nome");
            $this->db->bind(':nome', $unidade['nome']);
            
            if (!$this->db->resultado()) {
                $this->adicionar($unidade);
            }
        }

        return true;
    }
}