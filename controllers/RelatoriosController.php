<?php
require_once 'includes/functions.php';
require_once 'includes/ReportGenerator.php';

class RelatoriosController {
    
    public function index() {
        include 'views/relatorios/index.php';
    }
    
    public function generate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tipo_relatorio = $_POST['tipo_relatorio'] ?? '';
            $formato = $_POST['formato'] ?? 'pdf';
            $data_inicio = $_POST['data_inicio'] ?? '';
            $data_fim = $_POST['data_fim'] ?? '';
            
            $reportGenerator = new ReportGenerator();
            
            try {
                switch ($tipo_relatorio) {
                    case 'atendimentos':
                        if ($formato == 'pdf') {
                            $filename = $reportGenerator->generateAtendimentosPDF([
                                'data_inicio' => $data_inicio,
                                'data_fim' => $data_fim
                            ]);
                        } else {
                            $filename = $reportGenerator->generateAtendimentosExcel([
                                'data_inicio' => $data_inicio,
                                'data_fim' => $data_fim
                            ]);
                        }
                        break;
                        
                    case 'ocorrencias_veiculares':
                        if ($formato == 'pdf') {
                            $filename = $reportGenerator->generateOcorrenciasVeicularesPDF();
                        } else {
                            // Implementar Excel para ocorrências veiculares
                            flash_message('Relatório Excel para ocorrências veiculares em desenvolvimento', 'warning');
                            redirect('index.php?page=relatorios');
                        }
                        break;
                        
                    case 'prestadores':
                        // Implementar relatório de prestadores
                        flash_message('Relatório de prestadores em desenvolvimento', 'warning');
                        redirect('index.php?page=relatorios');
                        break;
                        
                    default:
                        flash_message('Tipo de relatório não encontrado', 'error');
                        redirect('index.php?page=relatorios');
                }
                
                if (isset($filename) && file_exists($filename)) {
                    // Download do arquivo
                    $this->downloadFile($filename);
                } else {
                    flash_message('Erro ao gerar relatório', 'error');
                    redirect('index.php?page=relatorios');
                }
                
            } catch (Exception $e) {
                flash_message('Erro ao gerar relatório: ' . $e->getMessage(), 'error');
                redirect('index.php?page=relatorios');
            }
        }
        
        redirect('index.php?page=relatorios');
    }
    
    private function downloadFile($filepath) {
        if (file_exists($filepath)) {
            $filename = basename($filepath);
            $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
            
            // Definir content type baseado na extensão
            switch ($file_extension) {
                case 'pdf':
                    $content_type = 'application/pdf';
                    break;
                case 'xlsx':
                    $content_type = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                    break;
                case 'csv':
                    $content_type = 'text/csv';
                    break;
                default:
                    $content_type = 'application/octet-stream';
            }
            
            // Headers para download
            header('Content-Type: ' . $content_type);
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . filesize($filepath));
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            
            // Limpar buffer de saída
            ob_clean();
            flush();
            
            // Enviar arquivo
            readfile($filepath);
            
            // Opcional: remover arquivo após download
            // unlink($filepath);
            
            exit;
        }
    }
    
    public function dashboard_data() {
        // Endpoint para dados do dashboard (AJAX)
        header('Content-Type: application/json');
        
        $database = new Database();
        $conn = $database->getConnection();
        
        $data = [];
        
        // Estatísticas gerais
        $queries = [
            'total_atendimentos' => "SELECT COUNT(*) as total FROM atendimentos",
            'total_ocorrencias' => "SELECT COUNT(*) as total FROM ocorrencias_veiculares",
            'total_prestadores' => "SELECT COUNT(*) as total FROM tabela_prestadores",
            'total_clientes' => "SELECT COUNT(*) as total FROM clientes"
        ];
        
        foreach ($queries as $key => $query) {
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $data[$key] = $result['total'];
        }
        
        // Atendimentos por mês (últimos 6 meses)
        $query = "SELECT DATE_FORMAT(hora_local, '%Y-%m') as mes, COUNT(*) as total 
                  FROM atendimentos 
                  WHERE hora_local >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                  GROUP BY DATE_FORMAT(hora_local, '%Y-%m')
                  ORDER BY mes";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $data['atendimentos_mes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($data);
        exit;
    }
}
?>

