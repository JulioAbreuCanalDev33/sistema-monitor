<?php
require_once 'includes/functions.php';

class AgentesController {
    
    public function index() {
        $agente = new Agente();
        $stmt = $agente->read();
        $agentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include 'views/agentes/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $agente = new Agente();
            
            // Verificar se email ou CPF já existem
            $agente->email_agente = sanitize_input($_POST['email_agente']);
            $agente->cpf_agente = sanitize_input($_POST['cpf_agente']);
            
            if ($agente->emailExists()) {
                flash_message('Email já cadastrado no sistema', 'error');
                redirect('index.php?page=agentes&action=create');
            }
            
            if ($agente->cpfExists()) {
                flash_message('CPF já cadastrado no sistema', 'error');
                redirect('index.php?page=agentes&action=create');
            }
            
            // Preencher propriedades
            $agente->nome_agente = sanitize_input($_POST['nome_agente']);
            $agente->rg_agente = sanitize_input($_POST['rg_agente']);
            $agente->telefone_agente = sanitize_input($_POST['telefone_agente']);
            $agente->endereco_agente = sanitize_input($_POST['endereco_agente']);
            $agente->numero_agente = sanitize_input($_POST['numero_agente']);
            $agente->bairro_agente = sanitize_input($_POST['bairro_agente']);
            $agente->cidade_agente = sanitize_input($_POST['cidade_agente']);
            $agente->estado_agente = sanitize_input($_POST['estado_agente']);
            $agente->cep_agente = sanitize_input($_POST['cep_agente']);
            $agente->data_nascimento = $_POST['data_nascimento'];
            $agente->status_agente = sanitize_input($_POST['status_agente']);
            $agente->observacoes = sanitize_input($_POST['observacoes']);
            
            if ($agente->create()) {
                flash_message('Agente cadastrado com sucesso!', 'success');
                redirect('index.php?page=agentes');
            } else {
                flash_message('Erro ao cadastrar agente', 'error');
            }
        }
        
        include 'views/agentes/create.php';
    }
    
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $agente = new Agente();
        $agente->id_agente = $id;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Verificar se email ou CPF já existem (exceto o próprio registro)
            $agente->email_agente = sanitize_input($_POST['email_agente']);
            $agente->cpf_agente = sanitize_input($_POST['cpf_agente']);
            
            if ($agente->emailExists()) {
                flash_message('Email já cadastrado no sistema', 'error');
                redirect('index.php?page=agentes&action=edit&id=' . $id);
            }
            
            if ($agente->cpfExists()) {
                flash_message('CPF já cadastrado no sistema', 'error');
                redirect('index.php?page=agentes&action=edit&id=' . $id);
            }
            
            // Preencher propriedades
            $agente->nome_agente = sanitize_input($_POST['nome_agente']);
            $agente->rg_agente = sanitize_input($_POST['rg_agente']);
            $agente->telefone_agente = sanitize_input($_POST['telefone_agente']);
            $agente->endereco_agente = sanitize_input($_POST['endereco_agente']);
            $agente->numero_agente = sanitize_input($_POST['numero_agente']);
            $agente->bairro_agente = sanitize_input($_POST['bairro_agente']);
            $agente->cidade_agente = sanitize_input($_POST['cidade_agente']);
            $agente->estado_agente = sanitize_input($_POST['estado_agente']);
            $agente->cep_agente = sanitize_input($_POST['cep_agente']);
            $agente->data_nascimento = $_POST['data_nascimento'];
            $agente->status_agente = sanitize_input($_POST['status_agente']);
            $agente->observacoes = sanitize_input($_POST['observacoes']);
            
            if ($agente->update()) {
                flash_message('Agente atualizado com sucesso!', 'success');
                redirect('index.php?page=agentes');
            } else {
                flash_message('Erro ao atualizar agente', 'error');
            }
        }
        
        if (!$agente->readOne()) {
            flash_message('Agente não encontrado', 'error');
            redirect('index.php?page=agentes');
        }
        
        include 'views/agentes/edit.php';
    }
    
    public function delete() {
        // Verificar se é admin
        if ($_SESSION['user_level'] !== 'admin') {
            flash_message('Acesso negado. Apenas administradores podem excluir registros.', 'error');
            redirect('index.php?page=agentes');
        }
        
        $id = $_GET['id'] ?? 0;
        $agente = new Agente();
        $agente->id_agente = $id;
        
        if ($agente->delete()) {
            flash_message('Agente excluído com sucesso!', 'success');
        } else {
            flash_message('Erro ao excluir agente', 'error');
        }
        
        redirect('index.php?page=agentes');
    }
    
    public function view() {
        $id = $_GET['id'] ?? 0;
        $agente = new Agente();
        $agente->id_agente = $id;
        
        if (!$agente->readOne()) {
            flash_message('Agente não encontrado', 'error');
            redirect('index.php?page=agentes');
        }
        
        include 'views/agentes/view.php';
    }
}
?>

