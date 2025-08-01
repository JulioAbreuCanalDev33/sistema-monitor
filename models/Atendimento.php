<?php
require_once 'config/Database.php';

class Atendimento {
    private $conn;
    private $table_name = "atendimentos";

    public $id_atendimento;
    public $solicitante;
    public $motivo;
    public $valor_patrimonial;
    public $id_cliente;
    public $conta;
    public $id_validacao;
    public $filial;
    public $ordem_servico;
    public $cep;
    public $estado;
    public $cidade;
    public $endereco;
    public $numero;
    public $latitude;
    public $longitude;
    public $agentes_aptos;
    public $id_agente;
    public $equipe;
    public $responsavel;
    public $estabelecimento;
    public $hora_solicitada;
    public $hora_local;
    public $hora_saida;
    public $status_atendimento;
    public $tipo_de_servico;
    public $tipos_de_dados;
    public $estabelecida_inicio;
    public $estabelecida_fim;
    public $indeterminado;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (solicitante, motivo, valor_patrimonial, id_cliente, conta, id_validacao, 
                   filial, ordem_servico, cep, estado, cidade, endereco, numero, latitude, 
                   longitude, agentes_aptos, id_agente, equipe, responsavel, estabelecimento, 
                   hora_solicitada, hora_local, hora_saida, status_atendimento, tipo_de_servico, 
                   tipos_de_dados, estabelecida_inicio, estabelecida_fim, indeterminado) 
                  VALUES 
                  (:solicitante, :motivo, :valor_patrimonial, :id_cliente, :conta, :id_validacao, 
                   :filial, :ordem_servico, :cep, :estado, :cidade, :endereco, :numero, :latitude, 
                   :longitude, :agentes_aptos, :id_agente, :equipe, :responsavel, :estabelecimento, 
                   :hora_solicitada, :hora_local, :hora_saida, :status_atendimento, :tipo_de_servico, 
                   :tipos_de_dados, :estabelecida_inicio, :estabelecida_fim, :indeterminado)";

        $stmt = $this->conn->prepare($query);

        // Sanitizar dados
        $this->solicitante = htmlspecialchars(strip_tags($this->solicitante));
        $this->motivo = htmlspecialchars(strip_tags($this->motivo));
        $this->endereco = htmlspecialchars(strip_tags($this->endereco));

        // Bind dos parâmetros
        $stmt->bindParam(':solicitante', $this->solicitante);
        $stmt->bindParam(':motivo', $this->motivo);
        $stmt->bindParam(':valor_patrimonial', $this->valor_patrimonial);
        $stmt->bindParam(':id_cliente', $this->id_cliente);
        $stmt->bindParam(':conta', $this->conta);
        $stmt->bindParam(':id_validacao', $this->id_validacao);
        $stmt->bindParam(':filial', $this->filial);
        $stmt->bindParam(':ordem_servico', $this->ordem_servico);
        $stmt->bindParam(':cep', $this->cep);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':cidade', $this->cidade);
        $stmt->bindParam(':endereco', $this->endereco);
        $stmt->bindParam(':numero', $this->numero);
        $stmt->bindParam(':latitude', $this->latitude);
        $stmt->bindParam(':longitude', $this->longitude);
        $stmt->bindParam(':agentes_aptos', $this->agentes_aptos);
        $stmt->bindParam(':id_agente', $this->id_agente);
        $stmt->bindParam(':equipe', $this->equipe);
        $stmt->bindParam(':responsavel', $this->responsavel);
        $stmt->bindParam(':estabelecimento', $this->estabelecimento);
        $stmt->bindParam(':hora_solicitada', $this->hora_solicitada);
        $stmt->bindParam(':hora_local', $this->hora_local);
        $stmt->bindParam(':hora_saida', $this->hora_saida);
        $stmt->bindParam(':status_atendimento', $this->status_atendimento);
        $stmt->bindParam(':tipo_de_servico', $this->tipo_de_servico);
        $stmt->bindParam(':tipos_de_dados', $this->tipos_de_dados);
        $stmt->bindParam(':estabelecida_inicio', $this->estabelecida_inicio);
        $stmt->bindParam(':estabelecida_fim', $this->estabelecida_fim);
        $stmt->bindParam(':indeterminado', $this->indeterminado);

        if ($stmt->execute()) {
            $this->id_atendimento = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT a.*, c.nome_empresa as cliente_nome, ag.nome as agente_nome 
                  FROM " . $this->table_name . " a 
                  LEFT JOIN clientes c ON a.id_cliente = c.id_cliente 
                  LEFT JOIN agentes ag ON a.id_agente = ag.id_agente 
                  ORDER BY a.hora_local DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function readOne() {
        $query = "SELECT a.*, c.nome_empresa as cliente_nome, ag.nome as agente_nome 
                  FROM " . $this->table_name . " a 
                  LEFT JOIN clientes c ON a.id_cliente = c.id_cliente 
                  LEFT JOIN agentes ag ON a.id_agente = ag.id_agente 
                  WHERE a.id_atendimento = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id_atendimento);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->solicitante = $row['solicitante'];
            $this->motivo = $row['motivo'];
            $this->valor_patrimonial = $row['valor_patrimonial'];
            $this->id_cliente = $row['id_cliente'];
            $this->conta = $row['conta'];
            $this->id_validacao = $row['id_validacao'];
            $this->filial = $row['filial'];
            $this->ordem_servico = $row['ordem_servico'];
            $this->cep = $row['cep'];
            $this->estado = $row['estado'];
            $this->cidade = $row['cidade'];
            $this->endereco = $row['endereco'];
            $this->numero = $row['numero'];
            $this->latitude = $row['latitude'];
            $this->longitude = $row['longitude'];
            $this->agentes_aptos = $row['agentes_aptos'];
            $this->id_agente = $row['id_agente'];
            $this->equipe = $row['equipe'];
            $this->responsavel = $row['responsavel'];
            $this->estabelecimento = $row['estabelecimento'];
            $this->hora_solicitada = $row['hora_solicitada'];
            $this->hora_local = $row['hora_local'];
            $this->hora_saida = $row['hora_saida'];
            $this->status_atendimento = $row['status_atendimento'];
            $this->tipo_de_servico = $row['tipo_de_servico'];
            $this->tipos_de_dados = $row['tipos_de_dados'];
            $this->estabelecida_inicio = $row['estabelecida_inicio'];
            $this->estabelecida_fim = $row['estabelecida_fim'];
            $this->indeterminado = $row['indeterminado'];
            return true;
        }

        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET solicitante = :solicitante, motivo = :motivo, valor_patrimonial = :valor_patrimonial,
                      id_cliente = :id_cliente, conta = :conta, id_validacao = :id_validacao,
                      filial = :filial, ordem_servico = :ordem_servico, cep = :cep, estado = :estado,
                      cidade = :cidade, endereco = :endereco, numero = :numero, latitude = :latitude,
                      longitude = :longitude, agentes_aptos = :agentes_aptos, id_agente = :id_agente,
                      equipe = :equipe, responsavel = :responsavel, estabelecimento = :estabelecimento,
                      hora_solicitada = :hora_solicitada, hora_local = :hora_local, hora_saida = :hora_saida,
                      status_atendimento = :status_atendimento, tipo_de_servico = :tipo_de_servico,
                      tipos_de_dados = :tipos_de_dados, estabelecida_inicio = :estabelecida_inicio,
                      estabelecida_fim = :estabelecida_fim, indeterminado = :indeterminado
                  WHERE id_atendimento = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitizar dados
        $this->solicitante = htmlspecialchars(strip_tags($this->solicitante));
        $this->motivo = htmlspecialchars(strip_tags($this->motivo));
        $this->endereco = htmlspecialchars(strip_tags($this->endereco));

        // Bind dos parâmetros
        $stmt->bindParam(':solicitante', $this->solicitante);
        $stmt->bindParam(':motivo', $this->motivo);
        $stmt->bindParam(':valor_patrimonial', $this->valor_patrimonial);
        $stmt->bindParam(':id_cliente', $this->id_cliente);
        $stmt->bindParam(':conta', $this->conta);
        $stmt->bindParam(':id_validacao', $this->id_validacao);
        $stmt->bindParam(':filial', $this->filial);
        $stmt->bindParam(':ordem_servico', $this->ordem_servico);
        $stmt->bindParam(':cep', $this->cep);
        $stmt->bindParam(':estado', $this->estado);
        $stmt->bindParam(':cidade', $this->cidade);
        $stmt->bindParam(':endereco', $this->endereco);
        $stmt->bindParam(':numero', $this->numero);
        $stmt->bindParam(':latitude', $this->latitude);
        $stmt->bindParam(':longitude', $this->longitude);
        $stmt->bindParam(':agentes_aptos', $this->agentes_aptos);
        $stmt->bindParam(':id_agente', $this->id_agente);
        $stmt->bindParam(':equipe', $this->equipe);
        $stmt->bindParam(':responsavel', $this->responsavel);
        $stmt->bindParam(':estabelecimento', $this->estabelecimento);
        $stmt->bindParam(':hora_solicitada', $this->hora_solicitada);
        $stmt->bindParam(':hora_local', $this->hora_local);
        $stmt->bindParam(':hora_saida', $this->hora_saida);
        $stmt->bindParam(':status_atendimento', $this->status_atendimento);
        $stmt->bindParam(':tipo_de_servico', $this->tipo_de_servico);
        $stmt->bindParam(':tipos_de_dados', $this->tipos_de_dados);
        $stmt->bindParam(':estabelecida_inicio', $this->estabelecida_inicio);
        $stmt->bindParam(':estabelecida_fim', $this->estabelecida_fim);
        $stmt->bindParam(':indeterminado', $this->indeterminado);
        $stmt->bindParam(':id', $this->id_atendimento);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_atendimento = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id_atendimento);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>

