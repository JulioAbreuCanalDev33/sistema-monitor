<?php
$page_title = 'Clientes';
$page = 'clientes';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Clientes</h2>
    <a href="index.php?page=clientes&action=create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novo Cliente
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h3 class="card-title">Lista de Clientes</h3>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="searchTable" class="form-control" placeholder="Buscar clientes...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="clientesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome da Empresa</th>
                        <th>CNPJ</th>
                        <th>Contato</th>
                        <th>Telefone</th>
                        <th>Endereço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?php echo $cliente['id_cliente']; ?></td>
                        <td><?php echo htmlspecialchars($cliente['nome_empresa']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['cnpj']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['contato']); ?></td>
                        <td><?php echo htmlspecialchars($cliente['telefone']); ?></td>
                        <td><?php echo htmlspecialchars(substr($cliente['endereco'], 0, 50)) . '...'; ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="index.php?page=clientes&action=view&id=<?php echo $cliente['id_cliente']; ?>" 
                                   class="btn btn-sm btn-info" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="index.php?page=clientes&action=edit&id=<?php echo $cliente['id_cliente']; ?>" 
                                   class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($_SESSION['user_level'] == 'admin'): ?>
                                <a href="index.php?page=clientes&action=delete&id=<?php echo $cliente['id_cliente']; ?>" 
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
                Total de <?php echo count($clientes); ?> cliente(s) encontrado(s)
            </p>
        </div>
        <div class="col-md-6 text-end">
            <button onclick="exportTableToCSV('clientesTable', 'clientes')" class="btn btn-success">
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
searchTable("searchTable", "clientesTable");
</script>
';

include 'views/layout.php';
?>

