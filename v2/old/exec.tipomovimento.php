<?php session_start();
require_once('classes/tipomovimento.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$TipoMovimento = new TipoMovimento();
$TipoMovimento->conn = $conn;

$operacao = $_REQUEST['op'];
if (empty($operacao))
{
	$operacao = 'I';
}
if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];

	$idtipomovimento = $_REQUEST['edtidtipomovimento'];
	$id = $_REQUEST['edtidtipomovimento'];
	
	$tipomovimento = $_REQUEST['edttipomovimento'];
	$idcategoriatipomovimento = $_REQUEST['cmboxcategoriatipomovimento'];
	$codigotipomovimento = $_REQUEST['edtcodigotipomovimento'];
	$idunidade = $_REQUEST['cmboxunidade'];

	$TipoMovimento->idtipomovimento = $idtipomovimento;
	$TipoMovimento->tipomovimento = $tipomovimento;
	$TipoMovimento->idcategoriatipomovimento = $idcategoriatipomovimento;
	$TipoMovimento->codigo = $codigotipomovimento;
	$TipoMovimento->idunidade = $idunidade;
}
if ($operacao=='I')
{

   $result = $TipoMovimento->incluir();
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível cadastrar o tipo de movimento')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadtipomovimento.php?op=I&tipomovimento=".$tipomovimento."&cmboxunidademedida=".$unidademedida."&cmboxcategoriatipomovimento=".$categoriatipomovimento."&edtcodigotipomovimento=".$codigotipomovimento."'</script>";
	}
	else
	{
       echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
       echo "<script language= 'javascript'>parent.corpo.location.href='constipomovimento.php'</script>";
	}
}
if ($operacao=='A')
{
   $result = $TipoMovimento->alterar($id);
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Alterar')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadtipomovimento.php?op=A&idtipomovimento=".$idtipomovimento."&tipomovimento=".$tipomovimento."&cmboxunidademedida=".$unidademedida."&cmboxcategoriatipomovimento=".$categoriatipomovimento."&edtcodigotipomovimento=".$codigotipomovimento."'</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Alterado com sucesso')</script>";	
        echo "<script language= 'javascript'>parent.corpo.location.href='constipomovimento.php'</script>";
	}
}


if ($operacao=='E')
{
	$id = $_REQUEST['id'];
	
    if (!empty($id)){
 		$result = $TipoMovimento->excluir($_REQUEST['id']);
	}
	else
	{
		$box=$_POST['id_tpomovimento'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $TipoMovimento->excluir($val);
		}
	} 
       echo "<script language= 'javascript'>parent.corpo.location.href='constipomovimento.php'</script>";
}
?>

