<?php
require_once 'includes/functions.php';

class UsuariosController {
    
    public function index() {
        // Verificar se é admin
        if ($_SESSION['user_level'] !== 'admin') {
            flash_message('Acesso negado. Apenas administradores podem gerenciar usuários.', 'error');
            redirect('index.php?page=dashboard');
        }
        
        $usuario = new Usuario();
        $stmt = $usuario->read();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include 'views/usuarios/index.php';
    }
    
    public function create() {
        // Verificar se é admin
        if ($_SESSION['user_level'] !== 'admin') {
            flash_message('Acesso negado. Apenas administradores podem criar usuários.', 'error');
            redirect('index.php?page=dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = new Usuario();
            
            // Verificar se email já existe
            $usuario->email = sanitize_input($_POST['email']);
            
            if ($usuario->emailExists()) {
                flash_message('Email já cadastrado no sistema', 'error');
                redirect('index.php?page=usuarios&action=create');
            }
            
            // Preencher propriedades
            $usuario->nome = sanitize_input($_POST['nome']);
            $usuario->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $usuario->nivel = sanitize_input($_POST['nivel']);
            $usuario->status = sanitize_input($_POST['status']);
            
            if ($usuario->create()) {
                log_activity('Usuário criado', "Novo usuário: {$usuario->nome} ({$usuario->email})");
                flash_message('Usuário cadastrado com sucesso!', 'success');
                redirect('index.php?page=usuarios');
            } else {
                flash_message('Erro ao cadastrar usuário', 'error');
            }
        }
        
        include 'views/usuarios/create.php';
    }
    
    public function edit() {
        // Verificar se é admin ou se está editando próprio perfil
        $id = $_GET['id'] ?? 0;
        if ($_SESSION['user_level'] !== 'admin' && $_SESSION['user_id'] != $id) {
            flash_message('Acesso negado.', 'error');
            redirect('index.php?page=dashboard');
        }
        
        $usuario = new Usuario();
        $usuario->id = $id;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Verificar se email já existe (exceto o próprio registro)
            $usuario->email = sanitize_input($_POST['email']);
            
            if ($usuario->emailExists()) {
                flash_message('Email já cadastrado no sistema', 'error');
                redirect('index.php?page=usuarios&action=edit&id=' . $id);
            }
            
            // Preencher propriedades
            $usuario->nome = sanitize_input($_POST['nome']);
            
            // Só alterar senha se foi informada
            if (!empty($_POST['senha'])) {
                $usuario->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            }
            
            // Só admin pode alterar nível e status
            if ($_SESSION['user_level'] === 'admin') {
                $usuario->nivel = sanitize_input($_POST['nivel']);
                $usuario->status = sanitize_input($_POST['status']);
            }
            
            if ($usuario->update()) {
                log_activity('Usuário atualizado', "Usuário editado: {$usuario->nome} ({$usuario->email})");
                flash_message('Usuário atualizado com sucesso!', 'success');
                redirect('index.php?page=usuarios');
            } else {
                flash_message('Erro ao atualizar usuário', 'error');
            }
        }
        
        if (!$usuario->readOne()) {
            flash_message('Usuário não encontrado', 'error');
            redirect('index.php?page=usuarios');
        }
        
        include 'views/usuarios/edit.php';
    }
    
    public function delete() {
        // Verificar se é admin
        if ($_SESSION['user_level'] !== 'admin') {
            flash_message('Acesso negado. Apenas administradores podem excluir usuários.', 'error');
            redirect('index.php?page=usuarios');
        }
        
        $id = $_GET['id'] ?? 0;
        
        // Não permitir excluir próprio usuário
        if ($id == $_SESSION['user_id']) {
            flash_message('Você não pode excluir seu próprio usuário', 'error');
            redirect('index.php?page=usuarios');
        }
        
        $usuario = new Usuario();
        $usuario->id = $id;
        
        // Buscar dados do usuário para log
        if ($usuario->readOne()) {
            $nome_usuario = $usuario->nome;
            $email_usuario = $usuario->email;
            
            if ($usuario->delete()) {
                log_activity('Usuário excluído', "Usuário removido: {$nome_usuario} ({$email_usuario})");
                flash_message('Usuário excluído com sucesso!', 'success');
            } else {
                flash_message('Erro ao excluir usuário', 'error');
            }
        } else {
            flash_message('Usuário não encontrado', 'error');
        }
        
        redirect('index.php?page=usuarios');
    }
    
    public function view() {
        $id = $_GET['id'] ?? 0;
        
        // Verificar se é admin ou se está visualizando próprio perfil
        if ($_SESSION['user_level'] !== 'admin' && $_SESSION['user_id'] != $id) {
            flash_message('Acesso negado.', 'error');
            redirect('index.php?page=dashboard');
        }
        
        $usuario = new Usuario();
        $usuario->id = $id;
        
        if (!$usuario->readOne()) {
            flash_message('Usuário não encontrado', 'error');
            redirect('index.php?page=usuarios');
        }
        
        include 'views/usuarios/view.php';
    }
    
    public function perfil() {
        $id = $_SESSION['user_id'];
        $usuario = new Usuario();
        $usuario->id = $id;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Verificar se email já existe (exceto o próprio registro)
            $usuario->email = sanitize_input($_POST['email']);
            
            if ($usuario->emailExists()) {
                flash_message('Email já cadastrado no sistema', 'error');
                redirect('index.php?page=usuarios&action=perfil');
            }
            
            // Preencher propriedades
            $usuario->nome = sanitize_input($_POST['nome']);
            
            // Só alterar senha se foi informada
            if (!empty($_POST['senha'])) {
                $usuario->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            }
            
            if ($usuario->updateProfile()) {
                // Atualizar sessão
                $_SESSION['user_name'] = $usuario->nome;
                $_SESSION['user_email'] = $usuario->email;
                
                log_activity('Perfil atualizado', 'Usuário atualizou próprio perfil');
                flash_message('Perfil atualizado com sucesso!', 'success');
                redirect('index.php?page=usuarios&action=perfil');
            } else {
                flash_message('Erro ao atualizar perfil', 'error');
            }
        }
        
        if (!$usuario->readOne()) {
            flash_message('Erro ao carregar perfil', 'error');
            redirect('index.php?page=dashboard');
        }
        
        include 'views/usuarios/perfil.php';
    }
}
?>

