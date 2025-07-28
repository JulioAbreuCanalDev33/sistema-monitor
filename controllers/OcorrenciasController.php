<?php
require_once 'includes/functions.php';

class OcorrenciasController {
    
    public function index() {
        $ocorrencia = new OcorrenciaVeicular();
        $stmt = $ocorrencia->read();
        $ocorrencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include 'views/ocorrencias/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ocorrencia = new OcorrenciaVeicular();
            
            // Preencher propriedades
            $ocorrencia->cliente = sanitize_input($_POST['cliente']);
            $ocorrencia->servico = sanitize_input($_POST['servico']);
            $ocorrencia->id_validacao = sanitize_input($_POST['id_validacao']);
            $ocorrencia->valor_veicular = $_POST['valor_veicular'];
            $ocorrencia->cep = sanitize_input($_POST['cep']);
            $ocorrencia->estado = sanitize_input($_POST['estado']);
            $ocorrencia->cidade = sanitize_input($_POST['cidade']);
            $ocorrencia->solicitante = sanitize_input($_POST['solicitante']);
            $ocorrencia->motivo = sanitize_input($_POST['motivo']);
            $ocorrencia->endereco_da_ocorrencia = sanitize_input($_POST['endereco_da_ocorrencia']);
            $ocorrencia->número = sanitize_input($_POST['número']);
            $ocorrencia->latitude = $_POST['latitude'];
            $ocorrencia->longitude = $_POST['longitude'];
            $ocorrencia->agentes_aptos = sanitize_input($_POST['agentes_aptos']);
            $ocorrencia->prestador = sanitize_input($_POST['prestador']);
            $ocorrencia->equipe = sanitize_input($_POST['equipe']);
            $ocorrencia->tipo_de_ocorrencia = sanitize_input($_POST['tipo_de_ocorrencia']);
            $ocorrencia->data_hora_evento = $_POST['data_hora_evento'];
            $ocorrencia->data_hora_deslocamento = $_POST['data_hora_deslocamento'];
            $ocorrencia->data_hora_transmissao = $_POST['data_hora_transmissao'];
            $ocorrencia->data_hora_local = $_POST['data_hora_local'];
            $ocorrencia->data_hora_inicio_atendimento = $_POST['data_hora_inicio_atendimento'];
            $ocorrencia->data_hora_fim_atendimento = $_POST['data_hora_fim_atendimento'];
            $ocorrencia->franquia_hora = $_POST['franquia_hora'];
            $ocorrencia->franquia_km = $_POST['franquia_km'];
            $ocorrencia->km_inicial_atendimento = $_POST['km_inicial_atendimento'];
            $ocorrencia->km_final_atendimento = $_POST['km_final_atendimento'];
            $ocorrencia->total_horas_atendimento = $_POST['total_horas_atendimento'];
            $ocorrencia->total_km_percorrido = $_POST['total_km_percorrido'];
            $ocorrencia->descricao_fatos = sanitize_input($_POST['descricao_fatos']);
            $ocorrencia->gastos_adicionais = $_POST['gastos_adicionais'];
            
            if ($ocorrencia->create()) {
                flash_message('Ocorrência veicular criada com sucesso!', 'success');
                redirect('index.php?page=ocorrencias');
            } else {
                flash_message('Erro ao criar ocorrência veicular', 'error');
            }
        }
        
        // Buscar prestadores para o select
        $database = new Database();
        $conn = $database->getConnection();
        
        $query = "SELECT id, nome_prestador FROM tabela_prestadores ORDER BY nome_prestador";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $prestadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include 'views/ocorrencias/create.php';
    }
    
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $ocorrencia = new OcorrenciaVeicular();
        $ocorrencia->id = $id;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Preencher propriedades (mesmo código do create)
            $ocorrencia->cliente = sanitize_input($_POST['cliente']);
            $ocorrencia->servico = sanitize_input($_POST['servico']);
            $ocorrencia->id_validacao = sanitize_input($_POST['id_validacao']);
            $ocorrencia->valor_veicular = $_POST['valor_veicular'];
            $ocorrencia->cep = sanitize_input($_POST['cep']);
            $ocorrencia->estado = sanitize_input($_POST['estado']);
            $ocorrencia->cidade = sanitize_input($_POST['cidade']);
            $ocorrencia->solicitante = sanitize_input($_POST['solicitante']);
            $ocorrencia->motivo = sanitize_input($_POST['motivo']);
            $ocorrencia->endereco_da_ocorrencia = sanitize_input($_POST['endereco_da_ocorrencia']);
            $ocorrencia->número = sanitize_input($_POST['número']);
            $ocorrencia->latitude = $_POST['latitude'];
            $ocorrencia->longitude = $_POST['longitude'];
            $ocorrencia->agentes_aptos = sanitize_input($_POST['agentes_aptos']);
            $ocorrencia->prestador = sanitize_input($_POST['prestador']);
            $ocorrencia->equipe = sanitize_input($_POST['equipe']);
            $ocorrencia->tipo_de_ocorrencia = sanitize_input($_POST['tipo_de_ocorrencia']);
            $ocorrencia->data_hora_evento = $_POST['data_hora_evento'];
            $ocorrencia->data_hora_deslocamento = $_POST['data_hora_deslocamento'];
            $ocorrencia->data_hora_transmissao = $_POST['data_hora_transmissao'];
            $ocorrencia->data_hora_local = $_POST['data_hora_local'];
            $ocorrencia->data_hora_inicio_atendimento = $_POST['data_hora_inicio_atendimento'];
            $ocorrencia->data_hora_fim_atendimento = $_POST['data_hora_fim_atendimento'];
            $ocorrencia->franquia_hora = $_POST['franquia_hora'];
            $ocorrencia->franquia_km = $_POST['franquia_km'];
            $ocorrencia->km_inicial_atendimento = $_POST['km_inicial_atendimento'];
            $ocorrencia->km_final_atendimento = $_POST['km_final_atendimento'];
            $ocorrencia->total_horas_atendimento = $_POST['total_horas_atendimento'];
            $ocorrencia->total_km_percorrido = $_POST['total_km_percorrido'];
            $ocorrencia->descricao_fatos = sanitize_input($_POST['descricao_fatos']);
            $ocorrencia->gastos_adicionais = $_POST['gastos_adicionais'];
            
            if ($ocorrencia->update()) {
                flash_message('Ocorrência veicular atualizada com sucesso!', 'success');
                redirect('index.php?page=ocorrencias');
            } else {
                flash_message('Erro ao atualizar ocorrência veicular', 'error');
            }
        }
        
        if (!$ocorrencia->readOne()) {
            flash_message('Ocorrência veicular não encontrada', 'error');
            redirect('index.php?page=ocorrencias');
        }
        
        // Buscar prestadores para o select
        $database = new Database();
        $conn = $database->getConnection();
        
        $query = "SELECT id, nome_prestador FROM tabela_prestadores ORDER BY nome_prestador";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $prestadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include 'views/ocorrencias/edit.php';
    }
    
    public function delete() {
        // Verificar se é admin
        if ($_SESSION['user_level'] !== 'admin') {
            flash_message('Acesso negado. Apenas administradores podem excluir registros.', 'error');
            redirect('index.php?page=ocorrencias');
        }
        
        $id = $_GET['id'] ?? 0;
        $ocorrencia = new OcorrenciaVeicular();
        $ocorrencia->id = $id;
        
        if ($ocorrencia->delete()) {
            flash_message('Ocorrência veicular excluída com sucesso!', 'success');
        } else {
            flash_message('Erro ao excluir ocorrência veicular', 'error');
        }
        
        redirect('index.php?page=ocorrencias');
    }
    
    public function view() {
        $id = $_GET['id'] ?? 0;
        $ocorrencia = new OcorrenciaVeicular();
        $ocorrencia->id = $id;
        
        if (!$ocorrencia->readOne()) {
            flash_message('Ocorrência veicular não encontrada', 'error');
            redirect('index.php?page=ocorrencias');
        }
        
        include 'views/ocorrencias/view.php';
    }
}
?>

