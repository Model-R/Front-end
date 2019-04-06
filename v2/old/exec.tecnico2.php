<?php session_start();

require_once('classes/tecnico.class.php');
require_once('classes/conexao.class.php');
require_once('classes/funcao.class.php');


$conexao = new Conexao;

$conn = $conexao->Conectar();

$Tecnico = new Tecnico();
$Tecnico->conn = $conn;

$operacao = $_REQUEST['op'];


if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$idtecnico = $_REQUEST['edtidtecnico'];
	$nometecnico = $_REQUEST['edtnometecnico'];
	$matricula = $_REQUEST['edtmatricula'];
	$email = $_REQUEST['edtemail'];
	$telefone = $_REQUEST['edttelefone'];
	$celular = $_REQUEST['edtcelular'];
	$endereco = $_REQUEST['edtendereco'];

	$Tecnico->matricula = $matricula;
	$Tecnico->nometecnico = $nometecnico;
	$Tecnico->email = $email;
	$Tecnico->celular = $celular;
	$Tecnico->telefone = $telefone;
	$Tecnico->endereco = $endereco;
}

if ($operacao=='I')
{
   if ($result = $Tecnico->incluir())
	{
	// MENSAGEM 19 ==> CADASTRAR TECNICO
	 header("Location: cadtecnico.php?op=A&MSGCODIGO=19&id=$result");
	}
	else
	{
	// MENSAGEM 20 ==> NÃO FOI POSSÍVEL CADASTRAR TECNICO
	 header("Location: cadtecnico.php?op=I&MSGCODIGO=20");
	}

}

if ($operacao=='A')

{
    if ($result = $Tecnico->alterar($idtecnico))
	{
	// MENSAGEM 21 ==> ALTERAR tecnico
	 header("Location: cadtecnico.php?op=A&MSGCODIGO=21&id=$id");
	}
	else
	{
	// MENSAGEM 22 ==> NÃO FOI POSSÍVEL ALTERAR tecnico
	 header("Location: cadtecnico.php?op=A&MSGCODIGO=22&id=$id");
	}
   
}

if ($operacao=='E')
{
    $id = $_REQUEST['id'];
    if (!empty($id)){
 		$result = $Tecnico->excluir($id);
	}
	else
	{
		$box=$_POST['id_tecnico'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Tecnico->excluir($val);
		}
	}
	header("Location: constecnico.php");	
}



?>



