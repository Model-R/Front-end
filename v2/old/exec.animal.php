<?php session_start();
require_once('classes/animal.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Animal = new Animal();
$Animal->conn = $conn;

$operacao = $_REQUEST['op'];

if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$id = $_REQUEST['edtidanimal'];
	$idavaliacao = $_REQUEST['cmboxavaliacao'];
	$nome = $_REQUEST['edtnome'];
	$idtipoanimal = $_REQUEST['cmboxtipoanimal'];
	$datanascimento = $_REQUEST['edtdatanascimento'];
	$nomemae = $_REQUEST['edtnomemae'];
	$nomepai = $_REQUEST['edtnomepai'];
	$idporteanimal = $_REQUEST['cmboxporteanimal'];
	
	$Animal->idanimal = $id;
	$Animal->idavaliacao = $idavaliacao;
	$Animal->nome = $nome;
	$Animal->idtipoanimal = $idtipoanimal;
	$Animal->datanascimento = $datanascimento;
	$Animal->idporteanimal = $idporteanimal;
	$Animal->nomepai = $nomepai;
	$Animal->nomemae = $nomemae;
	
}

if ($operacao=='I')
{

   $result = $Animal->incluir();
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Cadastrar a avaliação')</script>";	

	   echo "<script language= 'javascript'>parent.corpo.location.href='cadanimal.php?op=I&nome=".$nome."</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
   		if ($fechar == 's')
   		{
		   echo "<script language= 'javascript'>parent.corpo.location.href='consanimal.php'</script>";
   		}
   		else
   		{
		   echo "<script language= 'javascript'>parent.corpo.location.href='cadanimal.php?op=I'</script>";
   		}
	}
}
if ($operacao=='A')
{
   $result = $Animal->alterar($id);
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Alterar a visita t&eacute;cnica')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadanimal.php?op=A&id=".$idanimal."'</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
   		if ($fechar == 's')
   		{
		   echo "<script language= 'javascript'>parent.corpo.location.href='consanimal.php'</script>";
   		}
   		else
   		{
		   echo "<script language= 'javascript'>parent.corpo.location.href='cadanimal.php?op=A&id=".$idanimal."</script>";
   		}
	}
}


if ($operacao=='E')
{
	$id = $_REQUEST['id'];
    if (!empty($id)){
 		$result = $Animal->excluir($_REQUEST['id']);
	}
	else
	{
		$box=$_POST['id_animal'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Animal->excluir($val);
		}
	} 
   		   echo "<script language= 'javascript'>parent.corpo.location.href='consanimal.php'</script>";

}

?>

