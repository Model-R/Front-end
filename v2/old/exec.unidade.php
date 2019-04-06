<?php session_start();
require_once('classes/unidade.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Unidade = new Unidade();
$Unidade->conn = $conn;

$operacao = $_REQUEST['op'];
if (empty($operacao))
{
	$operacao = 'I';
}
if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];

	$idunidade = $_REQUEST['edtidunidade'];
	$id = $_REQUEST['edtidunidade'];
	
	$unidade = $_REQUEST['edtunidade'];

	$Unidade->idunidade= $idunidade;
	$Unidade->unidade = $unidade;
}
if ($operacao=='I')
{

   $result = $Unidade->incluir();
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível cadastrar a unidade')</script>";	

	   echo "<script language= 'javascript'>parent.corpo.location.href='cadunidade.php?op=I&unidade=".$unidade."'</script>";
	}
	else
	{
       echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
       echo "<script language= 'javascript'>parent.corpo.location.href='consunidade.php'</script>";
	}
}
if ($operacao=='A')
{
   $result = $Unidade->alterar($id);
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Alterar')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadunidade.php?op=A&idunidade=".$idunidade."'&unidade=".$unidade."'</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Alterado com sucesso')</script>";	
        echo "<script language= 'javascript'>parent.corpo.location.href='consunidade.php'</script>";
	}
}


if ($operacao=='E')
{
	$id = $_REQUEST['id'];
	
    if (!empty($id)){
 		$result = $Unidade->excluir($_REQUEST['id']);
	}
	else
	{
		$box=$_POST['id_unidade'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Unidade->excluir($val);
		}
	} 
       echo "<script language= 'javascript'>parent.corpo.location.href='consunidade.php'</script>";
}
?>

