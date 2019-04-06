<?php session_start();
require_once('classes/unidademedida.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$UnidadeMedida = new UnidadeMedida();
$UnidadeMedida->conn = $conn;

$operacao = $_REQUEST['op'];
if (empty($operacao))
{
	$operacao = 'I';
}
if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];

	$idunidademedida = $_REQUEST['edtidunidademedida'];
	$id = $_REQUEST['edtidunidademedida'];
	
	$unidademedida = $_REQUEST['edtunidademedida'];
	$siglaunidademedida = $_REQUEST['edtsiglaunidademedida'];
	$tipounidademedida = $_REQUEST['cmboxtipounidademedida'];

	$UnidadeMedida->idunidademedida = $idunidademedida;
	$UnidadeMedida->unidademedida = $unidademedida;
	$UnidadeMedida->siglaunidademedida = $siglaunidademedida;
	$UnidadeMedida->tipounidademedida = $tipounidademedida;
}
if ($operacao=='I')
{

   $result = $UnidadeMedida->incluir();
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível cadastrar a unidade de medida')</script>";	

	   echo "<script language= 'javascript'>parent.corpo.location.href='cadunidademedida.php?op=I&tipounidademedida=".$tipounidademedida."&unidademedida=".$unidademedida."&siglaunidademedida=".$siglaunidademedida."</script>";
	}
	else
	{
       echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
       echo "<script language= 'javascript'>parent.corpo.location.href='consunidademedida.php'</script>";
	}
}
if ($operacao=='A')
{
   $result = $UnidadeMedida->alterar($id);
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Alterar')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadunidademedida.php?op=A&idunidademedida=".$idunidademedida."&tipounidademedida=".$tipounidademedida."&unidademedida=".$unidademedida."&siglaunidademedida=".$siglaunidademedida."</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Alterado com sucesso')</script>";	
        echo "<script language= 'javascript'>parent.corpo.location.href='consunidademedida.php'</script>";
	}
}


if ($operacao=='E')
{
	$id = $_REQUEST['id'];
	
    if (!empty($id)){
 		$result = $UnidadeMedida->excluir($_REQUEST['id']);
	}
	else
	{
		$box=$_POST['id_unidademedida'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $UnidadeMedida->excluir($val);
		}
	} 
       echo "<script language= 'javascript'>parent.corpo.location.href='consunidademedida.php'</script>";
}
?>

