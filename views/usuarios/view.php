<?php
$page_title = 'Visualizar Usuário';
$page = 'usuarios';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Visualizar Usuário</h2>
    <div>
        <a href="index.php?page=usuarios&action=edit&id=<?php echo $usuario->id; ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="index.php?page=usuarios" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dados do Usuário</h3>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><strong>Nome Completo:</strong></label>
                            <p><?php echo htmlspecialchars($usuario->nome); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><strong>Email:</strong></label>
                            <p><a href="mailto:<?php echo htmlspecialchars($usuario->email); ?>"><?php echo htmlspecialchars($usuario->email); ?></a></p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><strong>Nível de Acesso:</strong></label>
                            <p>
                                <span class="badge <?php echo $usuario->nivel == 'admin' ? 'bg-danger' : 'bg-primary'; ?>">
                                    <?php echo ucfirst($usuario->nivel); ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><strong>Status:</strong></label>
                            <p>
                                <span class="badge <?php echo $usuario->status == 'ativo' ? 'bg-success' : 'bg-secondary'; ?>">
                                    <?php echo ucfirst($usuario->status); ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><strong>Data de Cadastro:</strong></label>
                            <p><?php echo isset($usuario->data_cadastro) ? format_date($usuario->data_cadastro) : 'Não informado'; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><strong>Último Acesso:</strong></label>
                            <p><?php echo isset($usuario->ultimo_acesso) && $usuario->ultimo_acesso ? format_date($usuario->ultimo_acesso) : 'Nunca'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informações do Sistema</h3>
            </div>
            
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label"><strong>ID do Usuário:</strong></label>
                    <p>#<?php echo $usuario->id; ?></p>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><strong>Permissões:</strong></label>
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
        
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Ações</h3>
            </div>
            
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="index.php?page=usuarios&action=edit&id=<?php echo $usuario->id; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar Usuário
                    </a>
                    
                    <?php if ($_SESSION['user_level'] == 'admin' && $usuario->id != $_SESSION['user_id']): ?>
                    <a href="index.php?page=usuarios&action=delete&id=<?php echo $usuario->id; ?>" 
                       class="btn btn-danger btn-delete" 
                       onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                        <i class="fas fa-trash"></i> Excluir Usuário
                    </a>
                    <?php endif; ?>
                    
                    <a href="index.php?page=usuarios" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Lista de Usuários
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'views/layout.php';
?>

