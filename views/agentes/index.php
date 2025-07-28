<?php
$page_title = 'Agentes';
$page = 'agentes';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Agentes</h2>
    <a href="index.php?page=agentes&action=create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novo Agente
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h3 class="card-title">Lista de Agentes</h3>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="searchTable" class="form-control" placeholder="Buscar agentes...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="agentesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Cidade</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agentes as $agente): ?>
                    <tr>
                        <td><?php echo $agente['id_agente']; ?></td>
                        <td><?php echo htmlspecialchars($agente['nome_agente']); ?></td>
                        <td><?php echo htmlspecialchars($agente['cpf_agente']); ?></td>
                        <td><?php echo htmlspecialchars($agente['email_agente']); ?></td>
                        <td><?php echo htmlspecialchars($agente['telefone_agente']); ?></td>
                        <td><?php echo htmlspecialchars($agente['cidade_agente']); ?></td>
                        <td>
                            <span class="badge <?php echo $agente['status_agente'] == 'Ativo' ? 'bg-success' : 'bg-danger'; ?>">
                                <?php echo htmlspecialchars($agente['status_agente']); ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="index.php?page=agentes&action=view&id=<?php echo $agente['id_agente']; ?>" 
                                   class="btn btn-sm btn-info" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="index.php?page=agentes&action=edit&id=<?php echo $agente['id_agente']; ?>" 
                                   class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($_SESSION['user_level'] == 'admin'): ?>
                                <a href="index.php?page=agentes&action=delete&id=<?php echo $agente['id_agente']; ?>" 
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
                Total de <?php echo count($agentes); ?> agente(s) encontrado(s)
            </p>
        </div>
        <div class="col-md-6 text-end">
            <button onclick="exportTableToCSV('agentesTable', 'agentes')" class="btn btn-success">
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
searchTable("searchTable", "agentesTable");
</script>
';

include 'views/layout.php';
?>

