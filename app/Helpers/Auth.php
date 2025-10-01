<?php

/**
 * Classe para gerenciar autenticação e autorização
 */
class Auth {
    
    public static function isAdmin() {
        return isset($_SESSION['admin_id']) || 
               (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin') ||
               (isset($_SESSION['usuario_id']) && isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'admin');
    }
    
    public static function isPaciente() {
        return isset($_SESSION['paciente_email']) && $_SESSION['tipo_usuario'] === 'paciente';
    }
    
    public static function isLoggedIn() {
        return isset($_SESSION['usuario_id']) || isset($_SESSION['admin_id']) || self::isPaciente();
    }
    
    public static function requireAdmin() {
        // Primeiro verifica se está logado
        if (!self::isLoggedIn()) {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode(['erro' => 'Acesso negado. Faça login como administrador.']);
                exit();
            }
            
            echo '<script>alert("Acesso negado! Faça login como administrador."); window.location.href = "' . URL . '/usuarios/loginPrincipal";</script>';
            exit();
        }
        
        // Verifica se é admin
        if (!self::isAdmin()) {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                
                http_response_code(403);
                header('Content-Type: application/json');
                echo json_encode(['erro' => 'Acesso negado. Permissões de administrador necessárias.']);
                exit();
            }
            
            echo '<script>alert("Acesso negado! Permissões de administrador necessárias."); window.location.href = "' . URL . '/usuarios/loginPrincipal?erro=nao_autorizado";</script>';
            exit();
        }
    }
    
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode(['erro' => 'Acesso negado. Faça login para continuar.']);
                exit();
            }
            
            echo '<script>alert("Acesso negado! Faça login para continuar."); window.location.href = "' . URL . '/usuarios/loginPrincipal";</script>';
            exit();
        }
    }
    
    public static function getUserInfo() {
        if (self::isAdmin()) {
            return [
                'tipo' => 'admin',
                'email' => $_SESSION['admin_email'] ?? $_SESSION['usuario_email'] ?? '',
                'id' => $_SESSION['admin_id'] ?? $_SESSION['usuario_id'] ?? null,
                'nome' => $_SESSION['usuario_nome'] ?? 'Administrador'
            ];
        } elseif (self::isPaciente()) {
            return [
                'tipo' => 'paciente',
                'email' => $_SESSION['paciente_email'],
                'cpf' => $_SESSION['paciente_cpf'] ?? ''
            ];
        } elseif (isset($_SESSION['usuario_id'])) {
            return [
                'tipo' => $_SESSION['tipo_usuario'] ?? 'usuario',
                'email' => $_SESSION['usuario_email'] ?? '',
                'id' => $_SESSION['usuario_id'],
                'nome' => $_SESSION['usuario_nome'] ?? 'Usuário'
            ];
        }
        return null;
    }
    
    /**
     * Faz login do usuário
     * @param array $userData Dados do usuário
     */
    public static function login($userData)
    {
        $_SESSION['usuario_id'] = $userData['id'];
        $_SESSION['usuario_nome'] = $userData['nome'];
        $_SESSION['usuario_email'] = $userData['email'];
        $_SESSION['tipo_usuario'] = $userData['tipo'] ?? 'usuario';
        
        // Se for admin, criar sessão específica
        if (isset($userData['tipo']) && $userData['tipo'] === 'admin') {
            $_SESSION['admin_id'] = $userData['id'];
        }
    }
    
    /**
     * Faz login temporário como admin para testes
     */
    public static function loginAsAdmin($adminData = null)
    {
        if ($adminData) {
            $_SESSION['admin_id'] = $adminData['id'] ?? 1;
            $_SESSION['usuario_id'] = $adminData['id'] ?? 1;
            $_SESSION['usuario_nome'] = $adminData['nome'] ?? 'Administrador';
            $_SESSION['usuario_email'] = $adminData['email'] ?? 'admin@saudenamao.com.br';
            $_SESSION['tipo_usuario'] = 'admin';
        } else {
            // Login temporário para desenvolvimento
            $_SESSION['admin_id'] = 1;
            $_SESSION['usuario_id'] = 1;
            $_SESSION['usuario_nome'] = 'Administrador do Sistema';
            $_SESSION['usuario_email'] = 'admin@saudenamao.com.br';
            $_SESSION['tipo_usuario'] = 'admin';
        }
    }
    
    /**
     * Faz logout do usuário
     */
    public static function logout()
    {
        // Limpar todas as sessões relacionadas ao usuário
        unset($_SESSION['usuario_id']);
        unset($_SESSION['usuario_nome']);
        unset($_SESSION['usuario_email']);
        unset($_SESSION['paciente_cpf']);
        unset($_SESSION['tipo_usuario']);
        unset($_SESSION['admin_id']);
        
        session_destroy();
    }
    
    /**
     * Obter dados do usuário atual
     * @return array|null
     */
    public static function user()
    {
        return self::getUserInfo();
    }
}