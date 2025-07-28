<?php
$page_title = 'Editar Usuário';
$page = 'usuarios';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Editar Usuário</h2>
    <a href="index.php?page=usuarios" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edição de Usuário</h3>
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
                
                <?php if ($_SESSION['user_level'] === 'admin'): ?>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nivel" class="form-label">Nível de Acesso *</label>
                        <select id="nivel" name="nivel" class="form-control form-select" required>
                            <option value="">Selecione...</option>
                            <option value="usuario" <?php echo ($usuario->nivel == 'usuario') ? 'selected' : ''; ?>>Usuário Comum</option>
                            <option value="admin" <?php echo ($usuario->nivel == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o nível de acesso.</div>
                        <small class="form-text text-muted">
                            <strong>Usuário Comum:</strong> Pode criar, visualizar e editar registros<br>
                            <strong>Administrador:</strong> Acesso total incluindo exclusão
                        </small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status" class="form-label">Status *</label>
                        <select id="status" name="status" class="form-control form-select" required>
                            <option value="">Selecione...</option>
                            <option value="ativo" <?php echo ($usuario->status == 'ativo') ? 'selected' : ''; ?>>Ativo</option>
                            <option value="inativo" <?php echo ($usuario->status == 'inativo') ? 'selected' : ''; ?>>Inativo</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o status.</div>
                    </div>
                </div>
                <?php else: ?>
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Nível atual:</strong> <?php echo ucfirst($usuario->nivel); ?><br>
                        <strong>Status atual:</strong> <?php echo ucfirst($usuario->status); ?><br>
                        <small>Apenas administradores podem alterar nível e status de usuários.</small>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Atualizar Usuário
                </button>
                <a href="index.php?page=usuarios" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
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

