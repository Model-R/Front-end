<?php session_start();

require_once('classes/experimento.class.php');
require_once('classes/conexao.class.php');


$conexao = new Conexao;

$conn = $conexao->Conectar();

$Experimento = new Experimento();
$Experimento->conn = $conn;

$operacao = $_REQUEST['op'];

//print_r($_REQUEST);
//exit;

if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$idexperimento = $_REQUEST['id'];
	$idprojeto = $_REQUEST['cmboxprojeto'];
	$experimento = $_REQUEST['edtexperimento'];
	$descricao = $_REQUEST['edtdescricao'];
	$idusuario = $_SESSION['s_idusuario'];

	$Experimento->idexperiment= $idexperimento;
	$Experimento->idproject= $idprojeto;
	$Experimento->name = $experimento;
	$Experimento->description = $descricao;
	$Experimento->iduser = $idusuario;
}
else
{
	$idexperimento = $_REQUEST['id'];
}

if ($operacao=='I')
{
   if ($result = $Experimento->incluir())
	{
	// MENSAGEM 19 ==> CADASTRAR TECNICO
	 header("Location: cadexperimento.php?op=A&MSGCODIGO=82&id=$result");
	}
	else
	{
	// MENSAGEM 20 ==> NÃO FOI POSSÍVEL CADASTRAR TECNICO
	 header("Location: cadexperimento.php?op=I&MSGCODIGO=83");
	}

}

if ($operacao=='A')
{

    if ($result = $Experimento->alterar($idexperimento))
	{
		header("Location: cadexperimento.php?op=A&tab=2&MSGCODIGO=84&id=$idexperimento");
	}
	else
	{
	 header("Location: cadexperimento.php?op=A&tab=2&MSGCODIGO=85&id=$idexperimento");
	}
   
}

if ($operacao=='LD')
{
   if ($result = $Experimento->limparDados($idexperimento))
	{
	 header("Location: consexperimento.php?MSGCODIGO=19&id=$idexperimento");
	}
	else
	{
	 header("Location: cadexperimento.php?MSGCODIGO=20");
	}
}

if ($operacao=='E')
{
    $id = $_REQUEST['id'];
    if (!empty($id)){
 		$result = $Experimento->excluir($id);
	}
	else
	{
		$box=$_POST['id_experiment'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Experimento->excluir($val);
		}
	}
	header("Location: consexperimento.php?MSGCODIGO=81");	
}


// liberar experimento
if ($operacao=='LE')
{

    if ($result = $Experimento->liberarExperimento($idexperimento))
	{
		header("Location: cadexperimento.php?op=A&tab=2&MSGCODIGO=84&id=$idexperimento");
	}
	else
	{
	 header("Location: cadexperimento.php?op=A&tab=2&MSGCODIGO=85&id=$idexperimento");
	}
   
}

?>



