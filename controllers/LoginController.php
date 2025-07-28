<?php
require_once 'includes/functions.php';

class LoginController {
    
    public function index() {
        // Se já estiver logado, redirecionar para dashboard
        if (isset($_SESSION['user_id'])) {
            redirect('index.php?page=dashboard');
        }
        
        include 'views/login.php';
    }
    
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = sanitize_input($_POST['email']);
            $senha = $_POST['senha'];
            
            if (empty($email) || empty($senha)) {
                flash_message('Email e senha são obrigatórios', 'error');
                redirect('index.php?page=login');
            }
            
            $usuario = new Usuario();
            
            if ($usuario->login($email, $senha)) {
                $_SESSION['user_id'] = $usuario->id;
                $_SESSION['user_name'] = $usuario->nome;
                $_SESSION['user_email'] = $usuario->email;
                $_SESSION['user_level'] = $usuario->nivel;
                
                // Log da ação
                $this->logAction('login', 'usuarios', $usuario->id);
                
                flash_message('Login realizado com sucesso!', 'success');
                redirect('index.php?page=dashboard');
            } else {
                flash_message('Email ou senha incorretos', 'error');
                redirect('index.php?page=login');
            }
        }
    }
    
    public function logout() {
        // Log da ação
        if (isset($_SESSION['user_id'])) {
            $this->logAction('logout', 'usuarios', $_SESSION['user_id']);
        }
        
        session_destroy();
        flash_message('Logout realizado com sucesso!', 'success');
        redirect('index.php?page=login');
    }
    
    private function logAction($acao, $tabela, $registro_id) {
        try {
            $database = new Database();
            $conn = $database->getConnection();
            
            $query = "INSERT INTO logs_sistema (usuario_id, acao, tabela_afetada, registro_id, ip_address, user_agent) 
                      VALUES (:usuario_id, :acao, :tabela, :registro_id, :ip, :user_agent)";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':usuario_id', $_SESSION['user_id']);
            $stmt->bindParam(':acao', $acao);
            $stmt->bindParam(':tabela', $tabela);
            $stmt->bindParam(':registro_id', $registro_id);
            $stmt->bindParam(':ip', $_SERVER['REMOTE_ADDR']);
            $stmt->bindParam(':user_agent', $_SERVER['HTTP_USER_AGENT']);
            
            $stmt->execute();
        } catch (Exception $e) {
            // Log error silently
        }
    }
}
?>

