<?php session_start();
require_once('classes/cobertura.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Cobertura = new Cobertura();
$Cobertura->conn = $conn;

$operacao = $_REQUEST['op'];

if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$id = $_REQUEST['edtidcobertura'];
	$idreprodutor= $_REQUEST['cmboxreprodutor'];
	$idanimal = $_REQUEST['edtidanimal'];
	$datacobertura = $_REQUEST['edtdatacobertura'];
	
	$Cobertura->idcobertura = $id;
	$Cobertura->idreprodutor = $idreprodutor;
	$Cobertura->idanimal = $idanimal;
	$Cobertura->datacobertura = $datacobertura;
	
}

if ($operacao=='I')
{

   $result = $Cobertura->incluir();
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Cadastrar a cobertura')</script>";	

	   echo "<script language= 'javascript'>parent.corpo.location.href='cadcobertura.php?op=I&edtdatacobertura=".$datacobertura."</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
   		if ($fechar == 's')
   		{
		   echo "<script language= 'javascript'>parent.corpo.location.href='cadanimal.php?id=".$idanimal."&op=A'</script>";
   		}
   		else
   		{
		   echo "<script language= 'javascript'>parent.corpo.location.href='cadanimal.php?id=".$idanimal."&op=I'</script>";
   		}
	}
}
if ($operacao=='A')
{
   $_SESSION['s_idavaliacao']=$id;
   $result = $Cobertura->alterar($id);
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Alterar a cobertura')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadcobertura.php?op=A&id=".$idcobertura."'</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadanimal.php?op=A&id=".$idanimal."</script>";
	}
}


if ($operacao=='E')
{
	$id = $_REQUEST['id'];
    if (!empty($id)){
 		$result = $Cobertura->excluir($_REQUEST['id']);
	}
	else
	{
		$box=$_POST['id_cobertura'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Cobertura->excluir($val);
		}
	} 
   		   echo "<script language= 'javascript'>parent.corpo.location.href='consanimal.php'</script>";

}

?>

