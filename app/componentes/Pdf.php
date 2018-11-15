<?

class Pdf extends FPDF{
       
    function header(){
        //$this->Image('logo.png',10,6);
        $this->SetFont('Arial','B',14);
        $this->Cell(276,10,'RELATÓRIO DE VISITANTES',0,0,'C');
        $this->Ln();
        $this->SetFont('Times','',12);
        $this->Cell(276,10,'Dados extraidos em ' .date('d/m/Y H:m:s'),0,0,'C');
        $this->Ln(20);
    }

    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function headerTable(){
        $this->SetFont('Times','',12);
        $this->Cell(37,10,'ID',1,0,'C');
        $this->Cell(100,10,'NOME',1,0,'C');
        $this->Cell(100,10,'CARGO',1,0,'C');
        $this->Cell(40,10,'DATA INSC.',1,0,'C');
        $this->Ln();
        
    }

    function viewData($dados){
        $this->SetFont('Times','',12);
        for ($i=0; $i < count($dados); $i++) { 
            $this->Cell(37,10,$dados[$i]['idvisitante'],1,0,'C');
            $this->Cell(100,10,$dados[$i]['nome'],1,0,'L');
            $this->Cell(100,10,$dados[$i]['cargo'],1,0,'L');
            $this->Cell(40,10,$dados[$i]['datainsc'],1,0,'L');
            $this->Ln();
        }
    }


}