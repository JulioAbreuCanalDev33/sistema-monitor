<?php


require_once __DIR__ . '/../config/database.php'; // ou o caminho correto para sua classe Database
class DashboardController
{



    // ...existing code...
    public function index()
    {
        $stats = $this->getStatistics();
        include 'views/dashboard.php';
    }

    private function getStatistics()
    {
        $database = new Database();
        $conn = $database->getConnection();

        $stats = [];

        // Total de atendimentos
        $query = "SELECT COUNT(*) as total FROM atendimentos";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stats['total_atendimentos'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Atendimentos em andamento
        $query = "SELECT COUNT(*) as total FROM atendimentos WHERE status_atendimento = 'Em andamento'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stats['atendimentos_andamento'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total de ocorrências veiculares
        $query = "SELECT COUNT(*) as total FROM ocorrencias_veiculares";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stats['total_ocorrencias'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total de vigilância veicular
        $query = "SELECT COUNT(*) as total FROM vigilancia_veicular";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stats['total_vigilancia'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total de prestadores
        $query = "SELECT COUNT(*) as total FROM tabela_prestadores";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stats['total_prestadores'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Total de clientes
        $query = "SELECT COUNT(*) as total FROM clientes";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stats['total_clientes'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Atendimentos por mês (últimos 6 meses)
        $query = "SELECT DATE_FORMAT(hora_local, '%Y-%m') as mes, COUNT(*) as total 
                  FROM atendimentos 
                  WHERE hora_local >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                  GROUP BY DATE_FORMAT(hora_local, '%Y-%m')
                  ORDER BY mes";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stats['atendimentos_mes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $stats;
    }
}
