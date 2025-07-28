<?php
/**
 * Sistema de Logs Avançado
 * Registra todas as atividades do sistema
 */

class Logger {
    private $log_dir;
    private $log_file;
    private $max_file_size;
    private $max_files;
    
    public function __construct() {
        $this->log_dir = __DIR__ . '/../logs/';
        $this->log_file = $this->log_dir . 'system.log';
        $this->max_file_size = 10 * 1024 * 1024; // 10MB
        $this->max_files = 10;
        
        // Criar diretório se não existir
        if (!is_dir($this->log_dir)) {
            mkdir($this->log_dir, 0755, true);
        }
    }
    
    /**
     * Registrar atividade no log
     */
    public function log($level, $action, $details = '', $user_id = null, $ip = null) {
        // Obter informações da sessão se não fornecidas
        if ($user_id === null && isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }
        
        if ($ip === null) {
            $ip = $this->getClientIP();
        }
        
        // Preparar dados do log
        $timestamp = date('Y-m-d H:i:s');
        $user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Sistema';
        $user_level = isset($_SESSION['user_level']) ? $_SESSION['user_level'] : 'N/A';
        
        // Formatar entrada do log
        $log_entry = [
            'timestamp' => $timestamp,
            'level' => strtoupper($level),
            'user_id' => $user_id ?: 0,
            'user_name' => $user_name,
            'user_level' => $user_level,
            'ip' => $ip,
            'action' => $action,
            'details' => $details,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
            'request_uri' => $_SERVER['REQUEST_URI'] ?? '',
            'request_method' => $_SERVER['REQUEST_METHOD'] ?? ''
        ];
        
        // Converter para JSON para facilitar parsing
        $json_entry = json_encode($log_entry, JSON_UNESCAPED_UNICODE);
        $formatted_entry = "[$timestamp] $json_entry" . PHP_EOL;
        
        // Verificar rotação de logs
        $this->rotateLogIfNeeded();
        
        // Escrever no arquivo
        file_put_contents($this->log_file, $formatted_entry, FILE_APPEND | LOCK_EX);
        
        // Log crítico também vai para arquivo separado
        if ($level === 'CRITICAL' || $level === 'ERROR') {
            $error_file = $this->log_dir . 'errors.log';
            file_put_contents($error_file, $formatted_entry, FILE_APPEND | LOCK_EX);
        }
    }
    
    /**
     * Logs de diferentes níveis
     */
    public function info($action, $details = '') {
        $this->log('INFO', $action, $details);
    }
    
    public function warning($action, $details = '') {
        $this->log('WARNING', $action, $details);
    }
    
    public function error($action, $details = '') {
        $this->log('ERROR', $action, $details);
    }
    
    public function critical($action, $details = '') {
        $this->log('CRITICAL', $action, $details);
    }
    
    public function debug($action, $details = '') {
        if (defined('DEBUG_MODE') && DEBUG_MODE) {
            $this->log('DEBUG', $action, $details);
        }
    }
    
    /**
     * Log de login/logout
     */
    public function logAuth($action, $email, $success = true, $details = '') {
        $level = $success ? 'INFO' : 'WARNING';
        $this->log($level, $action, "Email: $email | $details");
    }
    
    /**
     * Log de operações CRUD
     */
    public function logCrud($operation, $table, $record_id, $details = '') {
        $this->info("CRUD_$operation", "Tabela: $table | ID: $record_id | $details");
    }
    
    /**
     * Log de upload de arquivos
     */
    public function logUpload($filename, $size, $success = true, $details = '') {
        $level = $success ? 'INFO' : 'ERROR';
        $action = $success ? 'UPLOAD_SUCCESS' : 'UPLOAD_FAILED';
        $this->log($level, $action, "Arquivo: $filename | Tamanho: $size bytes | $details");
    }
    
    /**
     * Log de acesso a páginas
     */
    public function logPageAccess($page, $action = 'view') {
        $this->info('PAGE_ACCESS', "Página: $page | Ação: $action");
    }
    
    /**
     * Log de tentativas de acesso negado
     */
    public function logAccessDenied($resource, $reason = '') {
        $this->warning('ACCESS_DENIED', "Recurso: $resource | Motivo: $reason");
    }
    
    /**
     * Obter IP do cliente
     */
    private function getClientIP() {
        $ip_keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
        
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    }
    
    /**
     * Rotacionar logs quando necessário
     */
    private function rotateLogIfNeeded() {
        if (!file_exists($this->log_file)) {
            return;
        }
        
        if (filesize($this->log_file) > $this->max_file_size) {
            // Mover arquivos existentes
            for ($i = $this->max_files - 1; $i > 0; $i--) {
                $old_file = $this->log_dir . "system.log.$i";
                $new_file = $this->log_dir . "system.log." . ($i + 1);
                
                if (file_exists($old_file)) {
                    if ($i == $this->max_files - 1) {
                        unlink($old_file); // Remover o mais antigo
                    } else {
                        rename($old_file, $new_file);
                    }
                }
            }
            
            // Mover arquivo atual
            rename($this->log_file, $this->log_dir . 'system.log.1');
        }
    }
    
    /**
     * Ler logs com filtros
     */
    public function readLogs($limit = 100, $level = null, $user_id = null, $date_from = null, $date_to = null) {
        if (!file_exists($this->log_file)) {
            return [];
        }
        
        $lines = file($this->log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $logs = [];
        
        // Processar linhas (mais recentes primeiro)
        $lines = array_reverse($lines);
        
        foreach ($lines as $line) {
            if (count($logs) >= $limit) {
                break;
            }
            
            // Extrair JSON da linha
            if (preg_match('/\[(.*?)\] (.+)/', $line, $matches)) {
                $timestamp = $matches[1];
                $json_data = $matches[2];
                
                $log_data = json_decode($json_data, true);
                if ($log_data) {
                    // Aplicar filtros
                    if ($level && $log_data['level'] !== strtoupper($level)) {
                        continue;
                    }
                    
                    if ($user_id && $log_data['user_id'] != $user_id) {
                        continue;
                    }
                    
                    if ($date_from && $timestamp < $date_from) {
                        continue;
                    }
                    
                    if ($date_to && $timestamp > $date_to) {
                        continue;
                    }
                    
                    $logs[] = $log_data;
                }
            }
        }
        
        return $logs;
    }
    
    /**
     * Obter estatísticas dos logs
     */
    public function getLogStats($days = 7) {
        $date_from = date('Y-m-d H:i:s', strtotime("-$days days"));
        $logs = $this->readLogs(10000, null, null, $date_from);
        
        $stats = [
            'total' => count($logs),
            'by_level' => [],
            'by_user' => [],
            'by_action' => [],
            'recent_errors' => []
        ];
        
        foreach ($logs as $log) {
            // Por nível
            $level = $log['level'];
            $stats['by_level'][$level] = ($stats['by_level'][$level] ?? 0) + 1;
            
            // Por usuário
            $user = $log['user_name'];
            $stats['by_user'][$user] = ($stats['by_user'][$user] ?? 0) + 1;
            
            // Por ação
            $action = $log['action'];
            $stats['by_action'][$action] = ($stats['by_action'][$action] ?? 0) + 1;
            
            // Erros recentes
            if (in_array($level, ['ERROR', 'CRITICAL']) && count($stats['recent_errors']) < 10) {
                $stats['recent_errors'][] = $log;
            }
        }
        
        return $stats;
    }
    
    /**
     * Limpar logs antigos
     */
    public function cleanOldLogs($days = 30) {
        $cutoff_date = date('Y-m-d H:i:s', strtotime("-$days days"));
        
        if (!file_exists($this->log_file)) {
            return 0;
        }
        
        $lines = file($this->log_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $kept_lines = [];
        $removed_count = 0;
        
        foreach ($lines as $line) {
            if (preg_match('/\[(.*?)\]/', $line, $matches)) {
                $timestamp = $matches[1];
                
                if ($timestamp >= $cutoff_date) {
                    $kept_lines[] = $line;
                } else {
                    $removed_count++;
                }
            }
        }
        
        // Reescrever arquivo com linhas mantidas
        file_put_contents($this->log_file, implode(PHP_EOL, $kept_lines) . PHP_EOL);
        
        return $removed_count;
    }
}

// Instância global do logger
$logger = new Logger();

/**
 * Funções auxiliares para logging
 */
function log_info($action, $details = '') {
    global $logger;
    $logger->info($action, $details);
}

function log_warning($action, $details = '') {
    global $logger;
    $logger->warning($action, $details);
}

function log_error($action, $details = '') {
    global $logger;
    $logger->error($action, $details);
}

function log_critical($action, $details = '') {
    global $logger;
    $logger->critical($action, $details);
}

function log_auth($action, $email, $success = true, $details = '') {
    global $logger;
    $logger->logAuth($action, $email, $success, $details);
}

function log_crud($operation, $table, $record_id, $details = '') {
    global $logger;
    $logger->logCrud($operation, $table, $record_id, $details);
}

function log_upload($filename, $size, $success = true, $details = '') {
    global $logger;
    $logger->logUpload($filename, $size, $success, $details);
}

function log_page_access($page, $action = 'view') {
    global $logger;
    $logger->logPageAccess($page, $action);
}

function log_access_denied($resource, $reason = '') {
    global $logger;
    $logger->logAccessDenied($resource, $reason);
}
?>

