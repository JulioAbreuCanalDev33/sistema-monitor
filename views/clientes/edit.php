<?php
$page_title = 'Editar Cliente';
$page = 'clientes';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Editar Cliente</h2>
    <a href="index.php?page=clientes" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edição de Cliente</h3>
    </div>
    
    <div class="card-body">
        <form method="POST" class="needs-validation" novalidate>
            <div class="row">
                <!-- Dados da Empresa -->
                <div class="col-md-12">
                    <h5 class="mb-3"><i class="fas fa-building"></i> Dados da Empresa</h5>
                </div>
                
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="nome_empresa" class="form-label">Nome da Empresa *</label>
                        <input type="text" id="nome_empresa" name="nome_empresa" class="form-control" value="<?php echo htmlspecialchars($cliente->nome_empresa); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o nome da empresa.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cnpj" class="form-label">CNPJ *</label>
                        <input type="text" id="cnpj" name="cnpj" class="form-control" data-mask="cnpj" value="<?php echo htmlspecialchars($cliente->cnpj); ?>" required>
                        <div class="invalid-feedback">Por favor, informe um CNPJ válido.</div>
                    </div>
                </div>
                
                <!-- Dados de Contato -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-phone"></i> Dados de Contato</h5>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="contato" class="form-label">Pessoa de Contato *</label>
                        <input type="text" id="contato" name="contato" class="form-control" value="<?php echo htmlspecialchars($cliente->contato); ?>" required>
                        <div class="invalid-feedback">Por favor, informe a pessoa de contato.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefone" class="form-label">Telefone *</label>
                        <input type="text" id="telefone" name="telefone" class="form-control" data-mask="phone" value="<?php echo htmlspecialchars($cliente->telefone); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o telefone.</div>
                    </div>
                </div>
                
                <!-- Endereço -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-map-marker-alt"></i> Endereço</h5>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="endereco" class="form-label">Endereço Completo *</label>
                        <textarea id="endereco" name="endereco" class="form-control" rows="3" required placeholder="Rua, número, bairro, cidade, estado, CEP"><?php echo htmlspecialchars($cliente->endereco); ?></textarea>
                        <div class="invalid-feedback">Por favor, informe o endereço completo.</div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Atualizar Cliente
                </button>
                <a href="index.php?page=clientes" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();

$extra_js = '
<script>
// Aplicar máscaras
applyInputMasks();

// Validar CNPJ
document.getElementById("cnpj").addEventListener("blur", function() {
    const cnpj = this.value.replace(/\D/g, "");
    if (cnpj.length === 14) {
        // Aqui você pode adicionar validação de CNPJ se necessário
        console.log("CNPJ informado:", cnpj);
    }
});
</script>
';

include 'views/layout.php';
?>

