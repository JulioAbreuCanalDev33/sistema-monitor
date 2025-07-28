<?php
$page_title = 'Vigilância Veicular';
$page = 'vigilancia';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Vigilância Veicular</h2>
    <a href="index.php?page=vigilancia&action=create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nova Vigilância
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h3 class="card-title">Lista de Vigilâncias Veiculares</h3>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="searchTable" class="form-control" placeholder="Buscar vigilâncias...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="vigilanciaTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Veículo</th>
                        <th>Condutor</th>
                        <th>Data/Hora Início</th>
                        <th>Data/Hora Fim</th>
                        <th>KM Percorrido</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vigilancias as $vigilancia): ?>
                    <tr>
                        <td><?php echo $vigilancia['id']; ?></td>
                        <td><?php echo htmlspecialchars($vigilancia['veiculo']); ?></td>
                        <td><?php echo htmlspecialchars($vigilancia['condutor']); ?></td>
                        <td><?php echo format_date($vigilancia['data_hora_inicio']); ?></td>
                        <td><?php echo format_date($vigilancia['data_hora_fim']); ?></td>
                        <td>
                            <?php 
                            $km_percorrido = $vigilancia['km_final'] - $vigilancia['km_inicial'];
                            echo $km_percorrido > 0 ? $km_percorrido . ' km' : '-';
                            ?>
                        </td>
                        <td>
                            <span class="badge <?php 
                                echo match($vigilancia['status_vigilancia']) {
                                    'Em Andamento' => 'bg-warning',
                                    'Concluída' => 'bg-success',
                                    'Cancelada' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                            ?>">
                                <?php echo htmlspecialchars($vigilancia['status_vigilancia']); ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="index.php?page=vigilancia&action=view&id=<?php echo $vigilancia['id']; ?>" 
                                   class="btn btn-sm btn-info" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="index.php?page=vigilancia&action=edit&id=<?php echo $vigilancia['id']; ?>" 
                                   class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($_SESSION['user_level'] == 'admin'): ?>
                                <a href="index.php?page=vigilancia&action=delete&id=<?php echo $vigilancia['id']; ?>" 
                                   class="btn btn-sm btn-danger btn-delete" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <?php endif; ?>
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
                Total de <?php echo count($vigilancias); ?> vigilância(s) encontrada(s)
            </p>
        </div>
        <div class="col-md-6 text-end">
            <button onclick="exportTableToCSV('vigilanciaTable', 'vigilancia_veicular')" class="btn btn-success">
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
searchTable("searchTable", "vigilanciaTable");
</script>
';

include 'views/layout.php';
?>

