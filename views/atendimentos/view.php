<?php
$page_title = 'Visualizar Atendimento';
$page = 'atendimentos';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Visualizar Atendimento</h2>
    <div>
        <a href="index.php?page=atendimentos&action=edit&id=<?php echo $atendimento->id_atendimento; ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="index.php?page=atendimentos" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dados do Atendimento</h3>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <!-- Dados Básicos -->
                    <div class="col-md-12">
                        <h5 class="mb-3"><i class="fas fa-clipboard-list"></i> Informações Básicas</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><strong>Cliente:</strong></label>
                            <p><?php echo htmlspecialchars($cliente->nome_empresa ?? 'N/A'); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><strong>Agente Responsável:</strong></label>
                            <p><?php echo htmlspecialchars($agente->nome_agente ?? 'N/A'); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Data do Atendimento:</strong></label>
                            <p><?php echo format_date($atendimento->data_atendimento, 'd/m/Y'); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Hora de Início:</strong></label>
                            <p><?php echo $atendimento->hora_inicio; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>Hora de Término:</strong></label>
                            <p><?php echo $atendimento->hora_fim ?: 'Não informado'; ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><strong>Tipo de Atendimento:</strong></label>
                            <p>
                                <span class="badge bg-info">
                                    <?php echo htmlspecialchars($atendimento->tipo_atendimento); ?>
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
                                switch ($atendimento->status_atendimento) {
                                    case 'Concluído':
                                        $status_class = 'bg-success';
                                        break;
                                    case 'Em Andamento':
                                        $status_class = 'bg-warning';
                                        break;
                                    case 'Pendente':
                                        $status_class = 'bg-secondary';
                                        break;
                                    case 'Cancelado':
                                        $status_class = 'bg-danger';
                                        break;
                                    default:
                                        $status_class = 'bg-primary';
                                }
                                ?>
                                <span class="badge <?php echo $status_class; ?>">
                                    <?php echo htmlspecialchars($atendimento->status_atendimento); ?>
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Descrição -->
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3"><i class="fas fa-file-alt"></i> Descrição</h5>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <p><?php echo nl2br(htmlspecialchars($atendimento->descricao)); ?></p>
                        </div>
                    </div>
                    
                    <!-- Observações -->
                    <?php if ($atendimento->observacoes): ?>
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3"><i class="fas fa-sticky-note"></i> Observações</h5>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <p><?php echo nl2br(htmlspecialchars($atendimento->observacoes)); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Fotos do Atendimento -->
        <?php if (isset($fotos) && !empty($fotos)): ?>
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-camera"></i> Fotos do Atendimento</h3>
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
                    <label class="form-label"><strong>ID do Atendimento:</strong></label>
                    <p>#<?php echo $atendimento->id_atendimento; ?></p>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><strong>Data de Cadastro:</strong></label>
                    <p><?php echo isset($atendimento->data_cadastro) ? format_date($atendimento->data_cadastro) : 'Não informado'; ?></p>
                </div>
                
                <?php if ($atendimento->hora_inicio && $atendimento->hora_fim): ?>
                <div class="form-group">
                    <label class="form-label"><strong>Duração:</strong></label>
                    <p>
                        <?php
                        $inicio = new DateTime($atendimento->hora_inicio);
                        $fim = new DateTime($atendimento->hora_fim);
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
                    <a href="index.php?page=atendimentos&action=edit&id=<?php echo $atendimento->id_atendimento; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar Atendimento
                    </a>
                    
                    <?php if ($_SESSION['user_level'] == 'admin'): ?>
                    <a href="index.php?page=atendimentos&action=delete&id=<?php echo $atendimento->id_atendimento; ?>" 
                       class="btn btn-danger btn-delete" 
                       onclick="return confirm('Tem certeza que deseja excluir este atendimento?')">
                        <i class="fas fa-trash"></i> Excluir Atendimento
                    </a>
                    <?php endif; ?>
                    
                    <a href="index.php?page=atendimentos" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Lista de Atendimentos
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
                <h5 class="modal-title">Foto do Atendimento</h5>
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

