<?php session_start();

require_once('classes/projeto.class.php');
require_once('classes/conexao.class.php');


$conexao = new Conexao;

$conn = $conexao->Conectar();

$Projeto = new Projeto();
$Projeto->conn = $conn;

$operacao = $_REQUEST['op'];
$idusuario = $_REQUEST['cmboxusuario'];


if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$id = $_REQUEST['id'];
	$project = $_REQUEST['edtprojeto'];

	$Projeto->idproject= $idproject;
	$Projeto->project = $project;
	$Projeto->idusuario = $idusuario;
}

if ($operacao=='I')
{
   if ($result = $Projeto->incluir())
	{
	// MENSAGEM 19 ==> CADASTRAR TECNICO
	 header("Location: consprojeto.php?op=A&MSGCODIGO=92");
	}
	else
	{
	 header("Location: cadprojeto.php?op=I&MSGCODIGO=93");
	}

}

if ($operacao=='A')

{
    if ($result = $Projeto->alterar($id))
	{
	// MENSAGEM 21 ==> ALTERAR tecnico
	 header("Location: cadprojeto.php?op=A&MSGCODIGO=94&id=$id");
	}
	else
	{
	// MENSAGEM 22 ==> NÃO FOI POSSÍVEL ALTERAR tecnico
	 header("Location: cadprojeto.php?op=A&MSGCODIGO=95&id=$id");
	}
   
}

if ($operacao=='E')
{
    $id = $_REQUEST['id'];
    if (!empty($id)){
 		$result = $Projeto->excluir($id);
	}
	else
	{
		$box=$_POST['id_projeto'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Projeto->excluir($val);
		}
	}
	header("Location: consprojeto.php?MSGCODIGO=91&id=$id");	
}



?>



