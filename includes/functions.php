<?php
// Incluir arquivo de upload e logger
require_once __DIR__ . '/upload.php';
require_once __DIR__ . '/logger.php';

/**
 * Sanitizar entrada de dados
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Gerar token CSRF
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verificar token CSRF
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Redirecionar para uma URL
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Exibir mensagem flash
 */
function flash_message($message, $type = 'info') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

/**
 * Obter e limpar mensagem flash
 */
function get_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'] ?? 'info';
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

/**
 * Formatar data para exibição
 */
function format_date($date, $format = 'd/m/Y H:i') {
    if (!$date) return '-';
    return date($format, strtotime($date));
}

/**
 * Validar CPF
 */
function validate_cpf($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
    if (strlen($cpf) != 11) {
        return false;
    }
    
    // Verificar se todos os dígitos são iguais
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    
    // Validar primeiro dígito verificador
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    
    return true;
}

/**
 * Validar CNPJ
 */
function validate_cnpj($cnpj) {
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
    
    if (strlen($cnpj) != 14) {
        return false;
    }
    
    // Verificar se todos os dígitos são iguais
    if (preg_match('/(\d)\1{13}/', $cnpj)) {
        return false;
    }
    
    // Validar primeiro dígito verificador
    $length = strlen($cnpj) - 2;
    $numbers = substr($cnpj, 0, $length);
    $digits = substr($cnpj, $length);
    $sum = 0;
    $pos = $length - 7;
    
    for ($i = $length; $i >= 1; $i--) {
        $sum += $numbers[$length - $i] * $pos--;
        if ($pos < 2) {
            $pos = 9;
        }
    }
    
    $result = $sum % 11 < 2 ? 0 : 11 - $sum % 11;
    if ($result != $digits[0]) {
        return false;
    }
    
    // Validar segundo dígito verificador
    $length = $length + 1;
    $numbers = substr($cnpj, 0, $length);
    $sum = 0;
    $pos = $length - 7;
    
    for ($i = $length; $i >= 1; $i--) {
        $sum += $numbers[$length - $i] * $pos--;
        if ($pos < 2) {
            $pos = 9;
        }
    }
    
    $result = $sum % 11 < 2 ? 0 : 11 - $sum % 11;
    if ($result != $digits[1]) {
        return false;
    }
    
    return true;
}

/**
 * Gerar senha aleatória
 */
function generate_password($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    return $randomString;
}

/**
 * Verificar se usuário tem permissão
 */
function has_permission($required_level) {
    if (!isset($_SESSION['user_level'])) {
        return false;
    }
    
    $user_level = $_SESSION['user_level'];
    
    if ($required_level === 'admin' && $user_level !== 'admin') {
        return false;
    }
    
    return true;
}

/**
 * Calcular idade
 */
function calculate_age($birthdate) {
    $today = new DateTime();
    $birth = new DateTime($birthdate);
    $age = $today->diff($birth);
    return $age->y;
}

/**
 * Formatar telefone
 */
function format_phone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    if (strlen($phone) == 11) {
        return '(' . substr($phone, 0, 2) . ') ' . substr($phone, 2, 5) . '-' . substr($phone, 7);
    } elseif (strlen($phone) == 10) {
        return '(' . substr($phone, 0, 2) . ') ' . substr($phone, 2, 4) . '-' . substr($phone, 6);
    }
    
    return $phone;
}

/**
 * Formatar CPF
 */
function format_cpf($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
    if (strlen($cpf) == 11) {
        return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    }
    
    return $cpf;
}

/**
 * Formatar CNPJ
 */
function format_cnpj($cnpj) {
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
    
    if (strlen($cnpj) == 14) {
        return substr($cnpj, 0, 2) . '.' . substr($cnpj, 2, 3) . '.' . substr($cnpj, 5, 3) . '/' . substr($cnpj, 8, 4) . '-' . substr($cnpj, 12, 2);
    }
    
    return $cnpj;
}

/**
 * Formatar CEP
 */
function format_cep($cep) {
    $cep = preg_replace('/[^0-9]/', '', $cep);
    
    if (strlen($cep) == 8) {
        return substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
    }
    
    return $cep;
}

/**
 * Verificar se string é JSON válido
 */
function is_json($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

/**
 * Log de atividades
 */
function log_activity($action, $details = '') {
    if (!isset($_SESSION['user_id'])) {
        return;
    }
    
    $log_file = __DIR__ . '/../logs/activity.log';
    $log_dir = dirname($log_file);
    
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'] ?? 'Unknown';
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    
    $log_entry = "[$timestamp] User: $user_name (ID: $user_id) | IP: $ip | Action: $action | Details: $details" . PHP_EOL;
    
    file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
}
?>

