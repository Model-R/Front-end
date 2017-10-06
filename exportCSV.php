<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Experimento = new Experimento();
$Experimento->conn = $conn;

//output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=experimentos.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('Experimento', 'Descrição', 'Usuário', 'Status'));

if ($_SESSION['s_idtipousuario']=='1') {
   // fetch the data
    $sql = "select modelr.experiment.name as name, modelr.experiment.description as description, modelr.user.name as username, modelr.experiment.idstatusexperiment as idstatusexperiment 
    from modelr.experiment inner join modelr.user on modelr.experiment.iduser=modelr.user.iduser
    where modelr.experiment.iduser = " . $_SESSION['s_idusuario'];
}
else {
    // fetch the data
    $sql = "select modelr.experiment.name as name, modelr.experiment.description as description, modelr.user.name as username, modelr.experiment.idstatusexperiment as idstatusexperiment 
    from modelr.experiment inner join modelr.user on modelr.experiment.iduser=modelr.user.iduser";
}

$res = pg_exec($conn,$sql);

// loop over the rows, outputting them
while ($row = pg_fetch_assoc($res)) {
    if($row['idstatusexperiment'] == 1) $row['idstatusexperiment'] = 'Aguardando';
    if($row['idstatusexperiment'] == 2) $row['idstatusexperiment'] = 'Liberado';
    if($row['idstatusexperiment'] == 3) $row['idstatusexperiment'] = 'Em processamento';
    if($row['idstatusexperiment'] == 4) $row['idstatusexperiment'] = 'Processado';
    fputcsv($output, $row);
}

?>