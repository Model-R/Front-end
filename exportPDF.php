<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors','1');

    require_once('classes/experimento.class.php');
    require_once('classes/conexao.class.php');
    require('fpdf/fpdf.php');

    $conexao = new Conexao;
    $conn = $conexao->Conectar();
    $Experimento = new Experimento();
    $Experimento->conn = $conn;
    
    $pdf = new FPDF();
    $pdf->AddPage('Landscape');
    $pdf->SetFont('Arial','B',12);

    if ($_SESSION['s_idtipousuario']=='1') {
    // fetch the data
        $sql = "select modelr.experiment.name as name, modelr.experiment.description as description, modelr.experiment.idstatusexperiment as idstatusexperiment 
        from modelr.experiment inner join modelr.user on modelr.experiment.iduser=modelr.user.iduser
        where modelr.experiment.iduser = " . $_SESSION['s_idusuario'];

        $header = array('Experimento', 'Descrição', 'Status');
    }
    else {
        // fetch the data
        $sql = "select modelr.experiment.name as name, modelr.experiment.description as description, modelr.user.name as username, modelr.experiment.idstatusexperiment as idstatusexperiment 
        from modelr.experiment inner join modelr.user on modelr.experiment.iduser=modelr.user.iduser";

        $header = array('Experimento', 'Descrição', 'Usuário', 'Status');
    }
    
    $res = pg_exec($conn,$sql);

    foreach($header as $title) {
        $pdf->SetFillColor(63,83,103);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(70,12,$title,1,0,'C', true);
    }

    while($rows = pg_fetch_assoc($res)) {
        $pdf->SetFont('Arial','',12);
        $pdf->SetTextColor(0,0,0);
        $pdf->Ln();
       
        if($rows['idstatusexperiment'] == 1) $rows['idstatusexperiment'] = 'Aguardando';
        if($rows['idstatusexperiment'] == 2) $rows['idstatusexperiment'] = 'Liberado';
        if($rows['idstatusexperiment'] == 3) $rows['idstatusexperiment'] = 'Em processamento';
        if($rows['idstatusexperiment'] == 4) $rows['idstatusexperiment'] = 'Processado';

        foreach($rows as $column) {
            $pdf->Cell(70,12,$column,1);
        }
    }

    $pdf->Output();
?>