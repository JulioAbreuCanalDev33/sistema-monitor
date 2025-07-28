<?php
$page_title = 'Atendimentos';
$page = 'atendimentos';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Atendimentos</h2>
    <a href="index.php?page=atendimentos&action=create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novo Atendimento
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h3 class="card-title">Lista de Atendimentos</h3>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="searchTable" class="form-control" placeholder="Buscar atendimentos...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="atendimentosTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Solicitante</th>
                        <th>Cliente</th>
                        <th>Motivo</th>
                        <th>Status</th>
                        <th>Data/Hora</th>
                        <th>Valor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($atendimentos as $atendimento): ?>
                    <tr>
                        <td><?php echo $atendimento['id_atendimento']; ?></td>
                        <td><?php echo htmlspecialchars($atendimento['solicitante']); ?></td>
                        <td><?php echo htmlspecialchars($atendimento['cliente_nome'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars(substr($atendimento['motivo'], 0, 50)) . '...'; ?></td>
                        <td>
                            <span class="badge <?php echo $atendimento['status_atendimento'] == 'Finalizado' ? 'bg-success' : 'bg-warning'; ?>">
                                <?php echo $atendimento['status_atendimento']; ?>
                            </span>
                        </td>
                        <td><?php echo format_date($atendimento['hora_local']); ?></td>
                        <td><?php echo format_currency($atendimento['valor_patrimonial']); ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="index.php?page=atendimentos&action=view&id=<?php echo $atendimento['id_atendimento']; ?>" 
                                   class="btn btn-sm btn-info" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="index.php?page=atendimentos&action=edit&id=<?php echo $atendimento['id_atendimento']; ?>" 
                                   class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="index.php?page=atendimentos&action=delete&id=<?php echo $atendimento['id_atendimento']; ?>" 
                                   class="btn btn-sm btn-danger btn-delete" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    <div class="row">
        <div class="col-md-6">
            <p class="text-muted">
                Total de <?php echo count($atendimentos); ?> atendimento(s) encontrado(s)
            </p>
        </div>
        <div class="col-md-6 text-end">
            <button onclick="exportTableToCSV('atendimentosTable', 'atendimentos')" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Exportar CSV
            </button>
            <button onclick="printPage()" class="btn btn-secondary">
                <i class="fas fa-print"></i> Imprimir
            </button>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

$extra_js = '
<script>
// Busca na tabela
searchTable("searchTable", "atendimentosTable");
</script>
';

include 'views/layout.php';
?>

