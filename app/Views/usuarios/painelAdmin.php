<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Saúde na Mão</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?=URL?>/public/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=URL?>/public/img/logo.png">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?=URL?>/public/bootstrap/css/bootstrap.css"/>
    
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS do Painel Administrativo -->
    <link rel="stylesheet" href="<?=URL?>/public/css/painelAdmin.css">
</head>
<body>
    <div class="container admin-container">
        <!-- Header do Painel -->
        <div class="admin-header">
            <div class="admin-welcome">
                <div class="welcome-text">
                    <h1>
                        <div class="logo-admin">
                            <i class="fas fa-heart"></i>
                        </div>
                        Painel Administrativo - Saúde na Mão
                    </h1>
                    <p>Bem-vindo, <?php echo $_SESSION['admin_email']; ?>! Gerencie o conteúdo do sistema</p>
                </div>
                <div class="admin-actions">
                    <a href="<?=URL?>/" class="btn-admin">
                        <i class="fas fa-home"></i>
                        Ver Site
                    </a>
                    <a href="<?=URL?>/usuarios/logout" class="btn-admin">
                        <i class="fas fa-sign-out-alt"></i>
                        Sair
                    </a>
                </div>
            </div>
        </div>

        <!-- Estatísticas -->
        <div class="stats-grid horizontal">
            <div class="stat-card">
                <div class="stat-number">152</div>
                <div class="stat-label">Usuários Cadastrados</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">28</div>
                <div class="stat-label">Posts Publicados</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">89</div>
                <div class="stat-label">Acessos Hoje</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">12</div>
                <div class="stat-label">Unidades de Saúde</div>
            </div>
        </div>

        <!-- Cards de Funcionalidades -->
        <div class="admin-grid">
            <!-- Gerenciar Conteúdo -->
            <div class="admin-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <h3 class="card-title">Gerenciar Conteúdo</h3>
                </div>
                <div class="card-content">
                    Edite textos, imagens e informações das páginas principais do site. Mantenha o conteúdo sempre atualizado e relevante.
                </div>
                <div class="card-actions">
                    <a href="#" class="btn-card" onclick="editarPagina('home')">
                        <i class="fas fa-home"></i>
                        Página Inicial
                    </a>
                    <a href="#" class="btn-card" onclick="editarPagina('sobre')">
                        <i class="fas fa-info-circle"></i>
                        Sobre Nós
                    </a>
                    <a href="#" class="btn-card secondary" onclick="editarPagina('saude')">
                        <i class="fas fa-heartbeat"></i>
                        Saúde
                    </a>
                </div>
            </div>

            <!-- Posts e Artigos -->
            <div class="admin-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h3 class="card-title">Posts e Artigos</h3>
                </div>
                <div class="card-content">
                    Crie, edite e gerencie posts informativos sobre saúde. Mantenha a comunidade informada com conteúdo de qualidade.
                </div>
                <div class="card-actions">
                    <a href="<?=URL?>/posts/cadastrar" class="btn-card">
                        <i class="fas fa-plus"></i>
                        Novo Post
                    </a>
                    <a href="<?=URL?>/posts" class="btn-card secondary">
                        <i class="fas fa-list"></i>
                        Ver Todos
                    </a>
                </div>
            </div>

            <!-- Unidades de Saúde -->
            <div class="admin-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <h3 class="card-title">Unidades de Saúde</h3>
                </div>
                <div class="card-content">
                    Gerencie informações sobre postos de saúde, hospitais e clínicas. Mantenha dados de contato e horários atualizados.
                </div>
                <div class="card-actions">
                    <a href="#" class="btn-card" onclick="gerenciarUnidades('adicionar')">
                        <i class="fas fa-plus"></i>
                        Adicionar
                    </a>
                    <a href="#" class="btn-card secondary" onclick="gerenciarUnidades('listar')">
                        <i class="fas fa-map-marker-alt"></i>
                        Gerenciar
                    </a>
                </div>
            </div>

            <!-- Usuários -->
            <div class="admin-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="card-title">Usuários</h3>
                </div>
                <div class="card-content">
                    Visualize e gerencie usuários cadastrados no sistema. Monitore atividades e garanta a segurança da plataforma.
                </div>
                <div class="card-actions">
                    <a href="<?=URL?>/usuarios" class="btn-card">
                        <i class="fas fa-list"></i>
                        Listar Usuários
                    </a>
                    <a href="#" class="btn-card secondary" onclick="relatorioUsuarios()">
                        <i class="fas fa-chart-bar"></i>
                        Relatórios
                    </a>
                </div>
            </div>

            <!-- Configurações -->
            <div class="admin-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <h3 class="card-title">Configurações</h3>
                </div>
                <div class="card-content">
                    Ajuste configurações gerais do sistema, backup de dados e configurações de segurança da plataforma.
                </div>
                <div class="card-actions">
                    <a href="#" class="btn-card" onclick="configuracoes('geral')">
                        <i class="fas fa-wrench"></i>
                        Geral
                    </a>
                    <a href="#" class="btn-card secondary" onclick="configuracoes('backup')">
                        <i class="fas fa-download"></i>
                        Backup
                    </a>
                </div>
            </div>

            <!-- Editor de Páginas -->
            <div class="admin-card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3 class="card-title">Editor de Páginas</h3>
                </div>
                <div class="card-content">
                    Editor visual para modificar o conteúdo das páginas em tempo real. Veja as alterações conforme você edita.
                </div>
                <div class="card-actions">
                    <a href="#" class="btn-card" onclick="abrirEditor()">
                        <i class="fas fa-edit"></i>
                        Abrir Editor
                    </a>
                    <a href="#" class="btn-card secondary" onclick="previsualizarSite()">
                        <i class="fas fa-eye"></i>
                        Preview
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript do Painel Administrativo -->
    <script src="<?=URL?>/public/js/painelAdmin.js"></script>
</body>
</html>