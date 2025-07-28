<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Sistema de Monitoramento</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
</head>
<body>
    <div class="main-wrapper">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-shield-alt"></i> Sistema Monitor</h3>
            </div>
            
            <ul class="sidebar-menu">
                <li>
                    <a href="index.php?page=dashboard" class="<?php echo ($page == 'dashboard') ? 'active' : ''; ?>">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                
                <li>
                    <a href="index.php?page=atendimentos" class="<?php echo ($page == 'atendimentos') ? 'active' : ''; ?>">
                        <i class="fas fa-clipboard-list"></i> Atendimentos
                    </a>
                </li>
                
                <li>
                    <a href="index.php?page=ocorrencias" class="<?php echo ($page == 'ocorrencias') ? 'active' : ''; ?>">
                        <i class="fas fa-car-crash"></i> Ocorrências Veiculares
                    </a>
                </li>
                
                <li>
                    <a href="index.php?page=vigilancia" class="<?php echo ($page == 'vigilancia') ? 'active' : ''; ?>">
                        <i class="fas fa-video"></i> Vigilância Veicular
                    </a>
                </li>
                
                <li>
                    <a href="index.php?page=prestadores" class="<?php echo ($page == 'prestadores') ? 'active' : ''; ?>">
                        <i class="fas fa-users"></i> Prestadores
                    </a>
                </li>
                
                <li>
                    <a href="index.php?page=clientes" class="<?php echo ($page == 'clientes') ? 'active' : ''; ?>">
                        <i class="fas fa-building"></i> Clientes
                    </a>
                </li>
                
                <li>
                    <a href="index.php?page=agentes" class="<?php echo ($page == 'agentes') ? 'active' : ''; ?>">
                        <i class="fas fa-user-shield"></i> Agentes
                    </a>
                </li>
                
                <li>
                    <a href="index.php?page=relatorios" class="<?php echo ($page == 'relatorios') ? 'active' : ''; ?>">
                        <i class="fas fa-chart-bar"></i> Relatórios
                    </a>
                </li>
                
                <?php if ($_SESSION['user_level'] == 'admin'): ?>
                <li>
                    <a href="index.php?page=usuarios" class="<?php echo ($page == 'usuarios') ? 'active' : ''; ?>">
                        <i class="fas fa-user-cog"></i> Usuários
                    </a>
                </li>
                
                <li>
                    <a href="index.php?page=configuracoes" class="<?php echo ($page == 'configuracoes') ? 'active' : ''; ?>">
                        <i class="fas fa-cog"></i> Configurações
                    </a>
                </li>
                <?php endif; ?>
                
                <!-- Indicador de nível do usuário -->
                <li class="mt-3">
                    <div class="px-3 py-2">
                        <small class="text-muted">
                            <i class="fas fa-user"></i> 
                            <?php echo $_SESSION['user_level'] == 'admin' ? 'Administrador' : 'Usuário Comum'; ?>
                        </small>
                        <?php if ($_SESSION['user_level'] != 'admin'): ?>
                        <br><small class="text-warning">
                            <i class="fas fa-info-circle"></i> Acesso limitado
                        </small>
                        <?php endif; ?>
                    </div>
                </li>
            </ul>
        </nav>
        
        <!-- Conteúdo Principal -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <button id="sidebar-toggle" class="btn btn-secondary d-md-none">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1><?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></h1>
                </div>
                
                <div class="header-right">
                    <button id="theme-toggle" class="theme-toggle">
                        <i class="fas fa-moon"></i> Modo Escuro
                    </button>
                    
                    <div class="user-menu">
                        <div class="user-info">
                            <i class="fas fa-user-circle"></i>
                            <span><?php echo $_SESSION['user_name']; ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="user-dropdown">
                            <a href="index.php?page=perfil">
                                <i class="fas fa-user"></i> Meu Perfil
                            </a>
                            <a href="index.php?page=login&action=logout">
                                <i class="fas fa-sign-out-alt"></i> Sair
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Conteúdo da Página -->
            <div class="page-content">
                <?php
                // Exibir mensagens flash
                $flash = get_flash_message();
                if ($flash):
                ?>
                <div class="alert alert-<?php echo $flash['type']; ?>">
                    <?php echo $flash['message']; ?>
                    <button type="button" class="alert-close">&times;</button>
                </div>
                <?php endif; ?>
                
                <?php echo $content; ?>
            </div>
        </main>
    </div>
    
    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <?php if (isset($extra_js)): ?>
        <?php echo $extra_js; ?>
    <?php endif; ?>
</body>
</html>

