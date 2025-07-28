<?php
$page_title = 'Logs do Sistema';
$page = 'logs';

// Verificar se é admin
if ($_SESSION['user_level'] !== 'admin') {
    header('Location: index.php?page=dashboard');
    exit;
}

require_once 'includes/logger.php';

// Parâmetros de filtro
$level = $_GET['level'] ?? '';
$user_id = $_GET['user_id'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';
$limit = (int)($_GET['limit'] ?? 100);

// Obter logs
$logs = $logger->readLogs($limit, $level, $user_id, $date_from, $date_to);

// Obter estatísticas
$stats = $logger->getLogStats(7);

ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="fas fa-file-alt"></i> Logs do Sistema</h2>
    <div>
        <button class="btn btn-warning" onclick="cleanOldLogs()">
            <i class="fas fa-broom"></i> Limpar Logs Antigos
        </button>
        <button class="btn btn-info" onclick="exportLogs()">
            <i class="fas fa-download"></i> Exportar Logs
        </button>
    </div>
</div>

<!-- Estatísticas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo number_format($stats['total']); ?></h4>
                        <p class="mb-0">Total de Logs (7 dias)</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-list fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo ($stats['by_level']['ERROR'] ?? 0) + ($stats['by_level']['CRITICAL'] ?? 0); ?></h4>
                        <p class="mb-0">Erros</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo $stats['by_level']['WARNING'] ?? 0; ?></h4>
                        <p class="mb-0">Avisos</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4><?php echo $stats['by_level']['INFO'] ?? 0; ?></h4>
                        <p class="mb-0">Informações</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-info fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title">Filtros</h3>
    </div>
    
    <div class="card-body">
        <form method="GET" class="row g-3">
            <input type="hidden" name="page" value="logs">
            
            <div class="col-md-2">
                <label for="level" class="form-label">Nível</label>
                <select id="level" name="level" class="form-control form-select">
                    <option value="">Todos</option>
                    <option value="INFO" <?php echo $level == 'INFO' ? 'selected' : ''; ?>>INFO</option>
                    <option value="WARNING" <?php echo $level == 'WARNING' ? 'selected' : ''; ?>>WARNING</option>
                    <option value="ERROR" <?php echo $level == 'ERROR' ? 'selected' : ''; ?>>ERROR</option>
                    <option value="CRITICAL" <?php echo $level == 'CRITICAL' ? 'selected' : ''; ?>>CRITICAL</option>
                    <option value="DEBUG" <?php echo $level == 'DEBUG' ? 'selected' : ''; ?>>DEBUG</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label for="user_id" class="form-label">Usuário</label>
                <input type="number" id="user_id" name="user_id" class="form-control" value="<?php echo htmlspecialchars($user_id); ?>" placeholder="ID do usuário">
            </div>
            
            <div class="col-md-2">
                <label for="date_from" class="form-label">Data Inicial</label>
                <input type="datetime-local" id="date_from" name="date_from" class="form-control" value="<?php echo $date_from; ?>">
            </div>
            
            <div class="col-md-2">
                <label for="date_to" class="form-label">Data Final</label>
                <input type="datetime-local" id="date_to" name="date_to" class="form-control" value="<?php echo $date_to; ?>">
            </div>
            
            <div class="col-md-2">
                <label for="limit" class="form-label">Limite</label>
                <select id="limit" name="limit" class="form-control form-select">
                    <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
                    <option value="100" <?php echo $limit == 100 ? 'selected' : ''; ?>>100</option>
                    <option value="500" <?php echo $limit == 500 ? 'selected' : ''; ?>>500</option>
                    <option value="1000" <?php echo $limit == 1000 ? 'selected' : ''; ?>>1000</option>
                </select>
            </div>
            
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <a href="index.php?page=logs" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Limpar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Lista de Logs -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Registros de Log (<?php echo count($logs); ?> registros)</h3>
    </div>
    
    <div class="card-body">
        <?php if (empty($logs)): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Nenhum log encontrado com os filtros aplicados.
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Data/Hora</th>
                        <th>Nível</th>
                        <th>Usuário</th>
                        <th>Ação</th>
                        <th>Detalhes</th>
                        <th>IP</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                    <tr>
                        <td>
                            <small><?php echo date('d/m/Y H:i:s', strtotime($log['timestamp'])); ?></small>
                        </td>
                        <td>
                            <?php
                            $badge_class = '';
                            switch ($log['level']) {
                                case 'INFO':
                                    $badge_class = 'bg-success';
                                    break;
                                case 'WARNING':
                                    $badge_class = 'bg-warning';
                                    break;
                                case 'ERROR':
                                    $badge_class = 'bg-danger';
                                    break;
                                case 'CRITICAL':
                                    $badge_class = 'bg-dark';
                                    break;
                                case 'DEBUG':
                                    $badge_class = 'bg-secondary';
                                    break;
                                default:
                                    $badge_class = 'bg-primary';
                            }
                            ?>
                            <span class="badge <?php echo $badge_class; ?>">
                                <?php echo $log['level']; ?>
                            </span>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($log['user_name']); ?></strong>
                            <br>
                            <small class="text-muted"><?php echo htmlspecialchars($log['user_level']); ?></small>
                        </td>
                        <td>
                            <code><?php echo htmlspecialchars($log['action']); ?></code>
                        </td>
                        <td>
                            <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis;">
                                <?php echo htmlspecialchars($log['details']); ?>
                            </div>
                        </td>
                        <td>
                            <small><?php echo htmlspecialchars($log['ip']); ?></small>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="showLogDetails(<?php echo htmlspecialchars(json_encode($log)); ?>)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Erros Recentes -->
<?php if (!empty($stats['recent_errors'])): ?>
<div class="card mt-4">
    <div class="card-header bg-danger text-white">
        <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> Erros Recentes</h3>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Data/Hora</th>
                        <th>Nível</th>
                        <th>Usuário</th>
                        <th>Ação</th>
                        <th>Detalhes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats['recent_errors'] as $error): ?>
                    <tr>
                        <td><small><?php echo date('d/m/Y H:i:s', strtotime($error['timestamp'])); ?></small></td>
                        <td>
                            <span class="badge <?php echo $error['level'] == 'CRITICAL' ? 'bg-dark' : 'bg-danger'; ?>">
                                <?php echo $error['level']; ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($error['user_name']); ?></td>
                        <td><code><?php echo htmlspecialchars($error['action']); ?></code></td>
                        <td><?php echo htmlspecialchars(substr($error['details'], 0, 100)); ?><?php echo strlen($error['details']) > 100 ? '...' : ''; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Modal de Detalhes do Log -->
<div class="modal fade" id="logDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes do Log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="logDetailsContent"></div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();

$extra_js = '
<script>
function showLogDetails(log) {
    let content = `
        <div class="row">
            <div class="col-md-6">
                <strong>Data/Hora:</strong><br>
                ${log.timestamp}<br><br>
                
                <strong>Nível:</strong><br>
                <span class="badge bg-${getLevelColor(log.level)}">${log.level}</span><br><br>
                
                <strong>Usuário:</strong><br>
                ${log.user_name} (ID: ${log.user_id})<br>
                Nível: ${log.user_level}<br><br>
                
                <strong>IP:</strong><br>
                ${log.ip}<br><br>
            </div>
            <div class="col-md-6">
                <strong>Ação:</strong><br>
                <code>${log.action}</code><br><br>
                
                <strong>URI:</strong><br>
                ${log.request_method} ${log.request_uri}<br><br>
                
                <strong>User Agent:</strong><br>
                <small>${log.user_agent}</small><br><br>
            </div>
            <div class="col-md-12">
                <strong>Detalhes:</strong><br>
                <pre class="bg-light p-2 rounded">${log.details}</pre>
            </div>
        </div>
    `;
    
    document.getElementById("logDetailsContent").innerHTML = content;
    new bootstrap.Modal(document.getElementById("logDetailsModal")).show();
}

function getLevelColor(level) {
    switch(level) {
        case "INFO": return "success";
        case "WARNING": return "warning";
        case "ERROR": return "danger";
        case "CRITICAL": return "dark";
        case "DEBUG": return "secondary";
        default: return "primary";
    }
}

function cleanOldLogs() {
    if (confirm("Tem certeza que deseja limpar logs antigos (mais de 30 dias)?")) {
        // Implementar via AJAX
        fetch("index.php?page=logs&action=clean", {
            method: "POST"
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert("success", `${data.removed} logs antigos foram removidos.`);
                location.reload();
            } else {
                showAlert("danger", "Erro ao limpar logs: " + data.message);
            }
        });
    }
}

function exportLogs() {
    const params = new URLSearchParams(window.location.search);
    params.set("action", "export");
    window.open("index.php?" + params.toString());
}

// Auto-refresh a cada 30 segundos
setInterval(function() {
    if (document.getElementById("auto-refresh") && document.getElementById("auto-refresh").checked) {
        location.reload();
    }
}, 30000);
</script>
';

include 'views/layout.php';
?>

