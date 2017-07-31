<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors','1');
//print_r($_REQUEST);
//exit;

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Experimento = new Experimento();
$Experimento->conn = $conn;

$idexperimento = $_REQUEST['id'];


$idponto = $_REQUEST['idponto'];
$idstatus = $_REQUEST['idstatus'];
if (($idponto != 'undefined') && (!empty($idponto)))
{
	$Experimento->excluirPonto($idexperimento,$idponto,$idstatus);
}
else
{
	$lista = $_REQUEST['table_records'];
	foreach($lista as $idponto){
		$Experimento->excluirPonto($idexperimento,$idponto,$idstatus);
	}
}
header("Location: cadexperimento.php?op=A&MSGCODIGO=19&pag=2&id=$idexperimento");
?>



