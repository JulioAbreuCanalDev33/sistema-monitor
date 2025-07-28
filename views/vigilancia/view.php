<?php
$page_title = 'Visualizar Vigilância Veicular';
$page = 'vigilancia';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Visualizar Vigilância Veicular</h2>
    <div>
        <a href="index.php?page=vigilancia&action=edit&id=<?php echo $vigilancia->id_vigilancia; ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="index.php?page=vigilancia" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dados da Vigilância</h3>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <!-- Dados Básicos -->
                    <div class="col-md-12">
                        <h5 class="mb-3"><i class="fas fa-shield-alt"></i> Informações Básicas</h5>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Data da Vigilância:</strong></label>
                            <p><?php echo format_date($vigilancia->data_vigilancia, 'd/m/Y'); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Hora de Início:</strong></label>
                            <p><?php echo $vigilancia->hora_inicio; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Hora de Término:</strong></label>
                            <p><?php echo $vigilancia->hora_fim ?: 'Não informado'; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><strong>Tipo de Vigilância:</strong></label>
                            <p>
                                <span class="badge bg-info">
                                    <?php echo htmlspecialchars($vigilancia->tipo_vigilancia); ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><strong>Status:</strong></label>
                            <p>
                                <?php
                                $status_class = '';
                                switch ($vigilancia->status_vigilancia) {
                                    case 'Concluída':
                                        $status_class = 'bg-success';
                                        break;
                                    case 'Ativa':
                                        $status_class = 'bg-warning';
                                        break;
                                    case 'Suspensa':
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
                                    <?php echo htmlspecialchars($vigilancia->status_vigilancia); ?>
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
                            <p><?php echo htmlspecialchars($vigilancia->placa_veiculo); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><strong>Modelo:</strong></label>
                            <p><?php echo htmlspecialchars($vigilancia->modelo_veiculo); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><strong>Marca:</strong></label>
                            <p><?php echo htmlspecialchars($vigilancia->marca_veiculo); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label"><strong>Cor:</strong></label>
                            <p><?php echo htmlspecialchars($vigilancia->cor_veiculo) ?: 'Não informado'; ?></p>
                        </div>
                    </div>
                    
                    <!-- Local da Vigilância -->
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3"><i class="fas fa-map-marker-alt"></i> Local da Vigilância</h5>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <p><?php echo nl2br(htmlspecialchars($vigilancia->local_vigilancia)); ?></p>
                        </div>
                    </div>
                    
                    <!-- Descrição -->
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3"><i class="fas fa-file-alt"></i> Descrição da Vigilância</h5>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <p><?php echo nl2br(htmlspecialchars($vigilancia->descricao_vigilancia)); ?></p>
                        </div>
                    </div>
                    
                    <!-- Observações -->
                    <?php if ($vigilancia->observacoes): ?>
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3"><i class="fas fa-sticky-note"></i> Observações</h5>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <p><?php echo nl2br(htmlspecialchars($vigilancia->observacoes)); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Fotos da Vigilância -->
        <?php if (isset($fotos) && !empty($fotos)): ?>
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-camera"></i> Fotos da Vigilância</h3>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <?php foreach ($fotos as $foto): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="<?php echo get_file_url($foto); ?>" class="card-img-top" style="height: 200px; object-fit: cover;" data-bs-toggle="modal" data-bs-target="#fotoModal" onclick="mostrarFoto('<?php echo get_file_url($foto); ?>')">
                            <div class="card-body p-2 text-center">
                                <small class="text-muted"><?php echo basename($foto); ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informações Adicionais</h3>
            </div>
            
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label"><strong>ID da Vigilância:</strong></label>
                    <p>#<?php echo $vigilancia->id_vigilancia; ?></p>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><strong>Data de Cadastro:</strong></label>
                    <p><?php echo isset($vigilancia->data_cadastro) ? format_date($vigilancia->data_cadastro) : 'Não informado'; ?></p>
                </div>
                
                <?php if ($vigilancia->hora_inicio && $vigilancia->hora_fim): ?>
                <div class="form-group">
                    <label class="form-label"><strong>Duração:</strong></label>
                    <p>
                        <?php
                        $inicio = new DateTime($vigilancia->hora_inicio);
                        $fim = new DateTime($vigilancia->hora_fim);
                        $duracao = $inicio->diff($fim);
                        echo $duracao->format('%H:%I');
                        ?>
                    </p>
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
                    <a href="index.php?page=vigilancia&action=edit&id=<?php echo $vigilancia->id_vigilancia; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar Vigilância
                    </a>
                    
                    <?php if ($_SESSION['user_level'] == 'admin'): ?>
                    <a href="index.php?page=vigilancia&action=delete&id=<?php echo $vigilancia->id_vigilancia; ?>" 
                       class="btn btn-danger btn-delete" 
                       onclick="return confirm('Tem certeza que deseja excluir esta vigilância?')">
                        <i class="fas fa-trash"></i> Excluir Vigilância
                    </a>
                    <?php endif; ?>
                    
                    <a href="index.php?page=vigilancia" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Lista de Vigilâncias
                    </a>
                    
                    <button onclick="window.print()" class="btn btn-info">
                        <i class="fas fa-print"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para visualizar fotos -->
<div class="modal fade" id="fotoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto da Vigilância</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="fotoModalImg" src="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

$extra_js = '
<script>
function mostrarFoto(src) {
    document.getElementById("fotoModalImg").src = src;
}
</script>
';

include 'views/layout.php';
?>

