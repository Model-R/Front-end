<?php session_start();
require_once('classes/avaliacao.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Avaliacao = new Avaliacao();
$Avaliacao->conn = $conn;

$operacao = $_REQUEST['op'];

if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$id = $_REQUEST['edtidavaliacao'];
	$idpropriedade = $_REQUEST['cmboxpropriedade'];
	$avaliacao = $_REQUEST['edtavaliacao'];
	$anoreferencia = $_REQUEST['edtanoreferencia'];
	
	$Avaliacao->idavaliacao = $id;
	$Avaliacao->idpropriedade = $idpropriedade;
	$Avaliacao->avaliacao = $avaliacao;
	$Avaliacao->anoreferencia = $anoreferencia;
	$Avaliacao->idtecnico = $_SESSION['s_idtecnico'];
	
}

if ($operacao=='I')
{

   $result = $Avaliacao->incluir();
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Cadastrar a avaliação')</script>";	

	   echo "<script language= 'javascript'>parent.corpo.location.href='cadavaliacao.php?op=I&avaliacao=".$avaliacao."</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
   		if ($fechar == 's')
   		{
		   echo "<script language= 'javascript'>parent.corpo.location.href='consavaliacao.php'</script>";
   		}
   		else
   		{
		   echo "<script language= 'javascript'>parent.corpo.location.href='cadavaliacao.php?op=I'</script>";
   		}
	}
}
if ($operacao=='A')
{
   $_SESSION['s_idavaliacao']=$id;
   $result = $Avaliacao->alterar($id);
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&atilde;o foi possível Alterar a visita t&eacute;cnica')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cadavaliacao.php?op=A&id=".$idvisitatecnica."'</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
   		if ($fechar == 's')
   		{
		   echo "<script language= 'javascript'>parent.corpo.location.href='consavaliacao.php'</script>";
   		}
   		else
   		{
		   echo "<script language= 'javascript'>parent.corpo.location.href='cadavaliacao.php?op=A&id=".$idvisitatecnica."</script>";
   		}
	}
}


if ($operacao=='E')
{
	$id = $_REQUEST['id'];
	if (!empty($id)){
 		$result = $Avaliacao->excluir($_REQUEST['id']);
	}
	else
	{
		$box=$_POST['id_avaliacao'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Avaliacao->excluir($val);
		}
	} 
   		   echo "<script language= 'javascript'>parent.corpo.location.href='consavaliacao.php'</script>";

}

?>

