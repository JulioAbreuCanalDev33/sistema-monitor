<?php
require_once 'config/database.php';

class Cliente {
    private $conn;
    private $table_name = "clientes";

    public $id_cliente;
    public $nome_empresa;
    public $cnpj;
    public $contato;
    public $endereco;
    public $telefone;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (nome_empresa, cnpj, contato, endereco, telefone) 
                  VALUES 
                  (:nome_empresa, :cnpj, :contato, :endereco, :telefone)";

        $stmt = $this->conn->prepare($query);

        // Sanitizar dados
        $this->nome_empresa = htmlspecialchars(strip_tags($this->nome_empresa));
        $this->contato = htmlspecialchars(strip_tags($this->contato));
        $this->endereco = htmlspecialchars(strip_tags($this->endereco));

        $stmt->bindParam(':nome_empresa', $this->nome_empresa);
        $stmt->bindParam(':cnpj', $this->cnpj);
        $stmt->bindParam(':contato', $this->contato);
        $stmt->bindParam(':endereco', $this->endereco);
        $stmt->bindParam(':telefone', $this->telefone);

        if ($stmt->execute()) {
            $this->id_cliente = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY nome_empresa ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_cliente = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id_cliente);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nome_empresa = $row['nome_empresa'];
            $this->cnpj = $row['cnpj'];
            $this->contato = $row['contato'];
            $this->endereco = $row['endereco'];
            $this->telefone = $row['telefone'];
            return true;
        }

        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nome_empresa = :nome_empresa, cnpj = :cnpj, contato = :contato,
                      endereco = :endereco, telefone = :telefone
                  WHERE id_cliente = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitizar dados
        $this->nome_empresa = htmlspecialchars(strip_tags($this->nome_empresa));
        $this->contato = htmlspecialchars(strip_tags($this->contato));
        $this->endereco = htmlspecialchars(strip_tags($this->endereco));

        $stmt->bindParam(':nome_empresa', $this->nome_empresa);
        $stmt->bindParam(':cnpj', $this->cnpj);
        $stmt->bindParam(':contato', $this->contato);
        $stmt->bindParam(':endereco', $this->endereco);
        $stmt->bindParam(':telefone', $this->telefone);
        $stmt->bindParam(':id', $this->id_cliente);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_cliente = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id_cliente);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function cnpjExists() {
        $query = "SELECT id_cliente FROM " . $this->table_name . " WHERE cnpj = :cnpj";
        
        if (isset($this->id_cliente)) {
            $query .= " AND id_cliente != :id";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cnpj', $this->cnpj);
        
        if (isset($this->id_cliente)) {
            $stmt->bindParam(':id', $this->id_cliente);
        }

        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>

