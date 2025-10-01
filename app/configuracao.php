<?php
// Iniciar sessão
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define('APP', dirname(__FILE__));
define('URL', 'http://localhost/SaudeNaMao');
define('APP_NOME', 'Saúde na Mão');
const APP_VERSAO = '1.0.0';

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'SaudeNaMao2');
