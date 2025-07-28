<?php
$page_title = 'Editar Ocorrência Veicular';
$page = 'ocorrencias';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Editar Ocorrência Veicular</h2>
    <a href="index.php?page=ocorrencias" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edição de Ocorrência Veicular</h3>
    </div>
    
    <div class="card-body">
        <form method="POST" class="needs-validation" novalidate>
            <div class="row">
                <!-- Dados da Ocorrência -->
                <div class="col-md-12">
                    <h5 class="mb-3"><i class="fas fa-exclamation-triangle"></i> Dados da Ocorrência</h5>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="data_ocorrencia" class="form-label">Data da Ocorrência *</label>
                        <input type="date" id="data_ocorrencia" name="data_ocorrencia" class="form-control" value="<?php echo $ocorrencia->data_ocorrencia; ?>" required>
                        <div class="invalid-feedback">Por favor, informe a data da ocorrência.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="hora_ocorrencia" class="form-label">Hora da Ocorrência *</label>
                        <input type="time" id="hora_ocorrencia" name="hora_ocorrencia" class="form-control" value="<?php echo $ocorrencia->hora_ocorrencia; ?>" required>
                        <div class="invalid-feedback">Por favor, informe a hora da ocorrência.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipo_ocorrencia" class="form-label">Tipo de Ocorrência *</label>
                        <select id="tipo_ocorrencia" name="tipo_ocorrencia" class="form-control form-select" required>
                            <option value="">Selecione...</option>
                            <option value="Acidente" <?php echo ($ocorrencia->tipo_ocorrencia == 'Acidente') ? 'selected' : ''; ?>>Acidente</option>
                            <option value="Roubo" <?php echo ($ocorrencia->tipo_ocorrencia == 'Roubo') ? 'selected' : ''; ?>>Roubo</option>
                            <option value="Furto" <?php echo ($ocorrencia->tipo_ocorrencia == 'Furto') ? 'selected' : ''; ?>>Furto</option>
                            <option value="Vandalismo" <?php echo ($ocorrencia->tipo_ocorrencia == 'Vandalismo') ? 'selected' : ''; ?>>Vandalismo</option>
                            <option value="Pane Mecânica" <?php echo ($ocorrencia->tipo_ocorrencia == 'Pane Mecânica') ? 'selected' : ''; ?>>Pane Mecânica</option>
                            <option value="Multa" <?php echo ($ocorrencia->tipo_ocorrencia == 'Multa') ? 'selected' : ''; ?>>Multa</option>
                            <option value="Outros" <?php echo ($ocorrencia->tipo_ocorrencia == 'Outros') ? 'selected' : ''; ?>>Outros</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o tipo de ocorrência.</div>
                    </div>
                </div>
                
                <!-- Dados do Veículo -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-car"></i> Dados do Veículo</h5>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="placa_veiculo" class="form-label">Placa do Veículo *</label>
                        <input type="text" id="placa_veiculo" name="placa_veiculo" class="form-control" data-mask="placa" value="<?php echo htmlspecialchars($ocorrencia->placa_veiculo); ?>" required>
                        <div class="invalid-feedback">Por favor, informe a placa do veículo.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="modelo_veiculo" class="form-label">Modelo *</label>
                        <input type="text" id="modelo_veiculo" name="modelo_veiculo" class="form-control" value="<?php echo htmlspecialchars($ocorrencia->modelo_veiculo); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o modelo do veículo.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="marca_veiculo" class="form-label">Marca *</label>
                        <input type="text" id="marca_veiculo" name="marca_veiculo" class="form-control" value="<?php echo htmlspecialchars($ocorrencia->marca_veiculo); ?>" required>
                        <div class="invalid-feedback">Por favor, informe a marca do veículo.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="cor_veiculo" class="form-label">Cor</label>
                        <input type="text" id="cor_veiculo" name="cor_veiculo" class="form-control" value="<?php echo htmlspecialchars($ocorrencia->cor_veiculo); ?>">
                    </div>
                </div>
                
                <!-- Local da Ocorrência -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-map-marker-alt"></i> Local da Ocorrência</h5>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="local_ocorrencia" class="form-label">Endereço Completo *</label>
                        <textarea id="local_ocorrencia" name="local_ocorrencia" class="form-control" rows="2" required placeholder="Rua, número, bairro, cidade, estado"><?php echo htmlspecialchars($ocorrencia->local_ocorrencia); ?></textarea>
                        <div class="invalid-feedback">Por favor, informe o local da ocorrência.</div>
                    </div>
                </div>
                
                <!-- Descrição -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-file-alt"></i> Descrição da Ocorrência</h5>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="descricao_ocorrencia" class="form-label">Descrição Detalhada *</label>
                        <textarea id="descricao_ocorrencia" name="descricao_ocorrencia" class="form-control" rows="5" required placeholder="Descreva detalhadamente o que aconteceu..."><?php echo htmlspecialchars($ocorrencia->descricao_ocorrencia); ?></textarea>
                        <div class="invalid-feedback">Por favor, descreva a ocorrência.</div>
                    </div>
                </div>
                
                <!-- Dados do Condutor -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-user"></i> Dados do Condutor</h5>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nome_condutor" class="form-label">Nome do Condutor</label>
                        <input type="text" id="nome_condutor" name="nome_condutor" class="form-control" value="<?php echo htmlspecialchars($ocorrencia->nome_condutor); ?>">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="cnh_condutor" class="form-label">CNH</label>
                        <input type="text" id="cnh_condutor" name="cnh_condutor" class="form-control" value="<?php echo htmlspecialchars($ocorrencia->cnh_condutor); ?>">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="telefone_condutor" class="form-label">Telefone</label>
                        <input type="text" id="telefone_condutor" name="telefone_condutor" class="form-control" data-mask="phone" value="<?php echo htmlspecialchars($ocorrencia->telefone_condutor); ?>">
                    </div>
                </div>
                
                <!-- Status e Providências -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-cogs"></i> Status e Providências</h5>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status_ocorrencia" class="form-label">Status *</label>
                        <select id="status_ocorrencia" name="status_ocorrencia" class="form-control form-select" required>
                            <option value="">Selecione...</option>
                            <option value="Aberta" <?php echo ($ocorrencia->status_ocorrencia == 'Aberta') ? 'selected' : ''; ?>>Aberta</option>
                            <option value="Em Andamento" <?php echo ($ocorrencia->status_ocorrencia == 'Em Andamento') ? 'selected' : ''; ?>>Em Andamento</option>
                            <option value="Resolvida" <?php echo ($ocorrencia->status_ocorrencia == 'Resolvida') ? 'selected' : ''; ?>>Resolvida</option>
                            <option value="Cancelada" <?php echo ($ocorrencia->status_ocorrencia == 'Cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o status.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="numero_bo" class="form-label">Número do B.O.</label>
                        <input type="text" id="numero_bo" name="numero_bo" class="form-control" placeholder="Número do Boletim de Ocorrência" value="<?php echo htmlspecialchars($ocorrencia->numero_bo); ?>">
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="providencias" class="form-label">Providências Tomadas</label>
                        <textarea id="providencias" name="providencias" class="form-control" rows="3" placeholder="Descreva as providências tomadas..."><?php echo htmlspecialchars($ocorrencia->providencias); ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Atualizar Ocorrência
                </button>
                <a href="index.php?page=ocorrencias" class="btn btn-secondary">
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
</script>
';

include 'views/layout.php';
?>

