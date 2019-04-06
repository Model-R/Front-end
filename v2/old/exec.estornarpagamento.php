<?php session_start();
require_once('classes/visitatecnica.class.php');
require_once('classes/conexao.class.php');

$conexao = new Conexao;
$conn = $conexao->Conectar();
$VisitaTecnica = new VisitaTecnica();
$VisitaTecnica->conn = $conn;


//print_r($_REQUEST);

	$motivo = $_REQUEST['edtmotivo'];
	$box=$_POST['id_visitatecnica'];
	
	if ((!empty($box)) && (!empty($motivo)) )
	{
		while (list ($key,$val) = @each($box)) { 
			//print_r($val);
			$result = $VisitaTecnica->estornarPagamento($val,$motivo);
		}
//		exit;
		header('Location: consvisitatecnica.php?FINANC=T');
	}

?>

