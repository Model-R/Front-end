<?php session_start();
require_once('classes/lactacao.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Lactacao = new Lactacao();
$Lactacao->conn = $conn;

$operacao = $_REQUEST['op'];
$idavaliacao = $_REQUEST['idavaliacao'];

if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$id = $_REQUEST['edtidlactacao'];
	$idanimal = $_REQUEST['edtidanimal'];
	$datacontrole = $_REQUEST['edtdatacontrole'];
	$qtdlitros = $_REQUEST['edtqtdlitros'];
	$periodo = $_REQUEST['edtperiodo'];
	
	$Lactacao->idbalanca = $id;
	$Lactacao->idanimal = $idanimal;
	$Lactacao->datacontrole= $datacontrole;
	$Lactacao->qtdlitros= $qtdlitros;
	$Lactacao->periodo = $periodo;
	
}

if ($operacao=='I')
{

   $result = $Lactacao->incluir();
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Cadastrar a lactação')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadanimal.php?idavaliacao=".$idavaliacao."&id=".$idanimal."&op=A'</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
   		if ($fechar == 's')
   		{
		   echo "<script language= 'javascript'>parent.corpo.location.href='cadanimal.php?idavaliacao=".$idavaliacao."&id=".$idanimal."&op=A'</script>";
   		}
   		else
   		{
		   echo "<script language= 'javascript'>parent.corpo.location.href='cadanimal.php?idavaliacao=".$idavaliacao."&id=".$idanimal."&op=A'</script>";
   		}
	}
}
if ($operacao=='A')
{
   $_SESSION['s_idavaliacao']=$id;
   $result = $Lactacao->alterar($id);
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Alterar a lactação')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadanimal.php?idavaliacao=".$idavaliacao."&id=".$idanimal."&op=A'</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
   	    echo "<script language= 'javascript'>parent.corpo.location.href='cadanimal.php?idavaliacao=".$idavaliacao."&id=".$idanimal."&op=A'</script>";
	}
}


if ($operacao=='E')
{
	$id = $_REQUEST['id'];
    if (!empty($id)){
 		$result = $Lactacao->excluir($_REQUEST['id']);
	}
	else
	{
		$box=$_POST['id_lactacao'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Lactacao->excluir($val);
		}
	} 
    echo "<script language= 'javascript'>parent.corpo.location.href='cadanimal.php?idavaliacao=".$idavaliacao."&id=".$idanimal."&op=A'</script>";
}

?>

