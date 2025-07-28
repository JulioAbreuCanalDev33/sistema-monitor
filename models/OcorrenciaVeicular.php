<?php
require_once 'config/database.php';

class OcorrenciaVeicular {
    private $conn;
    private $table_name = "ocorrencias_veiculares";

    public $id;
    public $cliente;
    public $servico;
    public $id_validacao;
    public $valor_veicular;
    public $cep;
    public $estado;
    public $cidade;
    public $solicitante;
    public $motivo;
    public $endereco_da_ocorrencia;
    public $número;
    public $latitude;
    public $longitude;
    public $agentes_aptos;
    public $prestador;
    public $equipe;
    public $tipo_de_ocorrencia;
    public $data_hora_evento;
    public $data_hora_deslocamento;
    public $data_hora_transmissao;
    public $data_hora_local;
    public $data_hora_inicio_atendimento;
    public $data_hora_fim_atendimento;
    public $franquia_hora;
    public $franquia_km;
    public $km_inicial_atendimento;
    public $km_final_atendimento;
    public $total_horas_atendimento;
    public $total_km_percorrido;
    public $descricao_fatos;
    public $gastos_adicionais;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (cliente, servico, id_validacao, valor_veicular, cep, estado, cidade, 
                   solicitante, motivo, endereco_da_ocorrencia, número, latitude, longitude, 
                   agentes_aptos, prestador, equipe, tipo_de_ocorrencia, data_hora_evento, 
                   data_hora_deslocamento, data_hora_transmissao, data_hora_local, 
                   data_hora_inicio_atendimento, data_hora_fim_atendimento, franquia_hora, 
                   franquia_km, km_inicial_atendimento, km_final_atendimento, 
                   total_horas_atendimento, total_km_percorrido, descricao_fatos, gastos_adicionais) 
                  VALUES 
                  (:cliente, :servico, :id_validacao, :valor_veicular, :cep, :estado, :cidade, 
                   :solicitante, :motivo, :endereco_da_ocorrencia, :número, :latitude, :longitude, 
                   :agentes_aptos, :prestador, :equipe, :tipo_de_ocorrencia, :data_hora_evento, 
                   :data_hora_deslocamento, :data_hora_transmissao, :data_hora_local, 
                   :data_hora_inicio_atendimento, :data_hora_fim_atendimento, :franquia_hora, 
                   :franquia_km, :km_inicial_atendimento, :km_final_atendimento, 
                   :total_horas_atendimento, :total_km_percorrido, :descricao_fatos, :gastos_adicionais)";

        $stmt = $this->conn->prepare($query);

        // Sanitizar dados
        $this->cliente = htmlspecialchars(strip_tags($this->cliente));
        $this->solicitante = htmlspecialchars(strip_tags($this->solicitante));
        $this->endereco_da_ocorrencia = htmlspecialchars(strip_tags($this->endereco_da_ocorrencia));

        // Bind dos parâmetros
        $stmt->bindParam(':cliente', $this->cliente);
        $stmt->bindParam(':servico', $this->servico);
        $stmt->bindParam(':id_validacao', $this->id_validacao);
        $stmt->bindParam(':valor_veicular', $this->valor_veicular);
        $stmt->bindParam(':cep', $this->cep);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':cidade', $this->cidade);
        $stmt->bindParam(':solicitante', $this->solicitante);
        $stmt->bindParam(':motivo', $this->motivo);
        $stmt->bindParam(':endereco_da_ocorrencia', $this->endereco_da_ocorrencia);
        $stmt->bindParam(':número', $this->número);
        $stmt->bindParam(':latitude', $this->latitude);
        $stmt->bindParam(':longitude', $this->longitude);
        $stmt->bindParam(':agentes_aptos', $this->agentes_aptos);
        $stmt->bindParam(':prestador', $this->prestador);
        $stmt->bindParam(':equipe', $this->equipe);
        $stmt->bindParam(':tipo_de_ocorrencia', $this->tipo_de_ocorrencia);
        $stmt->bindParam(':data_hora_evento', $this->data_hora_evento);
        $stmt->bindParam(':data_hora_deslocamento', $this->data_hora_deslocamento);
        $stmt->bindParam(':data_hora_transmissao', $this->data_hora_transmissao);
        $stmt->bindParam(':data_hora_local', $this->data_hora_local);
        $stmt->bindParam(':data_hora_inicio_atendimento', $this->data_hora_inicio_atendimento);
        $stmt->bindParam(':data_hora_fim_atendimento', $this->data_hora_fim_atendimento);
        $stmt->bindParam(':franquia_hora', $this->franquia_hora);
        $stmt->bindParam(':franquia_km', $this->franquia_km);
        $stmt->bindParam(':km_inicial_atendimento', $this->km_inicial_atendimento);
        $stmt->bindParam(':km_final_atendimento', $this->km_final_atendimento);
        $stmt->bindParam(':total_horas_atendimento', $this->total_horas_atendimento);
        $stmt->bindParam(':total_km_percorrido', $this->total_km_percorrido);
        $stmt->bindParam(':descricao_fatos', $this->descricao_fatos);
        $stmt->bindParam(':gastos_adicionais', $this->gastos_adicionais);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY data_hora_evento DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->cliente = $row['cliente'];
            $this->servico = $row['servico'];
            $this->id_validacao = $row['id_validacao'];
            $this->valor_veicular = $row['valor_veicular'];
            $this->cep = $row['cep'];
            $this->estado = $row['estado'];
            $this->cidade = $row['cidade'];
            $this->solicitante = $row['solicitante'];
            $this->motivo = $row['motivo'];
            $this->endereco_da_ocorrencia = $row['endereco_da_ocorrencia'];
            $this->número = $row['número'];
            $this->latitude = $row['latitude'];
            $this->longitude = $row['longitude'];
            $this->agentes_aptos = $row['agentes_aptos'];
            $this->prestador = $row['prestador'];
            $this->equipe = $row['equipe'];
            $this->tipo_de_ocorrencia = $row['tipo_de_ocorrencia'];
            $this->data_hora_evento = $row['data_hora_evento'];
            $this->data_hora_deslocamento = $row['data_hora_deslocamento'];
            $this->data_hora_transmissao = $row['data_hora_transmissao'];
            $this->data_hora_local = $row['data_hora_local'];
            $this->data_hora_inicio_atendimento = $row['data_hora_inicio_atendimento'];
            $this->data_hora_fim_atendimento = $row['data_hora_fim_atendimento'];
            $this->franquia_hora = $row['franquia_hora'];
            $this->franquia_km = $row['franquia_km'];
            $this->km_inicial_atendimento = $row['km_inicial_atendimento'];
            $this->km_final_atendimento = $row['km_final_atendimento'];
            $this->total_horas_atendimento = $row['total_horas_atendimento'];
            $this->total_km_percorrido = $row['total_km_percorrido'];
            $this->descricao_fatos = $row['descricao_fatos'];
            $this->gastos_adicionais = $row['gastos_adicionais'];
            return true;
        }

        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET cliente = :cliente, servico = :servico, id_validacao = :id_validacao,
                      valor_veicular = :valor_veicular, cep = :cep, estado = :estado,
                      cidade = :cidade, solicitante = :solicitante, motivo = :motivo,
                      endereco_da_ocorrencia = :endereco_da_ocorrencia, número = :número,
                      latitude = :latitude, longitude = :longitude, agentes_aptos = :agentes_aptos,
                      prestador = :prestador, equipe = :equipe, tipo_de_ocorrencia = :tipo_de_ocorrencia,
                      data_hora_evento = :data_hora_evento, data_hora_deslocamento = :data_hora_deslocamento,
                      data_hora_transmissao = :data_hora_transmissao, data_hora_local = :data_hora_local,
                      data_hora_inicio_atendimento = :data_hora_inicio_atendimento,
                      data_hora_fim_atendimento = :data_hora_fim_atendimento,
                      franquia_hora = :franquia_hora, franquia_km = :franquia_km,
                      km_inicial_atendimento = :km_inicial_atendimento,
                      km_final_atendimento = :km_final_atendimento,
                      total_horas_atendimento = :total_horas_atendimento,
                      total_km_percorrido = :total_km_percorrido,
                      descricao_fatos = :descricao_fatos, gastos_adicionais = :gastos_adicionais
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitizar dados
        $this->cliente = htmlspecialchars(strip_tags($this->cliente));
        $this->solicitante = htmlspecialchars(strip_tags($this->solicitante));
        $this->endereco_da_ocorrencia = htmlspecialchars(strip_tags($this->endereco_da_ocorrencia));

        // Bind dos parâmetros (mesmo do create + id)
        $stmt->bindParam(':cliente', $this->cliente);
        $stmt->bindParam(':servico', $this->servico);
        $stmt->bindParam(':id_validacao', $this->id_validacao);
        $stmt->bindParam(':valor_veicular', $this->valor_veicular);
        $stmt->bindParam(':cep', $this->cep);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':cidade', $this->cidade);
        $stmt->bindParam(':solicitante', $this->solicitante);
        $stmt->bindParam(':motivo', $this->motivo);
        $stmt->bindParam(':endereco_da_ocorrencia', $this->endereco_da_ocorrencia);
        $stmt->bindParam(':número', $this->número);
        $stmt->bindParam(':latitude', $this->latitude);
        $stmt->bindParam(':longitude', $this->longitude);
        $stmt->bindParam(':agentes_aptos', $this->agentes_aptos);
        $stmt->bindParam(':prestador', $this->prestador);
        $stmt->bindParam(':equipe', $this->equipe);
        $stmt->bindParam(':tipo_de_ocorrencia', $this->tipo_de_ocorrencia);
        $stmt->bindParam(':data_hora_evento', $this->data_hora_evento);
        $stmt->bindParam(':data_hora_deslocamento', $this->data_hora_deslocamento);
        $stmt->bindParam(':data_hora_transmissao', $this->data_hora_transmissao);
        $stmt->bindParam(':data_hora_local', $this->data_hora_local);
        $stmt->bindParam(':data_hora_inicio_atendimento', $this->data_hora_inicio_atendimento);
        $stmt->bindParam(':data_hora_fim_atendimento', $this->data_hora_fim_atendimento);
        $stmt->bindParam(':franquia_hora', $this->franquia_hora);
        $stmt->bindParam(':franquia_km', $this->franquia_km);
        $stmt->bindParam(':km_inicial_atendimento', $this->km_inicial_atendimento);
        $stmt->bindParam(':km_final_atendimento', $this->km_final_atendimento);
        $stmt->bindParam(':total_horas_atendimento', $this->total_horas_atendimento);
        $stmt->bindParam(':total_km_percorrido', $this->total_km_percorrido);
        $stmt->bindParam(':descricao_fatos', $this->descricao_fatos);
        $stmt->bindParam(':gastos_adicionais', $this->gastos_adicionais);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>

