<?php
require_once 'includes/functions.php';

class ClientesController {
    
    public function index() {
        $cliente = new Cliente();
        $stmt = $cliente->read();
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include 'views/clientes/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cliente = new Cliente();
            
            // Verificar se CNPJ já existe
            $cliente->cnpj = sanitize_input($_POST['cnpj']);
            
            if ($cliente->cnpjExists()) {
                flash_message('CNPJ já cadastrado no sistema', 'error');
                redirect('index.php?page=clientes&action=create');
            }
            
            // Preencher propriedades
            $cliente->nome_empresa = sanitize_input($_POST['nome_empresa']);
            $cliente->contato = sanitize_input($_POST['contato']);
            $cliente->endereco = sanitize_input($_POST['endereco']);
            $cliente->telefone = sanitize_input($_POST['telefone']);
            
            if ($cliente->create()) {
                flash_message('Cliente cadastrado com sucesso!', 'success');
                redirect('index.php?page=clientes');
            } else {
                flash_message('Erro ao cadastrar cliente', 'error');
            }
        }
        
        include 'views/clientes/create.php';
    }
    
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $cliente = new Cliente();
        $cliente->id_cliente = $id;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Verificar se CNPJ já existe (exceto o próprio registro)
            $cliente->cnpj = sanitize_input($_POST['cnpj']);
            
            if ($cliente->cnpjExists()) {
                flash_message('CNPJ já cadastrado no sistema', 'error');
                redirect('index.php?page=clientes&action=edit&id=' . $id);
            }
            
            // Preencher propriedades
            $cliente->nome_empresa = sanitize_input($_POST['nome_empresa']);
            $cliente->contato = sanitize_input($_POST['contato']);
            $cliente->endereco = sanitize_input($_POST['endereco']);
            $cliente->telefone = sanitize_input($_POST['telefone']);
            
            if ($cliente->update()) {
                flash_message('Cliente atualizado com sucesso!', 'success');
                redirect('index.php?page=clientes');
            } else {
                flash_message('Erro ao atualizar cliente', 'error');
            }
        }
        
        if (!$cliente->readOne()) {
            flash_message('Cliente não encontrado', 'error');
            redirect('index.php?page=clientes');
        }
        
        include 'views/clientes/edit.php';
    }
    
    public function delete() {
        // Verificar se é admin
        if ($_SESSION['user_level'] !== 'admin') {
            flash_message('Acesso negado. Apenas administradores podem excluir registros.', 'error');
            redirect('index.php?page=clientes');
        }
        
        $id = $_GET['id'] ?? 0;
        $cliente = new Cliente();
        $cliente->id_cliente = $id;
        
        if ($cliente->delete()) {
            flash_message('Cliente excluído com sucesso!', 'success');
        } else {
            flash_message('Erro ao excluir cliente', 'error');
        }
        
        redirect('index.php?page=clientes');
    }
    
    public function view() {
        $id = $_GET['id'] ?? 0;
        $cliente = new Cliente();
        $cliente->id_cliente = $id;
        
        if (!$cliente->readOne()) {
            flash_message('Cliente não encontrado', 'error');
            redirect('index.php?page=clientes');
        }
        
        include 'views/clientes/view.php';
    }
}
?>

