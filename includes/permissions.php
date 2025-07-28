<?php
// Arquivo de verificação de permissões

function checkAdminPermission() {
    if (!isset($_SESSION['user_level']) || $_SESSION['user_level'] !== 'admin') {
        flash_message('Acesso negado. Apenas administradores podem realizar esta ação.', 'error');
        redirect('index.php?page=dashboard');
    }
}

function checkUserPermission() {
    if (!isset($_SESSION['user_id'])) {
        flash_message('Acesso negado. Faça login para continuar.', 'error');
        redirect('index.php?page=login');
    }
}

function canDelete() {
    return isset($_SESSION['user_level']) && $_SESSION['user_level'] === 'admin';
}

function canEdit() {
    return isset($_SESSION['user_id']); // Todos os usuários logados podem editar
}

function canCreate() {
    return isset($_SESSION['user_id']); // Todos os usuários logados podem criar
}

function canView() {
    return isset($_SESSION['user_id']); // Todos os usuários logados podem visualizar
}

function getUserLevelText() {
    if (!isset($_SESSION['user_level'])) {
        return 'Não logado';
    }
    
    return $_SESSION['user_level'] === 'admin' ? 'Administrador' : 'Usuário Comum';
}

function showDeleteButton() {
    return canDelete();
}

function showAdminOnlyContent() {
    return isset($_SESSION['user_level']) && $_SESSION['user_level'] === 'admin';
}

// Middleware para verificar permissões em ações específicas
function checkActionPermission($action) {
    switch ($action) {
        case 'delete':
            if (!canDelete()) {
                flash_message('Acesso negado. Apenas administradores podem excluir registros.', 'error');
                return false;
            }
            break;
            
        case 'edit':
        case 'update':
            if (!canEdit()) {
                flash_message('Acesso negado. Você não tem permissão para editar.', 'error');
                return false;
            }
            break;
            
        case 'create':
        case 'store':
            if (!canCreate()) {
                flash_message('Acesso negado. Você não tem permissão para criar registros.', 'error');
                return false;
            }
            break;
            
        case 'view':
        case 'show':
            if (!canView()) {
                flash_message('Acesso negado. Você não tem permissão para visualizar.', 'error');
                return false;
            }
            break;
    }
    
    return true;
}

// Função para log de ações com base no nível do usuário
function logUserAction($action, $table, $record_id = null, $details = null) {
    if (!isset($_SESSION['user_id'])) {
        return;
    }
    
    try {
        $database = new Database();
        $conn = $database->getConnection();
        
        $query = "INSERT INTO logs_sistema (usuario_id, acao, tabela_afetada, registro_id, detalhes, ip_address, user_agent) 
                  VALUES (:usuario_id, :acao, :tabela, :registro_id, :detalhes, :ip, :user_agent)";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':usuario_id', $_SESSION['user_id']);
        $stmt->bindParam(':acao', $action);
        $stmt->bindParam(':tabela', $table);
        $stmt->bindParam(':registro_id', $record_id);
        $stmt->bindParam(':detalhes', $details);
        $stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
        $stmt->bindParam(':user_agent', $_SERVER['HTTP_USER_AGENT']);
        
        $stmt->execute();
    } catch (Exception $e) {
        // Log error silently
        error_log("Erro ao registrar log: " . $e->getMessage());
    }
}

// Função para verificar se o usuário pode acessar uma página específica
function checkPagePermission($page) {
    $adminOnlyPages = ['usuarios', 'configuracoes'];
    
    if (in_array($page, $adminOnlyPages) && !showAdminOnlyContent()) {
        flash_message('Acesso negado. Esta página é restrita a administradores.', 'error');
        redirect('index.php?page=dashboard');
    }
}
?>

