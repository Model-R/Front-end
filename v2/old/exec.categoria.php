<?php session_start();

require_once('classes/categoria.class.php');
require_once('classes/conexao.class.php');
require_once('classes/funcao.class.php');


$conexao = new Conexao;

$conn = $conexao->Conectar();

$Categoria = new Categoria();
$Categoria->conn = $conn;

$operacao = $_REQUEST['op'];


if (($operacao=='I') || ($operacao=='A'))
{
	$fechar = $_REQUEST['fechar'];
	$idcategoria = $_REQUEST['id'];
	$idgrupo = $_REQUEST['cmboxgrupo'];
	$idsubgrupo = $_REQUEST['cmboxsubgrupo'];
	$idunidade = $_REQUEST['cmboxunidade'];
	$categoria = $_REQUEST['edtcategoria'];
	$tipo = $_REQUEST['edttipo'];
	$codigo = $_REQUEST['edtcodigo'];
	$resumida = $_REQUEST['cmboxresumida'];

	$Categoria->idcategoria = $idcategoria;
	$Categoria->idgrupo = $idgrupo;
	$Categoria->idsubgrupo = $idsubgrupo;
	$Categoria->idunidade = $idunidade;
	$Categoria->categoria = $categoria;
	$Categoria->tipo = $tipo;
	$Categoria->codigo = $codigo;
	$Categoria->resumida = $resumida;
}

if ($operacao=='I')
{
   if ($result = $Categoria->incluir())
	{
	// MENSAGEM 19 ==> CADASTRAR TECNICO
	 header("Location: cadcategoria.php?op=A&MSGCODIGO=19&id=$result");
	}
	else
	{
	// MENSAGEM 20 ==> NÃO FOI POSSÍVEL CADASTRAR TECNICO
	 header("Location: cadcategoria.php?op=I&MSGCODIGO=20");
	}

}

if ($operacao=='A')

{
    if ($result = $Tecnico->alterar($idcategoria))
	{
	// MENSAGEM 21 ==> ALTERAR tecnico
	 header("Location: cadcategoria.php?op=A&MSGCODIGO=21&id=$id");
	}
	else
	{
	// MENSAGEM 22 ==> NÃO FOI POSSÍVEL ALTERAR tecnico
	 header("Location: cadcategoria.php?op=A&MSGCODIGO=22&id=$id");
	}
   
}

if ($operacao=='E')
{
    $id = $_REQUEST['id'];
    if (!empty($id)){
 		$result = $Categoria->excluir($id);
	}
	else
	{
		$box=$_POST['id_categoria'];
		while (list ($key,$val) = @each($box)) { 
   			$result = $Categoria->excluir($val);
		}
	}
	header("Location: conscategoria.php");	
}



?>



