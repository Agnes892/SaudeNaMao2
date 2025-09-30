
<style>
@keyframes pulse-dot {
    0%, 100% { 
        opacity: 1; 
        transform: scale(1); 
    }
    50% { 
        opacity: 0.7; 
        transform: scale(1.1); 
    }
}

.btn-notificacao:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4) !important;
}

.navbar-brand:hover .logo {
    transform: scale(1.02);
    transition: transform 0.3s ease;
}

/* Gradiente animado para o título */
@keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.navbar-brand:hover + div > div:first-child {
    background-size: 200% 200%;
    animation: gradient-shift 3s ease infinite;
}

/* Dropdown de notificações */
#notificacoesDropdown {
    position: absolute !important;
    z-index: 9999 !important;
    top: 100% !important;
    right: 0 !important;
    margin-top: 8px !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    display: none;
    border-radius: 12px !important;
}

/* Seta do dropdown apontando para o botão */
#notificacoesDropdown::before {
    content: '';
    position: absolute;
    top: -8px;
    right: 15px;
    width: 0;
    height: 0;
    border-left: 8px solid transparent;
    border-right: 8px solid transparent;
    border-bottom: 8px solid #fff;
    filter: drop-shadow(0 -2px 4px rgba(0,0,0,0.1));
}
</style>

<header style="
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #cbd5e1 100%);
    position: relative;
    overflow: visible;
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
    border-bottom: 1px solid rgba(255,255,255,0.2);
    z-index: 1000;
">
    <!-- Efeito decorativo de fundo -->
    <div style="
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
        border-radius: 50%;
    "></div>
    <div style="
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.06) 0%, transparent 70%);
        border-radius: 50%;
    "></div>

    <link rel="stylesheet" href="<?=URL?>/public/css/saudename.css"/>
    <div class="container" style="position: relative; z-index: 1100;">
        <nav class="navbar navbar-expand-sm d-flex justify-content-between align-items-center" style="padding: 1rem 0;">
            
            <!-- Logo + Nome do App + Saudação -->
            <div class="d-flex align-items-center">
                <a class="navbar-brand d-flex align-items-center" href="<?=URL?>/paginas/sobre" style="text-decoration: none;">
                    <div style="
                        position: relative;
                        margin-right: 20px;
                        padding: 8px;
                        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
                        border-radius: 20px;
                        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.15);
                        border: 2px solid rgba(255, 255, 255, 0.8);
                    ">
                        <img src="/SaudeNaMao/public/img/logo.png" alt="Logo" style="height: 90px; width: 110px; border-radius: 12px;">
                    </div>
                </a>
                <div style="line-height: 1.2;">
                    <div style="
                        font-size: 1.8rem; 
                        font-weight: 800; 
                        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #06b6d4 100%);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                        background-clip: text;
                        text-shadow: 0 2px 4px rgba(59, 130, 246, 0.1);
                        margin-bottom: 2px;
                    ">Saúde na Mão</div>
                    <div style="
                        font-size: 1rem; 
                        color: #475569;
                        font-weight: 500;
                        display: flex;
                        align-items: center;
                        gap: 8px;
                    ">
                        <span style="
                            display: inline-block;
                            width: 8px;
                            height: 8px;
                            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                            border-radius: 50%;
                            animation: pulse-dot 2s infinite;
                        "></span>
                        Olá, <strong style="color: #1e40af;"><?= $_SESSION['usuario_nome'] ?? 'Visitante' ?></strong>!
                    </div>
                </div>
            </div>

            <!-- Notificações à direita -->
            <div class="d-flex align-items-center position-relative">
                <!-- Ícone de notificações -->
                <button id="btnNotificacoes" class="btn position-relative btn-notificacao" 
                    style="
                        border-radius:50%; 
                        padding:12px; 
                        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
                        border: 2px solid #ffffff;
                        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
                        transition: all 0.3s ease;
                        width: 50px;
                        height: 50px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    ">
                    <img src="<?=URL?>/public/img/bell.png" alt="Notificações" style="width:24px; filter: brightness(0) invert(1);">
                    <!-- Badge de notificação -->
                    <span id="badgeNotificacao" class="position-absolute top-0 start-100 translate-middle badge rounded-pill" 
                        style="
                            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                            color: white;
                            font-size: 10px;
                            font-weight: bold;
                            min-width: 18px;
                            height: 18px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            border: 2px solid white;
                            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.4);
                        ">3</span>
                </button>
                <!-- Aba flutuante de notificações -->
                <div id="notificacoesDropdown" class="shadow rounded" style="
                    min-width:350px; 
                    max-width:400px; 
                    background:#fff; 
                    max-height:500px; 
                    overflow-y:auto;
                    border: 1px solid rgba(0,0,0,0.1);
                    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
                ">
                    <!-- Conteúdo será gerado dinamicamente pelo JavaScript -->
                </div>
            </div>
        </nav>
    </div>
</header>
