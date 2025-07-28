<?php
$page_title = 'Usuários';
$page = 'usuarios';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Usuários do Sistema</h2>
    <a href="index.php?page=usuarios&action=create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novo Usuário
    </a>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h3 class="card-title">Lista de Usuários</h3>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="searchTable" class="form-control" placeholder="Buscar usuários...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="usuariosTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Nível</th>
                        <th>Status</th>
                        <th>Último Acesso</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td>
                            <span class="badge <?php echo $usuario['nivel'] == 'admin' ? 'bg-danger' : 'bg-primary'; ?>">
                                <?php echo ucfirst($usuario['nivel']); ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge <?php echo $usuario['status'] == 'ativo' ? 'bg-success' : 'bg-secondary'; ?>">
                                <?php echo ucfirst($usuario['status']); ?>
                            </span>
                        </td>
                        <td><?php echo $usuario['ultimo_acesso'] ? format_date($usuario['ultimo_acesso']) : 'Nunca'; ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="index.php?page=usuarios&action=view&id=<?php echo $usuario['id']; ?>" 
                                   class="btn btn-sm btn-info" title="Visualizar">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="index.php?page=usuarios&action=edit&id=<?php echo $usuario['id']; ?>" 
                                   class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($usuario['id'] != $_SESSION['user_id']): ?>
                                <a href="index.php?page=usuarios&action=delete&id=<?php echo $usuario['id']; ?>" 
                                   class="btn btn-sm btn-danger btn-delete" title="Excluir"
                                   onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
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
                Total de <?php echo count($usuarios); ?> usuário(s) encontrado(s)
            </p>
        </div>
        <div class="col-md-6 text-end">
            <button onclick="exportTableToCSV('usuariosTable', 'usuarios')" class="btn btn-success">
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
searchTable("searchTable", "usuariosTable");
</script>
';

include 'views/layout.php';
?>

