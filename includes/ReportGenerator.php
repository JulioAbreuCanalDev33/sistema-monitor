<?php
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use TCPDF;

class ReportGenerator {
    private $conn;
    
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function generateAtendimentosPDF($filters = []) {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Configurações do PDF
        $pdf->SetCreator('Sistema de Monitoramento');
        $pdf->SetAuthor('Sistema de Monitoramento');
        $pdf->SetTitle('Relatório de Atendimentos');
        $pdf->SetSubject('Relatório de Atendimentos');
        
        // Configurar header e footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        // Adicionar página
        $pdf->AddPage();
        
        // Título
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Relatório de Atendimentos', 0, 1, 'C');
        $pdf->Ln(5);
        
        // Data do relatório
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'Gerado em: ' . date('d/m/Y H:i:s'), 0, 1, 'R');
        $pdf->Ln(10);
        
        // Buscar dados
        $query = "SELECT a.*, c.nome_empresa as cliente_nome, ag.nome as agente_nome 
                  FROM atendimentos a 
                  LEFT JOIN clientes c ON a.id_cliente = c.id_cliente 
                  LEFT JOIN agentes ag ON a.id_agente = ag.id_agente 
                  ORDER BY a.hora_local DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        // Cabeçalho da tabela
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(20, 7, 'ID', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Solicitante', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Cliente', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Status', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Data/Hora', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Valor', 1, 1, 'C');
        
        // Dados da tabela
        $pdf->SetFont('helvetica', '', 7);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pdf->Cell(20, 6, $row['id_atendimento'], 1, 0, 'C');
            $pdf->Cell(40, 6, substr($row['solicitante'], 0, 25), 1, 0, 'L');
            $pdf->Cell(30, 6, substr($row['cliente_nome'], 0, 20), 1, 0, 'L');
            $pdf->Cell(25, 6, $row['status_atendimento'], 1, 0, 'C');
            $pdf->Cell(30, 6, date('d/m/Y H:i', strtotime($row['hora_local'])), 1, 0, 'C');
            $pdf->Cell(25, 6, 'R$ ' . number_format($row['valor_patrimonial'], 2, ',', '.'), 1, 1, 'R');
        }
        
        $filename = 'reports/atendimentos_' . date('Y-m-d_H-i-s') . '.pdf';
        $pdf->Output(__DIR__ . '/../' . $filename, 'F');
        
        return $filename;
    }
    
    public function generateAtendimentosExcel($filters = []) {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Título
        $sheet->setCellValue('A1', 'Relatório de Atendimentos');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        
        // Data
        $sheet->setCellValue('A2', 'Gerado em: ' . date('d/m/Y H:i:s'));
        $sheet->mergeCells('A2:F2');
        
        // Cabeçalhos
        $headers = ['ID', 'Solicitante', 'Cliente', 'Status', 'Data/Hora', 'Valor'];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '4', $header);
            $sheet->getStyle($col . '4')->getFont()->setBold(true);
            $col++;
        }
        
        // Buscar dados
        $query = "SELECT a.*, c.nome_empresa as cliente_nome, ag.nome as agente_nome 
                  FROM atendimentos a 
                  LEFT JOIN clientes c ON a.id_cliente = c.id_cliente 
                  LEFT JOIN agentes ag ON a.id_agente = ag.id_agente 
                  ORDER BY a.hora_local DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        // Dados
        $row = 5;
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sheet->setCellValue('A' . $row, $data['id_atendimento']);
            $sheet->setCellValue('B' . $row, $data['solicitante']);
            $sheet->setCellValue('C' . $row, $data['cliente_nome']);
            $sheet->setCellValue('D' . $row, $data['status_atendimento']);
            $sheet->setCellValue('E' . $row, date('d/m/Y H:i', strtotime($data['hora_local'])));
            $sheet->setCellValue('F' . $row, $data['valor_patrimonial']);
            $row++;
        }
        
        // Auto-ajustar colunas
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        $writer = new Xlsx($spreadsheet);
        $filename = 'reports/atendimentos_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer->save(__DIR__ . '/../' . $filename);
        
        return $filename;
    }
    
    public function generateOcorrenciasVeicularesPDF() {
        // Similar ao método de atendimentos, mas para ocorrências veiculares
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        $pdf->SetCreator('Sistema de Monitoramento');
        $pdf->SetTitle('Relatório de Ocorrências Veiculares');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'Relatório de Ocorrências Veiculares', 0, 1, 'C');
        $pdf->Ln(5);
        
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'Gerado em: ' . date('d/m/Y H:i:s'), 0, 1, 'R');
        $pdf->Ln(10);
        
        $query = "SELECT * FROM ocorrencias_veiculares ORDER BY data_hora_evento DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(20, 7, 'ID', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Cliente', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Serviço', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Data/Hora', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Valor', 1, 1, 'C');
        
        $pdf->SetFont('helvetica', '', 7);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pdf->Cell(20, 6, $row['id'], 1, 0, 'C');
            $pdf->Cell(40, 6, substr($row['cliente'], 0, 25), 1, 0, 'L');
            $pdf->Cell(30, 6, substr($row['servico'], 0, 20), 1, 0, 'L');
            $pdf->Cell(30, 6, date('d/m/Y H:i', strtotime($row['data_hora_evento'])), 1, 0, 'C');
            $pdf->Cell(25, 6, 'R$ ' . number_format($row['valor_veicular'], 2, ',', '.'), 1, 1, 'R');
        }
        
        $filename = 'reports/ocorrencias_veiculares_' . date('Y-m-d_H-i-s') . '.pdf';
        $pdf->Output(__DIR__ . '/../' . $filename, 'F');
        
        return $filename;
    }
}
?>

