<?php session_start();
require_once('classes/usuario.class.php');
require_once('classes/conexao.class.php');
$conexao = new Conexao;
$conn = $conexao->Conectar();
$usuario = new Usuario();
$usuario->conn = $conn;

$operacao = $_REQUEST['op'];
$tipo = $_REQUEST['tipo'];
$valor = $_REQUEST['valor'];
// guardo o valor do cpf e cnpj formatado no banco
//$s = array(".", "/", "-");
//$valor = str_replace($s, "", $valor);
if ($tipo=='LOGIN')
{
	if (($usuario->existeLogin($valor))==true)
	{
		echo '<input name="edtexistelogin"  id="edtexistelogin" type="hidden" value="T" /><font face="Arial, Helvetica, sans-serif" color="#FF0000">Login já cadastrado</font>';
	}
	else
	{
		echo '<input name="edtexistelogin"  id="edtexistelogin" type="hidden" value="F" />';
	}
}
if ($tipo=='EMAIL')
{
	if (($usuario->existeEmail($valor))==true)
	{
		echo '<input name="edtexisteemail" id="edtexisteemail" type="hidden" value="T" id="edtexiste"/><font face="Arial, Helvetica, sans-serif" color="#FF0000">Email já cadastrado</font>';
	}
	else
	{
		echo '<input name="edtexisteemail" id="edtexisteemail" type="hidden" value="F" />';
	}
}

?>

