<?php session_start();

require_once('classes/sindicato.class.php');
require_once('classes/conexao.class.php');
require_once('classes/funcao.class.php');


$conexao = new Conexao;

$conn = $conexao->Conectar();

$Sindicato = new Sindicato();
$Sindicato->conn = $conn;

$operacao = $_REQUEST['op'];


if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$idsindicato = $_REQUEST['id'];
	$sindicato = $_REQUEST['edtsindicato'];

	$Sindicato->idsindicato = $idsindicato;
	$Sindicato->sindicato = $sindicato;
}

if ($operacao=='I')
{
   if ($result = $Sindicato->incluir())
	{
	// MENSAGEM 19 ==> CADASTRAR TECNICO
	 header("Location: cadsindicato.php?op=A&MSGCODIGO=19&id=$result");
	}
	else
	{
	// MENSAGEM 20 ==> NÃO FOI POSSÍVEL CADASTRAR TECNICO
	 header("Location: cadsindicato.php?op=I&MSGCODIGO=20");
	}

}

if ($operacao=='A')

{
    if ($result = $Sindicato->alterar($idsindicato))
	{
	// MENSAGEM 21 ==> ALTERAR tecnico
	 header("Location: cadsindicato.php?op=A&MSGCODIGO=21&id=$id");
	}
	else
	{
	// MENSAGEM 22 ==> NÃO FOI POSSÍVEL ALTERAR tecnico
	 header("Location: cadsindicato.php?op=A&MSGCODIGO=22&id=$id");
	}
   
}

if ($operacao=='E')
{
    $id = $_REQUEST['id'];
    if (!empty($id)){
 		$result = $Sindicato->excluir($id);
	}
	else
	{
		$box=$_POST['id_sindicato'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Sindicato->excluir($val);
		}
	}
	header("Location: conssindicato.php");	
}



?>



