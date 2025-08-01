<?php
require_once 'config/Database.php';

class VigilanciaVeicular {
    private $conn;
    private $table_name = "vigilancia_veicular";

    public $id;
    public $veiculo;
    public $condutor;
    public $data_hora_inicio;
    public $data_hora_fim;
    public $localizacao_inicial;
    public $localizacao_final;
    public $km_inicial;
    public $km_final;
    public $combustivel_inicial;
    public $combustivel_final;
    public $observacoes;
    public $status_vigilancia;
    public $fotos_vigilancia;
    public $responsavel;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (veiculo, condutor, data_hora_inicio, data_hora_fim, localizacao_inicial, 
                   localizacao_final, km_inicial, km_final, combustivel_inicial, combustivel_final, 
                   observacoes, status_vigilancia, fotos_vigilancia, responsavel) 
                  VALUES 
                  (:veiculo, :condutor, :data_hora_inicio, :data_hora_fim, :localizacao_inicial, 
                   :localizacao_final, :km_inicial, :km_final, :combustivel_inicial, :combustivel_final, 
                   :observacoes, :status_vigilancia, :fotos_vigilancia, :responsavel)";

        $stmt = $this->conn->prepare($query);

        // Sanitizar dados
        $this->veiculo = htmlspecialchars(strip_tags($this->veiculo));
        $this->condutor = htmlspecialchars(strip_tags($this->condutor));
        $this->localizacao_inicial = htmlspecialchars(strip_tags($this->localizacao_inicial));
        $this->localizacao_final = htmlspecialchars(strip_tags($this->localizacao_final));

        $stmt->bindParam(':veiculo', $this->veiculo);
        $stmt->bindParam(':condutor', $this->condutor);
        $stmt->bindParam(':data_hora_inicio', $this->data_hora_inicio);
        $stmt->bindParam(':data_hora_fim', $this->data_hora_fim);
        $stmt->bindParam(':localizacao_inicial', $this->localizacao_inicial);
        $stmt->bindParam(':localizacao_final', $this->localizacao_final);
        $stmt->bindParam(':km_inicial', $this->km_inicial);
        $stmt->bindParam(':km_final', $this->km_final);
        $stmt->bindParam(':combustivel_inicial', $this->combustivel_inicial);
        $stmt->bindParam(':combustivel_final', $this->combustivel_final);
        $stmt->bindParam(':observacoes', $this->observacoes);
        $stmt->bindParam(':status_vigilancia', $this->status_vigilancia);
        $stmt->bindParam(':fotos_vigilancia', $this->fotos_vigilancia);
        $stmt->bindParam(':responsavel', $this->responsavel);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY data_hora_inicio DESC";
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
            $this->veiculo = $row['veiculo'];
            $this->condutor = $row['condutor'];
            $this->data_hora_inicio = $row['data_hora_inicio'];
            $this->data_hora_fim = $row['data_hora_fim'];
            $this->localizacao_inicial = $row['localizacao_inicial'];
            $this->localizacao_final = $row['localizacao_final'];
            $this->km_inicial = $row['km_inicial'];
            $this->km_final = $row['km_final'];
            $this->combustivel_inicial = $row['combustivel_inicial'];
            $this->combustivel_final = $row['combustivel_final'];
            $this->observacoes = $row['observacoes'];
            $this->status_vigilancia = $row['status_vigilancia'];
            $this->fotos_vigilancia = $row['fotos_vigilancia'];
            $this->responsavel = $row['responsavel'];
            return true;
        }

        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET veiculo = :veiculo, condutor = :condutor, data_hora_inicio = :data_hora_inicio,
                      data_hora_fim = :data_hora_fim, localizacao_inicial = :localizacao_inicial,
                      localizacao_final = :localizacao_final, km_inicial = :km_inicial,
                      km_final = :km_final, combustivel_inicial = :combustivel_inicial,
                      combustivel_final = :combustivel_final, observacoes = :observacoes,
                      status_vigilancia = :status_vigilancia, fotos_vigilancia = :fotos_vigilancia,
                      responsavel = :responsavel
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitizar dados
        $this->veiculo = htmlspecialchars(strip_tags($this->veiculo));
        $this->condutor = htmlspecialchars(strip_tags($this->condutor));
        $this->localizacao_inicial = htmlspecialchars(strip_tags($this->localizacao_inicial));
        $this->localizacao_final = htmlspecialchars(strip_tags($this->localizacao_final));

        $stmt->bindParam(':veiculo', $this->veiculo);
        $stmt->bindParam(':condutor', $this->condutor);
        $stmt->bindParam(':data_hora_inicio', $this->data_hora_inicio);
        $stmt->bindParam(':data_hora_fim', $this->data_hora_fim);
        $stmt->bindParam(':localizacao_inicial', $this->localizacao_inicial);
        $stmt->bindParam(':localizacao_final', $this->localizacao_final);
        $stmt->bindParam(':km_inicial', $this->km_inicial);
        $stmt->bindParam(':km_final', $this->km_final);
        $stmt->bindParam(':combustivel_inicial', $this->combustivel_inicial);
        $stmt->bindParam(':combustivel_final', $this->combustivel_final);
        $stmt->bindParam(':observacoes', $this->observacoes);
        $stmt->bindParam(':status_vigilancia', $this->status_vigilancia);
        $stmt->bindParam(':fotos_vigilancia', $this->fotos_vigilancia);
        $stmt->bindParam(':responsavel', $this->responsavel);
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

    public function getKmPercorrido() {
        if ($this->km_final && $this->km_inicial) {
            return $this->km_final - $this->km_inicial;
        }
        return 0;
    }

    public function getCombustivelConsumido() {
        if ($this->combustivel_inicial && $this->combustivel_final) {
            return $this->combustivel_inicial - $this->combustivel_final;
        }
        return 0;
    }
}
?>

