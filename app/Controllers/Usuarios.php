<?php
class Usuarios extends Controller
{
    private $usuarioModel;
    public function index()
    {
        if (isset($_SESSION['usuario_id'])) {
            // Redireciona para o perfil se estiver logado
            URL::redirecionar('usuarios/perfil');
        } else {
            // Redireciona para login se não estiver logado
            URL::redirecionar('usuarios/login');
        }
    }

    public function __construct()
    {
        $this->usuarioModel = $this->model('Usuario');
    }

    public function loginPrincipal()
    {
        // Limpar qualquer output anterior
        ob_start();
        ob_clean();
        
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        // Incluir diretamente o arquivo de view que criamos
        include __DIR__ . '/../Views/usuarios/loginPrincipal.php';
        exit();
    }


    public function cadastrar()
    {
        // Processar cadastro se for POST
        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        if (isset($formulario)) :
            // Validações básicas via JavaScript para evitar problemas de header
            if (!empty($formulario['nome']) && !empty($formulario['email']) && !empty($formulario['senha'])) {
                if ($formulario['senha'] === $formulario['confirmar_senha']) {
                    // Simular cadastro bem-sucedido
                    echo '<script>alert("Cadastro realizado com sucesso!"); window.location.href = "' . URL . '/usuarios/loginPrincipal";</script>';
                    exit();
                } else {
                    echo '<script>alert("As senhas não conferem!"); history.back();</script>';
                    exit();
                }
            } else {
                echo '<script>alert("Preencha todos os campos obrigatórios!"); history.back();</script>';
                exit();
            }
        endif;

        // Renderizar página standalone (sem header/footer do sistema MVC)
        ob_start();
        ob_clean();
        
        // Garantir que não há saída anterior
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        // Incluir diretamente o arquivo sem passar pelo sistema MVC
        include __DIR__ . '/../Views/usuarios/cadastrar.php';
        exit(); // Para não renderizar o layout padrão do MVC
    }

    public function login()
    {
        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (isset($formulario)) :
            
            $tipo = $formulario['tipo'] ?? 'paciente';
            $email = $formulario['email'] ?? '';
            $senha = $formulario['senha'] ?? '';
            
            if (!empty($email) && !empty($senha)) {
                
                if ($tipo === 'admin') {
                    // Login do Administrador
                    if ($this->validarLoginAdmin($email, $senha)) {
                        $_SESSION['admin_id'] = 1;
                        $_SESSION['admin_email'] = $email;
                        $_SESSION['tipo_usuario'] = 'admin';
                        
                        echo '<script>window.location.href = "' . URL . '/usuarios/painelAdmin";</script>';
                        exit();
                    } else {
                        echo '<script>alert("Credenciais de administrador inválidas!"); window.location.href = "' . URL . '/usuarios/loginPrincipal";</script>';
                        exit();
                    }
                    
                } else {
                    // Login do Paciente  
                    if ($this->validarLoginPaciente($email, $senha)) {
                        $_SESSION['paciente_email'] = $email;
                        $_SESSION['tipo_usuario'] = 'paciente';
                        
                        echo '<script>window.location.href = "' . URL . '/";</script>';
                        exit();
                    } else {
                        echo '<script>alert("Email ou senha incorretos!"); window.location.href = "' . URL . '/usuarios/loginPrincipal";</script>';
                        exit();
                    }
                }
                
            } else {
                echo '<script>alert("Preencha email e senha para continuar"); window.location.href = "' . URL . '/usuarios/loginPrincipal";</script>';
                exit();
            }
        endif;
    }
    
    private function validarLoginAdmin($email, $senha)
    {
        // Credenciais fixas do admin (você pode melhorar isso depois)
        return ($email === 'admin@saudenamao.com' && $senha === 'admin123');
    }
    
    private function validarLoginPaciente($email, $senha)
    {
        // Por enquanto aceita qualquer email/senha válidos
        return (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($senha) >= 3);
    }
    
    public function painelAdmin()
    {
        // Verificar se é admin logado usando a classe Auth
        Auth::requireAdmin();
        
        // Renderizar página standalone do painel admin
        ob_start();
        ob_clean();
        
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        include __DIR__ . '/../Views/usuarios/painelAdmin.php';
        exit();
    }
    
    public function logout()
    {
        session_destroy();
        echo '<script>window.location.href = "' . URL . '/usuarios/loginPrincipal";</script>';
        exit();
    }


    public function sair(){
        // Limpar todas as sessões
        unset($_SESSION['usuario_id']);
        unset($_SESSION['usuario_nome']);
        unset($_SESSION['usuario_email']);
        unset($_SESSION['paciente_cpf']);
        unset($_SESSION['tipo_usuario']);

        session_destroy();
        
        // Redirecionamento via JavaScript
        echo '<script>window.location.href = "' . URL . '/usuarios/loginPrincipal";</script>';
        exit();
    }

    public function perfil()
    {
        // Acesso livre ao perfil, sem verificação de login
        
        // Dados do perfil
        $dados = [
            'titulo' => 'Meu Perfil',
            'paciente_cpf' => isset($_SESSION['paciente_cpf']) ? $_SESSION['paciente_cpf'] : '',
            'tipo_usuario' => isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : 'visitante',
            'logado' => isset($_SESSION['paciente_cpf']) || isset($_SESSION['admin_id'])
        ];
        
        $this->view('usuarios/perfil', $dados);
    }


}
