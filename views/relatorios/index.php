<?php
$page_title = 'Relatórios';
$page = 'relatorios';

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Relatórios</h2>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Gerar Relatórios</h3>
            </div>
            
            <div class="card-body">
                <form method="POST" action="index.php?page=relatorios&action=generate" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tipo_relatorio" class="form-label">Tipo de Relatório *</label>
                                <select id="tipo_relatorio" name="tipo_relatorio" class="form-control form-select" required>
                                    <option value="">Selecione...</option>
                                    <option value="atendimentos">Atendimentos Patrimoniais</option>
                                    <option value="ocorrencias_veiculares">Ocorrências Veiculares</option>
                                    <option value="vigilancia_veicular">Vigilância Veicular</option>
                                    <option value="prestadores">Prestadores</option>
                                    <option value="clientes">Clientes</option>
                                    <option value="agentes">Agentes</option>
                                </select>
                                <div class="invalid-feedback">Por favor, selecione o tipo de relatório.</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="formato" class="form-label">Formato *</label>
                                <select id="formato" name="formato" class="form-control form-select" required>
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel (XLSX)</option>
                                </select>
                                <div class="invalid-feedback">Por favor, selecione o formato.</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="data_inicio" class="form-label">Data Início</label>
                                <input type="date" id="data_inicio" name="data_inicio" class="form-control">
                                <small class="form-text text-muted">Deixe em branco para incluir todos os registros</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="data_fim" class="form-label">Data Fim</label>
                                <input type="date" id="data_fim" name="data_fim" class="form-control">
                                <small class="form-text text-muted">Deixe em branco para incluir todos os registros</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-file-download"></i> Gerar Relatório
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Relatórios Disponíveis</h3>
            </div>
            
            <div class="card-body">
                <div class="list-group">
                    <div class="list-group-item">
                        <h6 class="mb-1">Atendimentos Patrimoniais</h6>
                        <p class="mb-1">Relatório completo de todos os atendimentos patrimoniais com detalhes de clientes, agentes e status.</p>
                        <small class="text-muted">Formatos: PDF, Excel</small>
                    </div>
                    
                    <div class="list-group-item">
                        <h6 class="mb-1">Ocorrências Veiculares</h6>
                        <p class="mb-1">Relatório de ocorrências veiculares com informações de prestadores, valores e localização.</p>
                        <small class="text-muted">Formatos: PDF</small>
                    </div>
                    
                    <div class="list-group-item">
                        <h6 class="mb-1">Vigilância Veicular</h6>
                        <p class="mb-1">Relatório de monitoramento veicular com dados de veículos e condutores.</p>
                        <small class="text-muted">Em desenvolvimento</small>
                    </div>
                    
                    <div class="list-group-item">
                        <h6 class="mb-1">Prestadores</h6>
                        <p class="mb-1">Lista completa de prestadores com dados pessoais, bancários e de contato.</p>
                        <small class="text-muted">Em desenvolvimento</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Estatísticas Rápidas</h3>
            </div>
            
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="stat-item">
                            <h4 class="text-primary" id="total-atendimentos">-</h4>
                            <small>Atendimentos</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-item">
                            <h4 class="text-warning" id="total-ocorrencias">-</h4>
                            <small>Ocorrências</small>
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="stat-item">
                            <h4 class="text-success" id="total-prestadores">-</h4>
                            <small>Prestadores</small>
                        </div>
                    </div>
                    <div class="col-6 mt-3">
                        <div class="stat-item">
                            <h4 class="text-info" id="total-clientes">-</h4>
                            <small>Clientes</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

$extra_js = '
<script>
// Carregar estatísticas via AJAX
fetch("index.php?page=relatorios&action=dashboard_data")
    .then(response => response.json())
    .then(data => {
        document.getElementById("total-atendimentos").textContent = data.total_atendimentos;
        document.getElementById("total-ocorrencias").textContent = data.total_ocorrencias;
        document.getElementById("total-prestadores").textContent = data.total_prestadores;
        document.getElementById("total-clientes").textContent = data.total_clientes;
    })
    .catch(error => console.log("Erro ao carregar estatísticas:", error));

// Validar datas
document.getElementById("data_fim").addEventListener("change", function() {
    const dataInicio = document.getElementById("data_inicio").value;
    const dataFim = this.value;
    
    if (dataInicio && dataFim && dataFim < dataInicio) {
        alert("A data fim não pode ser anterior à data início");
        this.value = "";
    }
});
</script>
';

include 'views/layout.php';
?>

