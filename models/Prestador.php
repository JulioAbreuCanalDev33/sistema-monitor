<?php
require_once 'config/database.php';

class Prestador {
    private $conn;
    private $table_name = "tabela_prestadores";

    public $id;
    public $nome_prestador;
    public $equipes;
    public $servico_prestador;
    public $cpf_prestador;
    public $rg_prestador;
    public $email_prestador;
    public $telefone_1_prestador;
    public $telefone_2_prestador;
    public $cep_prestador;
    public $endereco_prestador;
    public $numero_prestador;
    public $bairro_prestador;
    public $cidade_prestador;
    public $estado_prestador;
    public $observacao;
    public $documento_prestador;
    public $foto_prestador;
    public $codigo_do_banco;
    public $pix_banco_prestadores;
    public $titular_conta;
    public $tipo_de_conta;
    public $agencia_prestadores;
    public $digito_agencia_prestadores;
    public $conta_prestadores;
    public $digito_conta_prestadores;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (nome_prestador, equipes, servico_prestador, cpf_prestador, rg_prestador, 
                   email_prestador, telefone_1_prestador, telefone_2_prestador, cep_prestador, 
                   endereco_prestador, numero_prestador, bairro_prestador, cidade_prestador, 
                   estado_prestador, observacao, documento_prestador, foto_prestador, 
                   codigo_do_banco, pix_banco_prestadores, titular_conta, tipo_de_conta, 
                   agencia_prestadores, digito_agencia_prestadores, conta_prestadores, 
                   digito_conta_prestadores) 
                  VALUES 
                  (:nome_prestador, :equipes, :servico_prestador, :cpf_prestador, :rg_prestador, 
                   :email_prestador, :telefone_1_prestador, :telefone_2_prestador, :cep_prestador, 
                   :endereco_prestador, :numero_prestador, :bairro_prestador, :cidade_prestador, 
                   :estado_prestador, :observacao, :documento_prestador, :foto_prestador, 
                   :codigo_do_banco, :pix_banco_prestadores, :titular_conta, :tipo_de_conta, 
                   :agencia_prestadores, :digito_agencia_prestadores, :conta_prestadores, 
                   :digito_conta_prestadores)";

        $stmt = $this->conn->prepare($query);

        // Sanitizar dados
        $this->nome_prestador = htmlspecialchars(strip_tags($this->nome_prestador));
        $this->email_prestador = htmlspecialchars(strip_tags($this->email_prestador));
        $this->endereco_prestador = htmlspecialchars(strip_tags($this->endereco_prestador));

        // Bind dos parâmetros
        $stmt->bindParam(':nome_prestador', $this->nome_prestador);
        $stmt->bindParam(':equipes', $this->equipes);
        $stmt->bindParam(':servico_prestador', $this->servico_prestador);
        $stmt->bindParam(':cpf_prestador', $this->cpf_prestador);
        $stmt->bindParam(':rg_prestador', $this->rg_prestador);
        $stmt->bindParam(':email_prestador', $this->email_prestador);
        $stmt->bindParam(':telefone_1_prestador', $this->telefone_1_prestador);
        $stmt->bindParam(':telefone_2_prestador', $this->telefone_2_prestador);
        $stmt->bindParam(':cep_prestador', $this->cep_prestador);
        $stmt->bindParam(':endereco_prestador', $this->endereco_prestador);
        $stmt->bindParam(':numero_prestador', $this->numero_prestador);
        $stmt->bindParam(':bairro_prestador', $this->bairro_prestador);
        $stmt->bindParam(':cidade_prestador', $this->cidade_prestador);
        $stmt->bindParam(':estado_prestador', $this->estado_prestador);
        $stmt->bindParam(':observacao', $this->observacao);
        $stmt->bindParam(':documento_prestador', $this->documento_prestador);
        $stmt->bindParam(':foto_prestador', $this->foto_prestador);
        $stmt->bindParam(':codigo_do_banco', $this->codigo_do_banco);
        $stmt->bindParam(':pix_banco_prestadores', $this->pix_banco_prestadores);
        $stmt->bindParam(':titular_conta', $this->titular_conta);
        $stmt->bindParam(':tipo_de_conta', $this->tipo_de_conta);
        $stmt->bindParam(':agencia_prestadores', $this->agencia_prestadores);
        $stmt->bindParam(':digito_agencia_prestadores', $this->digito_agencia_prestadores);
        $stmt->bindParam(':conta_prestadores', $this->conta_prestadores);
        $stmt->bindParam(':digito_conta_prestadores', $this->digito_conta_prestadores);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome_prestador ASC";
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
            $this->nome_prestador = $row['nome_prestador'];
            $this->equipes = $row['equipes'];
            $this->servico_prestador = $row['servico_prestador'];
            $this->cpf_prestador = $row['cpf_prestador'];
            $this->rg_prestador = $row['rg_prestador'];
            $this->email_prestador = $row['email_prestador'];
            $this->telefone_1_prestador = $row['telefone_1_prestador'];
            $this->telefone_2_prestador = $row['telefone_2_prestador'];
            $this->cep_prestador = $row['cep_prestador'];
            $this->endereco_prestador = $row['endereco_prestador'];
            $this->numero_prestador = $row['numero_prestador'];
            $this->bairro_prestador = $row['bairro_prestador'];
            $this->cidade_prestador = $row['cidade_prestador'];
            $this->estado_prestador = $row['estado_prestador'];
            $this->observacao = $row['observacao'];
            $this->documento_prestador = $row['documento_prestador'];
            $this->foto_prestador = $row['foto_prestador'];
            $this->codigo_do_banco = $row['codigo_do_banco'];
            $this->pix_banco_prestadores = $row['pix_banco_prestadores'];
            $this->titular_conta = $row['titular_conta'];
            $this->tipo_de_conta = $row['tipo_de_conta'];
            $this->agencia_prestadores = $row['agencia_prestadores'];
            $this->digito_agencia_prestadores = $row['digito_agencia_prestadores'];
            $this->conta_prestadores = $row['conta_prestadores'];
            $this->digito_conta_prestadores = $row['digito_conta_prestadores'];
            return true;
        }

        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nome_prestador = :nome_prestador, equipes = :equipes, 
                      servico_prestador = :servico_prestador, cpf_prestador = :cpf_prestador,
                      rg_prestador = :rg_prestador, email_prestador = :email_prestador,
                      telefone_1_prestador = :telefone_1_prestador, telefone_2_prestador = :telefone_2_prestador,
                      cep_prestador = :cep_prestador, endereco_prestador = :endereco_prestador,
                      numero_prestador = :numero_prestador, bairro_prestador = :bairro_prestador,
                      cidade_prestador = :cidade_prestador, estado_prestador = :estado_prestador,
                      observacao = :observacao, documento_prestador = :documento_prestador,
                      foto_prestador = :foto_prestador, codigo_do_banco = :codigo_do_banco,
                      pix_banco_prestadores = :pix_banco_prestadores, titular_conta = :titular_conta,
                      tipo_de_conta = :tipo_de_conta, agencia_prestadores = :agencia_prestadores,
                      digito_agencia_prestadores = :digito_agencia_prestadores, 
                      conta_prestadores = :conta_prestadores,
                      digito_conta_prestadores = :digito_conta_prestadores
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitizar dados
        $this->nome_prestador = htmlspecialchars(strip_tags($this->nome_prestador));
        $this->email_prestador = htmlspecialchars(strip_tags($this->email_prestador));
        $this->endereco_prestador = htmlspecialchars(strip_tags($this->endereco_prestador));

        // Bind dos parâmetros
        $stmt->bindParam(':nome_prestador', $this->nome_prestador);
        $stmt->bindParam(':equipes', $this->equipes);
        $stmt->bindParam(':servico_prestador', $this->servico_prestador);
        $stmt->bindParam(':cpf_prestador', $this->cpf_prestador);
        $stmt->bindParam(':rg_prestador', $this->rg_prestador);
        $stmt->bindParam(':email_prestador', $this->email_prestador);
        $stmt->bindParam(':telefone_1_prestador', $this->telefone_1_prestador);
        $stmt->bindParam(':telefone_2_prestador', $this->telefone_2_prestador);
        $stmt->bindParam(':cep_prestador', $this->cep_prestador);
        $stmt->bindParam(':endereco_prestador', $this->endereco_prestador);
        $stmt->bindParam(':numero_prestador', $this->numero_prestador);
        $stmt->bindParam(':bairro_prestador', $this->bairro_prestador);
        $stmt->bindParam(':cidade_prestador', $this->cidade_prestador);
        $stmt->bindParam(':estado_prestador', $this->estado_prestador);
        $stmt->bindParam(':observacao', $this->observacao);
        $stmt->bindParam(':documento_prestador', $this->documento_prestador);
        $stmt->bindParam(':foto_prestador', $this->foto_prestador);
        $stmt->bindParam(':codigo_do_banco', $this->codigo_do_banco);
        $stmt->bindParam(':pix_banco_prestadores', $this->pix_banco_prestadores);
        $stmt->bindParam(':titular_conta', $this->titular_conta);
        $stmt->bindParam(':tipo_de_conta', $this->tipo_de_conta);
        $stmt->bindParam(':agencia_prestadores', $this->agencia_prestadores);
        $stmt->bindParam(':digito_agencia_prestadores', $this->digito_agencia_prestadores);
        $stmt->bindParam(':conta_prestadores', $this->conta_prestadores);
        $stmt->bindParam(':digito_conta_prestadores', $this->digito_conta_prestadores);
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

    public function emailExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email_prestador = :email";
        
        if (isset($this->id)) {
            $query .= " AND id != :id";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email_prestador);
        
        if (isset($this->id)) {
            $stmt->bindParam(':id', $this->id);
        }

        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function cpfExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE cpf_prestador = :cpf";
        
        if (isset($this->id)) {
            $query .= " AND id != :id";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cpf', $this->cpf_prestador);
        
        if (isset($this->id)) {
            $stmt->bindParam(':id', $this->id);
        }

        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>

