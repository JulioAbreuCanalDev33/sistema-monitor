<?php
$page_title = 'Visualizar Ocorrência Veicular';
$page = 'ocorrencias';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Visualizar Ocorrência Veicular</h2>
    <div>
        <a href="index.php?page=ocorrencias&action=edit&id=<?php echo $ocorrencia->id_ocorrencia; ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="index.php?page=ocorrencias" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dados da Ocorrência</h3>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <!-- Dados Básicos -->
                    <div class="col-md-12">
                        <h5 class="mb-3"><i class="fas fa-exclamation-triangle"></i> Informações Básicas</h5>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Data da Ocorrência:</strong></label>
                            <p><?php echo format_date($ocorrencia->data_ocorrencia, 'd/m/Y'); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Hora da Ocorrência:</strong></label>
                            <p><?php echo $ocorrencia->hora_ocorrencia; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Tipo de Ocorrência:</strong></label>
                            <p>
                                <?php
                                $tipo_class = '';
                                switch ($ocorrencia->tipo_ocorrencia) {
                                    case 'Acidente':
                                        $tipo_class = 'bg-danger';
                                        break;
                                    case 'Roubo':
                                    case 'Furto':
                                        $tipo_class = 'bg-warning';
                                        break;
                                    case 'Vandalismo':
                                        $tipo_class = 'bg-info';
                                        break;
                                    case 'Pane Mecânica':
                                        $tipo_class = 'bg-secondary';
                                        break;
                                    case 'Multa':
                                        $tipo_class = 'bg-primary';
                                        break;
                                    default:
                                        $tipo_class = 'bg-dark';
                                }
                                ?>
                                <span class="badge <?php echo $tipo_class; ?>">
                                    <?php echo htmlspecialchars($ocorrencia->tipo_ocorrencia); ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Dados do Veículo -->
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3"><i class="fas fa-car"></i> Dados do Veículo</h5>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><strong>Placa:</strong></label>
                            <p><?php echo htmlspecialchars($ocorrencia->placa_veiculo); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><strong>Modelo:</strong></label>
                            <p><?php echo htmlspecialchars($ocorrencia->modelo_veiculo); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><strong>Marca:</strong></label>
                            <p><?php echo htmlspecialchars($ocorrencia->marca_veiculo); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><strong>Cor:</strong></label>
                            <p><?php echo htmlspecialchars($ocorrencia->cor_veiculo) ?: 'Não informado'; ?></p>
                        </div>
                    </div>
                    
                    <!-- Local da Ocorrência -->
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3"><i class="fas fa-map-marker-alt"></i> Local da Ocorrência</h5>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <p><?php echo nl2br(htmlspecialchars($ocorrencia->local_ocorrencia)); ?></p>
                        </div>
                    </div>
                    
                    <!-- Descrição -->
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3"><i class="fas fa-file-alt"></i> Descrição da Ocorrência</h5>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <p><?php echo nl2br(htmlspecialchars($ocorrencia->descricao_ocorrencia)); ?></p>
                        </div>
                    </div>
                    
                    <!-- Dados do Condutor -->
                    <?php if ($ocorrencia->nome_condutor): ?>
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3"><i class="fas fa-user"></i> Dados do Condutor</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><strong>Nome:</strong></label>
                            <p><?php echo htmlspecialchars($ocorrencia->nome_condutor); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><strong>CNH:</strong></label>
                            <p><?php echo htmlspecialchars($ocorrencia->cnh_condutor) ?: 'Não informado'; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><strong>Telefone:</strong></label>
                            <p><?php echo $ocorrencia->telefone_condutor ? format_phone($ocorrencia->telefone_condutor) : 'Não informado'; ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Providências -->
                    <?php if ($ocorrencia->providencias): ?>
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3"><i class="fas fa-cogs"></i> Providências Tomadas</h5>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <p><?php echo nl2br(htmlspecialchars($ocorrencia->providencias)); ?></p>
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
                        <?php
                        $status_class = '';
                        switch ($ocorrencia->status_ocorrencia) {
                            case 'Resolvida':
                                $status_class = 'bg-success';
                                break;
                            case 'Em Andamento':
                                $status_class = 'bg-warning';
                                break;
                            case 'Aberta':
                                $status_class = 'bg-secondary';
                                break;
                            case 'Cancelada':
                                $status_class = 'bg-danger';
                                break;
                            default:
                                $status_class = 'bg-primary';
                        }
                        ?>
                        <span class="badge <?php echo $status_class; ?>">
                            <?php echo htmlspecialchars($ocorrencia->status_ocorrencia); ?>
                        </span>
                    </p>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><strong>ID da Ocorrência:</strong></label>
                    <p>#<?php echo $ocorrencia->id_ocorrencia; ?></p>
                </div>
                
                <?php if ($ocorrencia->numero_bo): ?>
                <div class="form-group">
                    <label class="form-label"><strong>Número do B.O.:</strong></label>
                    <p><?php echo htmlspecialchars($ocorrencia->numero_bo); ?></p>
                </div>
                <?php endif; ?>
                
                <div class="form-group">
                    <label class="form-label"><strong>Data de Cadastro:</strong></label>
                    <p><?php echo isset($ocorrencia->data_cadastro) ? format_date($ocorrencia->data_cadastro) : 'Não informado'; ?></p>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Ações</h3>
            </div>
            
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="index.php?page=ocorrencias&action=edit&id=<?php echo $ocorrencia->id_ocorrencia; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar Ocorrência
                    </a>
                    
                    <?php if ($_SESSION['user_level'] == 'admin'): ?>
                    <a href="index.php?page=ocorrencias&action=delete&id=<?php echo $ocorrencia->id_ocorrencia; ?>" 
                       class="btn btn-danger btn-delete" 
                       onclick="return confirm('Tem certeza que deseja excluir esta ocorrência?')">
                        <i class="fas fa-trash"></i> Excluir Ocorrência
                    </a>
                    <?php endif; ?>
                    
                    <a href="index.php?page=ocorrencias" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Lista de Ocorrências
                    </a>
                    
                    <button onclick="window.print()" class="btn btn-info">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'views/layout.php';
?>

