<?php session_start();
$NOMEFUNCAO = 'Município';
$NOMETABELA = 'municipio';
require_once('classes/municipio.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$Classe = new Municipio();
$Classe->conn = $conn;
$operacao = $_REQUEST['op'];
if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$idmunicipio = $_REQUEST['edtidmunicipio'];
	$municipio = $_REQUEST['edtmunicipio'];
	$idestado = $_REQUEST['cmboxestado'];
	$Classe->idmunicipio = $idmunicipio;
	$Classe->municipio = $municipio;
	$Classe->idestado = $idestado;
}



if ($operacao=='I')

{
   $result = $Classe->incluir();
   if (!$result)
	{
	   echo "<script language= 'javascript'>alert('N&Atilde;o foi poss&iacute;vel Cadastrar o ".$NOMEFUNCAO."')</script>";	
	   echo "<script language= 'javascript'>parent.corpo.location.href='cad".$NOMETABELA.".php?op=I&edtmunicipio".$municipio."'</script>";
	}
	else
	{
		echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	
   		if ($fechar == 's')

   		{
		//	header("Location: consusuario.php");
		   echo "<script language='javascript'>parent.corpo.location.href='cons".$NOMETABELA.".php'</script>";

   		}

   		else

   		{

		   echo "<script language= 'javascript'>parent.corpo.location.href='cad".$NOMETABELA.".php?op=I'</script>";

   		}

	}

}

if ($operacao=='A')

{

   $result = $Classe->alterar($idmunicipio);

   if (!$result)

	{

	   echo "<script language= 'javascript'>alert('N&Atilde;o foi poss&iacute;vel Alterar')</script>";	

	   echo "<script language= 'javascript'>parent.corpo.location.href='cad".$NOMETABELA.".php?op=A&id=".$idmunicipio."'</script>";

	}

	else

	{

		echo "<script language= 'javascript'>alert('Cadastrado com sucesso')</script>";	

   		if ($fechar == 's')

   		{
		   echo "<script language='javascript'>parent.corpo.location.href='cons".$NOMETABELA.".php'</script>";

   		}

   		else

   		{

	   echo "<script language= 'javascript'>parent.corpo.location.href='cad".$NOMETABELA.".php?op=A&id=".$idmunicipio."'</script>";

   		}

	}

}





if ($operacao=='E')

{

    $id = $_REQUEST['id'];

    if (!empty($id)){

 		$result = $Classe->excluir($_REQUEST['id']);

	}

	else

	{

		$box=$_POST['id_'];

		while (list ($key,$val) = @each($box)) { 

   			$result = $Classe->excluir($val);

		}

	} 

 echo "<script language='javascript'>parent.corpo.location.href='cons".$NOMETABELA.".php'</script>";

}



?>



