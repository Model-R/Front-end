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

$type = $_REQUEST['table'];
$expid = $_REQUEST['expid'];

if($type == 'exp'){
    //output headers so that the file is downloaded rather than displayed
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=experimentos.csv');

    // create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // output the column headings
    fputs($output, implode(array('Experimento', 'Descrição', 'Usuário', 'Status'), ';')."\n");

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
        fputs($output, implode($row, ';')."\n");
    }
}
else if ($type == 'points'){
    //output headers so that the file is downloaded rather than displayed
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=dadosambientais.csv');

    // create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // output the column headings
    fputs($output, implode(array('idexperimento', 'herbário', 'tombo', 'taxon','coletor','número coleta', 'status','localização', 'latitude', 'longitude'), ';')."\n");

 
    // fetch the data
    $sql = "select idexperiment,herbario, numtombo,taxon,collector,collectnumber,statusoccurrence,country || ' - ' || majorarea || ' - ' ||  minorarea as localizacao,
    case when lat2 is not null then lat2 else lat end as lat,
    case when long2 is not null then long2
    else long end as long
    from modelr.occurrence, modelr.statusoccurrence where 
    occurrence.idstatusoccurrence = statusoccurrence.idstatusoccurrence and
    idexperiment = ".$expid;

    $res = pg_exec($conn,$sql);

    // loop over the rows, outputting them
    while ($row = pg_fetch_assoc($res)) {
        fputs($output, implode($row, ';')."\n");
    }
}

?>