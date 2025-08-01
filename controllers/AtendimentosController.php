<?php
require_once 'includes/functions.php';

class AtendimentosController {
    
    public function index() 
    {
        $atendimento = new Atendimento();
        $stmt = $atendimento->read();
        $atendimentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include 'views/atendimentos/index.php';
    }
    
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $atendimento = new Atendimento();
            
            // Preencher propriedades
            $atendimento->solicitante = sanitize_input($_POST['solicitante']);
            $atendimento->motivo = sanitize_input($_POST['motivo']);
            $atendimento->valor_patrimonial = $_POST['valor_patrimonial'];
            $atendimento->id_cliente = $_POST['id_cliente'];
            $atendimento->conta = sanitize_input($_POST['conta']);
            $atendimento->id_validacao = sanitize_input($_POST['id_validacao']);
            $atendimento->filial = sanitize_input($_POST['filial']);
            $atendimento->ordem_servico = sanitize_input($_POST['ordem_servico']);
            $atendimento->cep = sanitize_input($_POST['cep']);
            $atendimento->estado = sanitize_input($_POST['estado']);
            $atendimento->cidade = sanitize_input($_POST['cidade']);
            $atendimento->endereco = sanitize_input($_POST['endereco']);
            $atendimento->numero = sanitize_input($_POST['numero']);
            $atendimento->latitude = $_POST['latitude'];
            $atendimento->longitude = $_POST['longitude'];
            $atendimento->agentes_aptos = sanitize_input($_POST['agentes_aptos']);
            $atendimento->id_agente = $_POST['id_agente'];
            $atendimento->equipe = sanitize_input($_POST['equipe']);
            $atendimento->responsavel = sanitize_input($_POST['responsavel']);
            $atendimento->estabelecimento = sanitize_input($_POST['estabelecimento']);
            $atendimento->hora_solicitada = $_POST['hora_solicitada'];
            $atendimento->hora_local = $_POST['hora_local'];
            $atendimento->hora_saida = $_POST['hora_saida'];
            $atendimento->status_atendimento = $_POST['status_atendimento'];
            $atendimento->tipo_de_servico = $_POST['tipo_de_servico'];
            $atendimento->tipos_de_dados = sanitize_input($_POST['tipos_de_dados']);
            $atendimento->estabelecida_inicio = $_POST['estabelecida_inicio'];
            $atendimento->estabelecida_fim = $_POST['estabelecida_fim'];
            $atendimento->indeterminado = isset($_POST['indeterminado']) ? 1 : 0;
            
            if ($atendimento->create()) {
                flash_message('Atendimento criado com sucesso!', 'success');
                redirect('index.php?page=atendimentos');
            } else {
                flash_message('Erro ao criar atendimento', 'error');
            }
        }
        
        // Buscar clientes e agentes para os selects
        $database = new Database();
        $conn = $database->getConnection();
        
        $query = "SELECT * FROM clientes ORDER BY nome_empresa";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $query = "SELECT * FROM agentes WHERE status = 'Ativo' ORDER BY nome";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $agentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include 'views/atendimentos/create.php';
    }
    
    public function edit() {
        $id = $_GET['id'] ?? 0;
        $atendimento = new Atendimento();
        $atendimento->id_atendimento = $id;
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Preencher propriedades (mesmo código do create)
            $atendimento->solicitante = sanitize_input($_POST['solicitante']);
            $atendimento->motivo = sanitize_input($_POST['motivo']);
            // ... outros campos
            
            if ($atendimento->update()) {
                flash_message('Atendimento atualizado com sucesso!', 'success');
                redirect('index.php?page=atendimentos');
            } else {
                flash_message('Erro ao atualizar atendimento', 'error');
            }
        }
        
        if (!$atendimento->readOne()) {
            flash_message('Atendimento não encontrado', 'error');
            redirect('index.php?page=atendimentos');
        }
        
        // Buscar clientes e agentes
        $database = new Database();
        $conn = $database->getConnection();
        
        $query = "SELECT * FROM clientes ORDER BY nome_empresa";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $query = "SELECT * FROM agentes WHERE status = 'Ativo' ORDER BY nome";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $agentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include 'views/atendimentos/edit.php';
    }
    
    public function delete() {
        $id = $_GET['id'] ?? 0;
        $atendimento = new Atendimento();
        $atendimento->id_atendimento = $id;
        
        if ($atendimento->delete()) {
            flash_message('Atendimento excluído com sucesso!', 'success');
        } else {
            flash_message('Erro ao excluir atendimento', 'error');
        }
        
        redirect('index.php?page=atendimentos');
    }
    
    public function view() {
        $id = $_GET['id'] ?? 0;
        $atendimento = new Atendimento();
        $atendimento->id_atendimento = $id;
        
        if (!$atendimento->readOne()) {
            flash_message('Atendimento não encontrado', 'error');
            redirect('index.php?page=atendimentos');
        }
        
        include 'views/atendimentos/view.php';
    }
}
?>

