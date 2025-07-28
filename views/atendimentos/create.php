<?php
$page_title = 'Novo Atendimento';
$page = 'atendimentos';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Novo Atendimento</h2>
    <a href="index.php?page=atendimentos" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Cadastro de Atendimento</h3>
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
                        <label for="cliente" class="form-label">Cliente *</label>
                        <select id="cliente" name="cliente" class="form-control form-select" required>
                            <option value="">Selecione o cliente...</option>
                            <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['id_cliente']; ?>">
                                <?php echo htmlspecialchars($cliente['nome_empresa']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o cliente.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="agente" class="form-label">Agente *</label>
                        <select id="agente" name="agente" class="form-control form-select" required>
                            <option value="">Selecione o agente...</option>
                            <?php foreach ($agentes as $agente): ?>
                            <option value="<?php echo $agente['id_agente']; ?>">
                                <?php echo htmlspecialchars($agente['nome_agente']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o agente.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="tipo_atendimento" class="form-label">Tipo de Atendimento *</label>
                        <select id="tipo_atendimento" name="tipo_atendimento" class="form-control form-select" required>
                            <option value="">Selecione...</option>
                            <option value="Ronda">Ronda</option>
                            <option value="Ocorrência">Ocorrência</option>
                            <option value="Manutenção">Manutenção</option>
                            <option value="Inspeção">Inspeção</option>
                            <option value="Emergência">Emergência</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o tipo de atendimento.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="status_atendimento" class="form-label">Status *</label>
                        <select id="status_atendimento" name="status_atendimento" class="form-control form-select" required>
                            <option value="">Selecione...</option>
                            <option value="Pendente">Pendente</option>
                            <option value="Em Andamento">Em Andamento</option>
                            <option value="Concluído">Concluído</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o status.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="prioridade" class="form-label">Prioridade</label>
                        <select id="prioridade" name="prioridade" class="form-control form-select">
                            <option value="Normal">Normal</option>
                            <option value="Alta">Alta</option>
                            <option value="Urgente">Urgente</option>
                        </select>
                    </div>
                </div>
                
                <!-- Data e Hora -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-clock"></i> Data e Hora</h5>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="data_atendimento" class="form-label">Data do Atendimento *</label>
                        <input type="date" id="data_atendimento" name="data_atendimento" class="form-control" required>
                        <div class="invalid-feedback">Por favor, informe a data do atendimento.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="hora_inicio" class="form-label">Hora de Início</label>
                        <input type="time" id="hora_inicio" name="hora_inicio" class="form-control">
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="hora_fim" class="form-label">Hora de Fim</label>
                        <input type="time" id="hora_fim" name="hora_fim" class="form-control">
                    </div>
                </div>
                
                <!-- Localização -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-map-marker-alt"></i> Localização</h5>
                </div>
                
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="endereco_atendimento" class="form-label">Endereço do Atendimento *</label>
                        <input type="text" id="endereco_atendimento" name="endereco_atendimento" class="form-control" required>
                        <div class="invalid-feedback">Por favor, informe o endereço do atendimento.</div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cep_atendimento" class="form-label">CEP</label>
                        <input type="text" id="cep_atendimento" name="cep_atendimento" class="form-control" data-mask="cep">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="latitude" class="form-label">Latitude</label>
                        <input type="text" id="latitude" name="latitude" class="form-control" placeholder="Ex: -23.5505">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="longitude" class="form-label">Longitude</label>
                        <input type="text" id="longitude" name="longitude" class="form-control" placeholder="Ex: -46.6333">
                    </div>
                </div>
                
                <!-- Upload de Fotos -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-camera"></i> Fotos do Atendimento</h5>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="fotos_atendimento" class="form-label">Fotos de Evidência (JPG, PNG)</label>
                        <input type="file" id="fotos_atendimento" name="fotos_atendimento[]" class="form-control" accept=".jpg,.jpeg,.png" multiple onchange="previewMultipleImages(this, 'fotos_preview')">
                        <small class="form-text text-muted">Selecione múltiplas fotos. Tamanho máximo: 5MB por foto</small>
                        <div id="fotos_preview" class="mt-3 row"></div>
                    </div>
                </div>
                
                <!-- Descrição -->
                <div class="col-md-12 mt-4">
                    <div class="form-group">
                        <label for="descricao_atendimento" class="form-label">Descrição do Atendimento *</label>
                        <textarea id="descricao_atendimento" name="descricao_atendimento" class="form-control" rows="4" required placeholder="Descreva detalhadamente o atendimento realizado"></textarea>
                        <div class="invalid-feedback">Por favor, informe a descrição do atendimento.</div>
                    </div>
                </div>
                
                <!-- Observações -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea id="observacoes" name="observacoes" class="form-control" rows="3" placeholder="Observações adicionais"></textarea>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Salvar Atendimento
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
// Aplicar máscaras
applyInputMasks();

// Função para preview de múltiplas imagens
function previewMultipleImages(input, previewId) {
    const preview = document.getElementById(previewId);
    preview.innerHTML = "";
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement("div");
                col.className = "col-md-3 mb-3";
                
                const img = document.createElement("img");
                img.src = e.target.result;
                img.className = "img-thumbnail";
                img.style.maxHeight = "150px";
                img.style.width = "100%";
                img.style.objectFit = "cover";
                
                const caption = document.createElement("small");
                caption.className = "text-muted d-block text-center mt-1";
                caption.textContent = file.name;
                
                col.appendChild(img);
                col.appendChild(caption);
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        });
    }
}

// Buscar endereço por CEP
document.getElementById("cep_atendimento").addEventListener("blur", function() {
    const cep = this.value.replace(/\D/g, "");
    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    const endereco = `${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`;
                    document.getElementById("endereco_atendimento").value = endereco;
                }
            })
            .catch(error => console.log("Erro ao buscar CEP:", error));
    }
});

// Obter localização atual
function obterLocalizacao() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById("latitude").value = position.coords.latitude.toFixed(6);
            document.getElementById("longitude").value = position.coords.longitude.toFixed(6);
        });
    }
}

// Adicionar botão para obter localização
document.addEventListener("DOMContentLoaded", function() {
    const latitudeField = document.getElementById("latitude");
    const btnLocation = document.createElement("button");
    btnLocation.type = "button";
    btnLocation.className = "btn btn-outline-primary btn-sm mt-2";
    btnLocation.innerHTML = "<i class=\"fas fa-map-marker-alt\"></i> Obter Localização Atual";
    btnLocation.onclick = obterLocalizacao;
    
    latitudeField.parentNode.appendChild(btnLocation);
});
</script>
';

include 'views/layout.php';
?>

