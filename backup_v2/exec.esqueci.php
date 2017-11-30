<?php session_start();
require_once('classes/usuario.class.php');
require_once('classes/conexao.class.php');
$email = $_REQUEST['edtemail'];
$conexao = new Conexao;
$conn = $conexao->Conectar();
$usuario = new Usuario();
$usuario->conn = $conn;
//$resultado=$usuario->enviarSenha($email);
$resultado=$usuario->enviarSenha($email);
if($resultado==true){
	header("Location: index.php?MSGCODIGO=9");
}else {
	header("Location: index.php?MSGCODIGO=8");
}
//header("Location: login.php");

?>

