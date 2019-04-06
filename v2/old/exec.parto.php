<?php session_start();
require_once('classes/parto.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Parto = new Parto();
$Parto->conn = $conn;

$operacao = $_REQUEST['op'];

if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$id = $_REQUEST['edtidparto'];
	$idanimal = $_REQUEST['edtidanimal'];
	$dataparto = $_REQUEST['edtdataparto'];
	
	$Parto->idcobertura = $id;
	$Parto->idanimal = $idanimal;
	$Parto->dataparto= $dataparto;
	
}

if ($operacao=='I')
{

   $result = $Parto->incluir();
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Cadastrar a cobertura')</script>";	

	   echo "<script language= 'javascript'>parent.corpo.location.href='cadparto.php?op=I&edtdataparto=".$dataparto."</script>";
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
   $result = $Parto->alterar($id);
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Alterar a cobertura')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadparto.php?op=A&id=".$idparto."'</script>";
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
 		$result = $Parto->excluir($_REQUEST['id']);
	}
	else
	{
		$box=$_POST['id_parto'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Parto->excluir($val);
		}
	} 
   		   echo "<script language= 'javascript'>parent.corpo.location.href='consanimal.php'</script>";

}

?>

