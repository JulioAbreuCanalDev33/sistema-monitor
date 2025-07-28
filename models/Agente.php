<?php
require_once 'config/database.php';

class Agente {
    private $conn;
    private $table_name = "agentes";

    public $id_agente;
    public $nome_agente;
    public $cpf_agente;
    public $rg_agente;
    public $telefone_agente;
    public $email_agente;
    public $endereco_agente;
    public $numero_agente;
    public $bairro_agente;
    public $cidade_agente;
    public $estado_agente;
    public $cep_agente;
    public $data_nascimento;
    public $status_agente;
    public $observacoes;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (nome_agente, cpf_agente, rg_agente, telefone_agente, email_agente, 
                   endereco_agente, numero_agente, bairro_agente, cidade_agente, estado_agente, 
                   cep_agente, data_nascimento, status_agente, observacoes) 
                  VALUES 
                  (:nome_agente, :cpf_agente, :rg_agente, :telefone_agente, :email_agente, 
                   :endereco_agente, :numero_agente, :bairro_agente, :cidade_agente, :estado_agente, 
                   :cep_agente, :data_nascimento, :status_agente, :observacoes)";

        $stmt = $this->conn->prepare($query);

        // Sanitizar dados
        $this->nome_agente = htmlspecialchars(strip_tags($this->nome_agente));
        $this->email_agente = htmlspecialchars(strip_tags($this->email_agente));
        $this->endereco_agente = htmlspecialchars(strip_tags($this->endereco_agente));

        $stmt->bindParam(':nome_agente', $this->nome_agente);
        $stmt->bindParam(':cpf_agente', $this->cpf_agente);
        $stmt->bindParam(':rg_agente', $this->rg_agente);
        $stmt->bindParam(':telefone_agente', $this->telefone_agente);
        $stmt->bindParam(':email_agente', $this->email_agente);
        $stmt->bindParam(':endereco_agente', $this->endereco_agente);
        $stmt->bindParam(':numero_agente', $this->numero_agente);
        $stmt->bindParam(':bairro_agente', $this->bairro_agente);
        $stmt->bindParam(':cidade_agente', $this->cidade_agente);
        $stmt->bindParam(':estado_agente', $this->estado_agente);
        $stmt->bindParam(':cep_agente', $this->cep_agente);
        $stmt->bindParam(':data_nascimento', $this->data_nascimento);
        $stmt->bindParam(':status_agente', $this->status_agente);
        $stmt->bindParam(':observacoes', $this->observacoes);

        if ($stmt->execute()) {
            $this->id_agente = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome_agente ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_agente = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id_agente);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nome_agente = $row['nome_agente'];
            $this->cpf_agente = $row['cpf_agente'];
            $this->rg_agente = $row['rg_agente'];
            $this->telefone_agente = $row['telefone_agente'];
            $this->email_agente = $row['email_agente'];
            $this->endereco_agente = $row['endereco_agente'];
            $this->numero_agente = $row['numero_agente'];
            $this->bairro_agente = $row['bairro_agente'];
            $this->cidade_agente = $row['cidade_agente'];
            $this->estado_agente = $row['estado_agente'];
            $this->cep_agente = $row['cep_agente'];
            $this->data_nascimento = $row['data_nascimento'];
            $this->status_agente = $row['status_agente'];
            $this->observacoes = $row['observacoes'];
            return true;
        }

        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nome_agente = :nome_agente, cpf_agente = :cpf_agente, rg_agente = :rg_agente,
                      telefone_agente = :telefone_agente, email_agente = :email_agente,
                      endereco_agente = :endereco_agente, numero_agente = :numero_agente,
                      bairro_agente = :bairro_agente, cidade_agente = :cidade_agente,
                      estado_agente = :estado_agente, cep_agente = :cep_agente,
                      data_nascimento = :data_nascimento, status_agente = :status_agente,
                      observacoes = :observacoes
                  WHERE id_agente = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitizar dados
        $this->nome_agente = htmlspecialchars(strip_tags($this->nome_agente));
        $this->email_agente = htmlspecialchars(strip_tags($this->email_agente));
        $this->endereco_agente = htmlspecialchars(strip_tags($this->endereco_agente));

        $stmt->bindParam(':nome_agente', $this->nome_agente);
        $stmt->bindParam(':cpf_agente', $this->cpf_agente);
        $stmt->bindParam(':rg_agente', $this->rg_agente);
        $stmt->bindParam(':telefone_agente', $this->telefone_agente);
        $stmt->bindParam(':email_agente', $this->email_agente);
        $stmt->bindParam(':endereco_agente', $this->endereco_agente);
        $stmt->bindParam(':numero_agente', $this->numero_agente);
        $stmt->bindParam(':bairro_agente', $this->bairro_agente);
        $stmt->bindParam(':cidade_agente', $this->cidade_agente);
        $stmt->bindParam(':estado_agente', $this->estado_agente);
        $stmt->bindParam(':cep_agente', $this->cep_agente);
        $stmt->bindParam(':data_nascimento', $this->data_nascimento);
        $stmt->bindParam(':status_agente', $this->status_agente);
        $stmt->bindParam(':observacoes', $this->observacoes);
        $stmt->bindParam(':id', $this->id_agente);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_agente = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id_agente);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function emailExists() {
        $query = "SELECT id_agente FROM " . $this->table_name . " WHERE email_agente = :email";
        
        if (isset($this->id_agente)) {
            $query .= " AND id_agente != :id";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email_agente);
        
        if (isset($this->id_agente)) {
            $stmt->bindParam(':id', $this->id_agente);
        }

        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function cpfExists() {
        $query = "SELECT id_agente FROM " . $this->table_name . " WHERE cpf_agente = :cpf";
        
        if (isset($this->id_agente)) {
            $query .= " AND id_agente != :id";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cpf', $this->cpf_agente);
        
        if (isset($this->id_agente)) {
            $stmt->bindParam(':id', $this->id_agente);
        }

        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function getActiveAgents() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE status_agente = 'Ativo' ORDER BY nome_agente ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>

