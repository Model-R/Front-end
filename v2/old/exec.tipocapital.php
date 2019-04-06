<?php session_start();
require_once('classes/tipocapital.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$TipoCapital = new TipoCapital();
$TipoCapital->conn = $conn;

$operacao = $_REQUEST['op'];
if (empty($operacao))
{
	$operacao = 'I';
}
if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];

	$idtipocapital = $_REQUEST['edtidtipocapital'];
	$id = $_REQUEST['edtidtipocapital'];
	
	$tipocapital = $_REQUEST['edttipocapital'];

	$TipoCapital->idtipocapital= $idtipocapital;
	$TipoCapital->tipocapital = $tipocapital;
}
if ($operacao=='I')
{

   $result = $TipoCapital->incluir();
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível cadastrar o tipo de capital')</script>";	

	   echo "<script language= 'javascript'>parent.corpo.location.href='cadtipocapital.php?op=I&tipocapital=".$tipocapital."'</script>";
	}
	else
	{
       echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
       echo "<script language= 'javascript'>parent.corpo.location.href='constipocapital.php'</script>";
	}
}
if ($operacao=='A')
{
   $result = $TipoCapital->alterar($id);
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Alterar')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadtipocapital.php?op=A&idtipocapital=".$idtipocapital."'&tipocapital=".$tipocapital."'</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Alterado com sucesso')</script>";	
        echo "<script language= 'javascript'>parent.corpo.location.href='constipocapital.php'</script>";
	}
}


if ($operacao=='E')
{
	$id = $_REQUEST['id'];
	
    if (!empty($id)){
 		$result = $TipoCapital->excluir($_REQUEST['id']);
	}
	else
	{
		$box=$_POST['id_unidade'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Unidade->TipoCapital($val);
		}
	} 
       echo "<script language= 'javascript'>parent.corpo.location.href='constipocapital.php'</script>";
}
?>

