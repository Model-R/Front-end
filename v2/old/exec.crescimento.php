<?php session_start();
require_once('classes/balanca.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Balanca = new Balanca();
$Balanca->conn = $conn;

$operacao = $_REQUEST['op'];
$idavaliacao = $_REQUEST['idavaliacao'];

if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$id = $_REQUEST['edtidbalanca'];
	$idanimal = $_REQUEST['edtidanimal'];
	$datapesagem = $_REQUEST['edtdatapesagem'];
	$peso = $_REQUEST['edtpeso'];
	
	$Balanca->idbalanca = $id;
	$Balanca->idanimal = $idanimal;
	$Balanca->datapesagem= $datapesagem;
	$Balanca->peso= $peso;
	
}

if ($operacao=='I')
{

   $result = $Balanca->incluir();
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Cadastrar o crescimento')</script>";	

	   echo "<script language= 'javascript'>parent.corpo.location.href='cadanimal.php?idavaliacao=".$idavaliacao."&idanimal=".$idanimal."&op=A'</script>";
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
   $result = $Balanca->alterar($id);
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Alterar o crescimento')</script>";	
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
 		$result = $Balanca->excluir($_REQUEST['id']);
	}
	else
	{
		$box=$_POST['id_balanca'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Balanca->excluir($val);
		}
	} 
   echo "<script language= 'javascript'>parent.corpo.location.href='cadanimal.php?idavaliacao=".$idavaliacao."&idanimal=".$idanimal."&op=A'</script>";

}

?>

