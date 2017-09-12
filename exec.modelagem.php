<?php session_start();
//error_reporting(E_ALL);
//ini_set('display_errors','1');

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');


$conexao = new Conexao;
$conn = $conexao->Conectar();

$Experimento = new Experimento();
$Experimento->conn = $conn;

$operacao = $_REQUEST['op'];
$id = $_REQUEST['id'];


$extensao1 = $_REQUEST['edtextensao1_oeste'].';'.$_REQUEST['edtextensao1_leste'].';'.$_REQUEST['edtextensao1_norte'].';'.$_REQUEST['edtextensao1_sul'];
//$extensao2 = $_REQUEST['edtextensao2_oeste'].';'.$_REQUEST['edtextensao2_leste'].';'.$_REQUEST['edtextensao2_norte'].';'.$_REQUEST['edtextensao2_sul'];

$nome = $_REQUEST['edtexperimento'];
$descricao = $_REQUEST['edtdescricao'];
$idfonte = $_REQUEST['cmboxfonte'];
$idtipoparticionamento = $_REQUEST['cmboxtipoparticionamento'];
$numpontos = $_REQUEST['edtnumpontos'];
$buffer = $_REQUEST['edtbuffer'];
$tss = $_REQUEST['edttss'];
$numparticoes = $_REQUEST['edtnumparticoes'];


$Experimento->name = $nome;//integer,
$Experimento->description = $descricao;//integer,
$Experimento->idpartitiontype = $idtipoparticionamento;//integer,
$Experimento->num_partition = $numparticoes;//integer,
$Experimento->num_points = $numpontos ;//integer,
$Experimento->buffer = $buffer;//numeric(10,2),
$Experimento->tss = $tss;
$Experimento->extent_model = $extensao1;
//$Experimento->extent_projection = $extensao2;

$box=$_REQUEST['raster'];
while (list ($key,$val) = @each($box)) { 
	$result = $Experimento->incluirRaster($id,$val);
}

//print_r($_REQUEST);
//exit;

$box=$_REQUEST['algoritmo'];
while (list ($key,$val) = @each($box)) { 
	$result = $Experimento->incluirAlgoritmo($id,$val);
}


if ($result = $Experimento->alterar($id))
{
	header("Location: consexperimento.php?op=A&MSGCODIGO=84&id=$id");
}
else
{
	header("Location: consexperimento.php?op=A&MSGCODIGO=85&id=$id");
}
?>



