<?php
require_once 'app/configuracao.php';
require_once 'app/autoload.php';

// Verificar se as sessões já estão iniciadas
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Login temporário como admin
Auth::loginAsAdmin([
    'id' => 1,
    'nome' => 'Administrador do Sistema',
    'email' => 'admin@saudenamao.com.br'
]);

echo '<script>alert("Login como admin realizado!"); window.location.href = "' . URL . '/usuarios/painelAdmin";</script>';
?>