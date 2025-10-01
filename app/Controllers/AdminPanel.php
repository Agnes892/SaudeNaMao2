<?php

class AdminPanel extends Controller {
    
    public function __construct() {
        // Verificar se o usuário está logado como admin
        if (!isset($_SESSION['admin_logado']) || $_SESSION['admin_logado'] !== true) {
            Url::redirecionar('usuarios/loginPrincipal');
        }
    }

    // Método principal do painel
    public function index() {
        $dados = [
            'titulo' => 'Painel Administrativo - Saúde na Mão',
            'admin_email' => $_SESSION['admin_email'] ?? 'admin@saudenamao.com'
        ];
        
        $this->view('usuarios/painelAdmin', $dados);
    }

    // ========== GERENCIAMENTO DE CONTEÚDO ==========
    
    public function editarPagina($pagina = null) {
        if (!$pagina) {
            // Listar páginas disponíveis
            $this->listarPaginas();
            return;
        }

        $conteudoModel = $this->model('Conteudo');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Processar edição
            $dados = [
                'pagina' => $pagina,
                'titulo' => trim($_POST['titulo']),
                'conteudo' => $_POST['conteudo'],
                'meta_description' => trim($_POST['meta_description'] ?? ''),
                'palavras_chave' => trim($_POST['palavras_chave'] ?? ''),
                'ativo' => isset($_POST['ativo']) ? 1 : 0
            ];

            if ($conteudoModel->atualizarPagina($dados)) {
                Sessao::mensagem('conteudo', 'Página atualizada com sucesso!', 'alert alert-success');
                Url::redirecionar('adminpanel/editarPagina/' . $pagina);
            } else {
                Sessao::mensagem('conteudo', 'Erro ao atualizar página!', 'alert alert-danger');
            }
        }

        // Buscar conteúdo atual da página
        $conteudo = $conteudoModel->buscarPorPagina($pagina);
        
        $dados = [
            'titulo' => 'Editar Página - ' . ucfirst($pagina),
            'pagina' => $pagina,
            'conteudo' => $conteudo
        ];

        $this->view('admin/editarPagina', $dados);
    }

    public function listarPaginas() {
        $conteudoModel = $this->model('Conteudo');
        $paginas = $conteudoModel->listarTodas();

        $dados = [
            'titulo' => 'Gerenciar Páginas',
            'paginas' => $paginas
        ];

        $this->view('admin/listarPaginas', $dados);
    }

    // ========== GERENCIAMENTO DE UNIDADES DE SAÚDE ==========
    
    public function unidades($acao = 'listar', $id = null) {
        $unidadeModel = $this->model('UnidadeSaude');

        switch ($acao) {
            case 'listar':
                $this->listarUnidades();
                break;
            case 'adicionar':
                $this->adicionarUnidade();
                break;
            case 'editar':
                $this->editarUnidade($id);
                break;
            case 'excluir':
                $this->excluirUnidade($id);
                break;
            default:
                $this->listarUnidades();
        }
    }

    private function listarUnidades() {
        $unidadeModel = $this->model('UnidadeSaude');
        $unidades = $unidadeModel->listarTodas();

        $dados = [
            'titulo' => 'Gerenciar Unidades de Saúde',
            'unidades' => $unidades
        ];

        $this->view('admin/unidades/listar', $dados);
    }

    private function adicionarUnidade() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $unidadeModel = $this->model('UnidadeSaude');
            
            $dados = [
                'nome' => trim($_POST['nome']),
                'endereco' => trim($_POST['endereco']),
                'bairro' => trim($_POST['bairro']),
                'telefone' => trim($_POST['telefone']),
                'email' => trim($_POST['email']),
                'horario_funcionamento' => trim($_POST['horario_funcionamento']),
                'especialidades' => trim($_POST['especialidades']),
                'latitude' => floatval($_POST['latitude'] ?? 0),
                'longitude' => floatval($_POST['longitude'] ?? 0),
                'ativo' => isset($_POST['ativo']) ? 1 : 0
            ];

            if ($unidadeModel->adicionar($dados)) {
                Sessao::mensagem('unidade', 'Unidade adicionada com sucesso!', 'alert alert-success');
                Url::redirecionar('adminpanel/unidades');
            } else {
                Sessao::mensagem('unidade', 'Erro ao adicionar unidade!', 'alert alert-danger');
            }
        }

        $dados = ['titulo' => 'Adicionar Unidade de Saúde'];
        $this->view('admin/unidades/adicionar', $dados);
    }

    private function editarUnidade($id) {
        if (!$id) {
            Url::redirecionar('adminpanel/unidades');
        }

        $unidadeModel = $this->model('UnidadeSaude');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dados = [
                'id' => $id,
                'nome' => trim($_POST['nome']),
                'endereco' => trim($_POST['endereco']),
                'bairro' => trim($_POST['bairro']),
                'telefone' => trim($_POST['telefone']),
                'email' => trim($_POST['email']),
                'horario_funcionamento' => trim($_POST['horario_funcionamento']),
                'especialidades' => trim($_POST['especialidades']),
                'latitude' => floatval($_POST['latitude'] ?? 0),
                'longitude' => floatval($_POST['longitude'] ?? 0),
                'ativo' => isset($_POST['ativo']) ? 1 : 0
            ];

            if ($unidadeModel->atualizar($dados)) {
                Sessao::mensagem('unidade', 'Unidade atualizada com sucesso!', 'alert alert-success');
                Url::redirecionar('adminpanel/unidades');
            } else {
                Sessao::mensagem('unidade', 'Erro ao atualizar unidade!', 'alert alert-danger');
            }
        }

        $unidade = $unidadeModel->buscarPorId($id);
        if (!$unidade) {
            Url::redirecionar('adminpanel/unidades');
        }

        $dados = [
            'titulo' => 'Editar Unidade de Saúde',
            'unidade' => $unidade
        ];

        $this->view('admin/unidades/editar', $dados);
    }

    private function excluirUnidade($id) {
        if (!$id) {
            Url::redirecionar('adminpanel/unidades');
        }

        $unidadeModel = $this->model('UnidadeSaude');
        
        if ($unidadeModel->excluir($id)) {
            Sessao::mensagem('unidade', 'Unidade excluída com sucesso!', 'alert alert-success');
        } else {
            Sessao::mensagem('unidade', 'Erro ao excluir unidade!', 'alert alert-danger');
        }

        Url::redirecionar('adminpanel/unidades');
    }

    // ========== GERENCIAMENTO DE USUÁRIOS ==========
    
    public function usuarios($acao = 'listar', $id = null) {
        switch ($acao) {
            case 'listar':
                $this->listarUsuarios();
                break;
            case 'editar':
                $this->editarUsuario($id);
                break;
            case 'excluir':
                $this->excluirUsuario($id);
                break;
            case 'relatorio':
                $this->relatorioUsuarios();
                break;
            default:
                $this->listarUsuarios();
        }
    }

    private function listarUsuarios() {
        $usuarioModel = $this->model('Usuario');
        $usuarios = $usuarioModel->listarTodos();

        $dados = [
            'titulo' => 'Gerenciar Usuários',
            'usuarios' => $usuarios
        ];

        $this->view('admin/usuarios/listar', $dados);
    }

    private function relatorioUsuarios() {
        $usuarioModel = $this->model('Usuario');
        $estatisticas = $usuarioModel->obterEstatisticas();

        $dados = [
            'titulo' => 'Relatório de Usuários',
            'estatisticas' => $estatisticas
        ];

        $this->view('admin/usuarios/relatorio', $dados);
    }

    // ========== CONFIGURAÇÕES ==========
    
    public function configuracoes($tipo = 'geral') {
        switch ($tipo) {
            case 'geral':
                $this->configuracaoGeral();
                break;
            case 'backup':
                $this->sistemaBackup();
                break;
            case 'seguranca':
                $this->configuracaoSeguranca();
                break;
            default:
                $this->configuracaoGeral();
        }
    }

    private function configuracaoGeral() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $configModel = $this->model('Configuracao');
            
            $configuracoes = [
                'nome_site' => trim($_POST['nome_site']),
                'email_contato' => trim($_POST['email_contato']),
                'telefone_contato' => trim($_POST['telefone_contato']),
                'endereco' => trim($_POST['endereco']),
                'meta_description' => trim($_POST['meta_description']),
                'palavras_chave' => trim($_POST['palavras_chave'])
            ];

            if ($configModel->atualizarConfiguracoes($configuracoes)) {
                Sessao::mensagem('config', 'Configurações atualizadas com sucesso!', 'alert alert-success');
            } else {
                Sessao::mensagem('config', 'Erro ao atualizar configurações!', 'alert alert-danger');
            }
        }

        $configModel = $this->model('Configuracao');
        $configuracoes = $configModel->obterConfiguracoes();

        $dados = [
            'titulo' => 'Configurações Gerais',
            'configuracoes' => $configuracoes
        ];

        $this->view('admin/configuracoes/geral', $dados);
    }

    private function sistemaBackup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $acao = $_POST['acao'] ?? '';
            
            switch ($acao) {
                case 'gerar_backup':
                    $this->gerarBackup();
                    break;
                case 'restaurar_backup':
                    $this->restaurarBackup();
                    break;
            }
        }

        $dados = ['titulo' => 'Sistema de Backup'];
        $this->view('admin/configuracoes/backup', $dados);
    }

    // ========== API ENDPOINTS ==========
    
    public function api($endpoint = null) {
        header('Content-Type: application/json');
        
        switch ($endpoint) {
            case 'estatisticas':
                $this->apiEstatisticas();
                break;
            case 'usuarios_recentes':
                $this->apiUsuariosRecentes();
                break;
            default:
                echo json_encode(['erro' => 'Endpoint não encontrado']);
        }
        exit;
    }

    private function apiEstatisticas() {
        $usuarioModel = $this->model('Usuario');
        $unidadeModel = $this->model('UnidadeSaude');
        
        $estatisticas = [
            'total_usuarios' => $usuarioModel->contarTotal(),
            'usuarios_mes' => $usuarioModel->contarPorPeriodo('mes'),
            'total_unidades' => $unidadeModel->contarTotal(),
            'unidades_ativas' => $unidadeModel->contarAtivas()
        ];

        echo json_encode($estatisticas);
    }

    private function apiUsuariosRecentes() {
        $usuarioModel = $this->model('Usuario');
        $usuarios = $usuarioModel->buscarRecentes(10);
        echo json_encode($usuarios);
    }

    // ========== MÉTODOS AUXILIARES ==========
    
    private function gerarBackup() {
        try {
            $database = new Database();
            $conexao = $database->conectar();
            
            $backup = "-- Backup Saúde na Mão - " . date('Y-m-d H:i:s') . "\n\n";
            
            // Listar todas as tabelas
            $stmt = $conexao->query("SHOW TABLES");
            $tabelas = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            foreach ($tabelas as $tabela) {
                $backup .= $this->exportarTabela($conexao, $tabela);
            }
            
            // Salvar backup
            $nomeArquivo = 'backup_saudenamao_' . date('Y-m-d_H-i-s') . '.sql';
            $caminhoBackup = '../backups/' . $nomeArquivo;
            
            if (!is_dir('../backups/')) {
                mkdir('../backups/', 0755, true);
            }
            
            file_put_contents($caminhoBackup, $backup);
            
            Sessao::mensagem('backup', 'Backup gerado com sucesso: ' . $nomeArquivo, 'alert alert-success');
            
        } catch (Exception $e) {
            Sessao::mensagem('backup', 'Erro ao gerar backup: ' . $e->getMessage(), 'alert alert-danger');
        }
    }
    
    private function exportarTabela($conexao, $tabela) {
        $resultado = "-- Estrutura da tabela `{$tabela}`\n";
        $resultado .= "DROP TABLE IF EXISTS `{$tabela}`;\n";
        
        $stmt = $conexao->query("SHOW CREATE TABLE `{$tabela}`");
        $create = $stmt->fetch(PDO::FETCH_ASSOC);
        $resultado .= $create['Create Table'] . ";\n\n";
        
        $resultado .= "-- Dados da tabela `{$tabela}`\n";
        $stmt = $conexao->query("SELECT * FROM `{$tabela}`");
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $valores = array_map(function($valor) use ($conexao) {
                return $conexao->quote($valor);
            }, array_values($row));
            
            $resultado .= "INSERT INTO `{$tabela}` VALUES (" . implode(', ', $valores) . ");\n";
        }
        
        return $resultado . "\n";
    }
}