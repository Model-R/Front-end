<?php session_start();
require_once('classes/categoriatipocapital.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$CategoriaTipoCapital = new CategoriaTipoCapital();
$CategoriaTipoCapital->conn = $conn;

$operacao = $_REQUEST['op'];
if (empty($operacao))
{
	$operacao = 'I';
}
if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];

	$idcategoriatipocapital = $_REQUEST['edtidcategoriatipocapital'];
	$id = $_REQUEST['edtidcategoriatipocapital'];

		
	$idtipocapital = $_REQUEST['cmboxtipocapital'];
	$categoriatipocapital = $_REQUEST['edtcategoriatipocapital'];
	$codigotipomovimento = $_REQUEST['edtcodigotipomovimento'];
	$idunidademedida = $_REQUEST['cmboxunidademedida'];

	$CategoriaTipoCapital->idtipocapital = $idtipocapital;
	$CategoriaTipoCapital->categoriatipocapital = $categoriatipocapital;
	$CategoriaTipoCapital->codigotipomovimento = $codigotipomovimento;
	$CategoriaTipoCapital->idunidademedida = $idunidademedida;
}
if ($operacao=='I')
{

   $result = $CategoriaTipoCapital->incluir();
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível cadastrar a categoria tipo capital')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadcategoriatipocapital.php?op=I&edtcategoriatipocapital=".$categoriatipocapital."&cmboxunidademedida=".$unidademedida."&cmboxtipocapital=".$idtipocapital."'</script>";
	}
	else
	{
       echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
       echo "<script language= 'javascript'>parent.corpo.location.href='conscategoriatipocapital.php'</script>";
	}
}
if ($operacao=='A')
{
   $result = $CategoriaTipoCapital->alterar($id);
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Alterar')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadcategoriatipocapital.php?op=A&idtipomovimento=".$idtipomovimento."&tipomovimento=".$tipomovimento."&cmboxunidademedida=".$unidademedida."&cmboxcategoriatipomovimento=".$categoriatipomovimento."&edtcodigotipomovimento=".$codigotipomovimento."'</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Alterado com sucesso')</script>";	
        echo "<script language= 'javascript'>parent.corpo.location.href='conscategoriatipocapital.php'</script>";
	}
}


if ($operacao=='E')
{
	$id = $_REQUEST['id'];
	
    if (!empty($id)){
 		$result = $CategoriaTipoCapital->excluir($_REQUEST['id']);
	}
	else
	{
		$box=$_POST['id_tpomovimento'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $CategoriaTipoCapital->excluir($val);
		}
	} 
       echo "<script language= 'javascript'>parent.corpo.location.href='conscategoriatipocapital.php'</script>";
}
?>

