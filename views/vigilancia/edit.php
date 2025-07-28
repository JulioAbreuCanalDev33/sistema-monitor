<?php
$page_title = 'Editar Vigilância Veicular';
$page = 'vigilancia';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Editar Vigilância Veicular</h2>
    <a href="index.php?page=vigilancia" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edição de Vigilância Veicular</h3>
    </div>
    
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="row">
                <!-- Dados da Vigilância -->
                <div class="col-md-12">
                    <h5 class="mb-3"><i class="fas fa-shield-alt"></i> Dados da Vigilância</h5>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="data_vigilancia" class="form-label">Data da Vigilância *</label>
                        <input type="date" id="data_vigilancia" name="data_vigilancia" class="form-control" value="<?php echo $vigilancia->data_vigilancia; ?>" required>
                        <div class="invalid-feedback">Por favor, informe a data da vigilância.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="hora_inicio" class="form-label">Hora de Início *</label>
                        <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" value="<?php echo $vigilancia->hora_inicio; ?>" required>
                        <div class="invalid-feedback">Por favor, informe a hora de início.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="hora_fim" class="form-label">Hora de Término</label>
                        <input type="time" id="hora_fim" name="hora_fim" class="form-control" value="<?php echo $vigilancia->hora_fim; ?>">
                    </div>
                </div>
                
                <!-- Dados do Veículo -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-car"></i> Dados do Veículo</h5>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="placa_veiculo" class="form-label">Placa do Veículo *</label>
                        <input type="text" id="placa_veiculo" name="placa_veiculo" class="form-control" data-mask="placa" value="<?php echo htmlspecialchars($vigilancia->placa_veiculo); ?>" required>
                        <div class="invalid-feedback">Por favor, informe a placa do veículo.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="modelo_veiculo" class="form-label">Modelo *</label>
                        <input type="text" id="modelo_veiculo" name="modelo_veiculo" class="form-control" value="<?php echo htmlspecialchars($vigilancia->modelo_veiculo); ?>" required>
                        <div class="invalid-feedback">Por favor, informe o modelo do veículo.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="marca_veiculo" class="form-label">Marca *</label>
                        <input type="text" id="marca_veiculo" name="marca_veiculo" class="form-control" value="<?php echo htmlspecialchars($vigilancia->marca_veiculo); ?>" required>
                        <div class="invalid-feedback">Por favor, informe a marca do veículo.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="cor_veiculo" class="form-label">Cor</label>
                        <input type="text" id="cor_veiculo" name="cor_veiculo" class="form-control" value="<?php echo htmlspecialchars($vigilancia->cor_veiculo); ?>">
                    </div>
                </div>
                
                <!-- Local da Vigilância -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-map-marker-alt"></i> Local da Vigilância</h5>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="local_vigilancia" class="form-label">Endereço Completo *</label>
                        <textarea id="local_vigilancia" name="local_vigilancia" class="form-control" rows="2" required placeholder="Rua, número, bairro, cidade, estado"><?php echo htmlspecialchars($vigilancia->local_vigilancia); ?></textarea>
                        <div class="invalid-feedback">Por favor, informe o local da vigilância.</div>
                    </div>
                </div>
                
                <!-- Tipo e Status -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_vigilancia" class="form-label">Tipo de Vigilância *</label>
                        <select id="tipo_vigilancia" name="tipo_vigilancia" class="form-control form-select" required>
                            <option value="">Selecione...</option>
                            <option value="Ronda" <?php echo ($vigilancia->tipo_vigilancia == 'Ronda') ? 'selected' : ''; ?>>Ronda</option>
                            <option value="Monitoramento" <?php echo ($vigilancia->tipo_vigilancia == 'Monitoramento') ? 'selected' : ''; ?>>Monitoramento</option>
                            <option value="Escolta" <?php echo ($vigilancia->tipo_vigilancia == 'Escolta') ? 'selected' : ''; ?>>Escolta</option>
                            <option value="Inspeção" <?php echo ($vigilancia->tipo_vigilancia == 'Inspeção') ? 'selected' : ''; ?>>Inspeção</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o tipo de vigilância.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status_vigilancia" class="form-label">Status *</label>
                        <select id="status_vigilancia" name="status_vigilancia" class="form-control form-select" required>
                            <option value="">Selecione...</option>
                            <option value="Ativa" <?php echo ($vigilancia->status_vigilancia == 'Ativa') ? 'selected' : ''; ?>>Ativa</option>
                            <option value="Concluída" <?php echo ($vigilancia->status_vigilancia == 'Concluída') ? 'selected' : ''; ?>>Concluída</option>
                            <option value="Suspensa" <?php echo ($vigilancia->status_vigilancia == 'Suspensa') ? 'selected' : ''; ?>>Suspensa</option>
                            <option value="Cancelada" <?php echo ($vigilancia->status_vigilancia == 'Cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o status.</div>
                    </div>
                </div>
                
                <!-- Descrição -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-file-alt"></i> Descrição da Vigilância</h5>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="descricao_vigilancia" class="form-label">Descrição Detalhada *</label>
                        <textarea id="descricao_vigilancia" name="descricao_vigilancia" class="form-control" rows="4" required placeholder="Descreva detalhadamente a vigilância realizada..."><?php echo htmlspecialchars($vigilancia->descricao_vigilancia); ?></textarea>
                        <div class="invalid-feedback">Por favor, descreva a vigilância.</div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea id="observacoes" name="observacoes" class="form-control" rows="3" placeholder="Observações adicionais..."><?php echo htmlspecialchars($vigilancia->observacoes); ?></textarea>
                    </div>
                </div>
                
                <!-- Upload de Fotos -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-camera"></i> Fotos da Vigilância</h5>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="fotos" class="form-label">Adicionar Novas Fotos</label>
                        <input type="file" id="fotos" name="fotos[]" class="form-control" multiple accept="image/*">
                        <small class="form-text text-muted">Selecione uma ou mais fotos (JPG, PNG, GIF). Máximo 5MB por arquivo.</small>
                    </div>
                </div>
                
                <!-- Fotos Existentes -->
                <?php if (isset($fotos_existentes) && !empty($fotos_existentes)): ?>
                <div class="col-md-12">
                    <label class="form-label">Fotos Atuais:</label>
                    <div class="row">
                        <?php foreach ($fotos_existentes as $foto): ?>
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <img src="<?php echo get_file_url($foto); ?>" class="card-img-top" style="height: 150px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <button type="button" class="btn btn-danger btn-sm w-100" onclick="removerFoto('<?php echo $foto; ?>')">
                                        <i class="fas fa-trash"></i> Remover
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Atualizar Vigilância
                </button>
                <a href="index.php?page=vigilancia" class="btn btn-secondary">
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

// Preview das fotos selecionadas
document.getElementById("fotos").addEventListener("change", function() {
    const files = this.files;
    const preview = document.getElementById("preview-fotos");
    
    if (preview) {
        preview.innerHTML = "";
    }
    
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        if (file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.style.width = "100px";
                img.style.height = "100px";
                img.style.objectFit = "cover";
                img.style.margin = "5px";
                img.className = "border rounded";
                
                if (preview) {
                    preview.appendChild(img);
                }
            };
            reader.readAsDataURL(file);
        }
    }
});

// Função para remover foto existente
function removerFoto(filename) {
    if (confirm("Tem certeza que deseja remover esta foto?")) {
        // Aqui você pode implementar a remoção via AJAX
        console.log("Removendo foto:", filename);
    }
}
</script>
';

include 'views/layout.php';
?>

