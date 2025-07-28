<?php
$page_title = 'Editar Atendimento';
$page = 'atendimentos';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Editar Atendimento</h2>
    <a href="index.php?page=atendimentos" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edição de Atendimento</h3>
    </div>
    
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="row">
                <!-- Dados do Atendimento -->
                <div class="col-md-12">
                    <h5 class="mb-3"><i class="fas fa-clipboard-list"></i> Dados do Atendimento</h5>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cliente_id" class="form-label">Cliente *</label>
                        <select id="cliente_id" name="cliente_id" class="form-control form-select" required>
                            <option value="">Selecione o cliente...</option>
                            <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['id_cliente']; ?>" <?php echo ($atendimento->cliente_id == $cliente['id_cliente']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cliente['nome_empresa']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o cliente.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="agente_id" class="form-label">Agente Responsável *</label>
                        <select id="agente_id" name="agente_id" class="form-control form-select" required>
                            <option value="">Selecione o agente...</option>
                            <?php foreach ($agentes as $agente): ?>
                            <option value="<?php echo $agente['id_agente']; ?>" <?php echo ($atendimento->agente_id == $agente['id_agente']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($agente['nome_agente']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o agente responsável.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="data_atendimento" class="form-label">Data do Atendimento *</label>
                        <input type="date" id="data_atendimento" name="data_atendimento" class="form-control" value="<?php echo $atendimento->data_atendimento; ?>" required>
                        <div class="invalid-feedback">Por favor, informe a data do atendimento.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="hora_inicio" class="form-label">Hora de Início *</label>
                        <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" value="<?php echo $atendimento->hora_inicio; ?>" required>
                        <div class="invalid-feedback">Por favor, informe a hora de início.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="hora_fim" class="form-label">Hora de Término</label>
                        <input type="time" id="hora_fim" name="hora_fim" class="form-control" value="<?php echo $atendimento->hora_fim; ?>">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_atendimento" class="form-label">Tipo de Atendimento *</label>
                        <select id="tipo_atendimento" name="tipo_atendimento" class="form-control form-select" required>
                            <option value="">Selecione...</option>
                            <option value="Ronda" <?php echo ($atendimento->tipo_atendimento == 'Ronda') ? 'selected' : ''; ?>>Ronda</option>
                            <option value="Ocorrência" <?php echo ($atendimento->tipo_atendimento == 'Ocorrência') ? 'selected' : ''; ?>>Ocorrência</option>
                            <option value="Manutenção" <?php echo ($atendimento->tipo_atendimento == 'Manutenção') ? 'selected' : ''; ?>>Manutenção</option>
                            <option value="Inspeção" <?php echo ($atendimento->tipo_atendimento == 'Inspeção') ? 'selected' : ''; ?>>Inspeção</option>
                            <option value="Emergência" <?php echo ($atendimento->tipo_atendimento == 'Emergência') ? 'selected' : ''; ?>>Emergência</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o tipo de atendimento.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status_atendimento" class="form-label">Status *</label>
                        <select id="status_atendimento" name="status_atendimento" class="form-control form-select" required>
                            <option value="">Selecione...</option>
                            <option value="Pendente" <?php echo ($atendimento->status_atendimento == 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
                            <option value="Em Andamento" <?php echo ($atendimento->status_atendimento == 'Em Andamento') ? 'selected' : ''; ?>>Em Andamento</option>
                            <option value="Concluído" <?php echo ($atendimento->status_atendimento == 'Concluído') ? 'selected' : ''; ?>>Concluído</option>
                            <option value="Cancelado" <?php echo ($atendimento->status_atendimento == 'Cancelado') ? 'selected' : ''; ?>>Cancelado</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o status.</div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="descricao" class="form-label">Descrição do Atendimento *</label>
                        <textarea id="descricao" name="descricao" class="form-control" rows="4" required placeholder="Descreva detalhadamente o atendimento realizado..."><?php echo htmlspecialchars($atendimento->descricao); ?></textarea>
                        <div class="invalid-feedback">Por favor, descreva o atendimento.</div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea id="observacoes" name="observacoes" class="form-control" rows="3" placeholder="Observações adicionais..."><?php echo htmlspecialchars($atendimento->observacoes); ?></textarea>
                    </div>
                </div>
                
                <!-- Upload de Fotos -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-camera"></i> Fotos do Atendimento</h5>
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
                    <i class="fas fa-save"></i> Atualizar Atendimento
                </button>
                <a href="index.php?page=atendimentos" class="btn btn-secondary">
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

