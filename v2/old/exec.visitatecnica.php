<?php session_start();

require_once('classes/visitatecnica.class.php');
require_once('classes/tecnico.class.php');
require_once('classes/conexao.class.php');
require_once('classes/funcao.class.php');


$conexao = new Conexao;

$conn = $conexao->Conectar();

$VisitaTecnica = new VisitaTecnica();
$VisitaTecnica->conn = $conn;

$operacao = $_REQUEST['op'];


if (($operacao=='I') || ($operacao=='A'))
{
		
	$fechar = $_REQUEST['fechar'];
	$idvisitatecnica = $_REQUEST['id'];
	$idpropriedade = $_REQUEST['cmboxpropriedade'];
	$datavisita = $_REQUEST['edtdatavisita'];
	$horachegada = $_REQUEST['edthorachegada'];
	$horasaida = $_REQUEST['edthorasaida'];
	$mesreferencia = $_REQUEST['edtmesreferencia'];
	$anoreferencia = $_REQUEST['edtanoreferencia'];
	$areaprojeto = $_REQUEST['edtareaprojeto'];
	$idunidademedida = $_REQUEST['cmboxunidademedida'];
	$producaodia = $_REQUEST['edtproducaodia'];
	$vacaslactacao = $_REQUEST['edtvacaslactacao'];
	$vacassecas = $_REQUEST['edtvacassecas'];
	$relatorio = $_REQUEST['edtrelatorio'];
	$dataproximavisita = $_REQUEST['edtdataproximavisita'];
	$idtecnico = $_REQUEST['cmboxtecnico'];

	$VisitaTecnica->idvisitatecnica = $idvisitatecnica;
	$VisitaTecnica->idpropriedade = $idpropriedade;
	$VisitaTecnica->datavisita = $datavisita;
	$VisitaTecnica->horachegada = $horachegada;
	$VisitaTecnica->horasaida = $horasaida;
	$VisitaTecnica->mesreferencia = $mesreferencia;
	$VisitaTecnica->anoreferencia = $anoreferencia;
	$VisitaTecnica->areaprojeto = $areaprojeto;
	$VisitaTecnica->idunidademedida = $idunidademedida;
	$VisitaTecnica->producaodia = $producaodia;
	$VisitaTecnica->numvacaslactacao = $vacaslactacao;
	$VisitaTecnica->numvacassecas = $vacassecas;
	$VisitaTecnica->relatorio = $relatorio;
	$VisitaTecnica->dataproximavisita = $dataproximavisita;
	$VisitaTecnica->idtecnico = $idtecnico;
	
	}

if ($operacao=='I')
{
   if ($result = $VisitaTecnica->incluir())
	{
	 header("Location: cadvisitatecnica.php?op=A&MSGCODIGO=23&id=$result");
	}
	else
	{
	 header("Location: cadvisitatecnica.php?op=I&MSGCODIGO=24");
	}

}

if ($operacao=='A')

{
    if ($result = $VisitaTecnica->alterar($idvisitatecnica))
	{
	 header("Location: cadvisitatecnica.php?op=A&MSGCODIGO=25&id=$id");
	}
	else
	{
	 header("Location: cadvisitatecnica.php?op=A&MSGCODIGO=26&id=$id");
	}
   
}

if ($operacao=='E')
{
    $id = $_REQUEST['id'];
    if (!empty($id)){
 		$result = $VisitaTecnica->excluir($id);
	}
	else
	{
		$box=$_POST['id_visitatecnica'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $VisitaTecnica->excluir($val);
		}
	}
	header("Location: consvisitatecnica.php");	
}



?>



