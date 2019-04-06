<?php
require_once('classes/visitasupervisor.class.php');
require_once('classes/configuracao.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();

$Configuracao = new Configuracao();
$Configuracao->conn = $conn;
$Configuracao->getConfiguracao();

$VisitaSupervisor = new VisitaSupervisor();
$VisitaSupervisor->conn = $conn;
$VisitaSupervisor->configuracao = $Configuracao;

//$emailrecebimento = $Configuracao->emailrecebimento;


$operacao = $_REQUEST['op'];

if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$id = $_REQUEST['edtidvisitasupervisor'];
	$idpropriedade = $_REQUEST['cmboxpropriedade'];
	$idusuario = $_REQUEST['cmboxusuario'];
	$datavisita = $_REQUEST['edtdatavisita'];
	$producaodia = $_REQUEST['edtproducaodia'];
	$nunvacaslactacao = $_REQUEST['edtnumvacaslactacao'];
	$numvacassecas = $_REQUEST['edtnumvacassecas'];
	$relatorio = $_REQUEST['edtrelatorio'];
	
	$VisitaSupervisor->idvisitasupervisor = $id;
	$VisitaSupervisor->idpropriedade = $idpropriedade;
	$VisitaSupervisor->idsupervisor = $idusuario;
	$VisitaSupervisor->datavisita = $datavisita;
	$VisitaSupervisor->producaodia = $producaodia;
	$VisitaSupervisor->nunvacaslactacao = $nunvacaslactacao;
	$VisitaSupervisor->numvacassecas = $numvacassecas;
	$VisitaSupervisor->relatorio = $relatorio;
}

if ($operacao=='I')
{

   $result = $VisitaSupervisor->incluir();
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Cadastrar a visita ')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadvisitasupervisor.php?op=I&produtor=".$produtor."</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
        echo "<script language= 'javascript'>parent.corpo.location.href='cadvisitasupervisor.php'</script>";
 	}
}
if ($operacao=='A')
{
   $result = $VisitaSupervisor->alterar($id);
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Alterar a visita do supervisor')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadvisitasupervisor.php?op=A&id=".$idvisitasupervisor."'</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
        echo "<script language= 'javascript'>parent.corpo.location.href='cadvisitasupervisor.php'</script>";
	}
}


if ($operacao=='E')
{
	if (isset($_POST['id_visitasupervisor']))
	{
			$box=$_POST['id_visitasupervisor'];
			while (list ($key,$val) = @each($box)) { 
					$result = $VisitaSupervisor->excluir($val);
			}
   		   echo "<script language= 'javascript'>parent.corpo.location.href='cadvisitasupervisor.php'</script>";
	}
}

?>

