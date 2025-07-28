<?php
$page_title = 'Visualizar Cliente';
$page = 'clientes';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Visualizar Cliente</h2>
    <div>
        <a href="index.php?page=clientes&action=edit&id=<?php echo $cliente->id_cliente; ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="index.php?page=clientes" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Dados do Cliente</h3>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <!-- Dados da Empresa -->
                    <div class="col-md-12">
                        <h5 class="mb-3"><i class="fas fa-building"></i> Dados da Empresa</h5>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label"><strong>Nome da Empresa:</strong></label>
                            <p><?php echo htmlspecialchars($cliente->nome_empresa); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label"><strong>CNPJ:</strong></label>
                            <p><?php echo format_cnpj($cliente->cnpj); ?></p>
                        </div>
                    </div>
                    
                    <!-- Dados de Contato -->
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3"><i class="fas fa-phone"></i> Dados de Contato</h5>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><strong>Pessoa de Contato:</strong></label>
                            <p><?php echo htmlspecialchars($cliente->contato); ?></p>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label"><strong>Telefone:</strong></label>
                            <p><?php echo format_phone($cliente->telefone); ?></p>
                        </div>
                    </div>
                    
                    <!-- Endereço -->
                    <div class="col-md-12 mt-4">
                        <h5 class="mb-3"><i class="fas fa-map-marker-alt"></i> Endereço</h5>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label"><strong>Endereço Completo:</strong></label>
                            <p><?php echo nl2br(htmlspecialchars($cliente->endereco)); ?></p>
                        </div>
                    </div>
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
                    <label class="form-label"><strong>ID do Cliente:</strong></label>
                    <p>#<?php echo $cliente->id_cliente; ?></p>
                </div>
                
                <div class="form-group">
                    <label class="form-label"><strong>Data de Cadastro:</strong></label>
                    <p><?php echo isset($cliente->data_cadastro) ? format_date($cliente->data_cadastro) : 'Não informado'; ?></p>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Ações</h3>
            </div>
            
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="index.php?page=clientes&action=edit&id=<?php echo $cliente->id_cliente; ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar Cliente
                    </a>
                    
                    <?php if ($_SESSION['user_level'] == 'admin'): ?>
                    <a href="index.php?page=clientes&action=delete&id=<?php echo $cliente->id_cliente; ?>" 
                       class="btn btn-danger btn-delete" 
                       onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                        <i class="fas fa-trash"></i> Excluir Cliente
                    </a>
                    <?php endif; ?>
                    
                    <a href="index.php?page=clientes" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Lista de Clientes
                    </a>
                    
                    <a href="index.php?page=atendimentos&action=create&cliente_id=<?php echo $cliente->id_cliente; ?>" class="btn btn-success">
                        <i class="fas fa-plus"></i> Novo Atendimento
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'views/layout.php';
?>

