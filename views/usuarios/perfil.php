<?php
$page_title = 'Meu Perfil';
$page = 'usuarios';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Meu Perfil</h2>
    <a href="index.php?page=dashboard" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar ao Dashboard
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Editar Perfil</h3>
            </div>
            
            <div class="card-body">
                <form method="POST" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nome" class="form-label">Nome Completo *</label>
                                <input type="text" id="nome" name="nome" class="form-control" value="<?php echo htmlspecialchars($usuario->nome); ?>" required>
                                <div class="invalid-feedback">Por favor, informe o nome completo.</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($usuario->email); ?>" required>
                                <div class="invalid-feedback">Por favor, informe um email válido.</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="senha" class="form-label">Nova Senha</label>
                                <input type="password" id="senha" name="senha" class="form-control" minlength="6">
                                <div class="invalid-feedback">A senha deve ter pelo menos 6 caracteres.</div>
                                <small class="form-text text-muted">Deixe em branco para manter a senha atual</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="confirmar_senha" class="form-label">Confirmar Nova Senha</label>
                                <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control">
                                <div class="invalid-feedback">As senhas não coincidem.</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Atualizar Perfil
                        </button>
                        <a href="index.php?page=dashboard" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informações da Conta</h3>
            </div>
            
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label"><strong>Nível de Acesso:</strong></label>
                    <p>
                        <span class="badge <?php echo $usuario->nivel == 'admin' ? 'bg-danger' : 'bg-primary'; ?>">
                            <?php echo ucfirst($usuario->nivel); ?>
                        </span>
                    </p>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><strong>Status:</strong></label>
                    <p>
                        <span class="badge <?php echo $usuario->status == 'ativo' ? 'bg-success' : 'bg-secondary'; ?>">
                            <?php echo ucfirst($usuario->status); ?>
                        </span>
                    </p>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><strong>ID do Usuário:</strong></label>
                    <p>#<?php echo $usuario->id; ?></p>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><strong>Último Acesso:</strong></label>
                    <p><?php echo isset($usuario->ultimo_acesso) && $usuario->ultimo_acesso ? format_date($usuario->ultimo_acesso) : 'Nunca'; ?></p>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Suas Permissões</h3>
            </div>
            
            <div class="card-body">
                <ul class="list-unstyled">
                    <?php if ($usuario->nivel == 'admin'): ?>
                    <li><i class="fas fa-check text-success"></i> Criar registros</li>
                    <li><i class="fas fa-check text-success"></i> Visualizar registros</li>
                    <li><i class="fas fa-check text-success"></i> Editar registros</li>
                    <li><i class="fas fa-check text-success"></i> Excluir registros</li>
                    <li><i class="fas fa-check text-success"></i> Gerenciar usuários</li>
                    <li><i class="fas fa-check text-success"></i> Gerar relatórios</li>
                    <?php else: ?>
                    <li><i class="fas fa-check text-success"></i> Criar registros</li>
                    <li><i class="fas fa-check text-success"></i> Visualizar registros</li>
                    <li><i class="fas fa-check text-success"></i> Editar registros</li>
                    <li><i class="fas fa-times text-danger"></i> Excluir registros</li>
                    <li><i class="fas fa-times text-danger"></i> Gerenciar usuários</li>
                    <li><i class="fas fa-check text-success"></i> Gerar relatórios</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

$extra_js = '
<script>
// Validar confirmação de senha apenas se senha foi preenchida
document.getElementById("confirmar_senha").addEventListener("input", function() {
    const senha = document.getElementById("senha").value;
    const confirmarSenha = this.value;
    
    if (senha && senha !== confirmarSenha) {
        this.setCustomValidity("As senhas não coincidem");
    } else {
        this.setCustomValidity("");
    }
});

// Validar quando a senha principal muda também
document.getElementById("senha").addEventListener("input", function() {
    const confirmarSenha = document.getElementById("confirmar_senha");
    if (confirmarSenha.value) {
        confirmarSenha.dispatchEvent(new Event("input"));
    }
    
    // Se senha foi preenchida, confirmar senha torna-se obrigatório
    if (this.value) {
        confirmarSenha.required = true;
    } else {
        confirmarSenha.required = false;
        confirmarSenha.setCustomValidity("");
    }
});
</script>
';

include 'views/layout.php';
?>

