<?php
require_once 'includes/functions.php';

class PrestadoresController {
    
    public function index() {
        $prestador = new Prestador();
        $stmt = $prestador->read();
        $prestadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include 'views/prestadores/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $prestador = new Prestador();
            
            // Verificar se email ou CPF já existem
            $prestador->email_prestador = sanitize_input($_POST['email_prestador']);
            $prestador->cpf_prestador = sanitize_input($_POST['cpf_prestador']);
            
            if ($prestador->emailExists()) {
                flash_message('Email já cadastrado no sistema', 'error');
                redirect('index.php?page=prestadores&action=create');
            }
            
            if ($prestador->cpfExists()) {
                flash_message('CPF já cadastrado no sistema', 'error');
                redirect('index.php?page=prestadores&action=create');
            }
            
            // Preencher propriedades
            $prestador->nome_prestador = sanitize_input($_POST['nome_prestador']);
            $prestador->equipes = sanitize_input($_POST['equipes']);
            $prestador->servico_prestador = sanitize_input($_POST['servico_prestador']);
            $prestador->rg_prestador = sanitize_input($_POST['rg_prestador']);
            $prestador->telefone_1_prestador = sanitize_input($_POST['telefone_1_prestador']);
            $prestador->telefone_2_prestador = sanitize_input($_POST['telefone_2_prestador']);
            $prestador->cep_prestador = sanitize_input($_POST['cep_prestador']);
            $prestador->endereco_prestador = sanitize_input($_POST['endereco_prestador']);
            $prestador->numero_prestador = sanitize_input($_POST['numero_prestador']);
            $prestador->bairro_prestador = sanitize_input($_POST['bairro_prestador']);
            $prestador->cidade_prestador = sanitize_input($_POST['cidade_prestador']);
            $prestador->estado_prestador = sanitize_input($_POST['estado_prestador']);
            $prestador->observacao = sanitize_input($_POST['observacao']);
            $prestador->codigo_do_banco = sanitize_input($_POST['codigo_do_banco']);
            $prestador->pix_banco_prestadores = sanitize_input($_POST['pix_banco_prestadores']);
            $prestador->titular_conta = sanitize_input($_POST['titular_conta']);
            $prestador->tipo_de_conta = sanitize_input($_POST['tipo_de_conta']);
            $prestador->agencia_prestadores = sanitize_input($_POST['agencia_prestadores']);
            $prestador->digito_agencia_prestadores = sanitize_input($_POST['digito_agencia_prestadores']);
            $prestador->conta_prestadores = sanitize_input($_POST['conta_prestadores']);
            $prestador->digito_conta_prestadores = sanitize_input($_POST['digito_conta_prestadores']);
            
            // Upload de documento
            if (isset($_FILES['documento_prestador']) && $_FILES['documento_prestador']['error'] == 0) {
                $upload_result = upload_file($_FILES['documento_prestador'], ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png']);
                if ($upload_result['success']) {
                    $prestador->documento_prestador = $upload_result['filename'];
                } else {
                    flash_message('Erro no upload do documento: ' . $upload_result['message'], 'error');
                    redirect('index.php?page=prestadores&action=create');
                }
            }
            
            // Upload de foto
            if (isset($_FILES['foto_prestador']) && $_FILES['foto_prestador']['error'] == 0) {
                $upload_result = upload_file($_FILES['foto_prestador'], ['jpg', 'jpeg', 'png']);
                if ($upload_result['success']) {
                    $prestador->foto_prestador = $upload_result['filename'];
                } else {
                    flash_message('Erro no upload da foto: ' . $upload_result['message'], 'error');
                    redirect('index.php?page=prestadores&action=create');
                }
            }
            
            if ($prestador->create()) {
                flash_message('Prestador cadastrado com sucesso!', 'success');
                redirect('index.php?page=prestadores');
            } else {
                flash_message('Erro ao cadastrar prestador', 'error');
            }
        }
        
        include 'views/prestadores/create.php';
    }
    
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $prestador = new Prestador();
        $prestador->id = $id;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Verificar se email ou CPF já existem (exceto o próprio registro)
            $prestador->email_prestador = sanitize_input($_POST['email_prestador']);
            $prestador->cpf_prestador = sanitize_input($_POST['cpf_prestador']);
            
            if ($prestador->emailExists()) {
                flash_message('Email já cadastrado no sistema', 'error');
                redirect('index.php?page=prestadores&action=edit&id=' . $id);
            }
            
            if ($prestador->cpfExists()) {
                flash_message('CPF já cadastrado no sistema', 'error');
                redirect('index.php?page=prestadores&action=edit&id=' . $id);
            }
            
            // Preencher propriedades (mesmo código do create)
            $prestador->nome_prestador = sanitize_input($_POST['nome_prestador']);
            $prestador->equipes = sanitize_input($_POST['equipes']);
            $prestador->servico_prestador = sanitize_input($_POST['servico_prestador']);
            $prestador->rg_prestador = sanitize_input($_POST['rg_prestador']);
            $prestador->telefone_1_prestador = sanitize_input($_POST['telefone_1_prestador']);
            $prestador->telefone_2_prestador = sanitize_input($_POST['telefone_2_prestador']);
            $prestador->cep_prestador = sanitize_input($_POST['cep_prestador']);
            $prestador->endereco_prestador = sanitize_input($_POST['endereco_prestador']);
            $prestador->numero_prestador = sanitize_input($_POST['numero_prestador']);
            $prestador->bairro_prestador = sanitize_input($_POST['bairro_prestador']);
            $prestador->cidade_prestador = sanitize_input($_POST['cidade_prestador']);
            $prestador->estado_prestador = sanitize_input($_POST['estado_prestador']);
            $prestador->observacao = sanitize_input($_POST['observacao']);
            $prestador->codigo_do_banco = sanitize_input($_POST['codigo_do_banco']);
            $prestador->pix_banco_prestadores = sanitize_input($_POST['pix_banco_prestadores']);
            $prestador->titular_conta = sanitize_input($_POST['titular_conta']);
            $prestador->tipo_de_conta = sanitize_input($_POST['tipo_de_conta']);
            $prestador->agencia_prestadores = sanitize_input($_POST['agencia_prestadores']);
            $prestador->digito_agencia_prestadores = sanitize_input($_POST['digito_agencia_prestadores']);
            $prestador->conta_prestadores = sanitize_input($_POST['conta_prestadores']);
            $prestador->digito_conta_prestadores = sanitize_input($_POST['digito_conta_prestadores']);
            
            // Manter arquivos existentes se não houver novos uploads
            $prestador_atual = new Prestador();
            $prestador_atual->id = $id;
            $prestador_atual->readOne();
            
            $prestador->documento_prestador = $prestador_atual->documento_prestador;
            $prestador->foto_prestador = $prestador_atual->foto_prestador;
            
            // Upload de documento (se houver)
            if (isset($_FILES['documento_prestador']) && $_FILES['documento_prestador']['error'] == 0) {
                $upload_result = upload_file($_FILES['documento_prestador'], ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png']);
                if ($upload_result['success']) {
                    // Remover arquivo anterior se existir
                    if ($prestador_atual->documento_prestador && file_exists(UPLOAD_PATH . $prestador_atual->documento_prestador)) {
                        unlink(UPLOAD_PATH . $prestador_atual->documento_prestador);
                    }
                    $prestador->documento_prestador = $upload_result['filename'];
                } else {
                    flash_message('Erro no upload do documento: ' . $upload_result['message'], 'warning');
                }
            }
            
            // Upload de foto (se houver)
            if (isset($_FILES['foto_prestador']) && $_FILES['foto_prestador']['error'] == 0) {
                $upload_result = upload_file($_FILES['foto_prestador'], ['jpg', 'jpeg', 'png']);
                if ($upload_result['success']) {
                    // Remover arquivo anterior se existir
                    if ($prestador_atual->foto_prestador && file_exists(UPLOAD_PATH . $prestador_atual->foto_prestador)) {
                        unlink(UPLOAD_PATH . $prestador_atual->foto_prestador);
                    }
                    $prestador->foto_prestador = $upload_result['filename'];
                } else {
                    flash_message('Erro no upload da foto: ' . $upload_result['message'], 'warning');
                }
            }
            
            if ($prestador->update()) {
                flash_message('Prestador atualizado com sucesso!', 'success');
                redirect('index.php?page=prestadores');
            } else {
                flash_message('Erro ao atualizar prestador', 'error');
            }
        }
        
        if (!$prestador->readOne()) {
            flash_message('Prestador não encontrado', 'error');
            redirect('index.php?page=prestadores');
        }
        
        include 'views/prestadores/edit.php';
    }
    
    public function delete() {
        // Verificar se é admin
        if ($_SESSION['user_level'] !== 'admin') {
            flash_message('Acesso negado. Apenas administradores podem excluir registros.', 'error');
            redirect('index.php?page=prestadores');
        }
        
        $id = $_GET['id'] ?? 0;
        $prestador = new Prestador();
        $prestador->id = $id;
        
        // Buscar dados para remover arquivos
        if ($prestador->readOne()) {
            // Remover arquivos se existirem
            if ($prestador->documento_prestador && file_exists(UPLOAD_PATH . $prestador->documento_prestador)) {
                unlink(UPLOAD_PATH . $prestador->documento_prestador);
            }
            if ($prestador->foto_prestador && file_exists(UPLOAD_PATH . $prestador->foto_prestador)) {
                unlink(UPLOAD_PATH . $prestador->foto_prestador);
            }
            
            if ($prestador->delete()) {
                flash_message('Prestador excluído com sucesso!', 'success');
            } else {
                flash_message('Erro ao excluir prestador', 'error');
            }
        } else {
            flash_message('Prestador não encontrado', 'error');
        }
        
        redirect('index.php?page=prestadores');
    }
    
    public function view() {
        $id = $_GET['id'] ?? 0;
        $prestador = new Prestador();
        $prestador->id = $id;
        
        if (!$prestador->readOne()) {
            flash_message('Prestador não encontrado', 'error');
            redirect('index.php?page=prestadores');
        }
        
        include 'views/prestadores/view.php';
    }
}
?>

