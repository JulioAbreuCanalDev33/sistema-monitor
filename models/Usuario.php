<?php
require_once 'config/Database.php';

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nome;
    public $email;
    public $senha;
    public $nivel;
    public $ativo;
    public $ultimo_login;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function login($email, $senha) {
        $query = "SELECT id, nome, email, senha, nivel, ativo FROM " . $this->table_name . " 
                  WHERE email = :email AND ativo = 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (password_verify($senha, $row['senha'])) {
                $this->id = $row['id'];
                $this->nome = $row['nome'];
                $this->email = $row['email'];
                $this->nivel = $row['nivel'];
                
                // Atualizar último login
                $this->updateLastLogin();
                
                return true;
            }
        }
        
        return false;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (nome, email, senha, nivel, ativo) 
                  VALUES (:nome, :email, :senha, :nivel, :ativo)";

        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->senha = password_hash($this->senha, PASSWORD_DEFAULT);
        $this->nivel = htmlspecialchars(strip_tags($this->nivel));

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':senha', $this->senha);
        $stmt->bindParam(':nivel', $this->nivel);
        $stmt->bindParam(':ativo', $this->ativo);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT id, nome, email, nivel, ativo, ultimo_login, created_at 
                  FROM " . $this->table_name . " 
                  ORDER BY nome ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function readOne() {
        $query = "SELECT id, nome, email, nivel, ativo, ultimo_login, created_at 
                  FROM " . $this->table_name . " 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->nome = $row['nome'];
            $this->email = $row['email'];
            $this->nivel = $row['nivel'];
            $this->ativo = $row['ativo'];
            $this->ultimo_login = $row['ultimo_login'];
            return true;
        }

        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET nome = :nome, email = :email, nivel = :nivel, ativo = :ativo";
        
        if (!empty($this->senha)) {
            $query .= ", senha = :senha";
        }
        
        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->nivel = htmlspecialchars(strip_tags($this->nivel));

        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':nivel', $this->nivel);
        $stmt->bindParam(':ativo', $this->ativo);
        $stmt->bindParam(':id', $this->id);

        if (!empty($this->senha)) {
            $this->senha = password_hash($this->senha, PASSWORD_DEFAULT);
            $stmt->bindParam(':senha', $this->senha);
        }

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

    private function updateLastLogin() {
        $query = "UPDATE " . $this->table_name . " 
                  SET ultimo_login = NOW() 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    public function emailExists() {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE email = :email";
        
        if (isset($this->id)) {
            $query .= " AND id != :id";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        
        if (isset($this->id)) {
            $stmt->bindParam(':id', $this->id);
        }

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
?>

