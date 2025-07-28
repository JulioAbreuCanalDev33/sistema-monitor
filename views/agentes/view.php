<?php
$page_title = 'Visualizar Agente';
$page = 'agentes';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Visualizar Agente</h2>
    <div>
        <a href="index.php?page=agentes&action=edit&id=<?php echo $agente->id_agente; ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="index.php?page=agentes" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dados do Agente</h3>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <!-- Dados Pessoais -->
                    <div class="col-md-12">
                        <h5 class="mb-3"><i class="fas fa-user"></i> Dados Pessoais</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><strong>Nome Completo:</strong></label>
                            <p><?php echo htmlspecialchars($agente->nome_agente); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><strong>CPF:</strong></label>
                            <p><?php echo format_cpf($agente->cpf_agente); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><strong>RG:</strong></label>
                            <p><?php echo htmlspecialchars($agente->rg_agente) ?: '-'; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Data de Nascimento:</strong></label>
                            <p><?php echo format_date($agente->data_nascimento, 'd/m/Y'); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Email:</strong></label>
                            <p><a href="mailto:<?php echo htmlspecialchars($agente->email_agente); ?>"><?php echo htmlspecialchars($agente->email_agente); ?></a></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Telefone:</strong></label>
                            <p><?php echo format_phone($agente->telefone_agente); ?></p>
                        </div>
                    </div>
                    
                    <!-- Endereço -->
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3"><i class="fas fa-map-marker-alt"></i> Endereço</h5>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label"><strong>Endereço Completo:</strong></label>
                            <p>
                                <?php echo htmlspecialchars($agente->endereco_agente); ?>, 
                                <?php echo htmlspecialchars($agente->numero_agente); ?><br>
                                <?php echo htmlspecialchars($agente->bairro_agente); ?> - 
                                <?php echo htmlspecialchars($agente->cidade_agente); ?>/<?php echo htmlspecialchars($agente->estado_agente); ?><br>
                                CEP: <?php echo format_cep($agente->cep_agente); ?>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Observações -->
                    <?php if ($agente->observacoes): ?>
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Observações:</strong></label>
                            <p><?php echo nl2br(htmlspecialchars($agente->observacoes)); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informações Adicionais</h3>
            </div>
            
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label"><strong>Status:</strong></label>
                    <p>
                        <span class="badge <?php echo $agente->status_agente == 'Ativo' ? 'bg-success' : 'bg-danger'; ?>">
                            <?php echo htmlspecialchars($agente->status_agente); ?>
                        </span>
                    </p>
                </div>
                
                <?php if ($agente->data_nascimento): ?>
                <div class="form-group">
                    <label class="form-label"><strong>Idade:</strong></label>
                    <p><?php echo calculate_age($agente->data_nascimento); ?> anos</p>
                </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label class="form-label"><strong>ID do Agente:</strong></label>
                    <p>#<?php echo $agente->id_agente; ?></p>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Ações</h3>
            </div>
            
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="index.php?page=agentes&action=edit&id=<?php echo $agente->id_agente; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar Agente
                    </a>
                    
                    <?php if ($_SESSION['user_level'] == 'admin'): ?>
                    <a href="index.php?page=agentes&action=delete&id=<?php echo $agente->id_agente; ?>" 
                       class="btn btn-danger btn-delete" 
                       onclick="return confirm('Tem certeza que deseja excluir este agente?')">
                        <i class="fas fa-trash"></i> Excluir Agente
                    </a>
                    <?php endif; ?>
                    
                    <a href="index.php?page=agentes" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Lista de Agentes
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

