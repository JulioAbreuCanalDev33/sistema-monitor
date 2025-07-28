<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Monitoramento</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h2><i class="fas fa-shield-alt"></i> Sistema de Monitoramento</h2>
                <p>Faça login para acessar o sistema</p>
            </div>
            
            <?php
            $flash = get_flash_message();
            if ($flash):
            ?>
            <div class="alert alert-<?php echo $flash['type']; ?>">
                <?php echo $flash['message']; ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="index.php?page=login&action=authenticate" class="needs-validation" novalidate>
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <input type="email" id="email" name="email" class="form-control" required>
                    <div class="invalid-feedback">
                        Por favor, insira um email válido.
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="senha" class="form-label">
                        <i class="fas fa-lock"></i> Senha
                    </label>
                    <input type="password" id="senha" name="senha" class="form-control" required>
                    <div class="invalid-feedback">
                        Por favor, insira sua senha.
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fas fa-sign-in-alt"></i> Entrar
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-3">
                <button id="theme-toggle" class="theme-toggle">
                    <i class="fas fa-moon"></i> Modo Escuro
                </button>
            </div>
            
            <div class="text-center mt-3">
                <small class="text-secondary">
                    Sistema de Monitoramento v1.0<br>
                    Login padrão: admin@sistema.com / password
                </small>
            </div>
        </div>
    </div>
    
    <script src="assets/js/main.js"></script>
</body>
</html>

