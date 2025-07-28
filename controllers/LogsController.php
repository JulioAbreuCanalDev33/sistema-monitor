<?php
require_once 'includes/logger.php';

class LogsController {
    private $logger;
    
    public function __construct() {
        $this->logger = new Logger();
        
        // Verificar se é admin
        if ($_SESSION['user_level'] !== 'admin') {
            log_access_denied('logs', 'Usuário não é administrador');
            header('Location: index.php?page=dashboard');
            exit;
        }
    }
    
    public function index() {
        log_page_access('logs', 'index');
        include 'views/logs/index.php';
    }
    
    public function clean() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
            return;
        }
        
        try {
            $removed = $this->logger->cleanOldLogs(30);
            log_info('LOGS_CLEANED', "Removidos $removed logs antigos");
            
            echo json_encode([
                'success' => true,
                'removed' => $removed,
                'message' => "$removed logs antigos foram removidos"
            ]);
        } catch (Exception $e) {
            log_error('LOGS_CLEAN_ERROR', $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao limpar logs: ' . $e->getMessage()
            ]);
        }
    }
    
    public function export() {
        $level = $_GET['level'] ?? '';
        $user_id = $_GET['user_id'] ?? '';
        $date_from = $_GET['date_from'] ?? '';
        $date_to = $_GET['date_to'] ?? '';
        $limit = (int)($_GET['limit'] ?? 1000);
        
        try {
            $logs = $this->logger->readLogs($limit, $level, $user_id, $date_from, $date_to);
            
            // Preparar dados para CSV
            $filename = 'logs_' . date('Y-m-d_H-i-s') . '.csv';
            
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=' . $filename);
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Expires: 0');
            
            $output = fopen('php://output', 'w');
            
            // Cabeçalho CSV
            fputcsv($output, [
                'Data/Hora',
                'Nível',
                'ID Usuário',
                'Nome Usuário',
                'Nível Usuário',
                'IP',
                'Ação',
                'Detalhes',
                'User Agent',
                'URI',
                'Método'
            ]);
            
            // Dados
            foreach ($logs as $log) {
                fputcsv($output, [
                    $log['timestamp'],
                    $log['level'],
                    $log['user_id'],
                    $log['user_name'],
                    $log['user_level'],
                    $log['ip'],
                    $log['action'],
                    $log['details'],
                    $log['user_agent'],
                    $log['request_uri'],
                    $log['request_method']
                ]);
            }
            
            fclose($output);
            
            log_info('LOGS_EXPORTED', "Exportados " . count($logs) . " logs");
            
        } catch (Exception $e) {
            log_error('LOGS_EXPORT_ERROR', $e->getMessage());
            echo 'Erro ao exportar logs: ' . $e->getMessage();
        }
    }
    
    public function stats() {
        $days = (int)($_GET['days'] ?? 7);
        
        try {
            $stats = $this->logger->getLogStats($days);
            
            header('Content-Type: application/json');
            echo json_encode($stats);
            
        } catch (Exception $e) {
            log_error('LOGS_STATS_ERROR', $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    
    public function view() {
        $id = $_GET['id'] ?? '';
        
        if (empty($id)) {
            header('Location: index.php?page=logs');
            return;
        }
        
        // Implementar visualização de log específico se necessário
        log_page_access('logs', 'view');
        header('Location: index.php?page=logs');
    }
    
    /**
     * Método para testar o sistema de logs
     */
    public function test() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método não permitido']);
            return;
        }
        
        try {
            // Gerar logs de teste
            log_info('LOG_TEST', 'Teste de log INFO');
            log_warning('LOG_TEST', 'Teste de log WARNING');
            log_error('LOG_TEST', 'Teste de log ERROR');
            log_critical('LOG_TEST', 'Teste de log CRITICAL');
            
            // Log de autenticação
            log_auth('LOGIN_TEST', 'teste@exemplo.com', true, 'Login de teste');
            log_auth('LOGIN_TEST', 'teste@exemplo.com', false, 'Falha no login de teste');
            
            // Log de CRUD
            log_crud('CREATE', 'test_table', 123, 'Teste de criação');
            log_crud('UPDATE', 'test_table', 123, 'Teste de atualização');
            log_crud('DELETE', 'test_table', 123, 'Teste de exclusão');
            
            // Log de upload
            log_upload('test_file.jpg', 1024000, true, 'Upload de teste');
            log_upload('invalid_file.exe', 0, false, 'Tipo de arquivo inválido');
            
            // Log de acesso negado
            log_access_denied('admin_panel', 'Usuário sem permissão');
            
            echo json_encode([
                'success' => true,
                'message' => 'Logs de teste gerados com sucesso'
            ]);
            
        } catch (Exception $e) {
            log_error('LOG_TEST_ERROR', $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao gerar logs de teste: ' . $e->getMessage()
            ]);
        }
    }
}
?>

