<?php
$page_title = 'Nova Vigilância Veicular';
$page = 'vigilancia';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Nova Vigilância Veicular</h2>
    <a href="index.php?page=vigilancia" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Cadastro de Vigilância Veicular</h3>
    </div>
    
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="row">
                <!-- Dados do Veículo -->
                <div class="col-md-12">
                    <h5 class="mb-3"><i class="fas fa-car"></i> Dados do Veículo</h5>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="veiculo" class="form-label">Veículo *</label>
                        <input type="text" id="veiculo" name="veiculo" class="form-control" placeholder="Ex: Honda Civic - ABC-1234" required>
                        <div class="invalid-feedback">Por favor, informe o veículo.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="condutor" class="form-label">Condutor *</label>
                        <input type="text" id="condutor" name="condutor" class="form-control" required>
                        <div class="invalid-feedback">Por favor, informe o condutor.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="responsavel" class="form-label">Responsável *</label>
                        <input type="text" id="responsavel" name="responsavel" class="form-control" required>
                        <div class="invalid-feedback">Por favor, informe o responsável.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status_vigilancia" class="form-label">Status *</label>
                        <select id="status_vigilancia" name="status_vigilancia" class="form-control form-select" required>
                            <option value="">Selecione...</option>
                            <option value="Em Andamento">Em Andamento</option>
                            <option value="Concluída">Concluída</option>
                            <option value="Cancelada">Cancelada</option>
                            <option value="Pausada">Pausada</option>
                        </select>
                        <div class="invalid-feedback">Por favor, selecione o status.</div>
                    </div>
                </div>
                
                <!-- Período de Vigilância -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-clock"></i> Período de Vigilância</h5>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="data_hora_inicio" class="form-label">Data/Hora Início *</label>
                        <input type="datetime-local" id="data_hora_inicio" name="data_hora_inicio" class="form-control" required>
                        <div class="invalid-feedback">Por favor, informe a data/hora de início.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="data_hora_fim" class="form-label">Data/Hora Fim</label>
                        <input type="datetime-local" id="data_hora_fim" name="data_hora_fim" class="form-control">
                    </div>
                </div>
                
                <!-- Localização -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-map-marker-alt"></i> Localização</h5>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="localizacao_inicial" class="form-label">Localização Inicial *</label>
                        <input type="text" id="localizacao_inicial" name="localizacao_inicial" class="form-control" required>
                        <div class="invalid-feedback">Por favor, informe a localização inicial.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="localizacao_final" class="form-label">Localização Final</label>
                        <input type="text" id="localizacao_final" name="localizacao_final" class="form-control">
                    </div>
                </div>
                
                <!-- Quilometragem -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-tachometer-alt"></i> Quilometragem e Combustível</h5>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="km_inicial" class="form-label">KM Inicial *</label>
                        <input type="number" id="km_inicial" name="km_inicial" class="form-control" step="0.1" required>
                        <div class="invalid-feedback">Por favor, informe a quilometragem inicial.</div>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="km_final" class="form-label">KM Final</label>
                        <input type="number" id="km_final" name="km_final" class="form-control" step="0.1">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="combustivel_inicial" class="form-label">Combustível Inicial (%)</label>
                        <input type="number" id="combustivel_inicial" name="combustivel_inicial" class="form-control" min="0" max="100">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="combustivel_final" class="form-label">Combustível Final (%)</label>
                        <input type="number" id="combustivel_final" name="combustivel_final" class="form-control" min="0" max="100">
                    </div>
                </div>
                
                <!-- Upload de Fotos -->
                <div class="col-md-12 mt-4">
                    <h5 class="mb-3"><i class="fas fa-camera"></i> Fotos de Vigilância</h5>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="fotos_vigilancia" class="form-label">Fotos (JPG, PNG)</label>
                        <input type="file" id="fotos_vigilancia" name="fotos_vigilancia[]" class="form-control" accept=".jpg,.jpeg,.png" multiple onchange="previewMultipleImages(this, 'fotos_preview')">
                        <small class="form-text text-muted">Selecione múltiplas fotos. Tamanho máximo: 5MB por foto</small>
                        <div id="fotos_preview" class="mt-3 row"></div>
                    </div>
                </div>
                
                <!-- Observações -->
                <div class="col-md-12 mt-4">
                    <div class="form-group">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea id="observacoes" name="observacoes" class="form-control" rows="4" placeholder="Observações sobre a vigilância veicular"></textarea>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Salvar Vigilância
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

// Calcular KM percorrido automaticamente
document.getElementById("km_final").addEventListener("input", function() {
    const kmInicial = parseFloat(document.getElementById("km_inicial").value) || 0;
    const kmFinal = parseFloat(this.value) || 0;
    
    if (kmFinal > kmInicial) {
        const kmPercorrido = kmFinal - kmInicial;
        // Você pode adicionar um campo para mostrar o resultado ou apenas validar
        console.log("KM Percorrido:", kmPercorrido);
    }
});

// Validar data/hora fim maior que início
document.getElementById("data_hora_fim").addEventListener("change", function() {
    const dataInicio = document.getElementById("data_hora_inicio").value;
    const dataFim = this.value;
    
    if (dataInicio && dataFim && dataFim < dataInicio) {
        alert("A data/hora fim não pode ser anterior à data/hora início");
        this.value = "";
    }
});
</script>
';

include 'views/layout.php';
?>

