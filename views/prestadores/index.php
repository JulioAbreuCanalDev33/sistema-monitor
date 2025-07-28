<?php
$page_title = 'Prestadores';
$page = 'prestadores';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Prestadores</h2>
    <a href="index.php?page=prestadores&action=create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novo Prestador
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h3 class="card-title">Lista de Prestadores</h3>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="searchTable" class="form-control" placeholder="Buscar prestadores...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="prestadoresTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Serviço</th>
                        <th>CPF</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Cidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prestadores as $prestador): ?>
                    <tr>
                        <td><?php echo $prestador['id']; ?></td>
                        <td><?php echo htmlspecialchars($prestador['nome_prestador']); ?></td>
                        <td><?php echo htmlspecialchars($prestador['servico_prestador']); ?></td>
                        <td><?php echo htmlspecialchars($prestador['cpf_prestador']); ?></td>
                        <td><?php echo htmlspecialchars($prestador['email_prestador']); ?></td>
                        <td><?php echo htmlspecialchars($prestador['telefone_1_prestador']); ?></td>
                        <td><?php echo htmlspecialchars($prestador['cidade_prestador']); ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="index.php?page=prestadores&action=view&id=<?php echo $prestador['id']; ?>" 
                                   class="btn btn-sm btn-info" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="index.php?page=prestadores&action=edit&id=<?php echo $prestador['id']; ?>" 
                                   class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($_SESSION['user_level'] == 'admin'): ?>
                                <a href="index.php?page=prestadores&action=delete&id=<?php echo $prestador['id']; ?>" 
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
                Total de <?php echo count($prestadores); ?> prestador(es) encontrado(s)
            </p>
        </div>
        <div class="col-md-6 text-end">
            <button onclick="exportTableToCSV('prestadoresTable', 'prestadores')" class="btn btn-success">
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
searchTable("searchTable", "prestadoresTable");
</script>
';

include 'views/layout.php';
?>

