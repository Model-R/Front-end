<?php session_start();
require_once('classes/visitatecnica.class.php');
require_once('classes/conexao.class.php');

$conexao = new Conexao;
$conn = $conexao->Conectar();
$VisitaTecnica = new VisitaTecnica();
$VisitaTecnica->conn = $conn;


//print_r($_REQUEST);

	$datapagamento = $_REQUEST['edtdatapagamento'];
	$datapagamento = substr($datapagamento,6,4).'-'.substr($datapagamento,3,2).'-'.substr($datapagamento,0,2);
	$valorpago = $_REQUEST['edtvalorpago'];
	$box=$_POST['id_visitatecnica'];
	$idprodutor = $_REQUEST['cmboxidprodutor'];
	$idpropriedade = $_REQUEST['cmboxpropriedade'];
	$idtecnico = $_REQUEST['cmboxtecnico'];
	$ano = $_REQUEST['cmboxano'];
	$mes = $_REQUEST['cmboxmes'];
	$datainicio = $_REQUEST['edtdatainicio'];
	$datatermino = $_REQUEST['edtdatatermino'];
	
	if ((!empty($box)) && (!empty($datapagamento)) && (!empty($valorpago)))
	{
		while (list ($key,$val) = @each($box)) { 
			//print_r($val);
			$result = $VisitaTecnica->pagar($val,$datapagamento,$valorpago);
		}
//		exit;
		header('Location: consvisitatecnica.php?FINANC=T');
	}

?>

