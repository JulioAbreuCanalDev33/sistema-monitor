<?php
require_once 'includes/functions.php';

class VigilanciaController {
    
    public function index() {
        $vigilancia = new VigilanciaVeicular();
        $stmt = $vigilancia->read();
        $vigilancias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include 'views/vigilancia/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $vigilancia = new VigilanciaVeicular();
            
            // Preencher propriedades
            $vigilancia->veiculo = sanitize_input($_POST['veiculo']);
            $vigilancia->condutor = sanitize_input($_POST['condutor']);
            $vigilancia->data_hora_inicio = $_POST['data_hora_inicio'];
            $vigilancia->data_hora_fim = $_POST['data_hora_fim'];
            $vigilancia->localizacao_inicial = sanitize_input($_POST['localizacao_inicial']);
            $vigilancia->localizacao_final = sanitize_input($_POST['localizacao_final']);
            $vigilancia->km_inicial = $_POST['km_inicial'];
            $vigilancia->km_final = $_POST['km_final'];
            $vigilancia->combustivel_inicial = $_POST['combustivel_inicial'];
            $vigilancia->combustivel_final = $_POST['combustivel_final'];
            $vigilancia->observacoes = sanitize_input($_POST['observacoes']);
            $vigilancia->status_vigilancia = sanitize_input($_POST['status_vigilancia']);
            $vigilancia->responsavel = sanitize_input($_POST['responsavel']);
            
            // Upload de fotos
            if (isset($_FILES['fotos_vigilancia']) && $_FILES['fotos_vigilancia']['error'][0] == 0) {
                $fotos_nomes = [];
                
                for ($i = 0; $i < count($_FILES['fotos_vigilancia']['name']); $i++) {
                    if ($_FILES['fotos_vigilancia']['error'][$i] == 0) {
                        $arquivo_temp = [
                            'name' => $_FILES['fotos_vigilancia']['name'][$i],
                            'type' => $_FILES['fotos_vigilancia']['type'][$i],
                            'tmp_name' => $_FILES['fotos_vigilancia']['tmp_name'][$i],
                            'error' => $_FILES['fotos_vigilancia']['error'][$i],
                            'size' => $_FILES['fotos_vigilancia']['size'][$i]
                        ];
                        
                        $upload_result = upload_file($arquivo_temp, ['jpg', 'jpeg', 'png']);
                        if ($upload_result['success']) {
                            $fotos_nomes[] = $upload_result['filename'];
                        }
                    }
                }
                
                $vigilancia->fotos_vigilancia = implode(',', $fotos_nomes);
            }
            
            if ($vigilancia->create()) {
                flash_message('Vigilância veicular criada com sucesso!', 'success');
                redirect('index.php?page=vigilancia');
            } else {
                flash_message('Erro ao criar vigilância veicular', 'error');
            }
        }
        
        include 'views/vigilancia/create.php';
    }
    
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $vigilancia = new VigilanciaVeicular();
        $vigilancia->id = $id;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Preencher propriedades
            $vigilancia->veiculo = sanitize_input($_POST['veiculo']);
            $vigilancia->condutor = sanitize_input($_POST['condutor']);
            $vigilancia->data_hora_inicio = $_POST['data_hora_inicio'];
            $vigilancia->data_hora_fim = $_POST['data_hora_fim'];
            $vigilancia->localizacao_inicial = sanitize_input($_POST['localizacao_inicial']);
            $vigilancia->localizacao_final = sanitize_input($_POST['localizacao_final']);
            $vigilancia->km_inicial = $_POST['km_inicial'];
            $vigilancia->km_final = $_POST['km_final'];
            $vigilancia->combustivel_inicial = $_POST['combustivel_inicial'];
            $vigilancia->combustivel_final = $_POST['combustivel_final'];
            $vigilancia->observacoes = sanitize_input($_POST['observacoes']);
            $vigilancia->status_vigilancia = sanitize_input($_POST['status_vigilancia']);
            $vigilancia->responsavel = sanitize_input($_POST['responsavel']);
            
            // Manter fotos existentes se não houver novos uploads
            $vigilancia_atual = new VigilanciaVeicular();
            $vigilancia_atual->id = $id;
            $vigilancia_atual->readOne();
            
            $vigilancia->fotos_vigilancia = $vigilancia_atual->fotos_vigilancia;
            
            // Upload de novas fotos (se houver)
            if (isset($_FILES['fotos_vigilancia']) && $_FILES['fotos_vigilancia']['error'][0] == 0) {
                $fotos_nomes = [];
                
                for ($i = 0; $i < count($_FILES['fotos_vigilancia']['name']); $i++) {
                    if ($_FILES['fotos_vigilancia']['error'][$i] == 0) {
                        $arquivo_temp = [
                            'name' => $_FILES['fotos_vigilancia']['name'][$i],
                            'type' => $_FILES['fotos_vigilancia']['type'][$i],
                            'tmp_name' => $_FILES['fotos_vigilancia']['tmp_name'][$i],
                            'error' => $_FILES['fotos_vigilancia']['error'][$i],
                            'size' => $_FILES['fotos_vigilancia']['size'][$i]
                        ];
                        
                        $upload_result = upload_file($arquivo_temp, ['jpg', 'jpeg', 'png']);
                        if ($upload_result['success']) {
                            $fotos_nomes[] = $upload_result['filename'];
                        }
                    }
                }
                
                if (!empty($fotos_nomes)) {
                    // Remover fotos antigas se existirem
                    if ($vigilancia_atual->fotos_vigilancia) {
                        $fotos_antigas = explode(',', $vigilancia_atual->fotos_vigilancia);
                        foreach ($fotos_antigas as $foto_antiga) {
                            if (file_exists(UPLOAD_PATH . $foto_antiga)) {
                                unlink(UPLOAD_PATH . $foto_antiga);
                            }
                        }
                    }
                    
                    $vigilancia->fotos_vigilancia = implode(',', $fotos_nomes);
                }
            }
            
            if ($vigilancia->update()) {
                flash_message('Vigilância veicular atualizada com sucesso!', 'success');
                redirect('index.php?page=vigilancia');
            } else {
                flash_message('Erro ao atualizar vigilância veicular', 'error');
            }
        }
        
        if (!$vigilancia->readOne()) {
            flash_message('Vigilância veicular não encontrada', 'error');
            redirect('index.php?page=vigilancia');
        }
        
        include 'views/vigilancia/edit.php';
    }
    
    public function delete() {
        // Verificar se é admin
        if ($_SESSION['user_level'] !== 'admin') {
            flash_message('Acesso negado. Apenas administradores podem excluir registros.', 'error');
            redirect('index.php?page=vigilancia');
        }
        
        $id = $_GET['id'] ?? 0;
        $vigilancia = new VigilanciaVeicular();
        $vigilancia->id = $id;
        
        // Buscar dados para remover arquivos
        if ($vigilancia->readOne()) {
            // Remover fotos se existirem
            if ($vigilancia->fotos_vigilancia) {
                $fotos = explode(',', $vigilancia->fotos_vigilancia);
                foreach ($fotos as $foto) {
                    if (file_exists(UPLOAD_PATH . $foto)) {
                        unlink(UPLOAD_PATH . $foto);
                    }
                }
            }
            
            if ($vigilancia->delete()) {
                flash_message('Vigilância veicular excluída com sucesso!', 'success');
            } else {
                flash_message('Erro ao excluir vigilância veicular', 'error');
            }
        } else {
            flash_message('Vigilância veicular não encontrada', 'error');
        }
        
        redirect('index.php?page=vigilancia');
    }
    
    public function view() {
        $id = $_GET['id'] ?? 0;
        $vigilancia = new VigilanciaVeicular();
        $vigilancia->id = $id;
        
        if (!$vigilancia->readOne()) {
            flash_message('Vigilância veicular não encontrada', 'error');
            redirect('index.php?page=vigilancia');
        }
        
        include 'views/vigilancia/view.php';
    }
}
?>

