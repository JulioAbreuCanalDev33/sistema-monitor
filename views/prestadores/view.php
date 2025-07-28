<?php
$page_title = 'Visualizar Prestador';
$page = 'prestadores';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Visualizar Prestador</h2>
    <div>
        <a href="index.php?page=prestadores&action=edit&id=<?php echo $prestador->id_prestador; ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="index.php?page=prestadores" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dados do Prestador</h3>
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
                            <p><?php echo htmlspecialchars($prestador->nome_prestador); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><strong>CPF:</strong></label>
                            <p><?php echo format_cpf($prestador->cpf_prestador); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><strong>RG:</strong></label>
                            <p><?php echo htmlspecialchars($prestador->rg_prestador) ?: 'Não informado'; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Data de Nascimento:</strong></label>
                            <p><?php echo format_date($prestador->data_nascimento, 'd/m/Y'); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Email:</strong></label>
                            <p><a href="mailto:<?php echo htmlspecialchars($prestador->email_prestador); ?>"><?php echo htmlspecialchars($prestador->email_prestador); ?></a></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Telefone:</strong></label>
                            <p><?php echo format_phone($prestador->telefone_prestador); ?></p>
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
                                <?php echo htmlspecialchars($prestador->endereco_prestador); ?>, 
                                <?php echo htmlspecialchars($prestador->numero_prestador); ?><br>
                                <?php echo htmlspecialchars($prestador->bairro_prestador); ?> - 
                                <?php echo htmlspecialchars($prestador->cidade_prestador); ?>/<?php echo htmlspecialchars($prestador->estado_prestador); ?><br>
                                CEP: <?php echo format_cep($prestador->cep_prestador); ?>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Dados Bancários -->
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3"><i class="fas fa-university"></i> Dados Bancários</h5>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Banco:</strong></label>
                            <p><?php echo htmlspecialchars($prestador->banco); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Agência:</strong></label>
                            <p><?php echo htmlspecialchars($prestador->agencia); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Conta:</strong></label>
                            <p><?php echo htmlspecialchars($prestador->conta); ?></p>
                        </div>
                    </div>
                    
                    <!-- Observações -->
                    <?php if ($prestador->observacoes): ?>
                    <div class="col-md-12 mt-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Observações:</strong></label>
                            <p><?php echo nl2br(htmlspecialchars($prestador->observacoes)); ?></p>
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
                        <span class="badge <?php echo $prestador->status_prestador == 'Ativo' ? 'bg-success' : 'bg-danger'; ?>">
                            <?php echo htmlspecialchars($prestador->status_prestador); ?>
                        </span>
                    </p>
                </div>
                
                <?php if ($prestador->data_nascimento): ?>
                <div class="form-group">
                    <label class="form-label"><strong>Idade:</strong></label>
                    <p><?php echo calculate_age($prestador->data_nascimento); ?> anos</p>
                </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label class="form-label"><strong>ID do Prestador:</strong></label>
                    <p>#<?php echo $prestador->id_prestador; ?></p>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><strong>Data de Cadastro:</strong></label>
                    <p><?php echo isset($prestador->data_cadastro) ? format_date($prestador->data_cadastro) : 'Não informado'; ?></p>
                </div>
            </div>
        </div>
        
        <!-- Documentos -->
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Documentos</h3>
            </div>
            
            <div class="card-body">
                <?php if ($prestador->documento): ?>
                <div class="form-group">
                    <label class="form-label"><strong>Documento:</strong></label>
                    <p>
                        <a href="<?php echo get_file_url($prestador->documento); ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-file-pdf"></i> Visualizar Documento
                        </a>
                    </p>
                </div>
                <?php endif; ?>
                
                <?php if ($prestador->foto): ?>
                <div class="form-group">
                    <label class="form-label"><strong>Foto:</strong></label>
                    <div class="text-center">
                        <img src="<?php echo get_file_url($prestador->foto); ?>" class="img-thumbnail" style="max-width: 200px;" data-bs-toggle="modal" data-bs-target="#fotoModal">
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Ações</h3>
            </div>
            
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="index.php?page=prestadores&action=edit&id=<?php echo $prestador->id_prestador; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar Prestador
                    </a>
                    
                    <?php if ($_SESSION['user_level'] == 'admin'): ?>
                    <a href="index.php?page=prestadores&action=delete&id=<?php echo $prestador->id_prestador; ?>" 
                       class="btn btn-danger btn-delete" 
                       onclick="return confirm('Tem certeza que deseja excluir este prestador?')">
                        <i class="fas fa-trash"></i> Excluir Prestador
                    </a>
                    <?php endif; ?>
                    
                    <a href="index.php?page=prestadores" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Lista de Prestadores
                    </a>
                    
                    <button onclick="window.print()" class="btn btn-info">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para visualizar foto -->
<?php if ($prestador->foto): ?>
<div class="modal fade" id="fotoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto do Prestador</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="<?php echo get_file_url($prestador->foto); ?>" class="img-fluid">
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include 'views/layout.php';
?>

