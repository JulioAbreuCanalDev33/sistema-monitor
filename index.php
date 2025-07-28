<?php
session_start();

// Autoload das classes
spl_autoload_register(function ($class_name) {
    $directories = ['controllers', 'models', 'config', 'includes'];
    
    foreach ($directories as $directory) {
        $file = __DIR__ . '/' . $directory . '/' . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Configurações gerais
define('BASE_URL', 'http://localhost/sistema_monitoramento/');
define('UPLOAD_PATH', __DIR__ . '/assets/uploads/');

    // Incluir funções (que já inclui o logger)
    require_once 'includes/functions.php';
    
    // Log de acesso à página
    if (isset($_GET['page'])) {
        log_page_access($_GET['page'], $_GET['action'] ?? 'index');
    }
    
    require_once 'includes/permissions.php';

// Roteamento simples
$page = isset($_GET['page']) ? $_GET['page'] : 'login';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Verificar se usuário está logado (exceto para login)
if ($page !== 'login' && !isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

// Verificar permissões de página (se logado)
if (isset($_SESSION['user_id'])) {
    checkPagePermission($page);
}

// Incluir o controlador apropriado
$controller_file = "controllers/" . ucfirst($page) . "Controller.php";

if (file_exists($controller_file)) {
    require_once $controller_file;
    $controller_class = ucfirst($page) . "Controller";
    
    if (class_exists($controller_class)) {
        $controller = new $controller_class();
        
        // Verificar permissões de ação
        if (isset($_SESSION['user_id']) && !checkActionPermission($action)) {
            redirect('index.php?page=' . $page);
        }
        
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            $controller->index();
        }
    } else {
        include 'views/404.php';
    }
} else {
    include 'views/404.php';
}
?>

