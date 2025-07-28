<?php
$page_title = 'Dashboard';
$page = 'dashboard';

ob_start();
?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?php echo $stats['total_atendimentos']; ?></div>
        <div class="stat-label">Total de Atendimentos</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-number"><?php echo $stats['atendimentos_andamento']; ?></div>
        <div class="stat-label">Em Andamento</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-number"><?php echo $stats['total_ocorrencias']; ?></div>
        <div class="stat-label">Ocorrências Veiculares</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-number"><?php echo $stats['total_vigilancia']; ?></div>
        <div class="stat-label">Vigilância Veicular</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-number"><?php echo $stats['total_prestadores']; ?></div>
        <div class="stat-label">Prestadores</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-number"><?php echo $stats['total_clientes']; ?></div>
        <div class="stat-label">Clientes</div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Atendimentos por Mês</h3>
            </div>
            <div class="card-body">
                <canvas id="atendimentosChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ações Rápidas</h3>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="index.php?page=atendimentos&action=create" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Novo Atendimento
                    </a>
                    <a href="index.php?page=ocorrencias&action=create" class="btn btn-warning">
                        <i class="fas fa-car-crash"></i> Nova Ocorrência
                    </a>
                    <a href="index.php?page=vigilancia&action=create" class="btn btn-info">
                        <i class="fas fa-video"></i> Nova Vigilância
                    </a>
                    <a href="index.php?page=relatorios" class="btn btn-success">
                        <i class="fas fa-chart-bar"></i> Relatórios
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Últimas Atividades</h3>
            </div>
            <div class="card-body">
                <div class="activity-list">
                    <div class="activity-item">
                        <i class="fas fa-plus text-success"></i>
                        <span>Novo atendimento criado</span>
                        <small class="text-muted">há 2 horas</small>
                    </div>
                    <div class="activity-item">
                        <i class="fas fa-edit text-warning"></i>
                        <span>Ocorrência atualizada</span>
                        <small class="text-muted">há 4 horas</small>
                    </div>
                    <div class="activity-item">
                        <i class="fas fa-check text-info"></i>
                        <span>Vigilância finalizada</span>
                        <small class="text-muted">há 6 horas</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Atendimentos Recentes</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Solicitante</th>
                                <th>Status</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#001</td>
                                <td>João Silva</td>
                                <td><span class="badge bg-warning">Em andamento</span></td>
                                <td>25/01/2024</td>
                            </tr>
                            <tr>
                                <td>#002</td>
                                <td>Maria Santos</td>
                                <td><span class="badge bg-success">Finalizado</span></td>
                                <td>24/01/2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Mapa de Atendimentos</h3>
            </div>
            <div class="card-body">
                <div id="map" style="height: 300px; background: var(--bg-tertiary); border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                    <span class="text-muted">Mapa de localização dos atendimentos</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

$extra_js = '
<script>
// Gráfico de atendimentos por mês
const ctx = document.getElementById("atendimentosChart").getContext("2d");
const atendimentosChart = new Chart(ctx, {
    type: "line",
    data: {
        labels: [' . implode(',', array_map(function($item) { return '"' . date('M/Y', strtotime($item['mes'] . '-01')) . '"'; }, $stats['atendimentos_mes'])) . '],
        datasets: [{
            label: "Atendimentos",
            data: [' . implode(',', array_column($stats['atendimentos_mes'], 'total')) . '],
            borderColor: "rgb(0, 123, 255)",
            backgroundColor: "rgba(0, 123, 255, 0.1)",
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
';

include 'views/layout.php';
?>

